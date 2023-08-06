<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class InsuranceBetHistory extends Model
{
    protected $table = 'insurance_bet_record';

    protected $fillable = [
        'username',
        'amount',
        'opened_rate', 'closed_rate',
        'pl', 'opened_date',
        'closed_date', 'trade_type', 'asset',
    ];
    protected $appends = [
        'user',
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
}
