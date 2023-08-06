<?php
namespace App\Helper\TradingPlatform;

use App\Models\FundTransfer;
use App\Models\TradeAsset;
use App\Models\User;
use DB;

class Trade
{
    private $apiUrl;

    public function __construct()
    {
        if (config('app.env') == 'production') {

        } else {

        }

    }

    public function matchBuy($tradeOrder)
    {
        $user = auth()->user();
        $order = DB::select('SELECT *  FROM trade_order WHERE user_id !=' . $user->id . ' and order_type="SELL"  and match_status <2 order by order_price ASC,id ASC ');

        for ($i = 0; $i < count($order); $i++) {

            if ($tradeOrder->order_left > $order[$i]->order_left) {
                $amount = $order[$i]->order_left;
            } else {
                $amount = $tradeOrder->order_left;
            }

            $detail['buy_order_no'] = $tradeOrder->order_no;
            $detail['sell_order_no'] = $order[$i]->order_no;
            $detail['price'] = $order[$i]->order_price;
            $detail['amount'] = $amount;
            $detail['fee'] = 0;
            TradeMatchDetail::create($detail);
        }

    }
    public function create_asset($user_id, $act, $amount, $coin, $coin_log)
    {
        $asset = TradeAsset::firstOrCreate(['user_id' => $user_id,
            'coin_name' => $coin]);

        if ($act == '+') {

            $log['from_asset'] = $asset->$asset_active;
            $log['to_asset'] = $asset->$asset_active + $amount;

        } else {

            $log['from_asset'] = $asset->$asset_active;
            $log['to_asset'] = $asset->$asset_active + $amount;
        }

        $log['user_id'] = $asset->$user_id;
        $log['trade_asset_id'] = $asset->$id;
        $log['amount'] = $amount;
        $log['act'] = $act;
        $log['log_type'] = $coin_log;
    }
    public function create_transaction($user_id, $act, $wallet, $found_type, $wallet_type, $amount, $detail, $detailen, $detailvn = '', $detailkr = '', $detailth = '', $remark = '')
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json(false);
        }

        if ($amount < 0) {
            return response()->json(false);
        }

        if ($act == '+') {
            $add['current'] = $user->$wallet + $amount;
            $add['in_type'] = $wallet_type;

        } else {
            $add['current'] = $user->$wallet - $amount;
            $add['out_type'] = $wallet_type;
        }
        /*if ($add['current'] < 0) {
        return response()->json(false);
        }*/

        $add['previous'] = $user->$wallet;
        $add['action'] = $act;
        $add['user_id'] = $user_id;
        $add['found_type'] = $found_type;
        $add['found'] = $amount;
        $add['detail'] = $detail;
        $add['detailen'] = $detailen;
        $add['detailth'] = $detailth;
        $add['detailvn'] = $detailvn;
        $add['detailkr'] = $detailkr;
        $add['remark'] = $remark;

        $r = DB::table('users')->where('id', $user_id)->update([$wallet => $add['current']]);
        $r = FundTransfer::create($add);
        return response()->json($r);
    }

    public function generateCode($length)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    public function generate_password($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
}
