<?php
namespace App\Helper\PaymentGateway;

use App\Models\PaymentGatewayOrder;
use App\Models\ThirdpartyLog;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class Yodgs
{
    private $depositLink;
    private $withdrawLink;
    private $merchantID; //商户号
    private $secretKey; //秘钥
    private $publicKey; //秘钥
    private $privateKey; //秘钥

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->depositLink = 'https://crscs.yodgs.com/ty/orderPay';
            $this->withdrawLink = 'https://setsv.yodgs.com/withdraw/singleOrder';
            $this->merchantID = '861100000033534'; //商户号
            $this->md5Key = '597D5F0218AE75B981FB279CF2D10860'; //秘钥
            $this->publicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCec5wrKO/H67QUs6aofWdDSyjusMMqaQuETmo6KwWRcXKiAWS4AJAW4XV+Duj/mImShh3JRXLgnLHuD6VSv0UZF0jKcIcBGtwIsyJgGAPkRBmxae6QzZ6heYu/OndmH7velhcFX2gayLbbDcmlMtklUf+JE8M6YaoJEREjWKPNuQIDAQAB'; //秘钥
            $this->privateKey = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJ5znCso78frtBSzpqh9Z0NLKO6wwyppC4ROajorBZFxcqIBZLgAkBbhdX4O6P+YiZKGHclFcuCcse4PpVK/RRkXSMpwhwEa3AizImAYA+REGbFp7pDNnqF5i786d2Yfu96WFwVfaBrIttsNyaUy2SVR/4kTwzphqgkRESNYo825AgMBAAECgYBQxts8XXgv0QdS7mrtxlBYS/6oAFDeVALdBiS9VqVWCiHIWTGBZDgQkguVogBCHP81RU32B4OS4g8LL8q2LnAIlyPLHqNVHZVWBsS17dxnC08YTtg1HpuiGFSjudUdMbS5koJ/gA+Kye1yDtDbJq8rv31A3vK+GiHlN9jolPa8oQJBAM2GoyU4nzClSzSntcIa7yIg0PqPlg3lcxN1qtIjMCMMhUB9ajCYshIyyc7CEA7glSRS22CbvUISsPcg9jExt+0CQQDFXWwBziGqoMKFECsW++hHBr+gDcYeEnU2+OqRPVanNEAxO91V5UlJM9+AA9AdGl3FLsSAYuUQgvuGxgub8xt9AkEAod9V5X34G1dEqV8hz5RpHccc8QtgEufRv9TgSot+YUx+MvHUThwlvCGWQqsj/KOzs50yvZ9L65tPGAU1Aj/3bQJAVqNRA2Xab42Mdl8Hm1pPt8YlnnwNaSwPGmegiMtVW6bbOwGdgtRZHHJR/V8vH2dwnFuQVQ+UoG/vPFV5ySap/QJAdg1sTMcWJPgiYbS1I25V+mAUVZJlj1dtVD5J+vq9tOns9w2C/+hwMbwvP8zbL24xBpighZ2CMn1LvCcTIzgSPg=='; //秘钥

        } else {
            $this->depositLink = 'https://crscs.yodgs.com/ty/orderPay';
            $this->withdrawLink = 'https://setsv.yodgs.com/withdraw/singleOrder';
            $this->merchantID = '861100000011990'; //商户号
            $this->md5Key = 'A21919FADD064948D4D2DEAD66B3AF76'; //秘钥
            $this->publicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCGFlXyzNp0t/USiN5mcfBnKkjNjzUrwov20TCPLjg4qSmm9hV4GoCzBRpfb5Z8GFfX1LxLtq1ikPgbnlo7mpp7v6003/x2btQZwVsUOqgUOyKJZA/NezQTbhNVXmz+aTnqdaOgtZ2nfRhC7tkjdHNvtjHPQ4YFKcTZG8XqvIY17wIDAQAB'; //秘钥
            $this->privateKey = 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJIjGdZ2QNzuyEf9DNHzYt00RlkwaqEA9cgTyjMT4GtEq0sT3rcF9UPA8y4c6FEOZfyQ02OXh8jGbIyIyEvbOy5khYRomMQMFwjxeVpMoS6B7UlA9ZI6cq3SX3Gw5Ehin8svHGMyxGvCTvkRgV7jZR6FuWWaa4GgXxrbydF3YTx3AgMBAAECgYEAhlNdXJQ16t5RmlovfoyJQ2rZfwHSAUwwn0gRhAGxNuhXyxrojLMdTrn8zVYk9NyXQiCdLd4LIbHB9SuFcLSDIC1Ta/9BKfeyntAIYMoNFiGEx87oRrf4r8nvX7ZTv5Ywn1EgFv/N2z6O3Cn2EKoevzwhI6pMsTEUvpNCQyJfqIECQQDOVpXvhtW6ByH1RG1Oz8ywuMSBg2KkTblfYftRxE9Xudg3IoxxnJfFNx4LwxpZ/JNe6J6AZpx/M6yMqI1HK/jlAkEAtU9B5BsSLyCZ75jf27GPT8PPzF1bCLfKWW16BOGYuEina0wlW1jOKAXcAT8BJzn+1RWW2ERJBfJRGvl2WUPWKwJBALgoV1GcygxqaUh6dgStOkdP4TKmjNeP9y7GSIRF7Xqih/NNhoOv+1UtSEe/Ljm6T92ZSD3ZVzvAZvRzSwSGnnECQHA7d5Y0C7WQgLmH8EqWRxghJehjgY6L9n4U/os2+spYbwpEQHujJToxJla/IX+erthIXO/SlUFRFlOUSGZJT7ECQD+yRlcAp4EmW6ngFWFWHf+JsqQiEutYv1YVYUr+odHh0HlgD39BTpHzeqokQRjRxEk6PrQEReDJ0OH4Gd8i/X4='; //秘钥

        }

    }
    public function withdraw($member_id, $amount, $withdraw = 0)
    {

        $date = date('Y/m/d h:i:s a', time());
        $date = (int) filter_var($date, FILTER_SANITIZE_NUMBER_INT);
        $params = array(
            'mer_no' => $this->merchantID,
            'order_amount' => $amount,
            'mer_order_no' => "I2U_W" . $date,
            'notifyUrl' => url('api/payment-gateway/yodgs-withdraw-respond'),
            'ccy_no' => 'THB',
            'summary' => '',
            'mobile_no' => '1231312',
            'identity_no' => 'THB',
            'identity_type' => 'THB',
            'province' => 'THB',
        );
        if ($withdraw) {
            $params['bank_code'] = $withdraw->branch;
            $params['acc_name'] = $withdraw->bank_user;
            $params['acc_no'] = $withdraw->bank_number;
        } else {
            $params['bank_code'] = '';
            $params['acc_name'] = '';
            $params['acc_no'] = '';
        }
        $order['user_id'] = $member_id;
        $order['platform'] = 'Yodgs';
        $order['order_no'] = $params['mer_order_no'];
        $order['merchant_code'] = $this->merchantID;
        $order['amount'] = $amount;
        $order['payment_type'] = 'WITHDRAW';
        $payment = PaymentGatewayOrder::create($order);
        if ($withdraw) {
            $withdraw->payment_gateway_order_id = $payment->id;
            $withdraw->save();
        }
        $data = $this->encrypt($params);

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $result['success'] = false;
        $result['data'] = null;
        $result['error'] = null;
        $respond = $this->globalpay_http_post_res_json($this->withdrawLink, $data);
        if ($respond) {
            if (isset($respond->status) && $respond->status == 'SUCCESS') {
                $result['data'] = $respond->order_no;
                $result['success'] = true;
            } else {
                $result['error'] = $respond->err_msg;
            }
        } else {
            $result['error'] = 'Fail to connect payment gateway';
        }
        return $result;

    }
    public function deposit($member_id, $amount, $deposit = 0)
    {

        $date = date('Y/m/d h:i:s a', time());
        $date = (int) filter_var($date, FILTER_SANITIZE_NUMBER_INT);
        $params = array(
            'mer_no' => $this->merchantID,
            'phone' => '9852146882',
            'pname' => 'ZhangSan',
            'order_amount' => $amount,
            'goods' => "I2U_D" . $date,
            'mer_order_no' => "I2U_D" . $date,
            'notifyUrl' => url('api/payment-gateway/yodgs-backend-respond'),
            'pageUrl' => url('api/payment-gateway/yodgs-frontend-respond'),
            'ccy_no' => 'THB',
            'pemail' => "test@mail.com",
            'busi_code' => $deposit->system_bank_id,

        );
        $order['user_id'] = $member_id;
        $order['platform'] = 'Yodgs';
        $order['order_no'] = $params['mer_order_no'];
        $order['merchant_code'] = $this->merchantID;
        $order['amount'] = $amount;

        $payment = PaymentGatewayOrder::create($order);
        if ($deposit) {
            $deposit->document = $params['mer_order_no'];
            $deposit->payment_gateway_order_id = $payment->id;
            $deposit->save();
        }
        $data = $this->encrypt($params);

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $result['success'] = false;
        $result['data'] = null;
        $result['error'] = null;

        $respond = $this->globalpay_http_post_res_json($this->depositLink, $data);
        if ($respond) {
            if (isset($respond->status) && $respond->status == 'SUCCESS') {
                $result['data'] = $respond->order_data;
                $result['success'] = true;
            } else {
                $result['error'] = $respond->err_msg;
            }
        } else {
            $result['error'] = 'Fail to connect payment gateway';
        }
        return $result;

    }

//支付加密
    public function encrypt($data)
    {
        ksort($data);
        $str = '';
        foreach ($data as $k => $v) {
            if (!empty($v)) {
                $str .= (string) $k . '=' . $v . '&';
            }
        }
        $str = rtrim($str, '&');
        $encrypted = '';
        //替换成自己的私钥
        $pem = chunk_split($this->privateKey, 64, "\n");
        $pem = "-----BEGIN PRIVATE KEY-----\n" . $pem . "-----END PRIVATE KEY-----\n";

        $private_key = openssl_pkey_get_private($pem);
        $crypto = '';
        foreach (str_split($str, 117) as $chunk) {
            openssl_private_encrypt($chunk, $encryptData, $private_key);
            $crypto .= $encryptData;
        }
        $encrypted = base64_encode($crypto);
        $encrypted = str_replace(array('+', '/', '='), array('-', '_', ''), $encrypted);

        $data['sign'] = $encrypted;
        return $data;
    }
//解密
    public function decrypt($data)
    {

        ksort($data);
        dump($data);
        $toSign = '';
        foreach ($data as $key => $value) {
            if (strcmp($key, 'sign') != 0 && $value != '') {
                $toSign .= $key . '=' . $value . '&';
            }
        }

        $str = rtrim($toSign, '&');

        $encrypted = '';
        //替换自己的公钥
        $pem = chunk_split($this->publicKey, 64, "\n");
        $pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
        $publickey = openssl_pkey_get_public($pem);

        $base64 = str_replace(array('-', '_'), array('+', '/'), $data['sign']);

        $crypto = '';
        foreach (str_split(base64_decode($base64), 128) as $chunk) {
            openssl_public_decrypt($chunk, $decrypted, $publickey);
            $crypto .= $decrypted;
        }

        if ($str != $crypto) {
            return false;
        } else {
            return true;
        }

    }

//请求
    public function globalpay_http_post_res_json($url, $postData)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        $log = ThirdpartyLog::create([
            'user_id' => $user_id,
            'link' => $url,
            'send_data' => $postData,
            'platform' => 'Yodgs',
        ]);

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/json',
                'content' => $postData,
                'timeout' => 15 * 60, // 超时时间（单位:s）
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $log->respond_data = $result;
        $log->save();

        $result = json_decode($result);

        return $result;
    }

//生成查询签名
    public function makeMd5Sign($data)
    {
        $getsign = $data['sign'];
        unset($data['sign']);
        ksort($data);
        $str = '';
        foreach ($data as $k => $v) {
            if (!empty($v)) {
                $str .= (string) $k . '=' . $v . '&';
            }
        }
        $str = rtrim($str, '&');
        $str .= '&key=' . $this->md5Key;

        //加密
        $sign = md5($str);
        if ($sign == $getsign) {
            return true;
        } else {
            return false;
        }

    }

}
