<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class TradeMatchDetail extends Model
{
    protected $table = 'trade_match_detail';

    protected $fillable = [

        'buy_order_no', 'sell_order_no', 'price', 'amount', 'fee',

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
