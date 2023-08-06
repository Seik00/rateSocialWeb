<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class TradeOrder extends Model
{
    protected $table = 'trade_order';

    const pending = 0;
    const partly_match = 1;
    const fully_match = 2;
    const cancel = 3;

    protected $fillable = [

        'trade_market_id',
        'user_id',
        'market_name',
        'order_type',
        'order_no',
        'order_amount',
        'order_fee',
        'order_price',
        'order_deal_stock',
        'order_deal_money',
        'order_left',
        'match_status',

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
