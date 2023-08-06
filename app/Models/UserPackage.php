<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserGroup;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    protected $table = 'user_package';
    protected $fillable = [
        'user_id', 'user_group_id', 'price', 'bv', 'pay', 'pay_type', 'status','exp_date'
    ];
    protected $appends = [
        'user', 'package',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    public function getUserAttribute()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }
    public function getPackageAttribute()
    {
        return UserGroup::where('id', $this->user_group_id)->first();
    }
}
