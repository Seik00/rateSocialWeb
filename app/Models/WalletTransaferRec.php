<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class WalletTransaferRec extends Model
{
    protected $table = 'wallet_transfer_rec';

    protected $fillable = [
        'user_id', 'to_id', 'founds', 'add_time', 'wallet', 'ago', 'current', 'balance', 'dis',
    ];
    protected $appends = [
        'user', 'to_user',
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
    public function getToUserAttribute()
    {
        $user = User::where('id', $this->to_id)->first();
        return $user ? $user : null;
    }
}
