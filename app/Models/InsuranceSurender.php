<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserPackage;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class InsuranceSurender extends Model
{
    protected $table = 'insurance_surender';

    protected $fillable = [
        'user_id',
        'user_package_id',
        'get_amount',
        'status',
        'remark',
    ];
    protected $appends = [
        'user', 'user_package',
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
    public function getUserPackageAttribute()
    {
        $user = UserPackage::where('id', $this->user_package_id)->first();
        return $user ? $user : null;

    }
}
