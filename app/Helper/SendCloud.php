<?php
namespace App\Helper;

class SendCloud
{
    private $url;
    private $API_USER;
    private $appId;
    private $appSecret;
    private $Sender;

    public function __construct()
    {
        $this->url = 'http://api.sendcloud.net/apiv2/mail/send';
        $this->API_USER = 'insurance2u';
        $this->API_KEY = '2bc3ef311d61c17b2ecb456be62aedda';
        $this->Sender = 'support@insurance-2u.com';
    }

    public function mailTemplate($user, $amount = 0, $template = 'welcome')
    {
        $to = $user->email;
        $username = $user->username;
        $lang = $user->bio;
        if ($template == 'welcome') {
            if ($lang != 'cn') {
                $subject = 'Welcome to Insurance2U';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Welcome to Insurance2U,</p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Our customer support team extends its warmest greetings and we hope that you will enjoy your journey with us.</p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We are always ready to assist you if you have any questions regarding Insurance2U and its services provided.</p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>So please do feel free to contact us and add our email address to your address book.</p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>To begin your journey, please login to  <a href='" . url('') . "'>Insurance2U user dashboard</a>
                            </p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                            <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Always Ready to Serve,</p>
                            <p>
                            <span style='font-size:15px;line-height:107%;font-family:Calibri,sans-serif;'>Insurance2U Support Team <br>&nbsp; </span>
                            </p>";
            } else {
                $subject = '欢迎加入Insurance2U';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>欢迎来到Insurance2U集团，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>我们的客户支持团队以最热烈的问候欢迎您。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>如果您对Insurance2U集团及其所提供的服务有任何疑问，我们随时准备为您提供帮助。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>因此，请与我们联系并将我们的电子邮件地址添加到您的通讯录中。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>欲开始参与体验，请登录<a href='" . url('') . "'>Insurance2U集团用户仪表板</a></p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>我们随时准备服务，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团客户支持团队</p>";

            }
        } elseif ($template == 'kyc_approve') {
            if ($lang != 'cn') {
                $subject = 'Insurance2U KYC approved';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Welcome to Insurance2U System. We would like to inform you that your account is now active and you can begin trading immediately by logging in [here] and selecting your desired trading instruments. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Please click  <a href='" . url('') . "'>Here</a> to login to your account and do feel free to contact us <span style=color:#4472C4;>[here]&nbsp;</span>if you do have any queries. &nbsp; </p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>On behalf of the Insurance2U Team, we hope that you enjoy your journey with us. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team Insurance2U</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>
                <em>This is an automatically generated message. Please do not reply.&nbsp;</em>
                </p>";
            } else {
                $subject = 'Insurance2U 身份认证已通过';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>欢迎来到Insurance2U集团系统。在此通知您，您的账户现已激活，您可以通过登录 [此处] 选择所需的交易工具并立即开始交易。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>请点击  <a href='" . url('') . "'>[此处]</a>登录您的帐户，如果您有任何疑问，请随时与我们联系 [此处]。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团团队希望您享受我们提供的服务并与我们共同体验。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团团队</p>
                <p>
                  <span style='font-size:15px;line-height:107%;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</span>
                </p>";

            }
        } elseif ($template == 'kyc_rejected') {
            if ($lang != 'cn') {
                $subject = 'Insurance2U KYC rejected';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We would like to inform you that your KYC submission was rejected.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>This may due to the following reasons;</p>
                <ul style='list-style-type: undefined;margin-left:0in;'>
                  <li>
                    <span style='color:black;'>Identity document has expired.</span>
                  </li>
                  <li>
                    <span style='color:black;'>The submitted document has been flagged as falsified by our operator.</span>
                  </li>
                  <li>
                    <span style='color:black;'>Data entered in the system does not match uploaded documents.</span>
                  </li>
                  <li>
                    <span style='color:black;'>Uploaded documents are not clearly visible, partially covered or blurred. &nbsp; &nbsp;</span>
                  </li>
                </ul>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>To amend your submission, please click <span style='color:#4472C4;'>[here]</span>
                </p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>If you require further clarification on your KYC submission please click <span style='color:#4472C4;'>[here]</span>
                </p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team Insurance2U            </p> ";
            } else {
                $subject = 'Insurance2U 身份认证审核失败';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>我们想通知您，您的 KYC 提交已被拒绝。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这可能是由以下几项原因导致；</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 身份证件已过期。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 提交的文件已被我们的运营商标记为伪造。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 在系统中输入的数据与上传的文件不匹配。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&bull; 上传的文件不清晰可见、部分覆盖或模糊。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>欲修改您的提交，请点击[这里]</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>如果您需要进一步澄清您的 KYC 提交，请点击 [这里]</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团团队</p>";

            }
        } elseif ($template == 'withdraw_pending') {
            if ($lang != 'cn') {
                $subject = 'Insurance2U Withdraw is pending';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . ",</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We have received your withdrawal request for the amount of " . $amount . "USDT from your trading account</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>We are pleased to inform you that your transaction is being processed.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>If you did not authenticate this transaction, please immediately change your password and contact us &ldquo;here&rdquo;. Our customer service officers will attend to you in the shortest time possible. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team Insurance2U &nbsp;</p>
                <p>
                  <span style='font-size:15px;line-height:107%;font-family:Calibri,sans-serif;'>This is an automatically generated message. Please do not reply.&nbsp; <br>&nbsp; </span>
                </p>";
            } else {
                $subject = 'Insurance2U 提现处理中';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "，</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>我们已收到您从您的交易账户中提取  " . $amount . "USDT 金额的请求</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>在此通知您，您的交易正在处理中。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>如果您没有操作此交易，请立即更改您的密码并在&ldquo;这里&rdquo;联系我们。我们的客服人员会在最短的时间内为您服务。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团团队</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</p>";

            }
        } elseif ($template == 'withdraw_approved') {
            if ($lang != 'cn') {
                $subject = 'Insurance2U Withdraw is approved';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Your withdrawal of " . $amount . " USDT have been processed. Please log in to check your balances. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>If you did not authenticate this transaction, please immediately change your password and contact us &ldquo;here&rdquo;. Our customer service officers will attend to you in the shortest time possible. &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team Insurance2U &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>This is an automatically generated message. Please do not reply.&nbsp;</p>";
            } else {
                $subject = 'Insurance2U 提现完成';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>敬爱的" . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>您提现 " . $amount . " USDT 已处理完毕。请登录以查看您的余额。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>如果您没有操作此交易，请立即更改您的密码并在&ldquo;这里&rdquo;联系我们。我们的客服人员会在最短的时间内为您服务。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团团队</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</p>";

            }
        } elseif ($template == 'withdraw_rejected') {
            if ($lang != 'cn') {
                $subject = 'Insurance2U Withdraw is rejected';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Dear " . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Your withdrawal request of " . $amount . " from your trading account has been rejected.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Please contact us [here] for further clarifications.</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Team Insurance2U &nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>This is an automatically generated message. Please do not reply.&nbsp;</p>";
            } else {
                $subject = 'Insurance2U 提现失败';
                $content = "<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>亲爱的" . $username . "</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>您从交易账户中提取 " . $amount . " 的请求已被拒绝。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>请[此处]联系我们以获取进一步说明。</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>&nbsp;</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>Insurance2U集团团队</p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:Calibri,sans-serif;'>这是一条自动生成的消息。请勿回复。</p>";

            }
        } elseif ($template == 'forget_password') {
            if ($lang == 'cn') {
                $subject = 'Insurance2U 验证码';
                $content = "<p>敬爱的" . $username . "</p>
                <p>我们已接收您的更换密码请求。如果您没提出此次请求，请忽略这封电邮。</p>
                <p>
                  <br>
                </p>
                <p>您的验证码是" . $amount . ".&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>Insurance2U集团团队</p>
                <p>这是一条自动生成的消息。请勿回复</p>";
            } else {
                $subject = 'Insurance2U Verification code';
                $content = "<p>Dear " . $username . ",&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>There was a request to change your password! If you did not make this request then please ignore this email.&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>Your verification code is " . $amount . ".&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>Insurance2U Support Team&nbsp;</p>
                <p>
                  <br>
                </p>
                <p>This is an automatically generated message. Please do not reply.</p>";

            }
        }

        $this->sendMail($to, $subject, $content);
    }
    public function sendMail($to, $subject, $content)
    {
        $url = $this->url;
        $API_USER = $this->API_USER;
        $API_KEY = $this->API_KEY;
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
            <img  src='" . url('') . "/assets/app/img/logo.0447219f.png'  width='25%' border='0' style='display: block;height:210px;width:280px'>
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
                                                    <span style='font-size:19px;line-height:107%;font-family:'Times New Roman','serif';'> $content</span>
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
            'from' => $this->Sender, # 发信人，用正确邮件地址替代
            'fromName' => $this->Sender,
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
