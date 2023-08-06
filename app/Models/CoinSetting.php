<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class CoinSetting extends Model
{
    protected $table = 'coin_setting';

    const PENDING = 0;
    const APPROVE = 1;
    const REJECTED = 2;

    protected $fillable = [
        'user_id',
        'tx_id',
        'amount',
        'address',
        'deposit_type',
        'status',
    ];
    protected $appends = [
        'user', 'status_remark',
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
    public function getStatusRemarkAttribute()
    {
        if ($this->status == 0) {
            return __('site.PENDING');
        } elseif ($this->status == 1) {
            return __('site.APPROVE');
        } elseif ($this->status == 2) {
            return __('site.REJECTED');
        }
    }

}
