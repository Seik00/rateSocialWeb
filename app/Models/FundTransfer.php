<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class FundTransfer extends Model
{
    protected $table = 'fund_transfer';

    protected $fillable = [
        'user_id', 'found', 'found_type', 'in_type', 'out_type', 'action', 'previous', 'current',
        'detail', 'detailen', 'detailvn', 'remark',
    ];
    protected $appends = [
        'user',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    /* public function getCreatedAtAttribute($value)
    {
    return $value->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }*/
    public function getUserAttribute()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }
}
