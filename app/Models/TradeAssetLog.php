<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class TradeAssetLog extends Model
{
    protected $table = 'trade_asset_log';

    protected $fillable = [

        'user_id', 'trade_asset_id', 'from_asset', 'act', 'amount', 'log_type', 'to_asset',

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
