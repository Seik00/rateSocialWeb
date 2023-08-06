<?php

namespace App\Models;

use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class BoostOrderMultiple extends Model
{
    protected $table = 'boost_order_multiple';

    protected $fillable = [
        'user_id',
        'total_order',
        'complete_order',
        'link_order',
        'status',
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
