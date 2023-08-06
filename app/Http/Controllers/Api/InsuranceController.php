<?php

namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Helper\Game\Casino2U;
use App\Http\Controllers\Controller;
use App\Models\ClaimInsurance;
use App\Models\InsuranceHis;
use App\Models\InsuranceSurender;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{

    public function getInsuranceHis(Request $request)
    {
        $user = auth()->user();
        $insurance_his = InsuranceHis::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        return $this->success($insurance_his, '');
    }

    public function purchaseInsurance(Request $request)
    {

        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $user = auth()->user();

        $activePackage = $user->myActivePackage();

        if (!$activePackage) {

            return $this->fail('E00016', 'NO_PACKAGE');
        }

        $check_insurance = ClaimInsurance::where([
            ['user_id', '=', $user->id],
            ['status', '=', 0],
        ])->first();

        if ($check_insurance) {
            return $this->fail('E00017', 'PENDING');
        }

        $insurance_his = InsuranceHis::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $tmp = Carbon::now()->format('Y-m-d');
        if ($insurance_his) {
            if ($insurance_his->created_at->format('Y-m-d') >= $tmp) {

                return $this->fail('E00017', 'TODAY_BOUGHT');
            }
        }
        $package = UserGroup::where('display', 1)->where('id', '=', $activePackage->user_group_id)->first();

        $pay = $package->insurance_pay;
        if ($request->get('pay_type') == 'point1') {
            $wallet = 'point1';
            $wallet_type = 1;
            $pay1 = $pay;

            if ($user->$wallet < $pay1) {
                $error_code = 'E00006';
                $error = 'INSUFFICIAN_BALANCE';
            }
        } else {
            $error_code = 'E00008';
            $error = 'INCORRECT_ACTION';
        }

        if ($error) {
            return $this->fail($error_code, $error);
        }

        $r = $this->create_transaction($user->id, '-', $wallet, 999, $wallet_type, $pay1, '购买保险', 'Purchase insurance ', 'Beli insurance ');

        if ($r) {
            /*if ($this->global_key('BONUS_SWITCH') > 0 && $user->pid > 0 && $currect->price == 0) {
            Bonus::special_bonus($user->pid, $this->global_key('SPECIAL_BONUS'));
            }*/

            $user_package = UserPackage::where('user_id', $user->id)->orderBy('id', 'desc')->first();

            $record['user_id'] = $user->id;
            $record['user_package_id'] = $user_package->id;
            $record['user_group_id'] = $package->id;
            $record['pay'] = $pay;

            Bonus::dynamic_bonus($pay, $user->id);
            Bonus::level_bonus($pay, $user->id);
            //Bonus::special_bonus($pay, $user->id);

            InsuranceHis::create($record);

            return $this->success('', 'REQUEST_COMPLETE');
        } else {

            return $this->fail('E00010', 'REQUEST_FAIL');
        }
    }

    public function claimInsurance(Request $request)
    {

        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $user = auth()->user();
        $casino = new Casino2U();
        $bo_info = $casino->accountInfo($user->id, $user->username);
        if ($bo_info['success'] == true) {
            $capital = $bo_info['data']->point;
        }

        // if ($capital > 0) {
        //     return $this->jsonResponse([
        //         'code' => 1,
        //         'data' => false,
        //         'message' => 'Capital must empty',
        //     ]);
        // }

        $check_insurance = ClaimInsurance::where([
            ['user_id', '=', $user->id],
            ['status', '=', 0],
        ])->first();

        if ($check_insurance) {
            return $this->fail('E00017', 'PENDING');
        }

        $insurance_his = InsuranceHis::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();

        if (!$insurance_his) {
            return $this->fail('E00008', 'INCORRECT_ACTION');
        }

        $lastClaim = ClaimInsurance::where([
            ['user_id', '=', $user->id],
            ['status', '!=', 2],
        ])->whereDate('created_at', '=', Carbon::today()->toDateString())->first();

        if ($lastClaim) {
            return $this->fail('E00019', 'TODAY_IS_CLAIMED');
        }

        $record['user_id'] = $user->id;
        $record['user_package_id'] = $insurance_his->user_package_id;

        if ($request->hasfile('doc1')) {
            $file = $request->file('doc1');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/claim/' . date("Y-m-d"), $filename);
            $path = '/claim/' . date("Y-m-d") . '/' . $filename;
            $record['doc1'] = $path;
        }

        if ($request->hasfile('doc2')) {
            $file = $request->file('doc2');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/claim/' . date("Y-m-d"), $filename);
            $path = '/claim/' . date("Y-m-d") . '/' . $filename;
            $record['doc2'] = $path;
        }

        if ($request->hasfile('doc3')) {
            $file = $request->file('doc3');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/claim/' . date("Y-m-d"), $filename);
            $path = '/claim/' . date("Y-m-d") . '/' . $filename;
            $record['doc3'] = $path;
        }

        $r = ClaimInsurance::create($record);

        if ($r) {
            return $this->success('', 'REQUEST_COMPLETE');
        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
    }

    public function getClaimInsuranceHis(Request $request)
    {
        $user = auth()->user();
        $insurance_his = ClaimInsurance::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        return $this->success($insurance_his, '');
    }

    public function surrender(Request $request)
    {

        $error = $this->check_secpass($request->get('sec_password'));
        if ($error) {
            return $error;
        }
        $user = auth()->user();
        $activePackage = $user->myActivePackage();

        if (!$activePackage) {
            return $this->fail('E00016', 'NO_PACKAGE');
        }

        $check_insurance = ClaimInsurance::where([
            ['user_id', '=', $user->id],
            ['status', '=', 0],
        ])->first();

        if ($check_insurance) {
            return $this->fail('E00017', 'PENDING');
        }

        $claimRecord = ClaimInsurance::where([
            ['user_id', '=', $user->id],
            ['status', '=', 0],
            ['user_package_id', '=', $activePackage->id],
        ])->orderBy('id', 'desc')->first();

        $tmp = Carbon::now()->format('Y-m-d');
        if ($claimRecord) {
            return $this->fail('E00017', 'PENDING');
        }
        $surrender_his = InsuranceSurender::where([
            ['user_id', '=', $user->id],
            ['status', '=', 0],
            ['user_package_id', '=', $activePackage->id],
        ])->orderBy('id', 'desc')->first();

        if ($surrender_his) {
            return $this->fail('E00017', 'PENDING');
        }

        if ($activePackage->exp_date > $tmp) {
            return $this->fail('E00020', 'LOCK_120_DAYS');
        }

        $surrender['user_id'] = $user->id;
        $surrender['user_package_id'] = $activePackage->id;
        $surrender['get_amount'] = $activePackage->price;

        $r = InsuranceSurender::create($surrender);

        if ($r) {
            return $this->success('', 'REQUEST_COMPLETE');
        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
    }
}
