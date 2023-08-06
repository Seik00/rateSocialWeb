<!doctype html>
<html>
<head>
<title>{!! $details['title'] !!}</title>
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
            <img  src='{{request()->getHost() }}/images/system_logo.png'  width='25%' border='0' style='display: block;height:210px;width:280px'>
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
                                            <td align='center' style='font-family: Open Sans, Helvetica, Arial, sans-serif;'>

                                                <p style='margin-top:0in;text-align: left;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;'>
                                                    <span style='font-size:19px;line-height:107%;font-family:'Times New Roman','serif';'>        {!! $details['body'] !!}</span>
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

                Website: <a href='{{request()->getHost()}}' target='_Blank'>{{request()->getHost() }}</a>
                <p>&copy;Destiny Trade</p>
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
