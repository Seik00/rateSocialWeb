<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class WalletReloadRecord extends Model
{
    protected $table = 'wallet_reload_record';

    protected $fillable = [
        'user_id', 'address', 'amount', 'txid', 'from_address', 'timestamp', 'confirm', 'status',
        'grouping_status',
        'grouping_txid',
        'grouping_amount',
        'grouping_at',
        'remark',
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
    public function getUserAttribute()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }
}
