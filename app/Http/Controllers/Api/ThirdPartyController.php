<?php
namespace App\Http\Controllers\Api;

use App\Helper\CryptedPay;
use App\Http\Controllers\Controller;
use App\Models\BoDepositRecord;
use App\Models\InsuranceBetHistory;use App\Models\ThirdpartyLog;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\WalletApi;
use App\Models\WalletReloadRecord;
use App\Models\WalletWithdrawRecord;
use App\Models\WithdrawCoin;
use Illuminate\Http\Request;

//project model//
class ThirdPartyController extends Controller
{
    public function reloadRespond(Request $request)
    {
        $sign = CryptedPay::getSignature($request->except('signature'));
        $data['action'] = 'Reload Respond';
        $data['respond_data'] = json_encode($request->all());
        WalletApi::create($data);

        if ($sign == $request->get('signature')) {

            $check = WalletReloadRecord::where('txid', $request->get('txid'))->first();
            if (!$check) {
                //Amount in tron. (6 decimals for USDT, 1 USDT = 1000000 tron)
                $record['address'] = $request->get('address');
                $record['amount'] = bcadd(($request->get('amount') / 1000000), 0, 6);
                $record['txid'] = $request->get('txid');
                $record['from_address'] = $request->get('from');
                $record['timestamp'] = $request->get('timestamp');
                $record['confirm'] = $request->get('confirmations');
                $reloadRecord = WalletReloadRecord::create($record);
                $wallet = UserWallet::where('address', $record['address'])->first();
                if ($wallet) {
                    $user = User::where('id', $wallet->user_id)->first();
                    if ($user) {
                        $reloadRecord->user_id = $user->id;
                        $this->create_transaction($user->id, '+', 'point1', 900, 1, $record['amount'], '充值成功', 'Reload Success', 'Tải lại thành công');
                        $reloadRecord->status = 1;
                        $reloadRecord->save();

                        if ($user->bio == 'vn') {
                            $user->pushMobileNotification('Gửi tiền thành công', 'Gửi thành công' . $record['amount'] . 'USDT', 'reload_complete');

                        } elseif ($user->bio == 'en') {
                            $user->pushMobileNotification('Deposit Success', 'Successfully deposit ' . $record['amount'] . 'USDT', 'reload_complete');

                        } else {
                            $user->pushMobileNotification('充值成功', '您充值' . $record['amount'] . 'USDT 已到账', 'reload_complete');
                        }
                        echo '完成';

                    }
                }

            }

        } else {

            echo '签名错误';
        }

    }
    public function withdrawRespond(Request $request)
    {

        $data['action'] = 'withdraw Respond';
        $data['respond_data'] = json_encode($request->all());
        WalletApi::create($data);
        $passin = json_decode($request->get('data'), true);
        unset($passin['signature']);
        if ($request->get('data')) {
            $sign = CryptedPay::getSignature($passin);
        } else {
            $sign = '12';
        }

        $respond = json_decode($request->get('data'));
        if ($sign == $respond->signature) {

            $check = WalletWithdrawRecord::where('txid', $respond->txid)->first();
            if (!$check) {
                //Amount in tron. (6 decimals for USDT, 1 USDT = 1000000 tron)
                $record['address'] = $respond->txid;
                $record['amount'] = bcadd(($respond->amount / 1000000), 0, 6);
                $record['txid'] = $respond->txid;
                $record['refno'] = $respond->refno;
                $record['signature'] = $respond->signature;
                $reloadRecord = WalletWithdrawRecord::create($record);
                if ($request->get('status') == 100) {
                    WithdrawCoin::where('refNo', $record['refno'])->update(['status' => 2]);
                } else {
                    WithdrawCoin::where('refNo', $record['refno'])->update(['status' => 0,
                        'error_message' => $request->get('error')]);
                }
            }

        } else {

            echo '签名错误';
        }

    }
    public function groupingRespond(Request $request)
    {
        $sign = $this->getSignature($request->except('signature'));
        if ($sign == $request->get('signature')) {
            $data['action'] = 'grouping Respond';
            $data['respond_data'] = json_encode($request->all());
            WalletApi::create($data);

            $check = WalletReloadRecord::where('address', $request->get('addr'))->first();
            if ($check) {
                $update['grouping_status'] = $request->get('state');
                $update['grouping_txid'] = $request->get('txid');
                $update['grouping_amount'] = $request->get('amount');
                $update['grouping_at'] = $request->get('create_time');
                WalletReloadRecord::where('address', $request->get('addr'))->
                    whereNull('grouping_txid')->update($update);
                echo '完成';
            }

        } else {
            echo '签名错误';
        }

    }
    //bo deposit to our system
    public function deposit(Request $request)
    {
        $log = ThirdpartyLog::create([
            'user_id' => 0,
            'link' => 'deposit',
            'respond_data' => json_encode($request->all()),
            'platform' => 'Binaxtion',
        ]);
        $sign = $this->getSignature($request->except('signature'));

        if ($sign == $request->get('signature')) {
            $user = User::where('username', $request->get('username'))->first();
            if (!$user) {
                return $this->jsonResponse([
                    'error_code' => 1,
                    'message' => 'User Not Found',
                ]);
            }
            if (!is_numeric($request->get('amount'))) {
                return $this->jsonResponse([
                    'error_code' => 3,
                    'message' => 'Amount must be numberic',
                ]);
            }
            $deposit = BoDepositRecord::where('orderid', $request->get('orderid'))->first();
            if (!$deposit) {
                BoDepositRecord::create([
                    'user_id' => $user->id,
                    'amount' => $request->get('amount'),
                    'timestamp' => $request->get('timestamp'),
                    'orderid' => $request->get('orderid'),
                ]);
                if ($request->get('wallet') == 'PROFIT') {
                    $this->create_transaction($user->id, '+', 'point2', 901, 2, $request->get('amount'), '交易盈利', 'Trading Profit', 'Tải lại thành công');
                } else {
                    $this->create_transaction($user->id, '+', 'point2', 902, 2, $request->get('amount'), 'BO充值成功', 'BO Deposit Success', 'Tải lại thành công');

                }

            }

            return $this->jsonResponse([
                'error_code' => 0,
                'message' => 'Deposit Successful',
            ]);
        } else {
            return $this->jsonResponse([
                'error_code' => 2,
                'sign' => $sign, 'time' => time(),
                'message' => 'Signature Fail',
            ]);
        }

    }
    //import bo bet history
    public function importBetRecord(Request $request)
    {
        $log = ThirdpartyLog::create([
            'user_id' => 0,
            'link' => 'importBetRecord',
            'respond_data' => json_encode($request->all()),
            'platform' => 'Binaxtion',
        ]);
        $sign = $this->getSignature($request->except('signature'));

        if ($sign == $request->get('signature')) {
            if ($request->get('bet_record') && count($request->get('bet_record')) > 1) {
                $bet_record = $request->get('bet_record');
                for ($i = 0; $i < count($bet_record); $i++) {
                    InsuranceBetHistory::create($bet_record[$i]);
                }
            }

            return $this->jsonResponse([
                'error_code' => 0,
                'message' => 'import Successful',
            ]);
        } else {
            return $this->jsonResponse([
                'error_code' => 2,
                'sign' => $sign, 'time' => time(),
                'message' => 'Signature Fail',
            ]);
        }

    }

    public static function getSignature($data)
    {
        $key = "g6O3DlDsq5";
        ksort($data);
        return strtoupper(md5(md5(http_build_query($data)) . $key));
    }
}
