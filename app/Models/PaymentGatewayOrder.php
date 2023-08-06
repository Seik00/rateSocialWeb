<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayOrder extends Model
{
    protected $table = 'payment_gateway_order';

    protected $fillable = [
        'user_id',
        'platform',
        'order_no',
        'merchant_code',
        'from_bank',
        'to_bank',
        'bank_account_number',
        'amount',
        'trans_id',
        'payment_status',
        'payment_type',
        'payment_done',
        'error_message',
    ];
}
