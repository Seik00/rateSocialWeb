<?php
namespace App\Http\Controllers\Api;

use App\Helper\PaymentGateway\Crypto5Pay;
use App\Helper\PaymentGateway\Yodgs;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositCoin;
use App\Models\PaymentGatewayLog;
use App\Models\PaymentGatewayOrder;
use App\Models\WithdrawCash;
use App\Models\WithdrawCoin;
use Carbon\Carbon;
use Illuminate\Http\Request;

//project model//
class PaymentGatewayController extends Controller
{
    public function yodgsFrontendRespond(Request $request)
    {
        sleep(rand(1, 3));
        $data['platform'] = 'Yodgs';
        $data['order_no'] = $request->get('order_no');
        $data['respond_log'] = json_encode($request->all());
        PaymentGatewayLog::create($data);
        $respond = $request->all();

        $Yodgs = new Yodgs;
        $result = $Yodgs->makeMd5Sign($request->all());

        if ($result == true) {
            $order = PaymentGatewayOrder::where('order_no', $request->get('mer_order_no'))->first();

            if ($order->payment_status != 1) {
                if ($respond['status'] == 'SUCCESS' && $respond['pay_amount'] == $order->amount) {
                    $order->payment_status = 1;
                    $order->payment_done = $respond['pay_time'];
                    $order->trans_id = $respond['order_no'];
                    $order->error_message = $respond['err_msg'];
                    $order->save();
                    if ($order->payment_type == 'DEPOSIT') {
                        $deposit = Deposit::where('payment_gateway_order_id', $order->id)->first();
                        if ($deposit) {
                            $deposit->status = 1;
                            $deposit->save();
                            $this->create_transaction($deposit->user_id, '+', 'point1', 900, 1, $deposit->amount, '充值成功', 'Reload Success', 'Tải lại thành công');

                        }
                    }

                }
            }

        }

        return redirect('/web/deposit/depositHistory');
    }
    public function yodgsBackendRespond(Request $request)
    {
        sleep(rand(1, 4));
        $data['platform'] = 'Yodgs';
        $data['order_no'] = $request->get('order_no');
        $data['respond_log'] = json_encode($request->all());
        PaymentGatewayLog::create($data);
        $respond = $request->all();

        $Yodgs = new Yodgs;
        $result = $Yodgs->makeMd5Sign($request->all());

        if ($result == true) {

            $order = PaymentGatewayOrder::where('order_no', $request->get('mer_order_no'))->first();

            if ($order->payment_status != 1) {
                if ($respond['status'] == 'SUCCESS' && $respond['pay_amount'] == $order->amount) {
                    $order->payment_status = 1;
                    $order->payment_done = $respond['pay_time'];
                    $order->trans_id = $respond['order_no'];
                    $order->error_message = $respond['err_msg'];
                    $order->save();
                    if ($order->payment_type == 'DEPOSIT') {
                        $deposit = Deposit::where('payment_gateway_order_id', $order->id)->first();
                        if ($deposit) {
                            $deposit->status = 1;
                            $deposit->save();
                            $this->create_transaction($deposit->user_id, '+', 'point1', 900, 1, $deposit->amount, '充值成功', 'Reload Success', 'Tải lại thành công');

                        }
                    }

                }
            }

        }

        echo 'SUCCESS';
    }

    public function yodgsWithdrawRespond(Request $request)
    {
        sleep(rand(1, 4));
        $data['platform'] = 'Yodgs';
        $data['order_no'] = $request->get('order_no');
        $data['respond_log'] = json_encode($request->all());
        PaymentGatewayLog::create($data);
        $respond = $request->all();

        $Yodgs = new Yodgs;
        $result = $Yodgs->makeMd5Sign($request->all());

        if ($result == true) {

            $order = PaymentGatewayOrder::where('order_no', $request->get('mer_order_no'))->first();

            if ($order->payment_status != 1) {
                if ($respond['status'] == 'SUCCESS' && $respond['order_amount'] == $order->amount) {
                    $order->payment_status = 1;
                    $order->payment_done = $respond['pay_time'];
                    $order->trans_id = $respond['order_no'];
                    $order->error_message = $respond['err_msg'];
                    $order->save();
                    if ($order->payment_type == 'WITHDRAW') {
                        $withdraw = WithdrawCash::where('payment_gateway_order_id', $order->id)->first();
                        if ($withdraw) {
                            $withdraw->status = 2;
                            $withdraw->save();
                        }
                    }

                } else {
                    $order->payment_status = 2;
                    $order->payment_done = $respond['pay_time'];
                    $order->trans_id = $respond['order_no'];
                    $order->error_message = $respond['err_msg'];
                    $order->save();
                    if ($order->payment_type == 'WITHDRAW') {
                        $withdraw = WithdrawCash::where('payment_gateway_order_id', $order->id)->first();
                        if (isset($withdraw) && $withdraw->status != 3 && $withdraw->status != 2) {
                            $withdraw->status = 3;
                            $withdraw->save();
                            $this->create_transaction($withdraw->user_id, '+', 'point2', 210, 2, $withdraw->amount, '提现失败', 'Withdraw Fail', 'Penarikan gagal', 'การถอนล้มเหลว', 'Rút tiền không thành công', '');

                        }
                    }

                }
            }

        }

        echo 'SUCCESS';
    }

    public function crypto5payFrontendRespond(Request $request)
    {
        sleep(rand(1, 3));
        $data['platform'] = 'Crypto5Pay';
        $data['order_no'] = '';
        $data['respond_log'] = json_encode($request->all());
        PaymentGatewayLog::create($data);
        $Crypto5Pay = new Crypto5Pay;

        $result = $Crypto5Pay->dencryptWithdraw($request->all());

        if (isset($result)) {
            $order = PaymentGatewayOrder::where('order_no', $result['merchantOrderNo'])->first();

            if (isset($order) && $order->payment_status != 1) {

                if ($result['status'] == '3' && $result['orderAmount'] == $order->amount) {
                    $transaction = $result['transaction'][0];

                    $order->payment_status = 1;
                    $order->payment_done = Carbon::now();
                    $order->trans_id = $transaction['transactionHash'];
                    $order->save();
                    if ($order->payment_type == 'DepositCoin') {
                        $deposit = DepositCoin::where('payment_gateway_order_id', $order->id)->first();
                        if ($deposit) {
                            if ($transaction['chainTypeId'] == '2') {
                                $deposit->deposit_type = 'ERC20';
                            } else {
                                $deposit->deposit_type = 'TRC20';
                            }
                            $deposit->tx_id = $transaction['transactionHash'];
                            $deposit->address = $transaction['depositWalletAddress'];
                            $deposit->status = 1;
                            $deposit->save();
                            $this->create_transaction($deposit->user_id, '+', 'point1', 900, 1, $deposit->amount, '充值成功', 'Reload Success', 'Tải lại thành công');

                        }
                    }

                } elseif ($result['status'] == '4') {
                    $order->payment_status = 2;
                    $order->payment_done = Carbon::now();
                    $order->trans_id = $result['paymentAddress'];
                    $order->save();
                    $deposit = DepositCoin::where('payment_gateway_order_id', $order->id)->first();
                    if ($deposit) {

                        $deposit->address = $transaction['paymentAddress'];
                        $deposit->status = 2;
                        $deposit->save();

                    }
                }
            }

        }
        return redirect('/web/deposit/depositHistory');
    }
    public function crypto5payBackendRespond(Request $request)
    {
        //sleep(rand(1, 4));

        $data['platform'] = 'Crypto5Pay';
        $data['order_no'] = '';
        $data['respond_log'] = json_encode($request->all());
        PaymentGatewayLog::create($data);
        $Crypto5Pay = new Crypto5Pay;

        $result = $Crypto5Pay->dencryptWithdraw($request->all());

        if (isset($result)) {
            $order = PaymentGatewayOrder::where('order_no', $result['merchantOrderNo'])->first();

            if (isset($order) && $order->payment_status != 1) {

                if ($result['status'] == '3' && $result['orderAmount'] == $order->amount) {
                    $transaction = $result['transaction'][0];

                    $order->payment_status = 1;
                    $order->payment_done = Carbon::now();
                    $order->trans_id = $transaction['transactionHash'];
                    $order->save();
                    if ($order->payment_type == 'DepositCoin') {
                        $deposit = DepositCoin::where('payment_gateway_order_id', $order->id)->first();
                        if ($deposit) {
                            if ($transaction['chainTypeId'] == '2') {
                                $deposit->deposit_type = 'ERC20';
                            } else {
                                $deposit->deposit_type = 'TRC20';
                            }
                            $deposit->tx_id = $transaction['transactionHash'];
                            $deposit->address = $transaction['depositWalletAddress'];
                            $deposit->status = 1;
                            $deposit->save();
                            $this->create_transaction($deposit->user_id, '+', 'point1', 900, 1, $deposit->amount, '充值成功', 'Reload Success', 'Tải lại thành công');

                        }
                    }

                } elseif ($result['status'] == '4') {
                    $order->payment_status = 2;
                    $order->payment_done = Carbon::now();
                    $order->trans_id = $result['paymentAddress'];
                    $order->save();
                    $deposit = DepositCoin::where('payment_gateway_order_id', $order->id)->first();
                    if ($deposit) {

                        $deposit->address = $transaction['paymentAddress'];
                        $deposit->status = 2;
                        $deposit->save();

                    }
                }
            }

        }

        echo 'SUCCESS';
    }
    public function crypto5PayWithdrawRespond(Request $request)
    {
        sleep(rand(1, 4));
        $data['platform'] = 'Crypto5Pay';
        $data['order_no'] = '';
        $data['respond_log'] = json_encode($request->all());
        PaymentGatewayLog::create($data);
        $Crypto5Pay = new Crypto5Pay;
        $result = $Crypto5Pay->dencryptWithdraw($request->all());

        if (isset($result)) {

            $order = PaymentGatewayOrder::where('order_no', $result['merchantOrderNo'])->first();

            if ($order->payment_status != 1) {

                if ($result['status'] == '3') { //1 待确认，2处理中，3批准，4拒绝
                    $withdraw_amount = $result['withdrawalAmount'] - $result['withdrawalCharges'];
                    if ($withdraw_amount == $order->amount) {
                        $order->payment_status = 1;
                    }

                    $order->payment_done = Carbon::now();
                    $order->trans_id = $result['withdrawalId'];
                    $order->save();
                    if ($order->payment_type == 'WithdrawCoin') {
                        $withdraw = WithdrawCoin::where('payment_gateway_order_id', $order->id)->first();
                        if ($withdraw) {
                            $withdraw->status = 2;
                            $withdraw->txid = $result['transactionHash'];
                            $withdraw->save();

                        }
                    }

                } else {

                    $order->payment_status = 2;
                    $order->payment_done = Carbon::now();
                    $order->error_message = $result['rejectedReason'];
                    $order->trans_id = $result['withdrawalId'];
                    $order->save();
                    if ($order->payment_type == 'WithdrawCoin') {
                        $withdraw = WithdrawCoin::where('payment_gateway_order_id', $order->id)->first();
                        if (isset($withdraw) && $withdraw->status != 3 && $withdraw->status != 2) {
                            $withdraw->status = 3;
                            $withdraw->save();
                            $this->create_transaction($withdraw->user_id, '+', 'point2', 210, 2, $withdraw->amount, '提现失败', 'Withdraw Fail', 'Penarikan gagal', 'การถอนล้มเหลว', 'Rút tiền không thành công', '');

                        }
                    }

                }
            }

        }

        echo 'SUCCESS';
    }
}
