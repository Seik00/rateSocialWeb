<?php
namespace App\Helper\Game;

use App\Models\ThirdpartyLog;
use App\Models\UserGame;

class Casino2U
{
    private $apiUrl;

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'http://casino2u77.site';
        } else {
            $this->apiUrl = 'http://c2u77.dittogaming.com';

        }

    }

    public function connect($data, $link)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        $log = ThirdpartyLog::create([
            'user_id' => $user_id,
            'link' => $this->apiUrl . $link,
            'send_data' => json_encode($data),
            'platform' => 'Casino2u',
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl . $link,
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

    public function createAccount($uid = 99999, $username)
    {
        $usergame = UserGame::where('user_id', $uid)->first();
        if (!$usergame) {
            $data['member_id'] = $uid . rand(12, 99);
            $data['username'] = $username;
            $data['password'] = $this->generateCode(10);
            $data['game_id'] = 1;
            $return = $this->connect($data, '/api/create-member');

            if (isset($return->success) && $return->success == 1) {
                $new['user_id'] = $uid;
                $new['username'] = $data['username'];
                $new['password'] = $data['password'];
                $new['player_id'] = $data['member_id'];
                $new['game_id'] = $data['game_id'];
                $usergame = UserGame::create($new);

            } else {
                $usergame = '';
            }

        }

        return $usergame;
    }
    public function accountInfo($uid = 99999, $username = 'test')
    {
        $result['success'] = false;

        $usergame = UserGame::where('user_id', $uid)->first();
        if (!$usergame) {
            $usergame = $this->createAccount($uid, $username);
        }

        if ($usergame) {
            $data['member_id'] = $usergame->player_id;

            $return = $this->connect($data, '/api/balance');

            if (isset($return->success) && $return->success == 1) {
                $usergame->point = $return->balance;
                $usergame->save();
                $result['success'] = true;
            } else {
                $usergame = '';
            }
        }
        $result['data'] = $usergame;
        return $result;
    }

    public function transfer($uid = 99999, $point)
    {
        $result['success'] = false;
        $result['error'] = null;
        $usergame = UserGame::where('user_id', $uid)->first();

        if (!$usergame) {
            $usergame = $this->createAccount($uid);
        }
        if ($usergame) {
            $data['member_id'] = $usergame->player_id;
            $data['amount'] = $point;
            $return = $this->connect($data, '/api/transfer');

            if (isset($return->success) && $return->success == 1) {

                $result['success'] = true;
            } else {
                $result['error'] = $return->msg;

            }
        }

        return $result;
    }
    public function betHistory($from, $to)
    {
        $result['success'] = false;

        $data['from'] = $from;
        $data['to'] = $to;

        $return = $this->connect($data, '/api/bet-history');

        if (isset($return->success) && $return->success == 1) {
            $return->data;

        } else {
            $usergame = '';
        }

        $result['data'] = $usergame;
        return $result;
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
