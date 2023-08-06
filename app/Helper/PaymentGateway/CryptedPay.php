<?php
namespace App\Helper;

use App\Models\ThirdpartyLog;
use App\Models\UserWallet;

class CryptedPay
{

    public static function connect($data, $link)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        $log = ThirdpartyLog::create([
            'user_id' => $user_id,
            'link' => 'https://coin.cryptedpay.com/_incoming' . $link,
            'send_data' => json_encode($data),
            'platform' => 'CryptedPay',
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://coin.cryptedpay.com/_incoming' . $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: multipart/form-data",
            ),
        ));

        $response = curl_exec($curl);
        $log->respond_data = $response;
        $log->save();
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);

    }

    public static function getAddress($uid = 99999)
    {
        $wallet = UserWallet::where('user_id', $uid)->first();
        if (!$wallet) {
            $data['token'] = 'igd5c6A97e7RCaHDyd8S7UeHriaV86i0';
            $data['call_back_url'] = url('api/third-party/reload-respond');

            $return = static::connect($data, '/tron/usdt/get-address');

            if (isset($return->code) && $return->code == 100) {
                $new['wallet_type'] = 'TRC20-USDT';
                $new['privateKey'] = null;
                $new['address'] = $return->input_address;
                $new['hexAddress'] = null;
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
    public static function checkAddress($address)
    {

        $data['token'] = 'igd5c6A97e7RCaHDyd8S7UeHriaV86i0';
        $data['address'] = $address;

        $return = static::connect($data, '/tron/usdt/validate-address');

        if (isset($return->is_valid) && $return->is_valid == 'true') {

            $address = true;
        } else {
            $address = false;
        }

        return $address;
    }
    public static function withdraw($address, $refNo, $amount)
    {

        $data['token'] = 'igd5c6A97e7RCaHDyd8S7UeHriaV86i0';
        $data['refno'] = $refNo;
        $data['to'] = $address;
        $data['amount'] = $amount * 1000000;
        $data['callback_url'] = url('api/third-party/withdraw-respond');

        $data['signature'] = static::getSignature($data);
        $return = static::connect($data, '/tron/usdt/withdrawal');

        $respond['txid'] = '';
        $respond['error'] = '';
        if (isset($return->status) && $return->status == 100) {
            $respond['success'] = true;

            $respond['txid'] = $return->data->txid;
        } else {
            $respond['success'] = false;
            $respond['error'] = $return->error;
        }

        return $respond;
    }
    public static function getSignature($data)
    {

        $secretKey = 'Ri>_&-/GO`<n|Qxm*y!(WEr|gvPx+_&c';
        ksort($data);
        $request = '';
        foreach ($data as $key => $value) {
            $request = $request . $value;
        }
        return hash('sha256', $request . $secretKey);
    }

}
