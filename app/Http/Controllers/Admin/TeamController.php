<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TeamController extends AdminBaseController
{
    public function sponsorTree(Request $request)
    {
        if ($request->get('username')) {

            $user = User::where('username', $request->get('username'))->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $request->get('username'))->where('role_id', 2)->first();
            }

            if ($user) {
                $uid = $user->id;
            } else {
                $uid = '1000000';
            }
        } else {
            $uid = '1000000';
        }
        return $this->success([
            'uid' => $uid,
            'username' => $request->get('username'),
        ], '');
    }
    public function jstree_ajax_data(Request $request)
    {

        $parent = $request->get("parent");
        $data = array();
        $states = array
            (
            "success",
            "info",
            "danger",
            "default",
            "warning",
        );

        if ($parent == '#') {

            $p = User::where('id', $request->get("uid"))->get();
            foreach ($p as $k => $v) {
                //$i = $v['jy'] == 1? 2:4;
                $sales = DB::select(DB::raw("SELECT sum(pay) as total FROM user_package WHERE user_id in (select user_id from u_all where p like '%" . $v->id . "%') and status = 1"));
                $team_withdraw = DB::select(DB::raw("SELECT sum(amount) as total FROM withdraw_coin WHERE user_id in (select user_id from u_all where p like '%" . $v->id . "%') and status = 1"));
                $team_deposit = DB::select(DB::raw("SELECT sum(amount) as total FROM wallet_reload_record WHERE user_id in (select user_id from u_all where p like '%" . $v->id . "%') and status = 1"));
                $no_active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $v->id . "%') and user_group_id = 1"));
                $active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $v->id . "%') and user_group_id > 1"));
                $total = $active[0]->total + $no_active[0]->total;
                $data[] = array
                    (
                    "id" => $v->id,
                    "p" => $parent,
                    "text" => $v->username . '-' . $v->package->package_name . '(Sales:' . $sales[0]->total . ')(Total:' . $total . ')(Team Withdraw:' . $team_withdraw[0]->total . ')(Team Deposit:' . $team_deposit[0]->total . ')',
                    "icon" => "fa fa-user",
                    "children" => true,
                    "type" => "root",
                );
            }
        } else {
            $count_p = User::where('pid', $parent)->count();
            if ($count_p <= 0) {
                //$lan=cookie("think_language");
                $lid = User::where('id', $parent)->first();

                $data[] = array
                    (
                    "id" => $lid->username,
                    "icon" => "fa fa-plus-square fa-large icon-state-default",
                    "text" => 'end',
                    "children" => false,
                );
            } else {
                $p2 = User::where('pid', $parent)->get();
                foreach ($p2 as $k2 => $v2) {
                    //$i = $v2['jy']  == 1? 2:1;
                    $sales = DB::select(DB::raw("SELECT sum(pay) as total FROM user_package WHERE user_id in (select user_id from u_all where p like '%" . $v2->id . "%') and status = 1"));
                    $team_withdraw = DB::select(DB::raw("SELECT sum(amount) as total FROM withdraw_coin WHERE user_id in (select user_id from u_all where p like '%" . $v2->id . "%') and status = 2"));
                    $team_deposit = DB::select(DB::raw("SELECT sum(amount) as total FROM wallet_reload_record WHERE user_id in (select user_id from u_all where p like '%" . $v2->id . "%') and status = 1"));
                    $no_active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $v2->id . "%') and user_group_id = 1"));
                    $active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $v2->id . "%') and user_group_id > 1"));
                    $total = $active[0]->total + $no_active[0]->total;
                    $data[] = array
                        (
                        "id" => $v2->id,
                        "p" => $parent,
                        "text" => $v2->username . '-' . $v2->package->package_name . '(Sales:' . $sales[0]->total . ')(Total:' . $total . ')(Team Withdraw:' . $team_withdraw[0]->total . ')(Team Deposit:' . $team_deposit[0]->total . ')',
                        "icon" => "fa fa-user",
                        "children" => true,
                        "type" => "root",
                    );
                }
            }
        }
        return Response::json($data);
    }
}
