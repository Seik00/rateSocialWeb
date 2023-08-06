<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\DynamicBonus;
use App\Models\FundTransfer;
use App\Models\LevelBonus;
use App\Models\MatchingBonus;
use App\Models\SpecialBonus;
use App\Models\SponsorBonus;
use App\Models\StaticBonus;
use App\Models\User;
use App\Models\UserOtpCode;
use App\Models\UserPackage;
use App\Models\UserGroup;
use DB;
use Illuminate\Http\Request;

class RecordController extends AdminBaseController
{
    public function userWalletRecord(Request $request)
    {
        $this->validate($request, [
            'wallet' => 'required',
        ]);
        if ($request->get('wallet') == 'point1') {
            $wallet = 1;
        } else if ($request->get('wallet') == 'point2') {
            $wallet = 2;
        } else if ($request->get('wallet') == 'point3') {
            $wallet = 3;
        } else if ($request->get('wallet') == 'point4') {
            $wallet = 4;
        } else {
            $wallet = 10;
        }
        $db = FundTransfer::select('*');
        $username = $request->get('username');
        if ($username) {

            $user = User::where('username', $username)->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $username)->where('role_id', 2)->first();
            }

            if ($user) {
                $db->where('user_id', $user->id);
            } else {
                $db->where('user_id', -1);
            }
        }

        if ($wallet) {
            $db->where(function ($q) use ($wallet) {
                $q->where('in_type', $wallet)
                    ->orWhere('out_type', $wallet);
            });
        }

        if ($request->get('start_date')) {
            $db->whereBetween('created_at', [$request->get('start_date') . ' 00:00:00', $request->get('end_date') . ' 23:59:59']);
        }

        if ($request->get('found_type')) {
            $found_type = explode(",", $request->get('found_type'));
            $db->wherein('found_type', $found_type);
        }

        $record = $db->orderBy('id', 'desc')->paginate(10);
        $total = $db->sum('found');

        return $this->success([
            'record' => $record,
            'total_amount' => $total,
            'found_type' => $this->fount_type(),
        ], '');
    }
    public function walletRecord(Request $request)
    {
        $db = FundTransfer::select('*');
        $wallet = $request->get('wallet');
        $username = $request->get('username');

        if ($wallet == 'point1') {
            $db->where(function ($q) {
                $q->where('in_type', 1)
                    ->orWhere('out_type', 1);
            });
        } elseif ($wallet == 'point2') {
            $db->where(function ($q) {
                $q->where('in_type', 2)
                    ->orWhere('out_type', 2);
            });
        } else {
            $db->where(function ($q) {
                $q->where('in_type', 10)
                    ->orWhere('out_type', 10);
            });
        }

        if ($username) {

            $user = User::where('username', $username)->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $username)->where('role_id', 2)->first();
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
        if ($user) {
            $balance = $user->$wallet;
        } else {
            $balance = 0;
        }

        $record = $db->orderBy('id', 'desc')->paginate(10);

        $wallet = $this->wallet_type();

        return $this->success([
            'record' => $record,
            'wallet' => $wallet,
            'balance' => $balance,
        ], '');
    }

    public function otpRecord(Request $request)
    {

        $db = UserOtpCode::select('*');
        if ($request->get('contact')) {
            $db->where('contact_number', 'like', '%' . $request->get('contact') . '%');
        }

        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function bonusRecord(Request $request)
    {

        $bonus = $request->get('bonus');

        if ($bonus == 'sponsor_bonus') {
            $db = SponsorBonus::select('*');
        } elseif ($bonus == 'dynamic_bonus') {
            $db = DynamicBonus::select('*');
        } elseif ($bonus == 'level_bonus') {
            $db = LevelBonus::select('*');
        } elseif ($bonus == 'special_bonus') {
            $db = SpecialBonus::select('*');
            //$total = SpecialBonus::where('user_id', auth()->user()->id)->sum('founds');
        } else {
            $db = StaticBonus::select('*');
            // $total = StaticBonus::where('user_id', auth()->user()->id)->sum('founds');
        }
        $db = $this->search_record($db, $request);
        $total = $db->orderBy('id', 'desc')->sum('founds');
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return $this->success([
            'record' => $record,
            'total' => $total,
            'bonus' => $bonus,
        ], '');
    }
    public function matchingBonus(Request $request)
    {

        $db = MatchingBonus::select('*');

        $db = $this->search_record($db, $request);

        $total = $db->orderBy('id', 'desc')->sum('founds');
        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }

    public function staticBonus(Request $request)
    {

        $db = StaticBonus::select('*');

        $db = $this->search_record($db, $request);

        $total = $db->orderBy('id', 'desc')->sum('founds');
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return view('admin.record.static_bonus')
            ->with('total', $total)
            ->with('bonus', 'static_bonus')
            ->with('record', $record);
    }

    public function dynamicBonus(Request $request)
    {
        $db = DynamicBonus::select('*');

        $db = $this->search_record($db, $request);

        $total = $db->orderBy('id', 'desc')->sum('founds');
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return view('admin.record.static_bonus')
            ->with('total', $total)
            ->with('bonus', 'dynamic_bonus')
            ->with('record', $record);
    }
    public function specialBonus(Request $request)
    {
        $db = SpecialBonus::select('*');

        $db = $this->search_record($db, $request);

        $total = $db->orderBy('id', 'desc')->sum('founds');
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return view('admin.record.static_bonus')
            ->with('total', $total)
            ->with('bonus', 'special_bonus')
            ->with('record', $record);
    }
    public function sponsorBonus(Request $request)
    {
        $db = SponsorBonus::select('*');

        $db = $this->search_record($db, $request);

        $total = $db->orderBy('id', 'desc')->sum('founds');
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return view('admin.record.static_bonus')
            ->with('total', $total)
            ->with('bonus', 'sponsor_bonus')
            ->with('record', $record);
    }

    public function userPackageRecord(Request $request)
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

        return $this->success([
            'record' => $record,
        ], '');
    }
    public function teamReport(Request $request)
    {
        $user = User::where('username', $request->get('username'))->first();
        $from = '';
        $result = array();
        if ($user) {

            $total = DB::select('SELECT *  FROM users WHERE id in (select user_id from u_all where p like "%' . $user->id . '%") ');
           
            if ($request->get('from')) {
                $from = ' and (created_at>="' . $request->get('from') . ' 00:00:00' . '" and created_at<="' . $request->get('to') . ' 23:59:59")';
            }
            for ($i = 0; $i < count($total); $i++) {
                
                $result[$i]['username'] = $total[$i]->username;
                $sponsor = User::where('id', $total[$i]->pid)->first();
                if ($sponsor) {
                    $result[$i]['sponsor'] = $sponsor->username;
                } else {
                    $result[$i]['sponsor'] = '';
                }
                $user_group = UserGroup::where('id', $total[$i]->user_group_id)->first();
                $withdraw = DB::select(DB::raw("SELECT COALESCE(SUM(amount),0) as total FROM withdraw_coin WHERE user_id =" . $total[$i]->id . " and status = 2 " . $from));
                $deposit = DB::select(DB::raw("SELECT COALESCE(SUM(amount),0) as total FROM wallet_reload_record WHERE user_id =" . $total[$i]->id . " " . $from));
                $result[$i]['withdraw'] = $withdraw[0]->total;
                $result[$i]['deposit'] = $deposit[0]->total;
                $result[$i]['package'] = $user_group->package_name_en;
            }
            // if($request->get('export') == '1'){
            //     $export['title'] = ['Username', 'Sponsor Income', 'Withdraw', 'Deposit'];

            //     return $this->exportExcel($export['title'], $result, 'TeamReport');
            // }
        }


        return $this->success([
            'record' => $result,
        ], '');
    }
    public function exportTeamReport(Request $request)
    {

        $user = User::where('username', $request->get('username'))->first();
        $from = '';
        $result = array();
        if ($user) {

            $total = DB::select('SELECT *  FROM users WHERE id in (select user_id from u_all where p like "%' . $user->id . '%") ');

            if ($request->get('from')) {
                $from = ' and (created_at>="' . $request->get('from') . ' 00:00:00' . '" and created_at<="' . $request->get('to') . ' 23:59:59")';
            }
            for ($i = 0; $i < count($total); $i++) {
                $result[$i]['username'] = $total[$i]->username;
                $sponsor = User::where('id', $total[$i]->pid)->first();
                if ($sponsor) {
                    $result[$i]['sponsor'] = $sponsor->username;
                } else {
                    $result[$i]['sponsor'] = '';
                }

                $withdraw = DB::select(DB::raw("SELECT COALESCE(SUM(amount),0) as total FROM withdraw_coin WHERE user_id =" . $total[$i]->id . " and status = 2 " . $from));
                $deposit = DB::select(DB::raw("SELECT COALESCE(SUM(amount),0) as total FROM wallet_reload_record WHERE user_id =" . $total[$i]->id . " " . $from));
                $result[$i]['withdraw'] = $withdraw[0]->total;
                $result[$i]['deposit'] = $deposit[0]->total;
            }
            // if($request->get('export') == '1'){
            //     $export['title'] = ['Username', 'Sponsor Income', 'Withdraw', 'Deposit'];

            //     return $this->exportExcel($export['title'], $result, 'TeamReport');
            // }
        }

        $export['data'] = array();


        for ($j = 0; $j < count($result); $j++) {

            $export['data'][$j]['username'] = $result[$j]['username'];
            $export['data'][$j]['sponsor'] = $result[$j]['sponsor'];
            $export['data'][$j]['withdraw'] = $result[$j]['withdraw'];
            $export['data'][$j]['deposit'] = number_format($result[$j]['deposit']);
        }
        $export['title'] = ['Username', 'Sponsor Income', 'Withdraw', 'Deposit'];

        return $this->exportExcel($export['title'], $export['data'], 'TeamReport');
    }
}
