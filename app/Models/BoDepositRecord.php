<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class BoDepositRecord extends Model
{
    protected $table = 'bo_deposit_record';

    protected $fillable = [
        'user_id',
        'amount',
        'orderid',
        'timestamp',
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
