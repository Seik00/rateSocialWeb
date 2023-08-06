<?php

namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Helper\SendCloud;
use App\Helper\SmsSendCloud;
use App\Http\Controllers\Controller;
use App\Models\DynamicBonus;
use App\Models\GlobalCountry;
use App\Models\SpecialBonus;
use App\Models\StaticBonus;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserGroup;
use App\Models\UserKyc;
use App\Models\UserOtpCode;
use App\Models\UserPackage;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

//project model//
class MemberController extends Controller
{
    public function detectUsername()
    {
        $user = auth()->user();

        if (!filter_var($user->username, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('E00021', 'INCORRECT_EMAIL_FORMAT');
        } else {
            return $this->success('', 'OK');
        }
    }
    /**
     * @OA\Post(
     *     path="/api/member/update-member-info",
     *     tags={"Member"},
     *     summary="updateMemberInfo ",
     *     description="updateMemberInfo",
     *     operationId="updateMemberInfo",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function updateMemberInfo(Request $request)
    {
        $user = auth()->user();
        if ($request->get('email')) {
            Validator::validate($request->all(), [
                'email' => 'required|confirmed',

            ]);

            /* $existedUser = User::where('email', $request->get('email'))->where('id', '!=', $user->id)->first();
            if ($existedUser) {
            return $this->jsonResponse([
            'code' => 2,
            'data' => false,
            'message' => 'EMAIL_EXITS',
            ]);
            }
            $existedUser = User::where('username', $request->get('email'))->where('id', '!=', $user->id)->first();
            if ($existedUser) {
            return $this->jsonResponse([
            'code' => 2,
            'data' => false,
            'message' => 'EMAIL_EXITS',
            ]);
            }*/

            $user->email = $request->get('email');
        }
        $user->auto_renew = $request->get('auto_renew');
        if ($request->get('country_id')) {
            $user->country_id = $request->get('country_id');
        }
        if ($request->get('country_id')) {
            $user->contact_number = $request->get('contact_number');
        }
        if ($request->get('country_id')) {
            $user->ic = $request->get('ic');
        }

        $user->save();

        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Get(
     *     path="/api/member/home-page",
     *     tags={"Member"},
     *     summary="",
     *     description="Home page",
     *     operationId="homepage",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function homePage(Request $request)
    {
        $user = auth()->user();
        $total_asset = $user->point1;
        $bonus_type = $this->bonus_type();

        $static_today = StaticBonus::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->sum('founds');

        //$sponsor_total = SponsorBonus::where('user_id',auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        $dynamic_today = DynamicBonus::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->sum('founds');
        $special_today = SpecialBonus::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->sum('founds');
        $static = StaticBonus::where('user_id', auth()->user()->id)->sum('founds');
        //$sponsor_total = SponsorBonus::where('user_id',auth()->user()->id)->paginate(10);
        $dynamic = DynamicBonus::where('user_id', auth()->user()->id)->sum('founds');
        $special = SpecialBonus::where('user_id', auth()->user()->id)->sum('founds');
        $total_income = $static + $dynamic + $special;
        $total_income_today = $static_today + $dynamic_today + $special_today;
        $country = GlobalCountry::where('id', $user->country_id)->first();
        $total_asset_currency = $total_asset * $country->buy;
        $notice = Ticket::where([
            'user_id' => $user->id,
            'user_read' => 0,
        ])->count();

        return $this->jsonResponse([
            'code' => 0,
            'data' => [
                'total_asset' => number_format($total_asset, 2, '.', ''),
                'total_asset_currency' => $country->short_form . ' ' . number_format($total_asset_currency, 2, '.', ''),
                'total_income' => number_format($total_income, 2, '.', ''),
                'total_income_today' => number_format($total_income_today, 2, '.', ''),
                'static_bonus' => number_format($static, 2, '.', ''),
                'special_bonus' => number_format($special, 2, '.', ''),
                'dynamic_bonus' => number_format($dynamic, 2, '.', ''),
                'notice' => $notice,
            ],
            'message' => '',
        ]);
    }
    /**
     * @OA\Get(
     *     path="/api/member/get-member-info",
     *     tags={"Member"},
     *     summary="",
     *     description="member info",
     *     operationId="getMemberInfo",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getMemberInfo(Request $request)
    {
        $user = auth()->user();

        $user->todayStatus = $user->todayStatus();
        $user->activePackage = $user->activePackage();
        $user->myActivePackage = $user->myActivePackage();
        $user->team_sales = $user->team_sales();
        $user->team_member = $user->team_member();
        $user->check_kyc = $user->check_kyc();
        return $this->success($user, '');
    }
    /**
     * @OA\Post(
     *     path="/api/member/setLanguage",
     *     tags={"Member"},
     *     summary="setLanguage ",
     *     description="setLanguage",
     *     operationId="setLanguage",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="language",
     *         in="query",
     *         description="cn,vn,en",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function setLanguage(Request $request)
    {

        $user = auth()->user();
        if ($request->get('language')) {
            $user->bio = $request->get('language');
        } else {
            $user->bio = 'cn';
        }

        $user->save();

        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/change-password",
     *     tags={"Member"},
     *     summary="change password ",
     *     description="change password",
     *     operationId="changePassword",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="old_password",
     *         in="query",
     *         description="old_password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="password_confirmation",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function changePassword(Request $request)
    {
        Validator::validate($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'old_password' => 'required',
        ]);

        $user = auth()->user();
        if (!Hash::check($request->get('old_password'), $user->password)) {
            return $this->fail('E00021', 'INCORRECT_PASSWORD');
        }
        $user->password = bcrypt($request->get('password'));
        $user->d_password = $request->get('password');
        $user->save();
        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/set-secpassword",
     *     tags={"Member"},
     *     summary="set sec password ",
     *     description="set sec password",
     *     operationId="setSecPassword",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="password_confirmation",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function setSecPassword(Request $request)
    {
        Validator::validate($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $user = auth()->user();
        $user->password2 = bcrypt($request->get('password'));
        $user->d_password2 = $request->get('password');
        $user->save();

        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/change-secpassword",
     *     tags={"Member"},
     *     summary="change sec password ",
     *     description="change sec password",
     *     operationId="changeSecPassword",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="sec_password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="password_confirmation",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function changeSecPassword(Request $request)
    {
        Validator::validate($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'sec_password' => 'required',
        ]);

        $user = auth()->user();
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }

        $user->password2 = bcrypt($request->get('password'));
        $user->d_password2 = $request->get('password');
        $user->save();

        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/reset-secpassword",
     *     tags={"Member"},
     *     summary="reset sec password ",
     *     description="reset sec password",
     *     operationId="resetSecPassword",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="password_confirmation",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function resetSecPassword(Request $request)
    {
        Validator::validate($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',

        ]);

        $user = auth()->user();

        $user->password2 = bcrypt($request->get('password'));
        $user->d_password2 = $request->get('password');
        $user->save();

        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/register-member",
     *     tags={"Member"},
     *     summary="Register member",
     *     description="Register member",
     *     operationId="Register member",
     *      security={{"bearerAuth":{}}},
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="user_group",
     *         in="query",
     *         description="package id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country_id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="contact_number",
     *         in="query",
     *         description="contact_number",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="password_confirmation",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="sec_password",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="ref_id",
     *         in="query",
     *         description="ref_id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="jid",
     *         in="query",
     *         description="jid now no need",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="group_type",
     *         in="query",
     *         description="A ==left /B == right",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="pay_type",
     *         in="query",
     *         description="point1/point1&pin",
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
    public function registerMember(Request $request)
    {
        Validator::validate($request->all(), [
            'username' => 'required',
            'user_group' => 'required',
            'country_id' => 'required',
            //  'contact_number' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'sec_password' => 'required',
            'ref_id' => 'required',
        ]);
        $user = auth()->user();
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        if ($request->get('user_group')) {
            $package = UserGroup::where('display', 0)->where('id', '=', $request->get('user_group'))->first();

            if (!$package) {
                return $this->fail('E00022', 'INCORRECT_PACKAGE');
            }
        }
        // check member existed by username and email
        $username = $request->get('username');
        $email = $request->get('email');
        $existedUser = User::where('username', $username)->first();
        if ($existedUser) {

            return $this->fail('E00003', 'MEMBER_EXITS');
        }

        // $existedEmail = User::where('email', $email)->first();
        // if ($existedEmail) {
        //     return $this->jsonResponse([
        //         'code' => 2,
        //         'data' => false,
        //         'message' => 'MEMBER_EXISTS',
        //     ]);
        // }
        // extract user data, hash password and trim contact number
        $userData = $request->only('username', 'email', 'password', 'country_id');
        $userData['password'] = bcrypt($request->password);
        $userData['role_id'] = 2;
        $userData['user_group_id'] = $package->id;
        $userData['d_password'] = $request->password;
        $ref = User::where('username', $request->ref_id)->first();
        if ($ref) {
            $userData['pid'] = $ref->id;
            $userData['p_level'] = $ref->p_level + 1;
        } else {
            $ref = User::where('id', $request->ref_id)->first();

            if ($ref) {
                $userData['pid'] = $ref->id;
                $userData['p_level'] = $ref->p_level + 1;
            } else {
                return $this->fail('E00004', 'INCORRECT_SPONSOR');
            }
        }
        $error = '';
        // $juser = User::where('username', $request->get('jid'))->first();

        // if (empty($juser)) {
        //     $error = 'PLACEMENT_USER_ERROR';
        // } else {
        //     if ($request->get('group_type') == 'A' && $juser->group_left != 0) {
        //         $error = 'PLACEMENT_GOT_USER';
        //     } elseif ($request->get('group_type') == 'B' && $juser->group_right != 0) {
        //         $error = 'PLACEMENT_GOT_USER';
        //     }
        // }
        // if ($request->get('group_type') == 'A') {
        //     $userData['group_type'] = 'A';
        //     $group = 'group_left';
        // } elseif ($request->get('group_type') == 'B') {
        //     $userData['group_type'] = 'B';
        //     $group = 'group_right';
        // } else {
        //     $error = 'PLACEMENT_GOT_USER';
        // }
        /*  if ($juser->group_left == 0) {
        $userData['group_type'] = 'A';
        $group = 'group_left';
        } elseif ($juser->group_right == 0) {
        $userData['group_type'] = 'B';
        $group = 'group_right';
        } else {
        $error = 'PLACEMENT_GOT_USER';
        }*/

        $pay = $package->price; // - $currect->price;

        if ($request->get('pay_type') == 'point2') {
            $wallet = 'point2';
            $wallet_type = 2;
            $pay1 = $pay;
            $wallet2 = 'point2';
            $wallet_type2 = 2;
            $pay2 = 0;
        } elseif ($request->get('pay_type') == 'point2&point3') {
            $wallet = 'point2';
            $wallet_type = 2;
            $pay1 = $pay * 0.5;
            $wallet2 = 'point3';
            $wallet_type2 = 3;
            $pay2 = $pay * 0.5;
        } else {
            $error_code = 'E00006';
            $error = 'INSUFFICIAN_BALANCE';
        }

        if ($user->$wallet < $pay1 || $user->$wallet2 < $pay2) {
            $error_code = 'E00006';
            $error = 'INSUFFICIAN_BALANCE';
        }

        if ($error) {
            return $this->fail($error_code, $error);
        }
        //generate code
        $userData['ref_code'] = $this->generateCode(8);
        $check = User::where('ref_code', $userData['ref_code'])->first();
        if ($check) {
            for ($i = 0; $i < 99; $i++) {
                $userData['ref_code'] = $this->generateCode(8);
                $check = User::where('ref_code', $userData['ref_code'])->first();
                if (!$check) {
                    break;
                }
            }
        }
        // $userData['jid'] = $juser->id;
        // $userData['j_level'] = $juser->j_level + 1;

        $userData['total_cap'] = $package->max_cap;
        // create user base on submitted data
        $new = User::create($userData);

        //update placement
        // $juser->$group = $new->id;
        // $juser->save();
        DB::select('call rw102("' . $new->id . '")');

        if ($new->email) {
            $sendCloud = new SendCloud();
            $sendCloud->mailTemplate($new, 0, 'welcome');
        }

        if ($package->price > 0) {

            $record['user_id'] = $new->id;
            $record['user_group_id'] = $package->id;
            $record['price'] = $package->price;
            $record['bv'] = $package->bv;
            $record['pay'] = $pay;
            $record['pay_type'] = $wallet;
            $record['status'] = 1;
            $user_package = UserPackage::create($record);

            $this->create_transaction($user->id, '-', $wallet, 11, $wallet_type, $pay1, $userData['username'] . ',购买配套' . $package->package_name, $userData['username'] . ',Purchase package ' . $package->package_name_en, $userData['username'] . ',Beli paket ' . $package->package_name_en);
            if ($pay2 > 0) {
                $this->create_transaction($user->id, '-', $wallet2, 11, $wallet_type2, $pay2, $userData['username'] . ',购买配套' . $package->package_name, $userData['username'] . ',Purchase package ' . $package->package_name_en, $userData['username'] . ',Beli paket ' . $package->package_name_en);
            }
            // DB::select('call sendBV("' . $new->id . '","' . $package->bv . '")');
            Bonus::sponsor_bonus($package->price, $new->id);
        }

        return $this->success('', 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/user-bank",
     *     tags={"Member"},
     *     summary="set user bank ",
     *     description="set user bank",
     *     operationId="userBank",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="sec_password",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="bank_country",
     *         in="query",
     *         description="country id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="bank_name",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="bank_user",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  @OA\Parameter(
     *          name="bank_number",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ), @OA\Parameter(
     *          name="branch",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),@OA\Parameter(
     *          name="swift_code",
     *         in="query",
     *         description="",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function userBank(Request $request)
    {
        Validator::validate($request->all(), [
            'sec_password' => 'required',
            'bank_country' => 'required',
            'bank_name' => 'required',
            'bank_user' => 'required',
            'bank_number' => 'required',
            'branch' => 'required',
        ]);
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $user = auth()->user();
        $record = $request->only(
            'amount',
            'bank_country',
            'bank_name',
            'bank_user',
            'bank_number',
            'branch',
            'swift_code'
        );
        $r = UserBank::updateOrCreate(['user_id' => $user->id], $record);
        return $this->success($r, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\get(
     *     path="/api/member/get-bank-info",
     *     tags={"Member"},
     *     summary="get user bank ",
     *     description="get user bank",
     *     operationId="getBankInfo",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getBankInfo(Request $request)
    {
        $user = auth()->user();

        $bank = UserBank::where('user_id', $user->id)->first();
        return $this->success($bank, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/update-address",
     *     tags={"Member"},
     *     summary="updateAddress ",
     *     description="updateAddress",
     *     operationId="updateAddress",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="address",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function updateAddress(Request $request)
    {

        $user = auth()->user();

        $user->address = $request->get('address');
        $user->save();

        return $this->success($user, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Post(
     *     path="/api/member/requestUserOTP",
     *     tags={"Member"},
     *     summary="update user info ",
     *     description="requestUserOTP",
     *     operationId="requestUserOTP",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="otp_type",
     *         in="query",
     *         description="email",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function requestUserOTP(Request $request)
    {
        $user = auth()->user();

        if ($request->get('otp_type') == 'contact_number') {
            $type = $user->contact_number;
        } else {
            $type = $user->email;
        }
        $code = mt_rand(100000, 999999);

        $contactNumber = $type;
        $country = GlobalCountry::where('id', $user->country_id)->first();

        UserOtpCode::create([
            'user_id' => $user->id,
            'contact_number' => $type,
            'code' => $code,
            'expiry_date' => now()->addMinutes(5),
        ]);
        if ($user->contact_number) {

            $sms = new SmsSendCloud();
            $sms->sendsms_curl($country->country_code . $contactNumber, $code);
        } else {
            $sendCloud = new SendCloud();
            $sendCloud->mailTemplate($user, $code, 'forget_password');
        }

        //  $this->sendMail2($user->email, 'Otp ', $code);
        // Juhesms::send_sms(str_replace("+","",$country->country_code),$contactNumber,$code,$request->get('lang'));

        return $this->success($code, 'OTP_sent');
    }
    /**
     * @OA\Get(
     *     path="/api/member/getWallet",
     *     tags={"Wallet"},
     *     summary="",
     *     description="member info",
     *     operationId="getWallet",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getWallet(Request $request)
    {

        return $this->success(auth()->user()->getWallet(), '');
    }

    /**
     * @OA\Post(
     *     path="/api/member/checkUserOTP",
     *     tags={"Member"},
     *     summary="update user info ",
     *     description="checkUserOTP",
     *     operationId="checkUserOTP",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="if edit passin id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Parameter(
     *         name="wallet_type",
     *         in="query",
     *         description="wallet_type",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="address",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function checkUserOTP(Request $request)
    {
        $user = auth()->user();

        $otp = UserOtpCode::where([
            'user_id' => $user->id,
            'code' => $request->get('otp'),
        ])->first();

        if ($otp) {
            $otp = UserOtpCode::where([
                'user_id' => $user->id,
                'code' => $request->get('otp'),
            ])->delete();
            return $this->success('', 'OTP_OK');
        } else {
            return $this->fail('E00015', 'INCORRECT_OTP');
        }
        // Juhesms::send_sms(str_replace("+","",$country->country_code),$contactNumber,$code,$request->get('lang'));

    }
    public function UserKyc(Request $request)
    {

        $user = auth()->user();
        $pending = UserKyc::where('user_id', $user->id)->first();
        if ($pending) {
            if ($pending->status == 0) {
                return $this->fail('E00017', 'PENDING');
            } else if ($pending->status == 1) {
                return $this->fail('E00023', 'APPROVED');
            }
        }

        $data['user_id'] = $user->id;

        if ($request->hasfile('ic_front')) {
            $file = $request->file('ic_front');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/kyc/' . date("Y-m-d"), $filename);
            $path = '/kyc/' . date("Y-m-d") . '/' . $filename;
            $data['ic_front'] = $path;
        }

        if ($request->hasfile('passport')) {
            $file = $request->file('passport');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/kyc/' . date("Y-m-d"), $filename);
            $path = '/kyc/' . date("Y-m-d") . '/' . $filename;
            $data['passport'] = $path;
        }

        if ($request->hasfile('ic_back')) {
            $file = $request->file('ic_back');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/kyc/' . date("Y-m-d"), $filename);
            $path = '/kyc/' . date("Y-m-d") . '/' . $filename;
            $data['ic_back'] = $path;
        }

        UserKyc::create($data);

        return $this->success($user, 'REQUEST_COMPLETE');
    }
}
