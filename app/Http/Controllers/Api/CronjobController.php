<?php
namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Http\Controllers\Controller;
use App\Models\ClaimInsurance;
use App\Models\InsuranceHis;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

//project model//
class CronjobController extends Controller
{
    public function introduce()
    {
        $users = Db::table("users")->where('role_id', 2)->get();

        for ($i = 0; $i < count($users); $i++) {

            $jie = Db::table("u_all")->where("user_id", $users[$i]->pid)->first();
            if ($jie) {
                $array = explode(",", $jie->p);
                array_shift($array);
                array_unshift($array, $users[$i]->pid);
                $data['p'] = "0," . implode(",", $array);
                $r = Db::table("u_all")->where('user_id', $users[$i]->id)->update($data);
                echo $r;
            }

        }
    }
    public function SetSite()
    {

        if ($this->global_key('SITE_ON') == 1) {
            $this->set_key('SITE_ON', 0);
            $this->activePackage();
        } else {
            $this->set_key('SITE_ON', 1);
        }

        echo 'SITE NOW:' . $this->global_key('SITE_ON');

    }
    public function RunMatchingBonus()
    {
        //  Bonus::matching_bonus();
        echo 'Matching bonus done:';

    }
    public function RunRoiBonus()
    {
        //    Bonus::runStatic();
        echo 'ROI bonus done:';
    }
    public function activePackage()
    {
        echo Carbon::now()->subDays(3);
        UserPackage::where('status', '=', 0)->whereDate('created_at', '<=', Carbon::now()->subDays(3))->update(['status' => 1]);
    }
    public function CheckRank(Request $request)
    {
        $user = User::where('role_id', '=', 2)->orderBy('id', 'desc')->get();

        for ($i = 0; $i < count($user); $i++) {

            $sponsor = User::where([
                ['pid', '=', $user[$i]->id],
                ['user_group_id', '>', 1],
            ])->count();

            $total = DB::select(DB::raw("SELECT COALESCE(SUM(price),0) as sales FROM user_package WHERE user_id in (select user_id from u_all where p like '%" . $user[$i]->id . "%' ) and status = 1"));
            $group_sales = $total[0]->sales;

            $totalrank = DB::select(DB::raw("SELECT count(user_rank_id) as total,user_rank_id FROM `users` where (id in (select user_id from u_all where p like '%" . $user[$i]->id . "%') ) and user_rank_id>0 group by user_rank_id order by user_rank_id desc"));
            $userRank = array();
            for ($j = 0; $j < count($totalrank); $j++) {
                if ($totalrank[$j]->total > 0) {
                    $userRank['user_rank' . $totalrank[$j]->user_rank_id] = $totalrank[$j]->total;
                }
            }
            $userRank = $user[$i]->teamRanking();
            dump($userRank);
            $rank = 0;

            if ($user[$i]->package->price >= 12600 && $group_sales >= 1000000) {
                $downlineRank = $userRank['user_rank4'] + $userRank['user_rank5'];
                if ($downlineRank >= 3) {
                    $rank = 5;
                }
            }
            if ($rank == 0 && $user[$i]->package->price >= 6300 && $group_sales >= 300000) {
                $downlineRank = $userRank['user_rank3'] + $userRank['user_rank4'] + $userRank['user_rank5'];
                if ($downlineRank >= 3) {
                    $rank = 4;
                }
            }
            if ($rank == 0 && $group_sales >= 100000 && $user[$i]->package->price >= 3150) {

                $downlineRank = $userRank['user_rank2'] + $userRank['user_rank3'] + $userRank['user_rank4'] + $userRank['user_rank5'];
                if ($downlineRank >= 3) {
                    $rank = 3;
                }

            }

            if ($rank == 0 && $group_sales >= 30000 && $user[$i]->package->price >= 1260) {
                $downlineRank = $userRank['user_rank1'] + $userRank['user_rank2'] + $userRank['user_rank3'] + $userRank['user_rank4'] + $userRank['user_rank5'];
                if ($downlineRank >= 3) {
                    $rank = 2;
                }
            }
            if ($rank == 0 && $group_sales >= 5000 && $sponsor >= 3 && $user[$i]->package->price >= 630) {
                $rank = 1;

            }

            echo $user[$i]->username . ' package:' . $user[$i]->package->price . ' sponsor:' . $sponsor . ' group sales:' . $group_sales . ' new rank:' . $rank . '<br>';

            if ($user[$i]->special == 1) {
                if ($rank < $user[$i]->set_rank) {
                    $rank = $user[$i]->set_rank;
                }
            }
            Db::table("users")->where('id', $user[$i]->id)->update(['user_rank_id' => $rank]);
        }
        echo 'check_rank done';
    }
    public function renewInsurance(Request $request)
    {
        $user = User::where('auto_renew', '=', 1)->get();

        for ($i = 0; $i < count($user); $i++) {
            $userPackage = $user[$i]->myActivePackage();

            if ($userPackage) {
                echo $user[$i]->id . ' <br>';
                $insurance_his = InsuranceHis::where([
                    ['user_id', '=', $user[$i]->id],
                    ['user_package_id', '=', $userPackage->id],
                ])->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
                $pendingClaim = ClaimInsurance::where([
                    ['user_id', '=', $user[$i]->id],
                    ['status', '=', 0],
                ])->first();
                if (!$insurance_his && !$pendingClaim) {
                    $pay = $userPackage->package->insurance_pay;
                    $wallet = 'point1';
                    $wallet_type = 1;
                    $pay1 = $pay;

                    if ($user[$i]->$wallet > $pay1) {
                        $r = $this->create_transaction($user[$i]->id, '-', $wallet, 999, $wallet_type, $pay1, '购买保险', 'Purchase insurance ', 'Beli insurance ');
                        if ($r) {
                            $record['user_id'] = $user[$i]->id;
                            $record['user_package_id'] = $userPackage->id;
                            $record['user_group_id'] = $userPackage->package->id;
                            $record['pay'] = $pay;

                            Bonus::dynamic_bonus($pay, $user[$i]->id);
                            Bonus::level_bonus($pay, $user[$i]->id);

                            InsuranceHis::create($record);
                            echo $user[$i]->id . ' renew<br>';
                        }
                    } else {
                        Db::table("users")->where('id', $user[$i]->id)->update(['auto_renew' => 0]);
                    }

                }
            }
        }
        echo 'auto renew done';
    }
}
