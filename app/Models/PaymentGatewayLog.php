<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayLog extends Model
{
    protected $table = 'payment_gateway_log';

    protected $fillable = [

        'platform', 'order_no', 'respond_log',
    ];
}
