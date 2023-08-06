<?php

namespace App\Http\Controllers\Api;

use App\Helper\SmsSendCloud;
use App\Http\Controllers\Controller;
use App\Models\GlobalCountry;
use App\Models\GlobalSetting;
use App\Models\Otp;
use App\Models\User;
use App\Models\UserDeviceToken;
use App\Models\UserOtpCode;
use Illuminate\Http\Request;
use App\Helper\SendCloud;

class GlobalAPIController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/global/lookup",
     *     tags={"Project"},
     *     summary="get system setting",
     *     description="get notice,system setting",
     *     operationId="lookup",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function lookup(Request $request)
    {
        $global = GlobalSetting::get()->toArray();

        foreach ($global as $x => $val) {
            $system[$val['global_key']] = $val['key_value'];
        }

        return $this->success([
            'system' => $system,
        ], '');
    }

    /**
     * @OA\Post(
     *     path="/api/global/add_device_token",
     *     tags={"Common"},
     *     summary="add_device_token",
     *     description="add_device_token",
     *     operationId="add_device_token",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="device_token",
     *         in="query",
     *         description="device token",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="device_id",
     *         in="query",
     *         description="device id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="device_type",
     *         in="query",
     *         description="HUAWEI,IOS,ANDROID",
     *          required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function add_device_token(Request $request)
    {

        $data = $request->except(['device_id']);
        if (auth()->user()) {

            $data['user_id'] = auth()->user()->id;
        } else {
            $data['user_id'] = 0;
        }

        $deviceToken = UserDeviceToken::updateOrCreate([
            'device_id' => $request->get('device_id'),
        ], $data);

        return response()->json([
            'data' => $deviceToken, //do not return otp code
            'status' => true,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/global/banner",
     *     tags={"Common"},
     *     summary="Banner",
     *     description="Use key to get global setting value",
     *     operationId="banner",
     *     deprecated=false,
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function banner(Request $request)
    {

        $value = OnboardingImg::orderBy('id', 'asc')->get();
        $login_banner = GlobalSetting::where('key', '=', 'login_banner')->first();
        $pre_login_wallpaper = GlobalSetting::where('key', '=', 'pre_login_wallpaper')->first();
        $homescreen_wallpaper = GlobalSetting::where('key', '=', 'homescreen_wallpaper')->first();
        return response()->json([
            'banner' => $value,
            'pre_login_wallpaper' => url('storage' . $pre_login_wallpaper->value),
            'login_banner' => url('storage' . $login_banner->value),
            'home_background' => url('storage' . $homescreen_wallpaper->value),
            'status' => true,
        ]);
    }

    /**
     * @OA\GET(
     *     path="/api/global/country_list",
     *     tags={"Common"},
     *     summary="list of country",
     *     description="list of country",
     *     operationId="country_list",
     *     deprecated=false,
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function country_list(Request $request)
    {

        $country = GlobalCountry::where('status', '1')->orderByRaw('sort=0, sort ASC')->orderBy('name_en', 'ASC')->get();
        return $this->success($country, '');
    }
    public function testExcel(Request $request)
    {
        $fileName = 'tasks';
        $tasks = User::get()->toarray();
        for ($i = 0; $i < count($tasks); $i++) {
            $record['data'][$i]['id'] = $tasks[$i]['id'];
            $record['data'][$i]['username'] = $tasks[$i]['username'];
        }
        $record['title'] = ['tital', 'username'];
        return $this->exportExcel($record['title'], $record['data'], 'testfile');
    }
    /**
     * @OA\POST(
     *     path="/api/global/sent-otp",
     *     tags={"Common"},
     *     summary="send otp",
     *     description="list of country",
     *     operationId="sentOTP",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="lang",
     *         in="query",
     *         description="cn/en",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="contact_number",
     *         in="query",
     *         description="contact_number",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function sentOTP(Request $request)
    {
        $code = mt_rand(100000, 999999);

        if ($request->get('email')) {
            if (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
                return $this->fail('E00013', 'INCORRECT_EMAIL_FORMAT');
            }
            UserOtpCode::create([
                'user_id' => 0,
                'contact_number' => $request->get('email'),
                'code' => $code,
                'expiry_date' => now()->addMinutes(5),
            ]);

            $this->sendMail2($request->get('email'), 'Otp ', $code);
        } else {
            $contactNumber = $request->get('contact_number');
            $country = GlobalCountry::where('id', $request->get('country_id'))->first();

            UserOtpCode::create([
                'user_id' => 0,
                'contact_number' => $contactNumber,
                'code' => $code,
                'expiry_date' => now()->addMinutes(5),
            ]);
            $sms = new SmsSendCloud();
            $sms->sendsms_curl($country->country_code . $contactNumber, $code);
            // SmsSendCloud::sendsms_curl($country->country_code+$contactNumber,$code);
        }
        return $this->success('', 'OTP_sent');
    }

    /**
     * @OA\POST(
     *     path="/api/global/usernameOTP",
     *     tags={"Common"},
     *     summary="send usernameOTP ",
     *     description="list of country",
     *     operationId="usernameOTP",
     *     deprecated=false,
     *      @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function usernameOTP(Request $request)
    {

        $code = mt_rand(100000, 999999);
        $user = User::where('username', $request->get('username'))->first();

        if ($user) {
            UserOtpCode::create([
                'user_id' => $user->id,
                'contact_number' => $user->email,
                'code' => $code,
                'expiry_date' => now()->addMinutes(5),
            ]);
            if ($user->email) {
                $sendCloud = new SendCloud();
                $sendCloud->mailTemplate($user, $code, 'forget_password');
            }
        } else {
            return $this->fail('E00014', 'INCORRECT_USERNAME');
        }
        return $this->success('', 'OTP_sent');
    }
    /**
     * @OA\GET(
     *     path="/api/global/checkUsernameOtp",
     *     tags={"Common"},
     *     summary="send checkUsernameOtp ",
     *     description="list of country",
     *     operationId="checkUsernameOtp",
     *     deprecated=false,
     *      @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *        @OA\Parameter(
     *         name="otp",
     *         in="query",
     *         description="otp",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function checkUsernameOtp(Request $request)
    {

        $code = mt_rand(100000, 999999);
        $user = User::where('username', $request->get('username'))->first();

        if ($user) {

            $otp = UserOtpCode::where([
                'user_id' => $user->id,
                'code' => $request->get('otp'),
            ])->first();

            if ($otp) {
                $otp = UserOtpCode::where([
                    'user_id' => $user->id,
                    'contact_number' => $user->email,
                    'code' => $request->get('otp'),
                ])->delete();
                return $this->success('', 'OTP_OK');
            } else {
                return $this->fail('E00015', 'INCORRECT_OTP');
            }
        } else {
            return $this->fail('E00015', 'INCORRECT_OTP');
        }
    }
    /**
     * @OA\GET(
     *     path="/api/global/check-otp",
     *     tags={"Common"},
     *     summary="send otp",
     *     description="list of country",
     *     operationId="checkOTP",
     *     deprecated=false,
     *      @OA\Parameter(
     *         name="contact",
     *         in="query",
     *         description="email /contact_number",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="otp",
     *         in="query",
     *         description="otp",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function checkOTP(Request $request)
    {

        $contactNumber = $request->get('contact');

        $otp = UserOtpCode::where([
            'contact_number' => $contactNumber,
            'code' => $request->get('otp'),
        ])->first();

        if ($otp) {
            $otp = UserOtpCode::where([
                'contact_number' => $contactNumber,
                'code' => $request->get('otp'),
            ])->delete();
            return $this->success('', 'OTP_OK');
        } else {
            return $this->fail('E00015', 'INCORRECT_OTP');
        }
    }
}
