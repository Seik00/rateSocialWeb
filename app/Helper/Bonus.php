<?php
namespace App\Helper;

use App\Models\DynamicBonus;
use App\Models\FundTransfer;
use App\Models\LevelBonus;
use App\Models\MatchingBonus;
use App\Models\SpecialBonus;
use App\Models\SponsorBonus;
use App\Models\StaticBonus;
use App\Models\User;
use App\Models\UserPackage;
use DB;

class Bonus
{
    public static function test()
    {
        return DynamicBonus::paginate(1);
    }
    public static function runStatic($id = 0, $max = 9999999)
    {
        $last = UserPackage::where('user_id', '>', '999999')->where('status', '=', '1')->where('user_group_id', '>', 1)->orderBy('id', 'desc')->first();
        $last_bonus = static::static_bonus($id, $max);

        if (isset($last->id) && $last_bonus < $last->id) {

            static::runStatic($last_bonus, $last->id);
        }
    }
    public static function static_bonus($id = 0, $max = 9999999)
    {
        $ur_list = UserPackage::where('user_id', '>', '999999')->where('status', '=', '1')->where('user_group_id', '>', 1)->where(
            function ($query) use ($id, $max) {
                $query->where('id', '>', $id)->where('id', '<=', $max);
            })->limit('1000')->get();

        $last = '';
        foreach ($ur_list as $k => $v) {
            $user = User::where('id', $v->user_id)->first();

            if ($user->rb == 1 && $user->package->id > 1) //
            {
                $rate = $v->package->static_bonus;
                $bonus = $v->package->static_bonus; // $v->package->price * $rate / 100;

                $bonus = $user->check_cap($bonus, 'normal');
                $user->increase_income($bonus);

                $record['wallet1'] = $bonus * (70 / 100);
                $record['wallet2'] = $bonus * (20 / 100);
                $record['wallet3'] = $bonus * (10 / 100);

                $record['founds'] = $bonus;
                $record['user_id'] = $v->user_id;
                $record['current'] = '+ ' . $bonus;
                $record['detail'] = $v->package->package_name . '静态收益' . $rate . '';
                $record['detailen'] = $v->package->package_name_en . 'ROI Bonus' . $rate . '';
                $record['detailkr'] = $v->package->package_name_en . 'ROI Bonus' . $rate . '';
                $record['dis'] = $v->id;

                echo 'id:' . $v->id . ' user_id:' . $v->user_id . ' package:' . $v->package->price . ' bonus:' . $bonus . '<br>';
                static::create_transaction($record['user_id'], '+', 'point1', 1000, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                static::create_transaction($record['user_id'], '+', 'point3', 1000, 3, $record['wallet2'], $record['detail'], $record['detailen']);
                static::create_transaction($record['user_id'], '+', 'point4', 1000, 4, $record['wallet3'], $record['detail'], $record['detailen']);

                //$r = static::create_transaction($record['user_id'], '+', 'point3', 1003, 3, $record['wallet2'], $record['detail'], $record['detailen']);

                StaticBonus::create($record);
/*
$update['earn'] = $v->earn + $bonus;
$update['status'] = 1;
if ($update['earn'] >= $v->price) {
$update['status'] = 2;
User::where('id', $v->user_id)->update(['user_group_id' => 1]);
static::create_transaction($v->user_id, '+', 'point1', 12, 1, $v->pay, '配套封顶出局' . $v->package->package_name, 'Package Fully earned' . $v->package->package_name_en, 'Batalkan paket ' . $v->package->package_name_en);

}
UserPackage::where('id', $v->id)->update($update);
 */
                $base = $bonus;
                if ($v->package->id > 1) {
                    static::dynamic_bonus($base, $v->user_id);
                }
            }

            $last = $v->id;

        }
        return $last;
    }

    public static function dynamic_bonus($match_val = 100, $uid = 1000345)
    {
        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 99, 'p');
        $now_lv = 1;

        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();

            if ($user->rb == 1 && $user->package->price > 0 && $user->package->id > 1) //
            {

                $bonus_rate = $user->package->dynamic_rate;

                $bonus_rate = explode(",", $bonus_rate);

                $rate = $bonus_rate[$now_lv - 1];
                $bonus = bcadd(($match_val * $rate / 100), 0, 4);
                // dump($user->id);
                // dump($bonus);
                if ($bonus > 0 && $user->package->dynamic_lv >= $now_lv) {

                    // $bonus = $user->check_cap($bonus, 'normal');
                    // $user->increase_income($bonus);

                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = '第' . $now_lv . ' 代 (' . $from->username . ')获得' . $rate . '% 层级奖金';
                    $record['detailen'] = 'Level bonus Of ' . $rate . '% - Level ' . $now_lv . ' (' . $from->username . ')';
                    $record['detailth'] = 'ระดับโบนัสของ ' . $rate . '% - ระดับ ' . $now_lv . ' (' . $from->username . ')';
                    $record['detailvi'] = 'Mức thưởng của ' . $rate . '% - Cấp độ ' . $now_lv . ' (' . $from->username . ')';
                    $record['detailkr'] = '레벨 보너스 ' . $rate . '% - 수준 ' . $now_lv . ' (' . $from->username . ')';

                    $record['dis'] = '';
                    // $record['detailkr'] = 'Generasi ' . $now_lv . '  (' . $from->username . ') ' . $match_val . ' berbagi pendapatan untuk mendapatkan ' . $rate . '% pendapatan aljabar ';
                    $record['wallet2'] = $bonus;

                    //    echo $user->username . $record['detail'] . '---' . $bonus . '<br>';
                    $r = DynamicBonus::create($record);
                    static::create_transaction($record['user_id'], '+', 'point2', 1002, 2, $record['wallet2'], $record['detail'], $record['detailen']);

                }

            }
            $now_lv = $now_lv + 1;
            if ($now_lv > 5) {
                break;
            }
        }
    }
    public static function special_bonus($uid = 99999, $bonus)
    {
        $ur_list = User::where([
            ['id', '>', $uid],
            ['rb', '=', 1],
            ['user_group_id', '>', 0],
            ['special', '=', 0],
        ])->orderBy('id', 'asc')->get()->toArray();

        if (count($ur_list) > 0) {

            foreach ($ur_list as $k => $v) {
                if ($v['pid'] != 0) {
                    $lv7 = $v['p_level'] + 7;
                    $total = DB::select('SELECT COALESCE(sum(pay), 0)  as pay  FROM user_package WHERE user_id in (select user_id from u_all where p like "%' . $v['id'] . '%") and user_id in (select id from users where p_level >' . $v['p_level'] . ' and p_level<=' . $lv7 . ') ');
                    // echo $v['id'] . ',sales:' . $total[0]->pay . '<br>';
                    if ($total[0]->pay >= 10000) {
                        $bonus = $total[0]->pay * 0.01;
                        $record['founds'] = $bonus;
                        $record['user_id'] = $v['pid'];
                        $record['current'] = '+ ' . $bonus;
                        $record['detail'] = $v['username'] . '无线团队奖励 ';
                        $record['detailen'] = $v['username'] . 'Unilevel bonus';
                        $record['detailkr'] = $v['username'] . '유니레벨 보너스 ';
                        $record['detailth'] = $v['username'] . 'โบนัสยูนิเลเวล ';
                        $record['detailvi'] = $v['username'] . 'tiền thưởng đơn cấp ';
                        $record['dis'] = '';
                        $record['wallet1'] = $bonus * (80 / 100);
                        $record['wallet2'] = $bonus * (20 / 100);
                        $r = SpecialBonus::create($record);

                        static::create_transaction($record['user_id'], '+', 'point1', 1003, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                        static::create_transaction($record['user_id'], '+', 'point2', 1003, 2, $record['wallet2'], $record['detail'], $record['detailen']);

                        User::where('id', $v['id'])->update(array('special' => '1'));
                    }
                }

                $last = $v['id'];
            }
        }

        /* $data['name'] = 'RUN_MATCHING';
    M('cronjob')->add($data);*/
    }

    public static function level_bonus($match_val = 100, $uid = 1000345)
    {
        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 999, 'p');

        $current_rank = 0;
        $current_rate = 0;
        foreach ($j as $k => $v) {

            $user = User::where('id', $v)->first();
            if ($user->rb == 1 && $user->user_rank_id > 0 && $user->package->id > 1 && $user->user_rank_id > $current_rank) //
            {
                $rank_info = $user->rank;
                $bonus_rate = $rank_info->static_bonus - $current_rate;

                $bonus = bcadd(($match_val * $bonus_rate / 100), 0, 4);

                //   echo $user->id . " rate = " . $bonus_rate . " bonus = " . $bonus . " current = " . $current_rank . " user_level = " . $user->package->level_rate . "<br/>";
                if ($bonus > 0) {
                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['dis'] = '';
                    $record['wallet1'] = 0;
                    $record['wallet2'] = $bonus;
                    if ($current_rank == 0) {
                        $record['detail'] = '获得  (' . $from->username . ')' . $match_val . ' (' . $bonus_rate . '%级别奖励' . ')';
                        $record['detailen'] = 'Gain (' . $from->username . ') total ' . $match_val . '  of ' . $bonus_rate . '% Rank bonus';
                        $record['detailvn'] = 'Nhận được (' . $from->username . ') toàn bộ ' . $match_val . '  của ' . $bonus_rate . '% tiền thưởng xếp hạng';
                        $record['detailth'] = 'ได้รับ (' . $from->username . ') ทั้งหมด ' . $match_val . '  ของ ' . $bonus_rate . '% โบนัสอันดับ';
                        $record['detailkr'] = '얻다 (' . $from->username . ') 총 ' . $match_val . '  ~의 ' . $bonus_rate . '% 순위 보너스';
                    } else {
                        $record['detail'] = '获得  (' . $from->username . ')' . $match_val . ' (' . $bonus_rate . '%级别奖励' . ')';
                        $record['detailen'] = 'Gain (' . $from->username . ') total ' . $match_val . '  of ' . $bonus_rate . '% Rank bonus';
                        $record['detailvn'] = 'Nhận được (' . $from->username . ') toàn bộ ' . $match_val . '  của ' . $bonus_rate . '% tiền thưởng xếp hạng';
                        $record['detailth'] = 'ได้รับ (' . $from->username . ') ทั้งหมด ' . $match_val . '  ของ ' . $bonus_rate . '% โบนัสอันดับ';
                        $record['detailkr'] = '얻다 (' . $from->username . ') 총 ' . $match_val . '  ~의 ' . $bonus_rate . '% 순위 보너스';
                    }

                    $record['dis'] = '';
                    //   echo $record['detail'] . "<br/>";
                    $r = SpecialBonus::create($record);
                    // static::create_transaction($record['user_id'], '+', 'point1', 1003, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point2', 1003, 2, $record['wallet2'], $record['detail'], $record['detailen']);

                    static::same_level_bonus($record['founds'], $record['user_id']);

                }
                $current_rank = $user->user_rank_id;
                $current_rate = $rank_info->static_bonus;

            }

            if ($current_rank >= 5) {
                break;
            }
        }
    }
    public static function same_level_bonus($match_val = 100, $uid = 1000345)
    {
        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 999, 'p');

        $bonus_rate = explode(",", '10');

        $now_lv = 1;
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();
            if ($user->rb == 1 && $from->user_rank_id == $user->user_rank_id) //
            {

                $rate = $bonus_rate[$now_lv - 1];
                $bonus = bcadd(($match_val * $rate / 100), 0, 4);

                if ($bonus > 0) {

                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = '第' . $now_lv . ' 代 (' . $from->username . ')获得' . $rate . '% 获得同级奖励';
                    $record['detailen'] = 'Same Rank Bonus ' . $rate . '% - Level ' . $now_lv . ' (' . $from->username . ')';

                    $record['dis'] = '';
                    $record['detailkr'] = 'Generasi ' . $now_lv . '  (' . $from->username . ') ' . $match_val . ' berbagi pendapatan untuk mendapatkan ' . $rate . '% pendapatan aljabar ';
                    $record['wallet1'] = 0;
                    $record['wallet2'] = $bonus;

                    //  echo $user->username . $record['detail'] . '---' . $bonus . '<br>';
                    $r = LevelBonus::create($record);
                    static::create_transaction($record['user_id'], '+', 'point2', 1004, 2, $record['wallet2'], $record['detail'], $record['detailen']);
                    $now_lv = $now_lv + 1;
                }

            }
            if ($now_lv >= 2 || $user->user_rank_id > $from->user_rank_id) {
                echo $user->username;
                break;
            }

        }

    }
    public static function sponsor_bonus($match_val = 100, $uid = 1000345)
    {
        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 99, 'p');

        $current_rate = 0;

        foreach ($j as $k => $v) {

            $user = User::where('id', $v)->first();

            if ($user->rb == 1 && $user->package->price > 0 && $user->package->id > 1) //
            {

                if ($user->package->sponsor_rate > $current_rate) {
                    $bonus_rate = $user->package->sponsor_rate - $current_rate;

                    $bonus = bcadd(($match_val * $bonus_rate / 100), 0, 4);

                    //  echo $user->id." rate = ".$bonus_rate." bonus = ".$bonus." current_rate = ".$current_rate." user_sponsor = ".$user->package->sponsor_rate."<br/>";
                    if ($bonus > 0) {
                        $record['founds'] = $bonus;
                        $record['user_id'] = $user->id;
                        $record['current'] = '+ ' . $bonus;
                        if ($current_rate == 0) {
                            $record['detail'] = '获得  (' . $from->username . ') ' . $match_val . ' (' . $bonus_rate . '%推荐奖励' . ')';
                            $record['detailen'] = 'Gain (' . $from->username . ') total ' . $match_val . '  of ' . $bonus_rate . '% Sponsor bonus';
                            $record['detailvn'] = 'Nhận được (' . $from->username . ') toàn bộ ' . $match_val . '  của ' . $bonus_rate . '% tiền thưởng nhà tài trợ';
                            $record['detailth'] = 'ได้รับ (' . $from->username . ') ทั้งหมด ' . $match_val . '  ของ ' . $bonus_rate . '% โบนัสสปอนเซอร์';
                            $record['detailkr'] = '얻다 (' . $from->username . ') 총 ' . $match_val . '  ~의 ' . $bonus_rate . '% 스폰서 보너스';
                        } else {
                            $record['detail'] = '获得  (' . $from->username . ') ' . $match_val . ' (' . $bonus_rate . '%推荐奖励' . ')';
                            $record['detailen'] = 'Gain (' . $from->username . ') total ' . $match_val . '  of ' . $bonus_rate . '% Sponsor bonus';
                            $record['detailvn'] = 'Nhận được (' . $from->username . ') toàn bộ ' . $match_val . '  của ' . $bonus_rate . '% tiền thưởng nhà tài trợ';
                            $record['detailth'] = 'ได้รับ (' . $from->username . ') ทั้งหมด ' . $match_val . '  ของ ' . $bonus_rate . '% โบนัสสปอนเซอร์';
                            $record['detailkr'] = '얻다 (' . $from->username . ') 총 ' . $match_val . '  ~의 ' . $bonus_rate . '% 스폰서 보너스';
                        }

                        $record['wallet2'] = $bonus;
                        $record['dis'] = '';
                        //      echo $record['detailen'] . "<br/>";
                        $r = SponsorBonus::create($record);
                        static::create_transaction($record['user_id'], '+', 'point2', 1001, 2, $record['wallet2'], $record['detail'], $record['detailen']);

                    }
                    $current_rate = $user->package->sponsor_rate;
                }

            }
            if ($current_rate >= 10) {
                break;
            }
        }
    }

    /* public static function sponsor_bonus($user_id, $price)
    {
    $user = User::where('id', $user_id)->first();
    $puser = User::where('id', $user->pid)->first();

    if ($puser) {

    if ($puser->rb == 1 && $puser->user_group_id > 1) {
    $bonus = $price * ($puser->package->sponsor_bonus / 100);
    $check = $puser->package->price * ($puser->package->sponsor_bonus / 100);
    $content = '';
    if ($bonus > $check) {
    $left = $bonus - $check;
    $bonus = $check;
    $content = '(burn ' . $left . ')';
    }
    $record['founds'] = $bonus;
    $record['user_id'] = $puser->id;
    $record['current'] = '+ ' . $bonus;
    $record['detail'] = '推荐奖励' . $puser->package->sponsor_bonus . '%' . $content;
    $record['detailen'] = 'Sponsor bonus' . $puser->package->sponsor_bonus . '%' . $content;
    $record['detailkr'] = 'Sponsor bonus' . $puser->package->sponsor_bonus . '%' . $content;
    $record['dis'] = '';
    $record['wallet1'] = $bonus; //* (80 / 100);
    $record['wallet2'] = 0; //$bonus * (20 / 100);
    //  echo $record['user_id'] . ':' . $record['detail'] . '<br>';
    $r = SponsorBonus::create($record);
    static::create_transaction($record['user_id'], '+', 'point1', 1002, 1, $record['wallet1'], $record['detail'], $record['detailen'], $record['detailkr']);
    //   static::create_transaction($record['user_id'], '+', 'point2', 1002, 2, $record['wallet2'], $record['detail'], $record['detailen']);

    }

    }
    }*/

    public static function unilevel_bonus($uid = 1000345, $match_val = 100)
    {
        $from = User::where('id', $uid)->first();
        $j = static::get_level($uid, 99, 'p');
        $bonus = bcadd(($match_val * 0.01), 0, 3);
        $now_lv = 1;
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();

            if ($user->rb == 1) //
            {
                // dump($user->id);
                $bonus = bcadd(($match_val * 1 / 100), 0, 2);
                $total = DB::select('SELECT count(id)  as refferal  FROM user_package WHERE  user_id in (select id from users where pid =' . $user->id . ' ) and created_at >="' . date('Y-m-d 00:00:00', strtotime("-1 days")) . '"');

                if ($now_lv <= $total[0]->refferal && $bonus > 0) {
                    // echo $user->username . '    unilevel代数：' . $now_lv . '  今日推荐' . $total[0]->refferal . 'bonus:' . $bonus . '<br>';
                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = '第' . $now_lv . ' 代 (' . $from->username . ')无线团队奖励 1%';
                    $record['detailen'] = 'Get Level' . $now_lv . '(' . $from->username . ')  Unilevel Reward of 1% ';
                    $record['dis'] = '';
                    $record['detailvn'] = 'Generasi ' . $now_lv . '  (' . $from->username . ') berbagi pendapatan untuk mendapatkan 1% pendapatan aljabar ';
                    $record['wallet1'] = $bonus * (80 / 100);
                    $record['wallet2'] = $bonus * (20 / 100);

                    //echo $record['detail'] . '<br>';
                    $r = SpecialBonus::create($record);

                    static::create_transaction($record['user_id'], '+', 'point1', 1003, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point2', 1003, 2, $record['wallet2'], $record['detail'], $record['detailen']);

                }
                $now_lv = $now_lv + 1;
                if ($now_lv > 3) {
                    break;
                }
            }
        }
    }

    public static function matching_bonus($uid = 99999)
    {
        $ur_list = User::where([
            ['id', '>', $uid],
            ['rb', '=', 1],
            ['user_group_id', '>', 0],
            ['left_point', '>', 0],
            ['right_point', '>', 0],
        ])->orderBy('id', 'asc')->get()->toArray();

        if (count($ur_list) > 0) {
            foreach ($ur_list as $k => $v) {

                if ($v['rb'] == 1) {
                    $user = User::where('id', $v['id'])->first();

                    $keep = $v["left_point"] >= $v["right_point"] ? "left_point" : "right_point";
                    $empty = $v["left_point"] >= $v["right_point"] ? "right_point" : "left_point";
                    $sb1 = $v["left_point"] >= $v["right_point"] ? $v["right_point"] : $v["left_point"];
                    $sb2 = $v["left_point"] >= $v["right_point"] ? $v["left_point"] : $v["right_point"];
                    $sbv = $sb2 - $sb1;
                    $tbv = 0;
                    $match_rate = $v['package']['matching_bonus'];
                    $bonus = $sb1 * ($match_rate / 100);

                    $bonus = $user->check_cap($bonus, 'matching');
                    $user->increase_income($bonus);

                    $data['user_id'] = $v['id'];
                    $data['get_bonus'] = $bonus;
                    $data['left_point'] = $v['left_point'];
                    $data['right_point'] = $v['right_point'];
                    $data['matching_point'] = $sb1;
                    MatchingRec::create($data);

                    $detail = "左区积分：" . $v["left_point"] . " 右区积分：" . $v["right_point"] . " 配对：" . $sb1 . "后获得" . $match_rate . "%奖励。";
                    $detailen = "Left Points：" . $v["left_point"] . " Right Points：" . $v["right_point"] . " Pairing：" . $sb1 . " Get " . $match_rate . "% Team Rewards.";
                    //   echo $v['id'] . ':' . $detailen . '<br>';
                    $record['founds'] = $bonus;
                    $record['user_id'] = $v['id'];
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = $detail;
                    $record['detailen'] = $detailen;
                    $record['dis'] = '';
                    $record['detailkr'] = $detailen;
                    $record['wallet1'] = $bonus * (70 / 100);
                    $record['wallet2'] = $bonus * (20 / 100);
                    $record['wallet3'] = $bonus * (10 / 100);
                    $r = MatchingBonus::create($record);

                    static::create_transaction($record['user_id'], '+', 'point1', 1001, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point3', 1001, 3, $record['wallet2'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point4', 1001, 4, $record['wallet3'], $record['detail'], $record['detailen']);

                    //经理奖金
                    //   static::dynamic_bonus($bonus, $v['id']);
                    $user->bv = $user->bv + $sb1;
                    $user->$keep = $sbv;
                    $user->$empty = $tbv;
                    $user->save();
                }
                $last = $v['id'];
            }
        }

        /* $data['name'] = 'RUN_MATCHING';
    M('cronjob')->add($data);*/
    }

    public static function create_transaction($user_id, $act, $wallet, $found_type, $wallet_type, $amount, $detail, $detailen, $detailkr = '', $detailvn = '', $detailth = '', $remark = '')
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json(false);
        }

        if ($amount < 0) {
            return response()->json(false);
        }

        if ($act == '+') {
            $add['current'] = $user->$wallet + $amount;
            $add['in_type'] = $wallet_type;

        } else {
            $add['current'] = $user->$wallet - $amount;
            $add['out_type'] = $wallet_type;
        }
        if ($add['current'] < 0) {
            return response()->json(false);
        }
        if ($amount > 0) {
            $add['previous'] = $user->$wallet;
            $add['action'] = $act;
            $add['user_id'] = $user_id;
            $add['found_type'] = $found_type;
            $add['found'] = $amount;
            $add['detail'] = $detail;
            $add['detailen'] = $detailen;
            $add['detailth'] = $detailth;
            $add['detailvn'] = $detailvn;
            $add['detailkr'] = $detailkr;
            $add['remark'] = $remark;
            $add['created_at'] = date("Y-m-d h:i:s");

            $r = DB::table('users')->where('id', $user_id)->update([$wallet => $add['current']]);
            $r = FundTransfer::create($add);
            return 1;
        }

    }
    public static function get_level($uid, $level, $team = 'P')
    {
        $pall = DB::table('u_all')->where('user_id', $uid)->value($team);
        $uall = explode(",", $pall);
        $gp = array();
        foreach ($uall as $kk => $v) {
            if ($v != 0) {
                if ($kk <= $level) {
                    $gp[$kk] = $v;
                }
            }
        }
        return $gp;
    }
    public static function boost_bonus($user_id, $price, $rate)
    {
        $user = User::where('id', $user_id)->first();
        if ($user->package->static_bonus > 0 && $user->rb == 1) {

            $bonus = number_format(($price * $rate / 100), 4, '.', '');
            $record['founds'] = $bonus;
            $record['user_id'] = $user->id;
            $record['current'] = '+ ' . $bonus;
            $record['detail'] = '刷单收益 ';
            $record['detailen'] = 'Boost bonus';
            $record['dis'] = '';
            $record['detailin'] = 'Bagikan pendapatan ';
            $record['detailvn'] = 'Chia sẻ doanh thu';
            $record['detailth'] = 'แบ่งปันรายได้ ';
            $r = StaticBonus::create($record);
            //static::dynamic_bonus($bonus, $user->id);
            //static::create_transaction($record['user_id'], '+', 'point1', 100, 1, $bonus + $price, $record['detail'], $record['detailen'], $record['detailin'], $record['detailth'], $record['detailvn']);
            return $bonus;
        }
    }
}
