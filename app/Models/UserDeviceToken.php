<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UserDeviceToken extends Model
{
    protected $table = 'user_device_tokens';

    protected $fillable = [
        'user_id',
        'device_id',
        'device_token',
        'device_type',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
}
