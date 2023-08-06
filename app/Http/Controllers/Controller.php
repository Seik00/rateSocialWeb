<?php

namespace App\Http\Controllers;

use App\Exports\RecordExport;
use App\HMS\HuaweiPush;
use App\Models\FundTransfer;
use App\Models\GlobalSetting;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserDevice;
use Auth;
use DB;
use FCM;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function global_key($key)
    {
        $GLOBAL = GlobalSetting::where('global_key', $key)->first();
        if ($GLOBAL) {
            return $GLOBAL->key_value;
        } else {
            return '';
        }
    }
    public function set_key($key, $value)
    {
        $GLOBAL = GlobalSetting::where('global_key', $key)->first();

        if ($GLOBAL) {
            $GLOBAL->key_value = $value;
            $GLOBAL->save();

        } else {
            return '';
        }
    }
    public function check_login()
    {
        $user = Auth::user();
        if (!$user) {
            echo '<script>alert("Please Login to continue");
			location.replace("/login");</script>';
        }
    }
    public function check_secpass($secpass)
    {
        $user = auth()->user();
        if (!Hash::check($secpass, $user->password2)) {
            return $this->jsonResponse([
                'code' => 1,
                'data' => false,
                'message' => 'INCORRECT_SEC_PASSWORD',
            ]);
        } else {
            return false;
        }
    }
    protected function jsonResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }
    protected function success($data, $message)
    {
        return response()->json([
            'data' => $data,
            'error_code' => '0',
            'message' => $message,
        ]);
    }
    protected function fail($errorCode, $errorMessage)
    {

        return response()->json([
            'data' => '',
            'error_code' => $errorCode,
            'message' => $errorMessage,
        ]);
    }
    protected function generate_string($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    protected function pushUserNotice($user_id, $token, $title, $body, $notification_type)
    {
        if ($user_id > 0) {
            $batch = UserDevice::where('user_id', $user_id)->get()->toArray();
            if ($batch) {
                $notice_record['title'] = $title;
                $notice_record['notice_type'] = $notification_type;
                $notice_record['description'] = $body;
                $notice_record['users_id'] = $user_id;
                Notification::Create($notice_record);
                for ($i = 0; $i < count($batch); $i++) {
                    $this->pushNotification($title, $body, $batch[$i]['device_token'], $notification_type, $batch[$i]['os_type']);
                }

            }
        } elseif ($token != 0) {
            $device = UserDevice::where('device_token', $token)->first();
            if ($device) {
                $notice_record['title'] = $title;
                $notice_record['notice_type'] = $notification_type;
                $notice_record['description'] = $body;
                $notice_record['users_id'] = $user_id;
                Notification::Create($notice_record);
                $this->pushNotification($title, $body, $device->device_token, $notification_type, $device->os_type);
            }

        } else {
            $batch = UserDevice::get()->toArray();
            if ($batch) {
                for ($i = 0; $i < count($batch); $i++) {
                    $this->pushNotification($title, $body, $batch[$i]['device_token'], $notification_type, $batch[$i]['os_type']);
                    $notice_record['title'] = $title;
                    $notice_record['notice_type'] = $notification_type;
                    $notice_record['description'] = $body;
                    $notice_record['users_id'] = $batch[$i]['user_id'];
                    Notification::firstOrCreate($notice_record);
                }

            }
        }
    }
    protected function pushNotification($title, $body, $device_token, $notification_type = 1, $device_type = 'IOS')
    {
        /**
         * this is huawei push notification
         */
        if ($device_type == 'HUAWEI') {
            $push = new HuaweiPush();

            // // notification message
            $message = [
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                "android" => [
                    "data" => "hi there",
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                        "click_action" => [
                            "type" => 1,
                            "intent" => "#Intent;compo=com.rvr/.Activity;S.W=U;end",
                        ],
                    ],
                ],
                "token" => array($device_token),
            ];

            $result = $push->push_send_msg($message);
            return response()->json([
                'data' => $result,
            ]);
        } else {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(0);

            $notificationBuilder = new PayloadNotificationBuilder($title);
            $notificationBuilder->setBody($body)
                ->setClickAction('FLUTTER_NOTIFICATION_CLICK')
                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
                'notification_type' => $notification_type,
                'title' => $title,
                'body' => $body,
            ]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $downstreamResponse = FCM::sendTo($device_token, $option, $notification, $data);

            return response()->json([
                'data' => array(
                    'success' => $downstreamResponse->numberSuccess(),
                    'failure' => $downstreamResponse->numberFailure(),
                    'modification' => $downstreamResponse->numberModification(),
                ),
            ]);
        }
    }

    protected function activities_log($log_name, $description, $changed_data = '', $causer_type = 'App\User')
    {
        $user = Auth::user();
        $r = DB::table('activity_log')->insert([
            'causer_id' => $user->id,
            'log_name' => $log_name,
            'causer_type' => $causer_type,
            'ip_address' => \Request::ip(),
            'properties' => json_encode($changed_data),
            'description' => $description,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        return $r;
    }
    protected function check_number($founds)
    {
        if (!is_numeric($founds) || !preg_match('/^[0-9]+(\\.[0-9]+)?$/', $founds)) {
            return false;
        } else {
            return true;
        }
    }
    protected function generateCode($length)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    protected function generate_password($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    protected function generate_number($length)
    {
        $chars = '1234567890';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    public function is_decimal($val)
    {
        return is_numeric($val) && floor($val) != $val;
    }

    public function exportExcel($title = ['tital', 'username'], $data, $fileName = '')
    {
        $record['title'] = $title;
        $record['data'] = $data;

        return Excel::download(new RecordExport(
            $record,
            '',
            '',
            ''
        ), $fileName . '_' . date("YmdHi") . '.xlsx');
    }
    public function search_record($db, $request)
    {
        if ($request->get('username')) {

            $user = User::where('username', $request->get('username'))->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $request->get('username'))->where('role_id', 2)->first();
            }

            if ($user) {
                $db->where('user_id', $user->id);
            } else {
                $db->where('user_id', -1);
            }
        }
        if ($request->get('from')) {
            $db->whereBetween('created_at', [$request->get('from') . ' 00:00:00', $request->get('to') . ' 23:59:59']);

        }
        return $db;
    }
    public function smtp_mail($to_email, $title, $message)
    {
        $content = "<tr>
                        <td style='padding-bottom: 30px;'>
                            <p>Dear " . $to_email . ",</p>
                            <p>Your Verification code for " . env('APP_NAME') . " is " . $message . "</p>

                        </td>
                    </tr>
                   ";
        $backgroundUrl = url('/assets/img/app/forgot%20password%202/bg-email.jpg');
        $details = [
            'title' => $title,
            'body' => $content,
            'backgroundUrl' => $backgroundUrl,
        ];

        $r = \Mail::to($to_email)->send(new \App\Mail\Send_Mail($details));
        dump($r);
        return response()->json([
            'data' => $r,
            'status' => true,
        ]);
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
    public function wallet_type()
    {
        return array
            (
            1 => array('id' => "point1", 'found_type' => "1", 'lan_key' => "POINT1", 'comments_cn' => "本金", 'comments_en' => "Insurance Wallet"),
            2 => array('id' => "point2", 'found_type' => "2", 'lan_key' => "POINT2", 'comments_cn' => "盈利", 'comments_en' => "Cash wallet"),
            // 3 => array('id' => "point3", 'found_type' => "3", 'lan_key' => "POINT3", 'comments_cn' => "DRP", 'comments_en' => "DRP"),
            // 4 => array('id' => "point4", 'found_type' => "4", 'lan_key' => "POINT4", 'comments_cn' => "DMP", 'comments_en' => "DMP"),

        );
    }
    public function fount_type()
    {
        return array
            (
            0 => array('found_type' => "1001", 'action' => "bonus", 'comments_cn' => "推荐奖励", 'comments_en' => "Sponsor Bonus"),
            1 => array('found_type' => "1002", 'action' => "bonus", 'comments_cn' => "层级奖金", 'comments_en' => "Level Bonus"),
            2 => array('found_type' => "1003", 'action' => "bonus", 'comments_cn' => "级别奖励", 'comments_en' => "Rank Bonus"),
            3 => array('found_type' => "1004", 'action' => "bonus", 'comments_cn' => "同级奖励", 'comments_en' => "Same Rank Bonus"),
            // 6 => array('found_type' => "11", 'action' => "register", 'comments_cn' => "注册", 'comments_en' => "Register"),
            4 => array('found_type' => "210", 'action' => "withdraw", 'comments_cn' => "提现", 'comments_en' => "Withdraw"),
            5 => array('found_type' => "900", 'action' => "deposit", 'comments_cn' => "充值", 'comments_en' => "Deposit"),
            // 6 => array('found_type' => "999", 'action' => "deposit", 'comments_cn' => "购买保险", 'comments_en' => "Purchase Premium"),
            6 => array('found_type' => "901", 'action' => "tradeprofit", 'comments_cn' => "交易盈利", 'comments_en' => "Trading Profit"),
            7 => array('found_type' => "7", 'action' => "wallet", 'comments_cn' => "钱包划转", 'comments_en' => "Wallet Transfer"),
            8 => array('found_type' => "11", 'action' => "package", 'comments_cn' => "购买保险配套", 'comments_en' => "Purchase Insurance Package"),
            9 => array('found_type' => "999", 'action' => "premium", 'comments_cn' => "购买保险", 'comments_en' => "Purchase Premium"),

        );
    }
    public function bonus_type()
    {
        return array
            (
            0 => array('key' => "sponsor_bonus", 'bonus_cn' => "推荐奖金", 'bonus_en' => "Sponsor Bonus"),
            //1 => array('key' => "static_bonus", 'bonus_cn' => "Roi Bonus", 'bonus_en' => "Roi Bonus"),
            1 => array('key' => "dynamic_bonus", 'bonus_cn' => "层级奖金", 'bonus_en' => "Level Bonus"),

            //4 => array('key' => "matching_bonus", 'bonus_cn' => "对碰奖励", 'bonus_en' => "Matching Bonus"),
            2 => array('key' => "special_bonus", 'bonus_cn' => "级别奖励", 'bonus_en' => " Rank Bonus"),
            3 => array('key' => "level_bonus", 'bonus_cn' => "同级奖励", 'bonus_en' => "Same Rank Bonus"),

        );
    }

    public function sendMail2($to, $subject, $content)
    {
        $url = 'http://api.sendcloud.net/apiv2/mail/send';
        $API_USER = 'Insurance2U';
        $API_KEY = '44118cfec403a5198e71ce318014e696';
        $body_content = "<!doctype html>
<html>
<head>
<title></title>
<style type='text/css'>
body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
img { -ms-interpolation-mode: bicubic; }

img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
table { border-collapse: collapse !important; }
body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

@media screen and (max-width: 600px) {
  .img-max {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
  }

  .max-width {
    max-width: 100% !important;
  }

  .mobile-wrapper {
    width: 85% !important;
    max-width: 85% !important;
  }

  .mobile-padding {
    padding-left: 5% !important;
    padding-right: 5% !important;
  }
}
div[style*='margin: 16px 0;'] { margin: 0 !important; }
</style>
</head>
<body style='margin: 0 !important; padding: 0; !important background-color: #ffffff;' bgcolor='#ffffff'>

<div style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'>

</div>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tr>
        <td align='center' valign='top' width='100%' background='bg.jpg' bgcolor='#f6f6f6' style='background: #f6f6f6 url(bg.jpg); background-size: cover; padding: 35px 15px 0 15px;' class='mobile-padding'>
            <!--[if (gte mso 9)|(IE)]>
            <table align='center' border='0' cellspacing='0' cellpadding='0' width='600'>
            <tr>
            <td align='center' valign='top' width='600'>
            <![endif]-->
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                <tr>
                    <!--td align='center' valign='top' style='padding: 0 0 50px 0;'>

                    </td-->
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
            <img  src='" . url('') . "/images/system_logo.png'  width='25%' border='0' style='display: block;height:80px;width:280px'>
            <br><br>
        </td>
    </tr>
    <tr>
        <td align='center' height='100%' valign='top' width='100%' bgcolor='#f6f6f6' style='padding: 0 15px 50px 15px;' class='mobile-padding'>
            <!--[if (gte mso 9)|(IE)]>
            <table align='center' border='0' cellspacing='0' cellpadding='0' width='600'>
            <tr>
            <td align='center' valign='top' width='800'>
            <![endif]-->
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                <tr>
                    <td align='center' valign='top' style='padding: 0 0 25px 0; font-family: Open Sans, Helvetica, Arial, sans-serif;'>
                        <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                            <tr>
                                <td align='center' bgcolor='#ffffff' style='border-radius: 0 0 3px 3px; padding: 25px;'>
                                    <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                        <tr>
                                            <td align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif;'>

                                                <p style='margin-top:0in;text-align: left;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;'>
                                                    <span style='font-size:19px;line-height:107%;font-family:'Times New Roman','serif';'> Your Verification code for Insurance2U is $content</span>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                      </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align='center' height='100%' valign='top' width='100%' bgcolor='#f6f6f6' style='padding: 0 15px 40px 15px;'>
            <!--[if (gte mso 9)|(IE)]>
            <table align='center' border='0' cellspacing='0' cellpadding='0' width='600'>
            <tr>
            <td align='center' valign='top' width='600'>
            <![endif]-->
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>

                Website: <a href='" . url('') . "' target='_Blank'>" . url('') . "</a>
                <p>&copy;Insurance2U</p>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>
</body>
</html>
"; //邮件内容

        $param = array(
            'apiUser' => $API_USER, # 使用api_user和api_key进行验证
            'apiKey' => $API_KEY,
            'from' => 'support@insurance2U.com', # 发信人，用正确邮件地址替代
            'fromName' => 'support@insurance2U.com',
            'to' => $to, # 收件人地址, 用正确邮件地址替代, 多个地址用';'分隔
            'subject' => $subject,
            'html' => $body_content,
            'respEmailId' => 'true',
        );

        $data = http_build_query($param);

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data,
            ));
        $context = stream_context_create($options);
        $result = file_get_contents($url, FILE_TEXT, $context);
        $info = json_decode($result);

        if ($info->statusCode == '200') {
            return 1;
        } else {
            return 0;
        }
    }
}
