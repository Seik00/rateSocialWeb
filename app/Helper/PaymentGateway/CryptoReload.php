<?php
namespace App\Helper;

use App\Models\UserWallet;

class CryptoReload
{

    public static function connect($data, $link)
    {
        //get method
        $data = http_build_query($data);
        $curl = curl_init();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://pay.infinityrobot.net' . $link . '?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch,CURLOPT_HEADER, false);
        $output = curl_exec($ch);

        curl_close($ch);
        //  return $link.'?'.$data;
        return json_decode($output);

    }

    public static function getAddress($uid = 99999)
    {
        $wallet = UserWallet::where('user_id', $uid)->first();
        if (!$wallet) {
            $data['contract'] = '';
            $data['decimals'] = 6;
            $data['remark'] = 'Atozbot';
            $data['coin'] = 'TRC20';
            $data['nonce'] = 6;
            $data['signature'] = static::getSignature($data);
            $return = static::connect($data, '/api/wallet/generateAddress');
            if (isset($return->code) && $return->code == 200) {
                $new['privateKey'] = $return->data->privateKey;
                $new['address'] = $return->data->address;
                $new['hexAddress'] = $return->data->hexAddress;
                $new['user_id'] = $uid;
                $wallet = UserWallet::create($new);
                $address = $wallet->address;
            } else {
                $address = '';
            }

        } else {
            $address = $wallet->address;
        }
        return $address;
    }
    public static function reload($uid = 99999)
    {
        $wallet = UserWallet::where('user_id', $uid)->first();
        if (!$wallet) {
            $data['contract'] = '';
            $data['decimals'] = 6;
            $data['remark'] = 'InfinityRobot'; //'Bosco';
            $data['coin'] = 'TRC20';
            $data['nonce'] = 6;
            $data['signature'] = static::getSignature($data);
            $return = static::connect($data, '/api/wallet/generateAddress');
            dump($return);exit;
            return $return;
            //static::create_transaction($record['user_id'], '+', 'point1', 1003, 1, $bonus, $record['detail'], $record['detailen']);

        } else {
            $address = $wallet->address;
        }
    }
    public static function getSignature($data)
    {
        $key = "M3eH4562MsieVbjlS1JfkF2EmVw7kWLb";
        ksort($data);
        return strtoupper(md5(md5(http_build_query($data)) . $key));
    }

    public static function create_transaction($user_id, $act, $wallet, $found_type, $wallet_type, $amount, $detail, $detailen, $detailvn = '', $detailkr = '', $detailth = '', $remark = '')
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
        if ($add['current'] < 0) {
            return response()->json(false);
        }

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
        $add['created_at'] = date("Y-m-d h:i:s");

        $r = DB::table('users')->where('id', $user_id)->update([$wallet => $add['current']]);
        $r = FundTransfer::create($add);
        return 1;
    }
}
