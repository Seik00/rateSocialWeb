<?php
namespace App\Helper;

use App\Models\ThirdpartyLog;

class Binaxtion
{

    public static function getLink()
    {

        if (config('app.env') == 'production') {
            $result['link'] = 'https://binaxtion.com/_api965/v1.0';
            $result['token'] = 'winato';
            $result['secretKey'] = 'uouueo7YQ^88!WF%@r7IriGMa6d';
        } else {
            $result['link'] = 'https://uat.binaxtion.com/_api965/v1.0';
            $result['token'] = 'winato';
            $result['secretKey'] = 'uouueo7YQ^88!WF%@r7IriGMa6d';
        }
        $result['env'] = config('app.env');
        return $result;
    }

    public static function connect($data, $link)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        $domain = static::getLink();

        $log = ThirdpartyLog::create([
            'user_id' => $user_id,
            'link' => $domain['link'] . $link,
            'send_data' => json_encode($data),
            'platform' => 'Binaxtion',
        ]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $domain['link'] . $link,
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
        //  echo '<br><br>link:' . 'http://tanya.justtoview.com:2000/binaxtion/_api965/v1.0' . $link . '<br><br>';
        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);
        //  echo 'result:';
        $log->respond_data = $response;
        $log->save();
        //dump($response);
        return json_decode($response);

    }

    public static function login($username = 99999)
    {
        $domain = static::getLink();
        $data['token'] = $domain['token'];
        $data['call_back_url'] = url('web');
        $data['username'] = $username;
        $data['timestamp'] = time();
        $data['signature'] = static::getSignature($data['token'] . $data['username'] . $data['call_back_url'] . $data['timestamp']);

        echo '<form action="' . $domain['link'] . '/public-login-crm" id="depositForm" method="POST">';

        echo '<input type="hidden" name="token" value="' . $data['token'] . '">
        <input type="hidden" name="callback_url" value="' . $data['call_back_url'] . '">
        <input type="hidden" name="username" value="' . $data['username'] . '">
        <input type="hidden" name="timestamp" value="' . $data['timestamp'] . '">
        <input type="hidden" name="signature" value="' . $data['signature'] . '">
        </form>
        <script >
        console.log("haha");
        document.getElementById("depositForm").submit();
        </script> ';
    }
    public static function user_info($username)
    {

        $domain = static::getLink();
        $data['token'] = $domain['token'];
        $data['username'] = $username;
        $data['timestamp'] = time();
        $data['signature'] = static::getSignature($data['token'] . $data['username'] . $data['timestamp']);
        $return = static::connect($data, '/public-get-crm-user-info');

        if (isset($return->status_code) && $return->status_code == 100) {
            $result['username'] = $return->data->username;
            $result['capital'] = $return->data->capital_balance;
            $result['profit'] = $return->data->profit_balance;

        } else {
            $result['username'] = null;
            $result['capital'] = 0;
            $result['profit'] = 0;

        }
        return $result;
    }
    public static function deposit($username, $amount, $deposit_type, $lock_amount = 0)
    {
        //$deposit_type = topup/claim
        $domain = static::getLink();
        $data['token'] = $domain['token'];
        $data['username'] = $username;
        $data['orderid'] = 'IB' . time();
        $data['amount'] = $amount;
        $data['deposit_type'] = $deposit_type;
        $data['lock_amount'] = $lock_amount;
        $data['timestamp'] = time();
        $data['signature'] = static::getSignature($data['token'] . $data['username'] . $data['orderid'] . $data['amount'] . $data['deposit_type'] . $data['lock_amount'] . $data['timestamp']);
        $return = static::connect($data, '/public-deposit-wallet-winato');

        if (isset($return->status_code) && $return->status_code == 100) {
            return true;
        } else {
            return false;
        }

    }
    public static function pull_capital($username)
    {
        $domain = static::getLink();
        $data['token'] = $domain['token'];
        $data['username'] = $username;
        $data['orderid'] = 'IB' . time();
        $data['timestamp'] = time();
        $data['signature'] = static::getSignature($data['token'] . $data['username'] . $data['orderid'] . $data['timestamp']);
        $return = static::connect($data, '/public-pull-out-wallet-capital');

        if (isset($return->status_code) && $return->status_code == 100) {
            return $return->data->amount;
        } else {
            return false;
        }

    }

    public static function generate_string($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    public static function getSignature($data)
    {
        $salt = static::generate_string(5);
        $domain = static::getLink();
        $secretKey = $domain['secretKey'];
        /* echo 'salt:' . $salt . '<br>';
        echo 'sha256 :' . $data . $secretKey . $salt . '<br>';
        echo 'result sha256 :' . hash('sha256', $data . $secretKey . $salt) . '<br>';
        echo 'final signature : ' . hash('sha256', $data . $secretKey . $salt) . ':' . $salt;*/
        return hash('sha256', $data . $secretKey . $salt) . ':' . $salt;
    }

}
