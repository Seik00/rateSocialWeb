<?php

namespace App\Http\Controllers\admin;

use App\Helper\Game\Casino2U;
use App\Http\Controllers\Common\AdminBaseController;
use App\Models\ClaimInsurance;
use App\Models\InsuranceBetHistory;
use App\Models\InsuranceSurender;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InsuranceController extends AdminBaseController
{

    public function claimRecord(Request $request)
    {

        $db = ClaimInsurance::select('*');

        $db->where('status', 0);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');

    }
    public function claimHis(Request $request)
    {

        $db = ClaimInsurance::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');

    }
    public function claimControl(Request $request)
    {
        $claim = ClaimInsurance::where('id', $request->get('id'))->first();
        if ($claim->status > 2) {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }

        if ($request->get('action') == 'APPROVE') {
            $claim->status = 1;
            $casino = new Casino2U();
            $bo_info = $casino->accountInfo($claim->user->id, $claim->user->username);
            if ($bo_info['success'] == true) {
                $capital = $bo_info['data']->point;
            }

            $claim_amount = $claim->user_package->price - $capital;
            $casino_status = $casino->transfer($claim->user->id, $claim_amount);

            if ($casino_status['success'] == false) {
                return $this->fail('E00007', 'ibo_return_msg');
            }

            UserPackage::where('id', $claim->user_package_id)->update(['exp_date' => Carbon::now()->addDays(120)]);

            $claim->claim_amount = $claim_amount;
        } elseif ($request->get('action') == 'REJECT') {
            $claim->status = 2;
            $claim->remark = $request->get('remark');

        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
        $this->activities_log('claim control', json_encode($request->all()));
        $claim->save();
        
        return $this->success([
            'record' => $claim,
        ], '');
    }
    public function surenderRecord(Request $request)
    {

        $db = InsuranceSurender::select('*');
        $db->where('status', 0);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');

    }
    public function surenderHis(Request $request)
    {

        $db = InsuranceSurender::select('*');
        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');

    }
    public function surenderControl(Request $request)
    {
        $surender = InsuranceSurender::where('id', $request->get('id'))->first();
        if ($surender->status > 0) {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }

        if ($request->get('action') == 'APPROVE') {
            $surender->status = 1;
            $user = User::where('id', $surender->user_id)->first();
            $casino = new Casino2U();
            $gameAccount = $casino->accountInfo($user->id, $user->username);
            if (isset($gameAccount['data']->point)) {

                if ($gameAccount['data']->point > $user->total_cap) {
                    $capital = $user->total_cap;
                } else {
                    $capital = $gameAccount['data']->point;
                }
                $pull_capital = 0 - $capital;

            }
            $casino_status = $casino->transfer($user->id, $pull_capital);
            if ($casino_status['success'] == false) {
                return $this->fail('E00007', 'ibo_return_msg');
            }
            UserPackage::where('id', $surender->user_package_id)->update(['status' => 3]);
            $surender->get_amount = $capital;

            if ($user->special == 0) {
                $user->user_group_id = 1;

            }
            $detail = '审核成功赎回本金';
            $detailen = 'Request Surender success, withdraw capital';
            $this->create_transaction($surender->user_id, '+', 'point2', '902', '2', $capital, $detail, $detailen);
            $user->total_cap = 0;
            $user->save();

        } elseif ($request->get('action') == 'REJECT') {
            $surender->status = 2;
            $surender->remark = $request->get('remark');

        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
        $this->activities_log('surender control', json_encode($request->all()));
        $surender->save();
        return $this->success([
                'record' => $surender,
        ], '');
    }

    public function insuranceBetRecord(Request $request)
    {

        $db = InsuranceBetHistory::select('*');
        $db->where('username', $request->get('username'));

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function revertRecord(Request $request)
    {

        $db = ClaimInsurance::select('*');

        $db->where('status', 1);

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');

    }
    public function revertControl(Request $request)
    {
        $claim = ClaimInsurance::where('id', $request->get('id'))->first();
        if ($claim->status != 1) {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }

        if ($request->get('action') == 'REVERT') {
            $gameAccount = $casino->accountInfo($claim->user->id, $claim->user->username);
            if (isset($gameAccount['data']->point)) {

                if ($gameAccount['data']->point > $claim->user->max_cap) {
                    $capital = $claim->user->max_cap;
                } else {
                    $capital = $gameAccount['data']->point;
                }
                $pull_capital = 0 - $capital;
                $casino_status = $casino->transfer($claim->user->id, $pull_capital);
                if ($casino_status['success'] == false) {
                    
                return $this->fail('E00007', 'ibo_return_msg');
                }
            }

            $claim->revert_amount = $pull_capital;
            $claim->status = 0;
            $claim->save();

        } else {
            return $this->fail('E00010', 'REQUEST_FAIL');
        }
        $this->activities_log('claim control', json_encode($request->all()));
        $claim->save();

        return $this->success([
            'record' => $claim,
        ], '');
    }
}
