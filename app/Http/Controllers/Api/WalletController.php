<?php
namespace App\Http\Controllers\Api;

use App\Helper\CryptedPay;
use App\Helper\SendCloud;
use App\Helper\Game\Casino2U;
use App\Http\Controllers\Controller;
use App\Models\BoostDeposit;
use App\Models\CoinSetting;
use App\Models\Deposit;
use App\Models\DepositCoin;
use App\Models\GlobalCountry;
use App\Models\SystemBank;
use App\Models\Uall;
use App\Models\User;
use App\Models\UserKyc;
use App\Models\WalletReloadRecord;
use App\Models\WalletTransaferRec;
use App\Models\WithdrawCash;
use App\Models\WithdrawCoin;
use Illuminate\Http\Request;

//project model//
class WalletController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/wallet/checkAllowDeposit",
     *     tags={"Wallet"},
     *     summary="",
     *     description="get deposit coin address",
     *     operationId="checkAllowDeposit",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function checkAllowDeposit(Request $request)
    {

        $user = auth()->user();
        $approval = BoostDeposit::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $result['deposit_info'] = $approval;
        if ($approval) {
            if ($approval->status == 2 || $approval->status == 3) {
                $result['approval'] = 2; //需要申请
            } elseif ($approval->status == 1) {
                $result['approval'] = 1; //批准申请可以去充值
            } else {
                $result['approval'] = 0; //叫他等 load着去

            }
        } else {
            $result['approval'] = 2;
        }
        return $this->jsonResponse([
            'code' => 0,
            'data' => $result,
            'message' => 'REQUEST_COMPLETE',
        ]);

    }
/**
 * @OA\post(
 *     path="/api/wallet/requestMakeDeposit",
 *     tags={"Wallet"},
 *     summary="",
 *     description="deposit Coin",
 *     operationId="requestMakeDeposit",
 *     deprecated=false,
 *     security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *         name="amount",
 *         in="query",
 *         description="amount",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *       @OA\Parameter(
 *         name="deposit_type",
 *         in="query",
 *         description="BANK/USDT_TRC20/USDT_ERC20",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="successful operation"
 *     ),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     @OA\Response(
 *         response=422,
 *         description="Error"
 *     )
 * )
 */
    public function requestMakeDeposit(Request $request)
    {
        $this->validate($request, [
            'deposit_type' => 'required',
            'amount' => 'required|numeric',
        ]);

        $user = auth()->user();
        $approval = BoostDeposit::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        if ($approval) {
            if ($approval->status != 2 && $approval->status != 3) {
                return $this->fail('E00030', 'NOT_ALLOW_REQUEST');
            }
        }

        $record = $request->only('deposit_type', 'amount', );

        $record['user_id'] = $user->id;

        BoostDeposit::create($record);

        return $this->success('', 'REQUEST_COMPLETE');

    }
    /**
     * @OA\GET(
     *     path="/api/wallet/getDepositAddress",
     *     tags={"Wallet"},
     *     summary="",
     *     description="get deposit coin address",
     *     operationId="getDepositAddress",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getDepositAddress(Request $request)
    {

        $user = auth()->user();
        $address = CoinSetting::get();
        return $this->success($address, 'REQUEST_COMPLETE');

    }
    /**
     * @OA\post(
     *     path="/api/wallet/doDepositCoin",
     *     tags={"Wallet"},
     *     summary="",
     *     description="deposit Coin",
     *     operationId="doDepositCoin",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="total_amount",
     *         in="query",
     *         description="total amount for DSP ",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="amount for first wallet",
     *         in="query",
     *         description="amount",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *       @OA\Parameter(
     *         name="amount2",
     *         in="query",
     *         description="amount2 for DFI coin",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="tx_id",
     *         in="query",
     *         description="tx id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="tx_id2",
     *         in="query",
     *         description="tx id for DFI coin",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="address from getDepositAddress",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="deposit_type",
     *         in="query",
     *         description="name from getDepositAddress",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="document",
     *         in="query",
     *         description="document id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * *       @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="uploaded id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function doDepositCoin(Request $request)
    {
        $this->validate($request, [
            'deposit_type' => 'required',
            'sec_password' => 'required',
            // 'address' => 'required',
            // 'tx_id' => 'required',

            'amount' => 'required|numeric',
        ]);

        $user = auth()->user();
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $systembank = CoinSetting::where('name', $request->get('deposit_type'))->first();

        if (!$systembank) {
            return $this->fail('E00031', 'INCORRECT_ADDRESS');
        }

        $last = DepositCoin::where('user_id', $user->id)->where('status', 0)->first();
        if ($last) {
            return $this->fail('E00032', 'LAST_DEPOSIT_PENDING');
        }
        if ($request->get('deposit_type') == 'DBP&DFI') {
            if ($request->get('amount2') > $user->point1) {
                return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
            } else {
                $r = $this->create_transaction($user->id, '-', 'point1', 98, 1, $request->get('amount2'), '申请充值', 'Request deposit', 'Chuyển sang ');

            }

        }
        $record = $request->only('deposit_type', 'total_amount', 'amount2', 'amount', 'address', 'tx_id', 'tx_id2', 'amount2', 'document');
        $record['market_price'] = $this->global_key('DFI_PRICE');
        $record['user_id'] = $user->id;
        $record['dfi_address'] = $this->global_key('DFI_ADDRESS');
        DepositCoin::create($record);

        return $this->success('', 'REQUEST_COMPLETE');

    }
    /**
     * @OA\GET(
     *     path="/api/wallet/getDepositBank",
     *     tags={"Wallet"},
     *     summary="",
     *     description="get deposit Bank",
     *     operationId="getDepositBank",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getDepositBank(Request $request)
    {

        $user = auth()->user();
        $bank = SystemBank::get();
        return $this->success($bank, 'REQUEST_COMPLETE');

    }
    /**
     * @OA\post(
     *     path="/api/wallet/doDeposit",
     *     tags={"Wallet"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="doDeposit",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="document",
     *         in="query",
     *         description="uploaded id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="system_bank_id",
     *         in="query",
     *         description="return from get deposit bank id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * *       @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="uploaded id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function doDeposit(Request $request)
    {
        $this->validate($request, [
            'system_bank_id' => 'required',
            'sec_password' => 'required',
            'document' => 'required',
            'amount' => 'required|numeric',
        ]);

        $user = auth()->user();
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $systembank = SystemBank::where('id', $request->get('system_bank_id'))->where('is_display', 1)->first();

        if (!$systembank) {
            return $this->fail('E00033', 'INCORRECT_BANK');
        }
        $last = Deposit::where('user_id', $user->id)->where('status', 0)->first();
        if ($last) {
            
            return $this->fail('E00032', 'LAST_DEPOSIT_PENDING');
        }
        $country = GlobalCountry::where('status', '1')->where('id', $request->get('country_id'))->first();
        if (!$country) {
            return $this->fail('E00012', 'INCORRECT_COUNTRY');
        }
        $record = $request->only('document', 'amount', 'system_bank_id', 'country_id');

        $record['user_id'] = $user->id;

        $record['pay_amount'] = $request->get('amount') * $country->sell;
        Deposit::create($record);

        return $this->success('', 'REQUEST_COMPLETE');

    }
    /**
     * @OA\post(
     *     path="/api/wallet/check-receiver",
     *     tags={"Wallet"},
     *     summary="",
     *     description="check receiver",
     *     operationId="checkReceiver",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function checkReceiver(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',

        ]);
        $user = auth()->user();

        $to_user = User::where('username', $request->get('username'))->first();

        if (!$to_user || $user->id == $to_user->id) {
            $to_user = null;
        }
        if ($to_user) {
            if ($user->uid != 100000) {
                $to_uid = Uall::where('user_id', $to_user->id)->where('p', 'like', '%' . $user->id . '%')->first();
                if (!$to_uid) {
                    $to_uid = Uall::where('user_id', $user->id)->where('p', 'like', '%' . $to_user->id . '%')->first();
                }
                if (empty($to_uid)) {
                    $to_user = null;
                }
            }
        }
        return $this->success($to_user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\post(
     *     path="/api/wallet/wallet-transafer",
     *     tags={"Wallet"},
     *     summary="",
     *     description="wallet transafer",
     *     operationId="walletTransfer",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="transfer_type",
     *         in="query",
     *         description="point1 = 1 point2 = 2",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function walletTransfer(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'sec_password' => 'required',
            'amount' => 'required|numeric',
            'transfer_type' => 'required',
        ]);
        $user = auth()->user();
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }

        if (!$user->wt) {
            
            return $this->fail('E00034', 'NO_PERMISSION');
        }

        $to_user = User::where('username', $request->get('username'))->first();

        if (!$to_user || $user->id == $to_user->id) {
            return $this->fail('E00035', 'INCORRECT_USERNAME');
        }

        if ($user->uid != 100000) {
            $to_uid = Uall::where('user_id', $to_user->id)->where('p', 'like', '%' . $user->id . '%')->first();
            if (!$to_uid) {
                $to_uid = Uall::where('user_id', $user->id)->where('p', 'like', '%' . $to_user->id . '%')->first();
            }
            if (empty($to_uid)) {
                return $this->fail('E00035', 'INCORRECT_USERNAME');
            }
        }
        $wallet_type = $this->wallet_type();

        if ($request->get('transfer_type') == 'point1') {
            $wallet = 'point1';
            $wallet_type = 1;
            $to_wallet = 'point1';
            $to_wallet_type = 1;

        } elseif ($request->get('transfer_type') == 'point2') {
            $wallet = 'point2';
            $wallet_type = 2;
            $to_wallet = 'point2';
            $to_wallet_type = 2;

        } else if ($request->get('transfer_type') == 'point3') {
            $wallet = 'point3';
            $wallet_type = 3;
            $to_wallet = 'point3';
            $to_wallet_type = 3;

        } else {
            return $this->fail('E00008', 'INCORRECT_ACTION');
        }

        $amount = $request->get('amount');
        if ($user->$wallet < $amount || $amount < 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }
        //$fee = $this->global_key('TRANSFER_FEE');
        $r = $this->create_transaction($user->id, '-', $wallet, 200, $wallet_type, $amount, '转账到' . $to_user->username, 'Transfer to ' . $to_user->username, 'Chuyển sang ' . $to_user->username);
        $r = $this->create_transaction($to_user->id, '+', $to_wallet, 201, $to_wallet_type, $amount, '收款来自 ' . $user->username, 'Receive from ' . $user->username, 'Nhận thanh toán từ ' . $user->username);
        $record['user_id'] = $user->id;
        $record['to_id'] = $to_user->id;
        $record['founds'] = $amount;
        $record['wallet'] = $wallet;
        $record['ago'] = $user->$wallet;
        $record['current'] = '- ' . $amount;
        $record['balance'] = $user->$wallet - $amount;
        $record['dis'] = $request->get('remark');
        WalletTransaferRec::create($record);

        return $this->success('', 'REQUEST_COMPLETE');
    }
    /**
     * @OA\get(
     *     path="/api/wallet/wallet-tranfer-record",
     *     tags={"Wallet"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="walletTransferRecord",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function walletTransferRecord(Request $request)
    {
        $user = auth()->user();
        $record = WalletTransaferRec::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('wallet', 'point1')
                    ->orwhere('wallet', 'point2')
                    ->orwhere('wallet', 'point3');
            })->orderBy('id', 'desc')->paginate(10);

            return $this->success($record, '');
    }
    /**
     * @OA\get(
     *     path="/api/wallet/deposit-record",
     *     tags={"Wallet"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="depositRecord",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *  *   @OA\Parameter(
     *         name="deposit_type",
     *         in="query",
     *         description="CASH /COIN",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function depositRecord(Request $request)
    {
        $user = auth()->user();
        if ($request->get('deposit_type') == 'COIN') {
            $record = DepositCoin::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        } else {
            $record = Deposit::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        }
        // $record = FundTransfer::where('user_id', auth()->user()->id)->where('found_type', 900)->orderBy('id', 'desc')->paginate(10);

        return $this->success($record, '');

    }
    /**
     * @OA\get(
     *     path="/api/wallet/withdraw-record",
     *     tags={"Wallet"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="withdrawRecord",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *         name="withdraw_type",
     *         in="query",
     *         description=" /COIN",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function withdrawRecord(Request $request)
    {
        $user = auth()->user();

        if ($request->get('withdraw_type') == 'COIN') {
            $record = WithdrawCoin::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        } else {
            $record = WithdrawCash::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        }

        $fee = $this->global_key('WITHDRAW_FEE');

        return $this->jsonResponse([
            'code' => 0,
            'data' => $record,
            'fee' => $fee,
            'message' => '',
        ]);
    }
    /**
     * @OA\post(
     *     path="/api/wallet/withdraw",
     *     tags={"Wallet"},
     *     description="withdraw",
     *     operationId="withdraw",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function withdraw(Request $request)
    {
        $this->validate($request, [
            // 'sec_password' => 'required',
            'amount' => 'required|numeric',
            'address' => 'required',

        ]);

        $user = auth()->user();
        // $error = $this->check_secpass($request->get('sec_password'));
        // if ($error) {
        //     return $error;
        // }
        if (!$user->wr) {
            return $this->fail('E00034', 'NO_PERMISSION');
        }
        // if (!CryptedPay::checkAddress($request->get('address'))) {
        //     return $this->jsonResponse([
        //         'code' => 2,
        //         'data' => false,
        //         'message' => 'Invalid withdraw address',
        //     ]);
        // }

        // $check_kyc = UserKyc::where([
        //     ['user_id', '=', $user->id],
        //     ['status', '=', 0],
        // ])->first();

        // if ($check_kyc) {
        //     return $this->jsonResponse([
        //         'code' => 2,
        //         'data' => false,
        //         'message' => 'PENDING',
        //     ]);
        // }

        $wallet = 'point2';
        $wallet_type = 2;
        $amount = $request->get('amount');
        if ($user->$wallet < $amount || $amount < 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }

        if ($amount < 10) {
            return $this->fail('E00036', 'MIN_WITHDRAW_AMOUNT_IS_10');
        }
        $pending = WithdrawCoin::where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('status', 0)
                    ->orWhere('status', 1);
            })->first();

        if ($pending) {
            return $this->fail('E00032', 'LAST_WITHDRAWAL_PENDING');
        }
        /* if ($this->is_decimal($amount)) {
        return $this->jsonResponse([
        'code' => 2,
        'data' => false,
        'message' => 'MUST_Integer',
        ]);
        }*/
        $fee = $request->get('amount') * ($this->global_key('WITHDRAW_FEE') / 100);
        $record = $request->only('amount', 'address', 'wallet_type');

        $record['get_amount'] = $request->get('amount') - $fee;
        $record['fee'] = $fee;
        $record['address'] = $request->get('address');
        $record['user_id'] = $user->id;
        $record['wallet'] = $wallet_type;
        WithdrawCoin::create($record);
        $this->create_transaction($user->id, '-', $wallet, 210, $wallet_type, $amount, '申请提现', 'Request withdraw', 'Đăng ký rút tiền');
        if ($user->email) {
            $sendCloud = new SendCloud();
            $sendCloud->mailTemplate($user, $record['get_amount'], 'withdraw_pending');
        }
        if ($user->bio == 'vn') {
            $user->pushMobileNotification('Đơn rút tiền', 'Bạn đã đăng ký rút tiền ' . $request->get('amount') . 'USDT ', 'request_withdraw');

        } elseif ($user->bio == 'en') {
            $user->pushMobileNotification('Withdrawal application', 'You have applied for withdrawal ' . $request->get('amount') . 'USDT ', 'request_withdraw');

        } else {
            $user->pushMobileNotification('提现申请', '您已申请提现' . $request->get('amount') . 'USDT ', 'request_withdraw');

        }

        return $this->success('', 'REQUEST_COMPLETE');
    }

    /**
     * @OA\get(
     *     path="/api/wallet/withdrawCashRecord",
     *     tags={"Wallet"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="withdrawCashRecord",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function withdrawCashRecord(Request $request)
    {
        $user = auth()->user();
        $record = WithdrawCash::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        return $this->success($record, '');
    }
    /**
     * @OA\post(
     *     path="/api/wallet/withdrawCash",
     *     tags={"Wallet"},
     *     description="withdrawCash",
     *     operationId="withdrawCash",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="bank_country",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="bank_name",
     *         in="query",
     *         description="point1 = 1 point2 = 2",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="bank_user",
     *         in="query",
     *         description="point1 = 1 point2 = 2",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *        @OA\Parameter(
     *         name="bank_number",
     *         in="query",
     *         description="point1 = 1 point2 = 2",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="branch",
     *         in="query",
     *         description="point1 = 1 point2 = 2",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *         @OA\Parameter(
     *         name="swift_code",
     *         in="query",
     *         description="point1 = 1 point2 = 2",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function withdrawCash(Request $request)
    {
        $this->validate($request, [
            // 'sec_password' => 'required',
            'amount' => 'required|numeric',
            'bank_country' => 'required',
            'bank_name' => 'required',
            'bank_user' => 'required',
            'bank_number' => 'required',
            'branch' => 'required',
        ]);

        $user = auth()->user();
        // $error = $this->check_secpass($request->get('sec_password'));
        // if ($error) {
        //     return $error;
        // }
        if (!$user->wr || $user->round != 2) {
            return $this->fail('E00034', 'NO_PERMISSION');
        }

        // $today_completed_order = BoostOrder::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();

        // $today_completed_order = $today_completed_order + $user->boost_limit;
        // $limit = $user->package->boost_times;

        // if ($today_completed_order < $limit) {
        //     return $this->jsonResponse([
        //         'code' => 2,
        //         'data' => false,
        //         'message' => 'TODAY_HAVEN_COMPLETE_TASK',
        //     ]);
        // }
        $wallet = 'point1';
        $wallet_type = 1;
        $amount = $request->get('amount');
        if ($user->$wallet < $amount || $amount < 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }
        /* if ($this->is_decimal($amount)) {
        return $this->jsonResponse([
        'code' => 2,
        'data' => false,
        'message' => 'MUST_Integer',
        ]);
        }*/
        if ($amount < 5) {
            return $this->fail('E00037', 'WITHDRAW_BETWEEN_25-5000');
        }
        $pending = WithdrawCash::where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('status', 0)
                    ->orWhere('status', 1);
            })->first();

        if ($pending) {
            return $this->fail('E00032', 'LAST_WITHDRAWAL_PENDING');
        }

        $record = $request->only(
            'amount',
            'bank_country',
            'bank_name',
            'bank_user',
            'bank_number',
            'branch',
            'swift_code');
        $country = GlobalCountry::where('id', $request->get('bank_country'))->first();
        $fee = ($request->get('amount') * $this->global_key('WITHDRAW_FEE')) *  100;

        // $fee = ($request->get('amount')) * ($chargefee / 100);
        //$record['get_amount'] = ($request->get('amount') * $country->buy) - $fee;
        $record['get_amount'] = $request->get('amount') - $fee;
        $record['currency'] = $country->short_form;
        $record['user_id'] = $user->id;
        $record['wallet'] = $wallet_type;
        WithdrawCash::create($record);
        $this->create_transaction($user->id, '-', $wallet, 210, $wallet_type, $amount, '申请提现', 'Request withdraw', 'Ajukan permohonan penarikan', 'สมัครถอนเงิน', 'Đăng ký rút tiền');

        return $this->success('', 'REQUEST_COMPLETE');
    }

    /**
     * @OA\post(
     *     path="/api/wallet/changeWallet",
     *     tags={"Wallet"},
     *     description="change_wallet",
     *     operationId="change_wallet",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="founds",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *   *      @OA\Parameter(
     *         name="transfer_type",
     *         in="query",
     *         description="point1/point2/point3",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function changeWallet(Request $request)
    {
        $user = auth()->user();
        /*$this->validate($request, [
        //  'sec_password' => 'required',
        'amount' => 'required|numeric',
        'transfer_type' => 'required',
        ]);*/

        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }

        if (!$user->wt) {
            return $this->fail('E00034', 'NO_PERMISSION');
        }
        if ($request->get('amount') <= 0 || !is_numeric($request->get('amount')) || !preg_match('/^[0-9]+(\\.[0-9]+)?$/', $request->get('amount'))) {
            return $this->fail('E00038', 'INCORRECT_AMOUNT');
        }

        /*  if (($request->get('amount') - (int) $request->get('amount')) != 0) {
        return $this->jsonResponse([
        'code' => 2,
        'data' => false,
        'message' => 'INCORRECT_AMOUNT',
        ]);
        }*/
        $transfer_type = $request->get('transfer_type');

        if ($user->$transfer_type < $request->get('amount')) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }

        if ($transfer_type == 'point1') {

            $from_wallet = 'point1';
            $from_type = '1';
            $to_wallet = 'point2';
            $to_type = '2';
            $save_wallet = $transfer_type . ' -> ' . $to_wallet;

        } elseif ($transfer_type == 'point2') {

            $from_wallet = 'point2';
            $from_type = '2';
            $to_wallet = 'point1';
            $to_type = '1';
            $save_wallet = $transfer_type . ' -> ' . $to_wallet;

        } else {
            return $this->fail('E00008', 'INCORRECT_ACTION');
        }

        $record['user_id'] = $user->id;
        $record['to_id'] = $user->id;
        $record['founds'] = $request->get('amount');
        $record['wallet'] = $save_wallet;
        $record['ago'] = $user->$from_wallet;
        $record['current'] = '- ' . $request->get('amount');
        $record['balance'] = $user->$from_wallet - $request->get('amount');
        $record['dis'] = $request->get('remark');
        WalletTransaferRec::create($record);

        $this->create_transaction($user->id, '-', $from_wallet, 7, $from_type, $request->get('amount'), '钱包划转', 'Wallet Transfer', 'Chuyển khoản');
        $this->create_transaction($user->id, '+', $to_wallet, 7, $to_type, $request->get('amount'), '钱包划转', 'Wallet Transfer', 'Chuyển khoản');

        return $this->success('', 'REQUEST_COMPLETE');
    }

    public function boDepositRecord(Request $request)
    {
        $user = auth()->user();

        $record = WalletReloadRecord::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        return $this->success($record, '');

    }
}
