<?php
namespace App\Helper\PaymentGateway;

use App\Models\PaymentGatewayOrder;
use App\Models\ThirdpartyLog;

class Crypto5Pay
{
    private $depositLink;
    private $withdrawLink;
    private $merchantID; //商户号
    private $chainTypeId;
    private $channelName;
    private $secretKey; //秘钥

    public function __construct()
    {
        //crypto deposit
        if (config('app.env') == 'production') {
            $this->depositLink = 'https://en-payment.pay-mate.co/c2cOrder/createorder';
            $this->withdrawLink = 'https://payment.pay-mate.co/Withdrawal/SubmitWithdrawal';
            $this->merchantID = '53516'; //商户号
            $this->chainTypeId = '4';
            $this->channelName = 'C2C';
            $this->secretKey = '88er7i2NCprGt83r6CkM9PJm'; //秘钥

        } else {
            $this->depositLink = 'http://uat.en-payment.pay-mate.co/c2cOrder/createorder';
            $this->withdrawLink = 'http://uat.payment.pay-mate.co/Withdrawal/SubmitWithdrawal';
            $this->merchantID = '11'; //商户号
            $this->chainTypeId = '4';
            $this->channelName = 'C2C';
            $this->secretKey = 'Gg9A0Mh1BfEjzvq0k4L8J2wb'; //秘钥
        }

    }
    public function deposit($member_id, $amount, $deposit)
    {

        $date = date('Y/m/d h:i:s a', time());
        $date = (int) filter_var($date, FILTER_SANITIZE_NUMBER_INT);
        //
        $params = array(
            'merchantId' => $this->merchantID,
            'chainTypeId' => $this->chainTypeId,
            'channelName' => $this->channelName,
            'orderAmount' => isset($amount) ? number_format($amount,
                6) : "0.000000",
            'merchantOrderNo' => "C5P_D" . $date,
            'secretKey' => $this->secretKey,
            'notifyUrl' => url('api/payment-gateway/crypto5Pay-frontend-respond'),
            'returnUrl' => url('api/payment-gateway/crypto5Pay-backend-respond'),
        );
        $order['user_id'] = $member_id;
        $order['platform'] = 'Crypto5Pay';
        $order['payment_type'] = 'DepositCoin';
        $order['order_no'] = $params['merchantOrderNo'];
        $order['merchant_code'] = $this->merchantID;
        $order['amount'] = $amount;

        $payment = PaymentGatewayOrder::create($order);
        if ($deposit) {
            $deposit->document = $params['merchantOrderNo'];
            $deposit->payment_gateway_order_id = $payment->id;
            $deposit->save();
        }
        $paramEncrypt = $this->encryptAll($params);

        $signature = $this->sign($paramEncrypt);

        $paramEncrypt['sign'] = $signature;
        $log = ThirdpartyLog::create([
            'user_id' => $member_id,
            'link' => $this->depositLink,
            'send_data' => json_encode($paramEncrypt),
            'platform' => 'Crypto5Pay',
        ]);

        echo '<DOCTYPE html>
                <html lang="en">
                <head>
                <meta charset="UTF-8">
                <title>loading ...</title>
                </head>
                <body onload="document.MyForm.submit();">
                <form name="MyForm" action="' . $this->depositLink . '" method="post">';

        foreach ($paramEncrypt as $key => $val) {
            echo '<input type="hidden" name="' . $key . '" value="' . $val . '" />';
        }

        echo '</form></body></html>';

    }
    public function withdraw($member_id, $amount, $withdrawCoin)
    {

        $date = date('Y/m/d h:i:s a', time());
        $date = (int) filter_var($date, FILTER_SANITIZE_NUMBER_INT);
        //
        $params = array(
            'secretKey' => $this->secretKey,
            'MerchantId' => $this->merchantID,
            'MerchantOrderNo' => "C5P_W" . $date,
            'Wallet' => 'Coin2Coin',
            'Token' => 'USDT (TRC20)',
            'WithdrawalAmount' => isset($amount) ? number_format($amount,
                6) : "0.000000",
            'ByReceivableAmount' => "true",
            'WalletAddress' => $withdrawCoin->address,
            'notifyUrl' => url('api/payment-gateway/crypto5Pay-withdraw-respond'),

        );

        $order['user_id'] = $member_id;
        $order['platform'] = 'Crypto5Pay';
        $order['order_no'] = $params['MerchantOrderNo'];
        $order['merchant_code'] = $this->merchantID;
        $order['payment_type'] = 'WithdrawCoin';
        $order['amount'] = $amount;

        $payment = PaymentGatewayOrder::create($order);
        if ($withdrawCoin) {
            $withdrawCoin->payment_gateway_order_id = $payment->id;
            $withdrawCoin->save();
        }
        $paramEncrypt = $this->encryptWithdraw($params);

        $signature = $this->sign($paramEncrypt);

        $paramEncrypt['sign'] = $signature;

        $return = $this->connect($paramEncrypt, $this->withdrawLink);

        $result['success'] = false;
        $result['data'] = null;
        $result['error'] = null;

        if (isset($return)) {
            if (isset($return->Success) && $return->Success == true) {
                if (isset($return->Data[0])) {

                    $feedback = $this->dencryptWithdraw(json_decode($return->Data[0]->Data));

                    $result['data'] = $feedback;
                    $result['success'] = true;
                }
            } else {

                $result['error'] = $return->Message;
            }
        }
        return $result;
    }
    public function encryptWithdraw($params)
    {

        $paramsEncrypt = array(
            'merchantId' => $params['MerchantId'],
            'token' => $this->encrypt($params['Token'], $params['secretKey']),
            'withdrawalAmount' => $this->encrypt($params['WithdrawalAmount'], $params['secretKey']),
            'wallet' => $this->encrypt($params['Wallet'], $params['secretKey']),
            'merchantOrderNo' => $this->encrypt($params['MerchantOrderNo'], $params['secretKey']),
            'byReceivableAmount' => $this->encrypt($params['ByReceivableAmount'], $params['secretKey']),
            'walletAddress' => $this->encrypt($params['WalletAddress'], $params['secretKey']),
            'notifyUrl' => $params['notifyUrl'],
        );

        return $paramsEncrypt;

    }
    public function dencryptWithdraw($params)
    {
        $array = array();

        foreach ($params as $k => $v) {
            if ($k != 'MerchantId' && $k != 'NotifyUrl' && $k != 'transactionHash' && $k != 'transaction' && $k != 'merchantId') {
                $array[$k] = $this->decrypt($v);
            } else {
                $array[$k] = $v;
            }
        }

        return $array;

    }
    public function connect($data, $link)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        $send = array();
        $send[] = $data;

        $log = ThirdpartyLog::create([
            'user_id' => $user_id,
            'link' => $link,
            'send_data' => json_encode($send),
            'platform' => 'Crypto5Pay',
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($send),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $log->respond_data = $response;
        $log->save();
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);

    }
    public function sign($params)
    {

        ksort($params);

        $string = "";
        foreach ($params as $value) {
            $string .= $value;
        }

        $sha1Encrypt = sha1($string);
        $encryptedstring = md5($sha1Encrypt);

        return $encryptedstring;
    }

    public function encryptAll($params)
    {
        $paramsEncrypt = array(
            'merchantId' => $params['merchantId'],
            'orderAmount' => $this->encrypt($params['orderAmount'], $params['secretKey']),
            'chainTypeId' => $this->encrypt($params['chainTypeId'], $params['secretKey']),
            'merchantOrderNo' => $this->encrypt($params['merchantOrderNo'], $params['secretKey']),
            'channelName' => $this->encrypt($params['channelName'], $params['secretKey']),
            'notifyUrl' => $params['notifyUrl'],
            'returnUrl' => $params['returnUrl'],
        );

        return $paramsEncrypt;

    }

    public function encrypt($data, $secret = null)
    {
        $secret = $this->secretKey;
        //Take first 8 bytes of $key and append them to the end of $key.
        $subkey = substr($secret, 0, 8);

        // Encrypt data
        $encData = openssl_encrypt($data, "DES-EDE3-CBC", $secret, OPENSSL_RAW_DATA, $subkey);

        return bin2hex($encData);
    }

    public function decrypt($data, $secret = null)
    {
        //Take first 8 bytes of $key and append them to the end of $key.
        $secret = $this->secretKey;
        $subkey = substr($secret, 0, 8);

        $decOpenSSLZeroPadding = openssl_decrypt(hex2bin($data), 'DES-EDE3-CBC', $secret, OPENSSL_RAW_DATA, $subkey);

        return $decOpenSSLZeroPadding;
    }
}
