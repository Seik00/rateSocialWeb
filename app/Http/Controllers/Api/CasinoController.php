<?php
namespace App\Http\Controllers\Api;

use App\Helper\Game\Casino2U;
use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\User;
use App\Models\WalletTransaferRec;
use App\Models\UserGame;
use Illuminate\Http\Request;

//project model//
class CasinoController extends Controller
{
    /**
     * @OA\get(
     *     path="/api/casino/gameInfo",
     *     tags={"Casino"},
     *     summary="",
     *     description="gameInfo",
     *     operationId="gameInfo",
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
    public function gameInfo(Request $request)
    {
        $user = auth()->user();
        $game = GameList::where('id', 1)->first();

        $casino = new Casino2U();
        $gameAccount = $casino->accountInfo($user->id, $user->username);
        if (isset($gameAccount['data']->point)) {
            
            $profit = $gameAccount['data']->point - $user->package->price;
            if ($profit > 0) {
                $gameAccount['data']->profit = $profit;
            } else {
                $gameAccount['data']->profit = 0;
            }
            $gameAccount = $gameAccount['data'];
        }
        return $this->success([
            'game' => $game,
            'gameAccount' => $gameAccount], '');
        
    }

    /**
     * @OA\post(
     *     path="/api/casino/withdraw",
     *     tags={"Casino"},
     *     summary="",
     *     description="casino withdraw",
     *     operationId="withdraw",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ), @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount to deposit",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
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
        $amount = $request->get('amount');
        $user = auth()->user();
        //$result = Binaxtion::deposit($user->username, $amount);

        return $this->success($result, '');

    }

    public function withdrawCasinoProfit(Request $request)
    {
        $user = auth()->user();
        
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }

        $casino = new Casino2U();
        $gameAccount = $casino->accountInfo($user->id, $user->username);
        if (isset($gameAccount)) {
            $profit = $gameAccount['data']->point - $user->package->price;

            if($request->get('amount') > $profit){
                return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
                
            }

            $pull_capital = 0 - $request->get('amount');
            $casino_status = $casino->transfer($user->id, $pull_capital);
            if ($casino_status['success'] == false) {
                return $this->fail('E00007', 'ibo_return_msg');
            }
            
            $transfer_type = $request->get('transfer_type');

            if ($transfer_type == 'casino2u_profit') {

                $from_wallet = 'casino2u_profit';
                $from_type = '22';
                $to_wallet = 'point2';
                $to_type = '2';
                $save_wallet = 'casino2u_profit';

            } else {
                return $this->fail('E00008', 'INCORRECT_ACTION');
            }

            $record['user_id'] = $user->id;
            $record['to_id'] = $user->id;
            $record['founds'] = $request->get('amount');
            $record['wallet'] = $save_wallet;
            $record['ago'] = $profit;
            $record['current'] = '- ' . $request->get('amount');
            $record['balance'] = $profit - $request->get('amount');

            WalletTransaferRec::create($record);

            $this->create_transaction($user->id, '+', $to_wallet, 22, $to_type, $request->get('amount'), 'Casino2U划转', 'Casino2U Transfer', 'Chuyển khoản');

            return $this->success('', 'REQUEST_COMPLETE');
        }
    }

    public function depositCasinoProfit(Request $request)
    {
        $user = auth()->user();
        
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }

        if ($user->point1 < $request->get('amount') || $request->get('amount') < 0) {
            return $this->fail('E00006', 'INSUFFICIAN_BALANCE');
        }

        $casino = new Casino2U();
        $gameAccount = $casino->accountInfo($user->id, $user->username);
        if (isset($gameAccount)) {

            if($gameAccount['data']->point < $user->package->price || $user->package->id == 1){
                return $this->fail('E00009', 'PLEASE_PURCHASE_PACKAGE_TO_ACTION');
            }

            $deposit = $request->get('amount');
            $casino_status = $casino->transfer($user->id, $deposit);
            if ($casino_status['success'] == false) {
                return $this->fail('E00007', 'ibo_return_msg');
            }
            
            $transfer_type = $request->get('transfer_type');

            if ($transfer_type == 'point1') {

                $from_wallet = 'point1';
                $from_type = '1';
                $to_wallet = 'casino2u_profit';
                $to_type = '222';
                $save_wallet = 'point1';

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

            WalletTransaferRec::create($record);

            $this->create_transaction($user->id, '-', $from_wallet, 222, $from_type, $request->get('amount'), 'Casino2U充值', 'Casino2U Topup', 'Chuyển khoản');
            // $this->create_transaction($user->id, '+', $to_wallet, 7, $to_type, $request->get('amount'), 'Casino2U划转', 'Casino2U Transfer', 'Chuyển khoản');
            return $this->success('', 'REQUEST_COMPLETE');
        }
    }

}
