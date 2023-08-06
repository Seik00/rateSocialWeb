<?php

namespace App\Models;

use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class BoostOrder extends Model
{
    protected $table = 'boost_order';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_no',
        'cost',
        'bonus',
        'round',
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
