<?php

namespace App\Http\Controllers\Api;

use App\Helper\SendCloud;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function loginCredential($request)
    {
        if (is_numeric($request->get('loginId'))) {
            return ['contact_number' => ltrim($request->get('loginId'), "0"), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('loginId'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('loginId'), 'password' => $request->get('password')];
        }
        return ['user_login_id' => $request->get('loginId'), 'password' => $request->get('password')];
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="User login",
     *     description="User login",
     *     operationId="login",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="loginId = username /phone number(without country code)",
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
    public function login(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $token = JWTAuth::attempt([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ]);

        if (!$token) {
            return $this->fail('E00001', 'LOGIN_FAIL');
            // return $this->fail([
            //     'code' => 1,
            //     'data' => false,
            //     'message' => 'LOGIN_FAIL',
            // ]);
        }

        if (auth()->user()->active == 0) {
            return $this->fail('E00001', 'LOGIN_FAIL');
        }
        return $this->success([
            'token' => $token,
            'user' => auth()->user(),
        ], 'Login_OK');
    }
    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="User logout",
     *     description="User logout",
     *      security={ {"bearerAuth": {}} },
     *     operationId="logout",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="device_token",
     *         in="query",
     *         description="logout account and delete the previous token ",
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

    /**
     * Logout a User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            // log out user's session
            auth()->logout();

            // flush current session
            session()->flush();

            // invalidates token
            JWTAuth::parseToken()->invalidate();

            $success = true;
        } catch (TokenExpiredException $exception) { // token expired exception
            $success = true;
        } catch (\Exception $exception) {
            $success = false;
            Log::error('[AuthController] Unable to log out user id:' . json_encode($request->all()));
        }

        return $this->success('', 'Logout_OK');
    }

    /**
     * @OA\Post(
     *     path="/api/auth/changePassword",
     *     tags={"Auth"},
     *     summary="Change Password",
     *     description="Change user password",
     *     operationId="changePassword",
     *     security={{"bearerAuth":{}}},
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="current_password",
     *         in="query",
     *         description="current password",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="new password",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully changed password",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function changePassword(Request $request)
    {

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return $this->fail('E00002', 'INCORRECT_CURRENT_PASSWORD');
            exit;
        }
        $user = auth()->user();
        $this->activities_log(auth()->user()->id, 'change_password', 'Change Password');
        $user->password = bcrypt($request->password);
        $user->save();
        return $this->success('', 'Password_changed');
    }

    /**
     * @OA\Post(
     *     path="/api/auth/signup",
     *     tags={"Auth"},
     *     summary="signup",
     *     description="signup",
     *     operationId="signup",
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
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country_id",
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
     *     @OA\Parameter(
     *         name="ref_id",
     *         in="query",
     *         description="ref_id",
     *         required=true,
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
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws MemberExistedException
     */
    public function signup(Request $request)
    {
        Validator::validate($request->all(), [
            'username' => 'required',
            //'contact_number' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'ref_id' => 'required',
        ]);

        // check member existed by username and email
        $username = $request->get('username');
        $email = $request->get('email');
        $existedUser = User::where('username', $username)->first();
        if ($existedUser) {
            return $this->fail('E00003', 'MEMBER_EXITS');
        }

        // extract user data, hash password and trim contact number
        $userData = $request->only('username', 'email', 'password', 'country_id', 'fullname', 'ic', 'contact_number', 'bio');
        $userData['password'] = bcrypt($request->password);
        $userData['role_id'] = 2;
        $userData['d_password'] = $request->password;
        //$request->ref_id = 1000000;
        $ref = User::where('ref_code', $request->ref_id)->first();

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

        // create user base on submitted data
        $user = User::create($userData);
        /*update placement
        $juser->$group = $user->id;
        $juser->save();*/
        DB::select('call rw102("' . $user->id . '")');

        if ($user->email) {
            $sendCloud = new SendCloud();
            $sendCloud->mailTemplate($user, 0, 'welcome');
        }
        // login automatically
        $loginCredential = ['username' => $user->username, 'password' => $request->get('password')];
        $token = JWTAuth::attempt($loginCredential);

        return $this->success([
                'token' => $token,
                'user' => $user,
            ], 'Register_successful');
    }

    /**
     * @OA\POST(
     *     path="/api/auth/reset-password",
     *     tags={"Auth"},
     *     summary="send otp",
     *     description="request user otp",
     *     operationId="resetPassword",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="passcode",
     *         in="query",
     *         description="otp",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
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
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            //'passcode' => 'required|numeric',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return $this->fail('E00005', 'INCORRECT_USERNAME');
        }

        /* $otp = UserOtpCode::where([
        'contact_number' => $user->email,
        'code' => $request->get('passcode'),
        ])->first();

        if (!$otp) {
        return $this->jsonResponse([
        'code' => 2,
        'message' => 'Incorrect_otp',
        ]);
        }

        $otp->delete();*/
        $user->d_password = $request->password;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->success('', 'Password_reset_success');
    }
}
