<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class TradeAsset extends Model
{
    protected $table = 'trade_asset';

    protected $fillable = [

        'user_id', 'coin_name', 'asset_active', 'asset_frozen',

    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }

    public function create_asset($user_id, $act, $amount, $coin, $coin_log)
    {
        $asset = TradeAsset::firstOrCreate(['user_id' => $user_id,
            'coin_name' => $coin]);

        if ($act == '+') {

        }
    }
}
