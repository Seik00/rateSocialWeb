<?php

namespace App\Models;

use App\Models\PaymentGatewayOrder;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class WithdrawCash extends Model
{
    protected $table = 'withdraw_cash';

    const PENDING = 0;
    const APPROVE = 1;
    const SUCCESS = 2;
    const REJECTED = 3;

    protected $fillable = [
        'user_id',
        'amount',
        'get_amount',
        'currency',
        'wallet',
        'bank_country',
        'bank_name',
        'bank_user',
        'bank_number',
        'branch',
        'swift_code',
        'withdraw_type',
        'remark',
        'status',
        'txid',
        'fee',
        'payment_gateway_order_id',
    ];
    protected $appends = [
        'user', 'status_remark', 'payment_gateway',
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
    public function getPaymentGatewayAttribute()
    {
        $gateway = PaymentGatewayOrder::where('id', $this->payment_gateway_order_id)->first();
        return $gateway ? $gateway : null;

    }
    public function getStatusRemarkAttribute()
    {
        if ($this->status == 0) {
            return __('site.PENDING');
        } elseif ($this->status == 1) {
            return __('site.APPROVE');
        } elseif ($this->status == 2) {
            return __('site.SUCCESS');
        } elseif ($this->status == 3) {
            return __('site.REJECTED');
        }
    }
}
