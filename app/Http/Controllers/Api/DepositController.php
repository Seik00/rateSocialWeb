<?php
namespace App\Http\Controllers\Api;

use App\Helper\PaymentGateway\Crypto5Pay;
use App\Helper\PaymentGateway\Yodgs;
use App\Http\Controllers\Controller;
use App\Models\CoinSetting;
use App\Models\Deposit;
use App\Models\DepositCoin;
use App\Models\GlobalCountry;
use App\Models\User;
use Illuminate\Http\Request;

//project model//
class DepositController extends Controller
{

    /**
     * @OA\post(
     *     path="/api/deposit/depositCoin",
     *     tags={"Deposit"},
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
    public function depositCoin(Request $request)
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

        // if (!$systembank) {
        //     return $this->jsonResponse([
        //         'code' => 2,
        //         'message' => 'INCORRECT_ADDRESS',
        //     ]);
        // }
        /*
        $last = DepositCoin::where('user_id', $user->id)->where('status', 0)->first();
        if ($last) {
        return $this->jsonResponse([
        'code' => 2,
        'message' => 'LAST_DEPOSIT_PENDING',
        ]);
        }*/
        $record = $request->only('deposit_type', 'total_amount', 'amount', 'address', 'tx_id');

        $record['total_amount'] = $record['amount'];
        $record['user_id'] = $user->id;
        $deposit = DepositCoin::create($record);
        if ($deposit) {

            $dreampay = new Crypto5Pay;
            $deposit = $dreampay->deposit($user->id, $request->get('amount'), $deposit);
        } else {
            
            return $this->fail('E00011', 'PAYMENT_GATEWAY_ERROR');
        }

        // return $this->jsonResponse([
        //     'code' => 0,
        //     'data' => $deposit,
        //     'message' => 'REQUEST_COMPLETE',
        // ]);

    }
    /**
     * @OA\post(
     *     path="/api/deposit/depositCoin",
     *     tags={"Deposit"},
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
    public function depositCash(Request $request)
    {
        $this->validate($request, [
            'country_id' => 'required',

            'amount' => 'required|numeric',
        ]);

        $user = auth()->user();
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $country = GlobalCountry::where('status', '1')->where('id', $request->get('country_id'))->first();
        if (!$country) {
            return $this->fail('E00012', 'INCORRECT_COUNTRY');
        }
        $reload = $request->get('amount') * $country->sell;
        $record = $request->only('amount', 'country_id');
        // $record['system_bank_id'] = isset($request->get('system_bank_id')) ? $request->get('system_bank_id'):'100202';
        $record['system_bank_id'] = 100202; //isset($request->system_bank_id) ? $request->system_bank_id : 100202;
        $record['user_id'] = $user->id;

        $record['pay_amount'] = $reload;
        $deposit = Deposit::create($record);
        if ($deposit) {

            $Yodgs = new Yodgs;
            $deposit = $Yodgs->deposit($user->id, $reload, $deposit);
        } else {
            
            return $this->fail('E00011', 'PAYMENT_GATEWAY_ERROR');
        }
        return $this->success($deposit, 'REQUEST_COMPLETE');

    }

}
