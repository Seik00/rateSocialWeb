<?php

namespace App\Models;

use App\Helper\CryptedPay;
use App\Models\ClaimInsurance;
use App\Models\GlobalCountry;
use App\Models\InsuranceHis;
use App\Models\Role;
use App\Models\Uall;
use App\Models\UserDeviceToken;
use App\Models\UserGroup;
use App\Models\UserKyc;
use App\Models\UserNotification;
use App\Models\UserPackage;
use App\Models\UserRank;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'username',
        'ref_code',
        'user_group_id',
        'set_rank',
        'role_id',
        'pid',
        'p_level',
        'jid',
        'j_level',
        'group_type',
        'group_left',
        'group_right',
        'bv',
        'left_point',
        'right_point',
        'country_id',
        'email',
        'password',
        'd_password',
        'password2',
        'd_password2',
        'contact_number',
        'bio',
        'birthday',
        'point1',
        'point2',
        'point3',
        'point4',
        'income_today',
        'income_monthly',
        'total_income',
        'total_cap',
        'expired_at',
        'special',
        'dynamic_lv',
        'auto_renew',
        'follow_trade',
        'user_rank_id',
        'fullname',
        'ic',

        'phone_verified_at',
        'remember_token',
        'address',
    ];
    protected $appends = [
        'total_sponsor', 'share_link', 'role_info', 'package', 'country', 'sponsor', 'active_cover', 'rank',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',

        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getRoleInfoAttribute()
    {
        $role_type = Role::where('id', $this->role_id)->first();
        return $role_type;
    }
    public function oneTimePasscode()
    {
        return $this->hasOne('App\Models\UserOtpCode', 'user_id', 'id');
    }
    public function getPackageAttribute()
    {
        return UserGroup::where('id', $this->user_group_id)->first();
    }
    public function getShareLinkAttribute()
    {
        return url('register?ref_id=' . $this->id);
    }
    public function role_type()
    {
        $data = auth()->user();
        $role_type = Role::where('id', $data->role_id)->first();
        return $role_type->name;
    }
    public function getTotalSponsorAttribute()
    {
        return User::where('pid', $this->id)->count();
    }
    public function getSponsorAttribute()
    {
        return User::where('id', $this->pid)->first();
    }
    public function getCountryAttribute()
    {
        $country = GlobalCountry::where('id', $this->country_id)->first();
        return $country;
    }
    public function getRankAttribute()
    {
        $rank = UserRank::where([['id', '=', $this->user_rank_id]])->first();
        return $rank;
    }
    public function checkDownline($user_id, $line = 'p')
    {

        return Uall::where('user_id', $user_id)->where($line, 'like', "%" . $this->id . "%")->first();

    }
    public function getWallet()
    {
        $address = CryptedPay::getAddress($this->id);

        return $address;
    }
    public function team_sales()
    {
        $total = DB::select(DB::raw("SELECT COALESCE(SUM(price),0) as sales FROM user_package WHERE status = 1 and user_id in (select user_id from u_all where p like '%" . $this->id . "%') "));
        return $total[0]->sales;
    }
    public function team_member()
    {
        $team = DB::table('u_all')->where('p', 'like', '%' . $this->id . '%')->count('user_id');
        return $team;
    }
    public function teamRanking()
    {
        $downline = DB::select(DB::raw("SELECT id FROM `users` where pid = " . $this->id . " "));
        $rank['user_rank1'] = 0;
        $rank['user_rank2'] = 0;
        $rank['user_rank3'] = 0;
        $rank['user_rank4'] = 0;
        $rank['user_rank5'] = 0;
        for ($i = 0; $i < count($downline); $i++) {
            $total = DB::select(DB::raw("SELECT count(user_rank_id) as total_rank,user_rank_id FROM `users` where (id in (select user_id from u_all where p like '%" . $downline[$i]->id . "%') or id= " . $downline[$i]->id . ") and user_rank_id>0 group by user_rank_id order by user_rank_id desc"));

            for ($j = 0; $j < count($total); $j++) {
                if ($total[$j]->total_rank > 0) {
                    $rank['user_rank' . $total[$j]->user_rank_id] = $rank['user_rank' . $total[$j]->user_rank_id] + 1;
                    break;
                }
            }

        }

        return $rank;
    }
    public function check_cap($bonus, $bonus_type = 'normal')
    {

        if ($bonus_type == 'matching') {
            if ($bonus > $this->package->day_cap) {
                $bonus = $this->package->day_cap;
            }

            if ($this->income_monthly + $bonus > $this->package->month_cap) {
                $bonus = $this->package->month_cap - $this->income_monthly;
            }
        }
        $total_income = bcadd(($this->total_income + $bonus), 0, 4);

        if ($total_income > $this->total_cap) {
            $bonus = $this->total_cap - $this->total_income;
            $this->user_group_id = 1;
            $this->save();
            UserPackage::where([
                'user_id' => $this->id,
                'status' => 1,
            ])->update([['status', 2]]);
        }

        return $bonus;
    }
    public function increase_income($bonus)
    {

        $this->income_today = $this->income_today + $bonus;
        $this->income_monthly = $this->income_monthly + $bonus;
        $this->total_income = $this->total_income + $bonus;
        $this->save(); // = 1;

    }
    public function find_end($position = 'right')
    {
        if ($position == 'left') {
            $position = 'group_left';
        } else {
            $position = 'group_right';
        }
        if ($this->$position == 0) {
            return $this->$username;
        } else {

            for ($i = 0; $i < 99; $i++) {
                if ($i == 0) {
                    $me = DB::table('users')->where('id', $this->$position)->first();
                } else {
                    $me = DB::table('users')->where('id', $me->$position)->first();
                }

                if ($me->$position == 0) {
                    return $me->$username;
                    break;
                }
            }
        }
    }

    public function auto_placement()
    {
        $result = array();
        if ($this->group_left == 0) {
            $result['juser'] = $this;
            $result['group_type'] = 'A';
            $result['group'] = 'group_left';

        } elseif ($this->group_right == 0) {
            $result['juser'] = $this;
            $result['group_type'] = 'B';
            $result['group'] = 'group_right';

        } else {
            $jlevel = $this->j_level;
            for ($i = 0; $i < 99; $i++) {
                $userlist = $total = DB::select(DB::raw("SELECT * FROM users WHERE id in (select user_id from u_all where j like '%" . $this->id . "%') and j_level = " . $jlevel . " order by id asc"));

                for ($j = 0; $j < count($userlist); $j++) {
                    if ($userlist[$j]->group_left == 0) {
                        $result['juser'] = $userlist[$j]->id;
                        $result['group_type'] = 'A';
                        $result['group'] = 'group_left';

                    } elseif ($this->group_right == 0) {
                        $result['juser'] = $userlist[$j]->id;
                        $result['group_type'] = 'B';
                        $result['group'] = 'group_right';

                    }
                }

                if ($result) {
                    break;
                } else {
                    $jlevel = $jlevel + 1;
                }
            }
        }

        return $result;
    }
    public function check_kyc()
    {
        $check = UserKyc::where([
            ['user_id', '=', $this->id],
        ])->orderBy('id', 'desc')->first();
        if ($check) {
            if ($check->status == 1) {
                $return['can_withdraw'] = 'approved';
            } else if ($check->status == 0) {
                $return['can_withdraw'] = 'pending';
            } else {
                $return['can_withdraw'] = 'failed';
                $return['failed_reason'] = $check->remark;
            }
        } else {
            $return['can_withdraw'] = 'failed';
        }

        return $return;
    }
    public function myActivePackage()
    {
        $user_package = UserPackage::where([
            ['user_id', '=', $this->id],
            ['status', '=', 1],
        ])->first();

        return $user_package;

    }
    public function todayStatus()
    {
        $userPackage = $this->myActivePackage();
        if ($userPackage) {
            $insurance_his = InsuranceHis::where('user_id', $this->id)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
            $todayClaimed = ClaimInsurance::where([
                ['user_id', '=', $this->id],
                ['status', '=', 1],
                ['user_package_id', '=', $userPackage->id],
            ])->whereDate('created_at', '=', Carbon::today()->toDateString())->first();

            $pending = ClaimInsurance::where([
                ['user_id', '=', $this->id],
                ['status', '=', 0],
            ])->first();

            $return['cover'] = 0;
            $return['can_claim'] = 1;
            $return['pending'] = false;

            if ($insurance_his) {
                $return['cover'] = 1;
            }
            if ($todayClaimed) {
                $return['can_claim'] = 0;
            }
            if ($pending) {
                $return['pending'] = true;
            }
        } else {
            $return['cover'] = 0;
            $return['can_claim'] = 0;
            $return['pending'] = false;
        }

        return $return;

    }
    public function activePackage()
    {

        $user_package = UserPackage::where([
            ['user_id', '=', $this->id],
            ['status', '=', 1],
        ])->first();
        // $insurance_clamin_his = ClaimInsurance::where('user_id', $user->id)->whereDate('created_at', '!=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->first();
        // 0 = pending , 1 = approved , 2 = reject , 3 = surrender , 10 = can buy new or renew claim insurance / 99 = no package / 100 = claimed

        if (!$user_package) {
            $data['status'] = 99;
            $result = [
                'code' => 0,
                'data' => $data,
                'message' => 'NO_PACKAGE',
            ];
            return $result;
        }
        $todayClaimed = ClaimInsurance::where([
            ['user_id', '=', $this->id],
            ['status', '!=', 2],
        ])->whereDate('created_at', '=', Carbon::today()->toDateString())->first();

        if ($todayClaimed) {
            if ($todayClaimed->status == 0) { //status pending
                $data['data'] = $user_package;
                $data['status'] = 0;
                $data['exp_date'] = $user_package->exp_date;
                $result = [
                    'code' => 0,
                    'data' => $data,
                    'message' => 'Pending',
                ];

            } else if ($todayClaimed->status == 1) { //status approved
                $data['data'] = $user_package;
                $data['status'] = 1;
                $data['exp_date'] = $user_package->exp_date;
                $result = [
                    'code' => 0,
                    'data' => $data,
                    'message' => 'Approved',
                ];

            } else { // today not claim yet
                $data['data'] = $user_package;
                $data['status'] = 10;
                $data['exp_date'] = $user_package->exp_date;
                $result = [
                    'code' => 0,
                    'data' => $data,
                    'message' => '',
                ];
            }
        } else { // first claim
            $data['data'] = $user_package;
            $data['status'] = 10;
            $data['exp_date'] = $user_package->exp_date;
            $result = [
                'code' => 0,
                'data' => $data,
                'message' => '',
            ];
        }
        return $result;
    }
    public function getActiveCoverAttribute()
    {
        $insurance_his = InsuranceHis::where('user_id', $this->id)->orderBy('id', 'desc')->first();

        if ($insurance_his) {
            if ($insurance_his->created_at->isToday()) {
                $result = [
                    'code' => 0,
                    'data' => '',
                    'message' => 'UNDER_COVER',
                ];
            } else {
                $result = [
                    'code' => 1,
                    'data' => '',
                    'message' => 'OUT_OF_COVER',
                ];
            }
            return $result;
        }

    }

    public function pushMobileNotification($title, $message, $type)
    {

        UserNotification::create([
            'user_id' => $this->id,
            'title' => $title,
            'description' => $message,
            'notice_type' => $type,
        ]);
        $this->sendNotificationHuawei($title, $message, $type);
        return $this->sendNotificationFCM($title, $message, $type);

    }

    public function sendNotificationHuawei($title, $message, $type = 123)
    {
        $device_token = UserDeviceToken::where([
            ['user_id', $this->id],
            ['device_type', '=', 'HUAWEI'],
        ])->pluck('device_token')->toArray();
        if ($device_token) {
            $push = new HuaweiPush();

            // // notification message
            $message = [
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "android" => [
                    "data" => "hi there",
                    "notification" => [
                        "title" => $title,
                        "body" => $message,
                        "click_action" => [
                            "type" => 1,
                            "intent" => "#Intent;compo=com.rvr/.Activity;S.W=U;end",
                        ],
                    ],
                ],
                "token" => $device_token,
            ];
            $result = $push->push_send_msg($message);

            return json_encode($result);
        }
    }
    public function sendNotificationFCM($title, $message, $type = 123)
    {

        $notification_id = UserDeviceToken::where([
            ['user_id', $this->id],
            ['device_type', '!=', 'HUAWEI'],
        ])->pluck('device_token')->toArray();
        if ($notification_id) {
            $accesstoken = env('FCM_KEY');

            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = [
                "registration_ids" => $notification_id,
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "data" => [
                    "message" => [
                        "type" => $type,
                    ],
                ],
            ];

            $fields = json_encode($fields);

            $headers = array(
                'Authorization: key=' . $accesstoken,
                'Content-Type: application/json',
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);

            if ($result === false) {
                $result_noti = 0;
            } else {

                $result_noti = 1;
            }
            return $result_noti;
        }
    }
}
