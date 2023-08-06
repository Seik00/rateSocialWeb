<?php
namespace App\Helper;

class SmsSendCloud
{
    private $url;
    private $apiUser;
    private $userApiKey;

    public function __construct()
    {
        $this->url = 'https://api.sendcloud.net/smsapi/send';
        $this->apiUser = 'INSURANCE2U';
        $this->apiKey = 'NYZZ9Lia1GVF8OuGhrImabV3CfybaO37';
    }

    public function sign($apiKey, $params)
    {
        ksort($params);
        $signParts = [$apiKey, $apiKey];
        foreach ($params as $key => $value) {
            array_splice($signParts, -1, 0, $key . '=' . $value);
        }
        return md5(join('&', $signParts));
    }
    /*
     * msgType:
     *   0 表示短信，1 表示彩信，2 表示国际短信，3 表示国内语音，5 表示影音。
     *   默认值为 0。
     */

    public function sendsms_curl($phone, $otp)
    {
        $templateParams['%code%'] = $otp;

        $params = [
            'smsUser' => 'INSURANCE2U',
            'templateId' => 897570,
            'msgType' => 2,
            'phone' => $phone,
            'vars' => json_encode($templateParams, 1),
        ];

        $params['signature'] = $this->sign($this->apiKey, $params);
        $ch = curl_init();

        try {
            // https://www.php.net/manual/zh/function.curl-setopt.php
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->url,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_POSTFIELDS => http_build_query($params),
            ]);
            $result = curl_exec($ch);
            $error = curl_error($ch);
            if ($error) {
                return false;
            } else {
                return true;
            }

        } catch (Exception $error) {
            return false;
        } finally {
            curl_close($ch);

            return false;
        }
        return json_decode($result, true);

    }
}
