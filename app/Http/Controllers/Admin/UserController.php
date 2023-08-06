<?php

namespace App\Http\Controllers\Admin;

use App\Helper\SendCloud;
use App\Http\Controllers\Common\AdminBaseController;
use App\Models\GlobalCountry;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserKyc;
use App\Models\UserPackage;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends AdminBaseController
{
    /**
     * @OA\GET(
     *     path="/admin-api/user/user_list",
     *     tags={"Admin"},
     *     summary="Get User List",
     *     description="Get User List",
     *     operationId="user_list",
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="mobile_no",
     *         in="query",
     *         description="mobile_no",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
    public function user_list(Request $request)
    {
        $mobile = '';
        $has_search = false;

        // $user = Auth::user();
        $db = User::select('*')->where('role_id', 2);

        if ($request->get('uid')) {
            $db->where('id', $request->get('uid'));
            $has_search = true;
        }

        if ($request->get('mobile_no')) {
            $mobile = substr($request->get('mobile_no'), -5);
            $db->where('mobile_no', 'like', '%' . $mobile);
            $has_search = true;
        }
        if ($request->get('username')) {
            $db->where('username', 'like', '%' . $request->get('username') . '%');
            $has_search = true;
        }

        $record = $db->orderBy('id', 'desc')->paginate(10);

        $country = GlobalCountry::where('status', '1')->orderByRaw('sort=0, sort ASC')->orderBy('name_en', 'ASC')->get();
        $package = UserGroup::get();
        $product = Product::where('status', 1)->get();
        return $this->success([
            'user' => $record,
            'product' => $product,
            'package' => $package,
        ], 'Successful');
    }
    public function set_blacklist(Request $request)
    {
        try {

            $user = User::select('*')->where('id', $request->id)->first();

            if (!$user) {
                return $this->fail('E000037', 'Incorrect User');
            }
            if ($user->is_active == 1) {
                $user->is_active = 0;
            } else {
                $user->is_active = 1;
            }
            $user->save();

            return $this->success(true, 'User status is updated');
        } catch (\Exception $e) {

            return $this->fail('', 'Fail to create employee ' . $e->getMessage());
        }
    }

    public function registerMember(Request $request)
    {
        /*Validator::validate($request->all(), [
        'username' => 'required',
        'user_group' => 'required',
        'country_id' => 'required',
        //  'contact_number' => 'required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
        //'sec_password' => 'required',
        'ref_id' => 'required',
        ]);*/

        // if ($request->get('user_group')) {
        //     $package = UserGroup::where('display', 1)->where('id', '=', $request->get('user_group'))->first();

        //     if (!$package) {
        //         return $this->jsonResponse([
        //             'code' => 1,
        //             'data' => false,
        //             'message' => 'INCORRECT_PACKAGE',
        //         ]);
        //     }
        // }
        // check member existed by username and email
        $username = $request->get('username');
        $email = $request->get('email');
        $existedUser = User::where('username', $username)->first();
        if ($existedUser) {
            
            return $this->fail('E00003', 'MEMBER_EXITS');
        }

        // extract user data, hash password and trim contact number
        $userData = $request->only('username', 'email', 'password', 'country_id', 'contact_number', 'fullname', 'ic', 'bio');
        $userData['password'] = bcrypt($request->password);
        $userData['role_id'] = 2;
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
        $pay_type = 'point1';

        if ($error) {
            return $this->jsonResponse([
                'code' => 2,
                'data' => false,
                'message' => $error,
            ]);
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
        $new = User::create($userData);

        DB::select('call rw102("' . $new->id . '")');

        if ($request->get('email')) {
            $sendCloud = new SendCloud();
            $sendCloud->mailTemplate($new, 0, 'welcome');
        }

        // if ($package->price > 0) {
        //     $record['user_id'] = $new->id;
        //     $record['user_group_id'] = $package->id;
        //     $record['price'] = $package->price;
        //     $record['bv'] = $package->bv;
        //     $record['pay'] = $pay;
        //     $record['pay_type'] = $wallet;
        //     $user_package = UserPackage::create($record);

        //     DB::select('call sendBV("' . $new->id . '","' . $package->bv . '")');
        // }

        return $this->success(true, 'REQUEST_COMPLETE');
    }
    public function admin_list()
    {
        $user = Auth::user();
        $record = User::where('role_id', '!=', 2)->orderBy('id', 'desc')->paginate(10);
        $role = Role::where('id', '!=', 2)->get();
        return $this->success([
            'user' => $record,
            'role' => $role,
        ], 'Successful');
    }

    public function setUserPwd(Request $request)
    {
        $user = Auth::user();
        return view('admin.user.setUserPwd');
    }

    public function updatePwd(Request $request)
    {
        $user = User::where('username', request('username'))->first();
        if (!$user) {
            return redirect()->back()->withErrors('用户名错误')->withInput();
        }
        if ($request->get('pwd_type') == 'pwd') {
            $user->password = bcrypt($request->get('password'));
            $user->d_password = $request->get('password');
        } else {
            $user->password2 = bcrypt($request->get('password'));
            $user->d_password2 = $request->get('password');
        }
        $this->activities_log('change password', json_encode($request->all()));
        $user->save();

        return $this->success('', 'Updated Successfully');
    }
    public function create_admin()
    {
        try {

            $name_count = User::where('name', request('username'))->where('is_active', 1)->count();
            if ($name_count > 0) {
                return $this->fail('E00040', 'Username already registered');
            }
            $user = Auth::user();
            if ($user->role_id > 3) {
                return $this->fail('E00041', 'Incorrect Role');
            }
            if ($user->role_id != 1 && request("role_id") < $user->role_id) {
                return $this->fail('E00041', 'Incorrect Role');
            }
            $ref_id = 0;
            $batch_id = 0;
            $user = User::create([
                'role_id' => request("role_id"),
                'name' => request("username"),
                'ref_id' => $ref_id,
                'batch_id' => $batch_id,
                'password' => bcrypt(request("password")),
                //'email' => request("email"),
                'mobile_no' => request("mobile_no"),
                'user_login_id' => 'user',
            ]);

            $this->activities_log('CREAT_ADMIN', 'Create admin' . request("username") . ' admin id :' . $user->id);

            return $this->success(true, 'Username already registered');
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'code' => 0,
                'message' => 'Fail to create employee ' . $e->getMessage(),
            ]);
        }
    }
    public function update_admin()
    {
        try {
            $name_count = User::where('name', request('name'))->where('id', '!=', request('id'))->count();
            if ($name_count > 0) {
                return $this->fail('E00040', 'Username already registered');
            }

            $update = [];
            $update['name'] = request('name');
            $update['role_id'] = request('role_id');

            $password = request('password');

            if ($password != '') {
                $update['password'] = bcrypt($password);
            }

            User::where('id', request('id'))->update($update);

            $this->activities_log('UDPATE_ADMIN', 'Update admin' . request("name") . ' admin id :' . request('id'));

            return $this->success(true, '');
        } catch (\Exception $e) {

            return Response::json(array(
                'success' => false,
                'message' => 'Fail to update employee ' . $e->getMessage(),
            ));
        }
    }
    public function updateUser(Request $request)
    {
        try {
            $user = User::where('id', '=', $request->get('user_id'))->first();

            $username = $request->get('username');
            $email = $request->get('email');
            $existedUser = User::where('username', $username)->first();
            if ($existedUser && $user->id != $existedUser->id) {
                return $this->fail('E00003', 'MEMBER_EXISTS');
            }

            $update = $request->only('username', 'fullname', 'email', 'contact_number', 'country_id', 'user_group_id', 'wr', 'rb', 'wt', 'special', 'auto_renew', 'user_rank_id');
            $update['email'] = $request->get('email');
            $update['special'] = $request->get('special');
            $update['user_rank_id'] = $request->get('user_rank_id');
            $update['total_cap'] = $request->get('total_cap');
            $update['set_rank'] = $request->get('set_rank');
            User::where('id', $request->get('user_id'))->update($update);

            $this->activities_log('UDPATE_User', 'Update user:' . json_encode($request->all()));

            return $this->success(true, '');
        } catch (\Exception $e) {

            return Response::json(array(
                'success' => false,
                'message' => 'Fail to update employee ' . $e->getMessage(),
            ));
        }
    }
    public function delete_admin()
    {
        try {
            $name_count = User::where('id', '=', request('id'))->where('is_active', 1)->first();
            if (!$name_count) {
                return $this->fail('E00040', 'Username already registered');
            }

            $user = Auth::user();

            $update = [];
            $update['is_active'] = 0;

            User::where('id', request('id'))->update($update);

            $this->activities_log('DELETE_ADMIN', 'Delete admin' . request("name") . ' admin id :' . request('id'));

            return $this->success(true, '');
        } catch (\Exception $e) {

            return Response::json(array(
                'success' => false,
                'message' => 'Fail to update employee ' . $e->getMessage(),
            ));
        }
    }
    public function get_user_info()
    {
        $user = User::where('id', request('search_id'))->first();
        return $this->success([
            'record' => $user,
        ], '');
    }
    public function userPackage(Request $request)
    {
        $db = UserPackage::select('*');
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
        $record = $db->orderBy('id', 'desc')->paginate(10);
        $wallet = $this->wallet_type();

        return view('admin.user.userPackage')
            ->with('record', $record)
            ->with('wallet', $wallet)
            ->with('output_data', $this->output_data);
    }

    public function userSetting(Request $request)
    {

        try {
            $user = User::where('id', '=', $request->get('user_id'))->first();

            $user->setting = json_encode($request->get('setting'));
            $user->save();

            $this->activities_log('UDPATE_User', 'Update user:' . json_encode($request->all()));

            return $this->success(true, '');
        } catch (\Exception $e) {

            return Response::json(array(
                'success' => false,
                'message' => 'Fail to update employee ' . $e->getMessage(),
            ));
        }
    }
    public function kycList(Request $request)
    {
        $db = UserKyc::select('*')->where('status', '=', 0);

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function kycHis(Request $request)
    {
        $db = UserKyc::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function kycControl(Request $request)
    {
        $kyc = UserKyc::where('id', $request->get('id'))->first();
        if ($kyc->status > 2) {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
        $sendCloud = new SendCloud();

        if ($request->get('action') == 'APPROVE') {
            $kyc->status = 1;

            if ($kyc->user->email) {
                $sendCloud->mailTemplate($kyc->user, 10, 'kyc_approve');
            }
        } elseif ($request->get('action') == 'REJECT') {
            $kyc->status = 2;
            $kyc->remark = $request->get('remark');

            if ($kyc->user->email) {
                $sendCloud->mailTemplate($kyc->user, 10, 'kyc_rejected');
            }
        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
        $kyc->save();

        return $this->success([
            'record' => $kyc,
        ], '');
    }
}
