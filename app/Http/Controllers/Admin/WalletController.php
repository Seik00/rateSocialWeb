<?php

namespace App\Http\Controllers\admin;

use App\Helper\PaymentGateway\Crypto5Pay;
use App\Helper\PaymentGateway\Yodgs;
use App\Helper\SendCloud;
use App\Http\Controllers\Common\AdminBaseController;
use App\Models\BoostDeposit;
use App\Models\Deposit;
use App\Models\DepositCoin;
use App\Models\FundTransfer;
use App\Models\SystemBank;
use App\Models\User;
use App\Models\WalletReloadRecord;
use App\Models\WalletTransaferRec;
use App\Models\WithdrawCash;
use App\Models\WithdrawCoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class WalletController extends AdminBaseController
{
    public function withdrawCashHis(Request $request)
    {
        $db = WithdrawCash::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function withdrawCashList(Request $request)
    {
        $db = WithdrawCash::select('*')->where('status', '<', 2);

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }

    public function editWithdrawCash(Request $request)
    {
        $withdrawCash = WithdrawCash::where('id', $request->get('id'))->first();
        $withdrawCash->bank_name = $request->get('bank_name');
        $withdrawCash->bank_user = $request->get('bank_user');
        $withdrawCash->bank_number = $request->get('bank_number');
        $withdrawCash->branch = $request->get('branch');
        $withdrawCash->save();
        $this->activities_log('edit withdraw cash', json_encode($request->all()));
        return $this->success([
            'withdrawCash' => $withdrawCash,
        ], '');
    }
    public function withdrawCashControl(Request $request)
    {
        $withdraw = WithdrawCash::where('id', $request->get('id'))->first();
        if ($withdraw->status > 2) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }

        if ($request->get('action') == 'APPROVE') {

            $Yodgs = new Yodgs();
            $result = $Yodgs->withdraw($withdraw->user_id, $withdraw->get_amount, $withdraw);
            if ($result['success'] == false) {
                return Response::json(array(
                    'code' => 1,
                    'message' => $result['error'],
                ));
            }
            $withdraw->status = 1;
            $withdraw->save();
        } elseif ($request->get('action') == 'COMPLETED') {
            $withdraw->status = 2;
        } elseif ($request->get('action') == 'REJECT') {
            $withdraw->status = 3;
            $withdraw->remark = $request->get('remark');
            $this->create_transaction($withdraw->user_id, '+', 'point1', 210, 1, $withdraw->amount, '提现失败', 'Withdraw Fail', 'Penarikan gagal', 'การถอนล้มเหลว', 'Rút tiền không thành công', $request->get('remark'));
        } else {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        $this->activities_log('withdraw cash control', json_encode($request->all()));
        $withdraw->save();
        return $this->success(true, 'REQUEST_COMPLETE');
    }
    public function withdrawHis(Request $request)
    {
        $db = WithdrawCoin::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function withdrawList(Request $request)
    {
        $db = WithdrawCoin::select('*')->where('status', '<', 1);

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function editWithdrawCoin(Request $request)
    {
        $WithdrawCoin = WithdrawCoin::where('id', $request->get('id'))->first();
        $WithdrawCoin->address = $request->get('address');
        $WithdrawCoin->save();
        $this->activities_log('edit withdraw coin', json_encode($request->all()));
        return $this->success([
            'withdrawCash' => $WithdrawCoin,
        ], '');
    }
    public function withdrawControl(Request $request)
    {
        $withdraw = WithdrawCoin::where('id', $request->get('id'))->first();
        if ($withdraw->status > 2) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        $sendCloud = new SendCloud();
        if ($request->get('action') == 'APPROVE') {
            if ($withdraw->user->email) {
                $sendCloud->mailTemplate($withdraw->user, $withdraw->get_amount, 'withdraw_approved');
            }
            $withdraw->refNo = 'WNT' . $withdraw->id;

            $Crypto5Pay = new Crypto5Pay();
            $result = $Crypto5Pay->withdraw($withdraw->user_id, $withdraw->get_amount, $withdraw);
            if ($result['success'] == false) {
                return Response::json(array(
                    'code' => 1,
                    'message' => $result['error'],
                ));
            }
            $withdraw->status = 1;
        } elseif ($request->get('action') == 'COMPLETED') {

            $withdraw->status = 2;
        } elseif ($request->get('action') == 'REJECT') {

            if ($withdraw->user->email) {
                $sendCloud->mailTemplate($withdraw->user, $withdraw->get_amount, 'withdraw_rejected');
            }

            $withdraw->status = 3;
            $withdraw->remark = $request->get('remark');
            $this->create_transaction($withdraw->user_id, '+', 'point2', 210, 2, $withdraw->amount, '提现失败', 'Withdraw Fail', 'Rút tiền không thành công', 'Penarikan gagal', 'การถอนล้มเหลว', $request->get('remark'));
        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }

        $this->activities_log('withdraw coin control', json_encode($request->all()));
        $withdraw->save();

        return $this->success([
            'record' => $withdraw,
        ], '');
    }
    public function batchWithdrawControl(Request $request)
    {
        $id = explode(",", $request->get('id'));
        $sendCloud = new SendCloud();
        $withdraw = WithdrawCoin::wherein('id', $id)->get();
        for ($i = 0; $i < count($withdraw); $i++) {
            $update = array();

            if ($withdraw[$i]->status < 2) {
                if ($request->get('action') == 'APPROVE') {
                    $update['status'] = 1;
                    if ($withdraw[$i]->user->email) {
                        $sendCloud->mailTemplate($withdraw[$i]->user, $withdraw[$i]->get_amount, 'withdraw_approved');
                    }
                    $Crypto5Pay = new Crypto5Pay();
                    $result = $Crypto5Pay->withdraw($withdraw[$i]->user_id, $withdraw[$i]->get_amount, $withdraw[$i]);
                    if ($result['success'] == false) {
                        return Response::json(array(
                            'code' => 1,
                            'message' => $result['error'],
                        ));
                    }

                    $update['error_message'] = $result['error'];
                } elseif ($request->get('action') == 'COMPLETED') {

                    $update['status'] = 2;
                    /*$result = CryptedPay::withdraw($withdraw[$i]->address, $update['refNo'], $withdraw[$i]->get_amount);
                if ($result['success'] == false) {
                return Response::json(array(
                'code' => 0,
                'message' => $result['error'],
                ));
                }

                $update['txid'] = $result['txid'];
                $update['error_message'] = $result['error'];
                 */
                } elseif ($request->get('action') == 'REJECT') {
                    $update['status'] = 3;
                    $update['remark'] = $request->get('remark');

                    $this->create_transaction($withdraw[$i]->user_id, '+', 'point2', 210, 2, $withdraw[$i]->amount, '提现失败', 'Withdraw Fail', 'Rút tiền không thành công', 'Penarikan gagal', 'การถอนล้มเหลว', $request->get('remark'));
                }
            }
            WithdrawCoin::where('id', $withdraw[$i]->id)->update($update);
        }

        $this->activities_log('batch withdraw coin control', json_encode($request->all()));

        return $this->success([
            'record' => $withdraw,
        ], '');
    }
    public function withdrawControl_old(Request $request)
    {
        $withdraw = WithdrawCoin::where('id', $request->get('id'))->first();
        if ($withdraw->status > 2) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }

        if ($request->get('action') == 'APPROVE') {
            $withdraw->status = 1;
        } elseif ($request->get('action') == 'COMPLETED') {
            $withdraw->status = 2;
        } elseif ($request->get('action') == 'REJECT') {
            $withdraw->status = 3;
            $withdraw->remark = $request->get('remark');
            $this->create_transaction($withdraw->user_id, '+', 'point2', 98, 2, $withdraw->amount, '提现失败', 'Withdraw Fail', 'Rút tiền không thành công', 'Penarikan gagal', 'การถอนล้มเหลว', $request->get('remark'));
        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
        $this->activities_log('withdraw coin control', json_encode($request->all()));
        $withdraw->save();

        return $this->success([
            'record' => $withdraw,
        ], '');
    }
    public function reloadRecord(Request $request)
    {
        $db = WalletReloadRecord::select('*');

        $db = $this->search_record($db, $request);

        if ($request->get('txid')) {
            $db->where('txid', $request->get('txid'));
        }
        if ($request->get('address')) {
            $db->where('address', $request->get('address'));
        }
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return $this->success([
            'record' => $record,
        ], '');
    }
    public function depositRequestList(Request $request)
    {
        $bank = SystemBank::where('is_display', 1)->get();
        $db = BoostDeposit::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->where('status', 0)->orderBy('id', 'DESC')->paginate(10);

        return $this->success([
            'record' => $record,
            'bank' => $bank,
        ], '');
    }
    public function depositRequestControl(Request $request)
    {
        //action = APPROVE/REJECT
        //id = id
        //address = 当deposit_type不是bank 的时候，让他自己输入地址 ,如果是bank 就null 就好

        //bank_id = 当deposit_type是bank 的时候，让他选银行 ,如果bu是bank 就null 就好

        $deposit = BoostDeposit::where('id', $request->get('id'))->first();
        if ($deposit->status > 0) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        $deposit->address = $request->get('address');
        $deposit->bank_id = $request->get('bank_id');
        if ($request->get('action') == 'APPROVE') {
            $deposit->status = 1;
        } elseif ($request->get('action') == 'REJECT') {
            $deposit->status = 3;
        } else {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        $this->activities_log('deposit request control', json_encode($request->all()));
        $deposit->save();
        return $this->success([
            'record' => $deposit,
        ], '');
    }
    public function depositList(Request $request)
    {
        $db = Deposit::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'DESC')->paginate(10);

        return $this->success([
            'record' => $record,
        ], '');
    }

    public function depositControl(Request $request)
    {
        //action = APPROVE/REJECT
        //id = id

        $deposit = Deposit::where('id', $request->get('id'))->first();
        if ($deposit->status > 0) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        if ($request->get('action') == 'APPROVE') {
            $this->create_transaction($deposit->user_id, '+', 'point1', 99, 1, $deposit->amount, '充值成功', 'Deposit successfully', 'Deposit Berjaya', 'เติมเงินเรียบร้อย', 'Nạp tiền thành công');

            $deposit->status = 1;
        } elseif ($request->get('action') == 'REJECT') {
            $deposit->status = 2;
        } else {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        $this->activities_log('deposit control', json_encode($request->all()));
        $deposit->save();
        return $this->success([
            'record' => $deposit,
        ], '');
    }

    public function depositCoinList(Request $request)
    {
        $db = DepositCoin::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'DESC')->paginate(10);

        return $this->success([
            'record' => $record,
        ], '');
    }

    public function depositCoinControl(Request $request)
    {
        //action = APPROVE/REJECT
        //id = id

        $deposit = DepositCoin::where('id', $request->get('id'))->first();
        if ($deposit->status > 0) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        if ($request->get('action') == 'APPROVE') {

            $this->create_transaction($deposit->user_id, '+', 'point2', 99, 1, $deposit->total_amount, '充值成功', 'Deposit successfully', 'Deposit Berjaya', 'เติมเงินเรียบร้อย', 'Nạp tiền thành công');
            $deposit->status = 1;
        } elseif ($request->get('action') == 'REJECT') {
            if ($deposit->deposit_type == 'DBP&DFI') {
                $this->create_transaction($deposit->user_id, '+', 'point1', 99, 1, $deposit->amount2, '充值失败', 'Deposit fail', 'Deposit fail', 'เติมเงินเรียบร้อย', 'Nạp tiền thành công');
            }
            $deposit->status = 2;
        } else {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '操作失败',
            ));
=======
            return $this->fail('E00010', 'REQUEST_FAIL');
>>>>>>> Stashed changes
        }
        $this->activities_log('deposit coin control', json_encode($request->all()));
        $deposit->save();

        return $this->success([
            'record' => $deposit,
        ], '');
    }
    public function userTransRec(Request $request)
    {
        $db = WalletTransaferRec::select('*');
        if ($request->get('username')) {

            $user = User::where('username', $request->get('username'))->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $request->get('username'))->where('role_id', 2)->first();
            }

            if ($user) {
                $db->where('user_id', $user->id);
            } else {
                $db->where('user_id', -1);
            }
        }
        $record = $db->orderBy('id', 'desc')->paginate(10);
        $wallet = $this->wallet_type();
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function walletChangeRec(Request $request)
    {
        $db = FundTransfer::select('*')->where('found_type', 0);
        $db = $this->search_record($db, $request);
        // if ($request->get('username')) {

        //     $user = User::where('username', $request->get('username'))->where('role_id', 2)->first();
        //     if (!$user) {
        //         $user = User::where('id', $request->get('username'))->where('role_id', 2)->first();
        //     }

        //     if ($user) {
        //         $db->where('user_id', $user->id);
        //     } else {
        //         $db->where('user_id', -1);
        //     }

        // }
        $record = $db->orderBy('id', 'desc')->paginate(10);
        $wallet = $this->wallet_type();
        return $this->success([
            'record' => $record,
            'wallet' => $wallet,
        ], '');
    }
    public function changeWallet(Request $request)
    {
        $user = User::where('username', $request->get('username'))->where('role_id', 2)->first();
        if (!$user) {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '用户不存在',
            ));
=======
            return $this->fail('E00042', 'USER_NOT_EXISTS');
>>>>>>> Stashed changes
        }
        $user = $user->toArray();
        $wallet_type = $this->wallet_type();

        $wallet = $wallet_type[$request->get('wallet')];
        if ($request->get('amount') > $user[$wallet['id']] && $request->get('act') == '-') {
<<<<<<< Updated upstream
            return Response::json(array(
                'code' => 1,
                'message' => '钱包不足',
            ));
=======
            return $this->fail('E00043', 'INSUFFICIENT_BALANCE');
>>>>>>> Stashed changes
        }
        if ($request->get('detail')) {
            $detail = $request->get('detail');
        } else {
            $detail = '管理员调整';
        }
        if ($request->get('detail_en')) {
            $detail_en = $request->get('detail_en');
        } else {
            $detail_en = 'Admin adjustment';
        }
        $intype = $wallet['found_type'];
        $this->create_transaction($user['id'], $request->get('act'), $wallet['id'], 0, $intype, $request->get('amount'), $detail, $detail_en, 'Điều chỉnh của quản trị viên', 'Penyesuaian administrator', 'การปรับผู้ดูแลระบบ', $request->get('remark'));

        return $this->success(null, '');
    }
}
