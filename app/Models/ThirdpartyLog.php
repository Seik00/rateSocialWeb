<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class ThirdpartyLog extends Model
{
    protected $table = 'thirdparty_log';

    protected $fillable = [
        'user_id',
        'platform',
        'link',
        'send_data',
        'respond_data',
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
