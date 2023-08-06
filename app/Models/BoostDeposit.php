<?php

namespace App\Models;

use App\Models\SystemBank;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class BoostDeposit extends Model
{
    protected $table = 'boost_deposit';

    protected $fillable = [
        'user_id',
        'deposit_type',
        'bank_id',
        'address',
        'amount',
        'pay_amount',
        'status',
    ];
    protected $appends = [
        'bank_info',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    public function getBankInfoAttribute()
    {
        $bank = SystemBank::where('id', $this->bank_id)->first();
        return $bank ? $bank : null;

    }
}
