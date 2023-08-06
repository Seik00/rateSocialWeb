<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserPackage;
use App\Models\InsuranceHis;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class ClaimInsurance extends Model
{
    protected $table = 'claim_insurance';

    protected $fillable = [
        'user_id',
        'user_package_id',
        'claim_amount',
        'revert_amount',
        'doc1',
        'doc2',
        'doc3',
        'status',
        'remark',
    ];
    protected $appends = [
        'user', 'user_package','check_create_date','public_path',
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
    public function getCheckCreateDateAttribute()
    {
        $check = InsuranceHis::where('user_id', $this->user_id)->where('user_package_id', $this->user_package_id)->whereDate('created_at', $this->created_at)->first();
        return $check ? $check : null;

    }
    public function getPublicPathAttribute()
    {

        return url('storage' . $this->banner);
    }
}
