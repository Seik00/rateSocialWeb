<?php

namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Helper\Game\Casino2U;
use App\Http\Controllers\Controller;
use App\Models\ClaimInsurance;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/package/get-upgrade-package",
     *     tags={"Package"},
     *     summary="",
     *       deprecated=false,
     * *     operationId="getUpgradePackage",
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
    public function getUpgradePackage(Request $request)
    {
        $user = auth()->user();

        // DB::select('exec my_stored_procedure("Param1", "param2",..)');
        // call sendBV($nid,$price);
        $casino = new Casino2U();
        $bo_info = $casino->accountInfo($user->id, $user->username);
        if ($bo_info['success'] == true) {
            $capital = $bo_info['data']->point;
        } else {
            $capital = 0;
        }

        // if ($user->package->price == $capital) {
        //     $package = UserGroup::where('display', 1)->where('price', '>', $user->package->price)->get();
        // } else {
        //     $package = UserGroup::where('display', 1)->where('price', '>=', $user->package->price)->get();
        // }

        if ($capital > $user->package->price) {
            $package = UserGroup::where('display', 1)->where('price', '>', $user->package->price)->get();
        } else {
            $package = UserGroup::where('display', 1)->where('price', '>=', $user->package->price)->get();
        }

        return $this->success($package, '');
    }
    /**
     * @OA\Post(
     *     path="/api/package/upgrade-package",
     *     tags={"Package"},
     *     summary="change password ",
     *     operationId="upgradePackage",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="user_group",
     *         in="query",
     *         description="package id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *       @OA\Parameter(
     *         name="pay_type",
     *         in="query",
     *         description="P1 = POINT1",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sec_password",
     *         in="query",
     *         description="password",
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
    public function purchasePackage(Request $request)
    {
        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $user = auth()->user();
        $currect = $user->package;
        //$package = UserGroup::where('display', 1)->where('id', '=', $request->get('user_group'))->where('price', '>=', $user->package->price)->first();

        $package = UserGroup::where('display', 1)->where('id', '=', $request->get('user_group'))->first();

        if (!$package) {
            return $this->fail('E00022', 'INCORRECT_PACKAGE');
        }

        /*if ($package->price <= $user->package->price) {
        return $this->jsonResponse([
        'code' => 1,
        'data' => false,
        'message' => 'INCORRECT_PACKAGE',
        ]);
        }*/
        $casino = new Casino2U();
        $bo_info = $casino->accountInfo($user->id, $user->username);
        if ($bo_info['success'] == true) {
            $capital = $bo_info['data']->point;
        } else {
            $capital = 0;
        }
        if ($package->price == $capital && $user->package->price != 0) {
            return $this->fail('E00028', 'Your BO capital is same with package');
        }

        $claim = ClaimInsurance::where([
            ['user_id', '=', $user->id],
            ['status', '=', 0],
        ])->first();
        if ($claim) {
            return $this->fail('E00029', 'Your claim is pending');
        }
        $pay = $package->price - $capital;
        if ($request->get('pay_type') == 'point1') {
            $wallet = 'point1';
            $wallet_type = 1;
            $pay1 = $pay;
            $wallet2 = 'point1';
            $wallet_type2 = 1;
            $pay2 = 0;
        } elseif ($request->get('pay_type') == 'point2') {
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
            $$error_code = 'E00006';
            $error = 'INSUFFICIAN_BALANCE';
        }

        if ($user->$wallet < $pay1 || $user->$wallet2 < $pay2) {
            $$error_code = 'E00006';
            $error = 'INSUFFICIAN_BALANCE';
        }

        if ($error) {
            return $this->fail($error_code, $error);
        }
        if ($user->user_group_id == $package->id) {
            $deposit_type = 'topup';
            $lock_amount = 0;
        } else {
            $deposit_type = 'package';
            $lock_amount = $package->price;
        }

        $casino_status = $casino->transfer($user->id, $pay);

        if ($casino_status['success'] == false) {
            return $this->fail('E00007', 'ibo_return_msg');
        }

        $r = $this->create_transaction($user->id, '-', $wallet, 11, $wallet_type, $pay1, '购买配套' . $package->package_name, 'Purchase package ' . $package->package_name_en, 'Beli paket ' . $package->package_name_en);

        if ($pay2 > 0) {
            $this->create_transaction($user->id, '-', $wallet2, 11, $wallet_type2, $pay2, ',购买配套' . $package->package_name, ',Purchase package ' . $package->package_name_en, 'Beli paket ' . $package->package_name_en);
        }

        if ($r) {

            /*if ($this->global_key('BONUS_SWITCH') > 0 && $user->pid > 0 && $currect->price == 0) {
            Bonus::special_bonus($user->pid, $this->global_key('SPECIAL_BONUS'));
            }*/
            $record['user_id'] = $user->id;
            $record['user_group_id'] = $package->id;
            $record['price'] = $package->price;
            $record['pay'] = $pay;
            $record['bv'] = $package->bv;
            $record['pay_type'] = $request->get('pay_type');
            $record['exp_date'] = Carbon::now()->addDays(120);

            $record['status'] = 1;

            $user_package = UserPackage::create($record);

            if ($lock_amount > 0) {
                $user->total_cap = $lock_amount; //casino 绑定capital升级才更新
            }

            $user->user_group_id = $package->id;

            $user->save();

            if ($package->price > 0) {

                UserPackage::where([
                    ['user_id', '=', $user->id],
                    ['status', '=', 1],
                    ['id', '!=', $user_package->id],
                ])->update(['status' => 2]);
                // DB::select('call sendBV("' . $user->id . '","' . $package->bv . '")');

                Bonus::sponsor_bonus($pay, $user->id);
                // Bonus::dynamic_bonus($pay, $user->id);
                // Bonus::level_bonus($pay, $user->id);
            }

            return $this->success('', 'REQUEST_COMPLETE');
        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
    }
    /**
     * @OA\get(
     *     path="/api/package/get-user-package",
     *     tags={"Package"},
     *     summary="get user package",
     *     description="get user package",
     *     operationId="getUserPackage",
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
    public function getUserPackage(Request $request)
    {
        $user = auth()->user();

        $package = UserPackage::where('user_id', $user->id)->get();
        return $this->success($package, 'REQUEST_COMPLETE');
    }
    /**
     * @OA\Get(
     *     path="/api/package/get-package",
     *     tags={"Package"},
     *     summary="",
     *       deprecated=false,
     *  operationId="getPackage",
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
    public function getPackage(Request $request)
    {
        $package = UserGroup::where('display', 1)->get();
        return $this->success($package, 'REQUEST_COMPLETE');
    }
}
