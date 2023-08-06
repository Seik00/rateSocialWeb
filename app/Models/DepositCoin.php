<?php

namespace App\Models;

use App\Models\PaymentGatewayOrder;
use App\Models\User;
use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class DepositCoin extends Model
{
    protected $table = 'deposit_coin';

    const PENDING = 0;
    const APPROVE = 1;
    const REJECTED = 2;

    protected $fillable = [
        'user_id',
        'tx_id',
        'tx_id2',
        'total_amount',
        'amount',
        'amount2',
        'market_price',
        'address',
        'dfi_address',
        'deposit_type',
        'status',
        'payment_gateway_order_id',
        'document',
    ];
    protected $appends = [
        'user', 'status_remark', 'uploaded_file', 'payment_gateway',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function getPaymentGatewayAttribute()
    {
        $gateway = PaymentGatewayOrder::where('id', $this->payment_gateway_order_id)->first();
        return $gateway ? $gateway : null;

    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    public function getUserAttribute()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }
    public function getUploadedFileAttribute()
    {
        $atteched_file = explode(",", $this->document);
        $file = null; // AttachFile::wherein('id', $atteched_file)->get();
        return $file;
    }
    public function getStatusRemarkAttribute()
    {
        if ($this->status == 0) {
            return __('site.PENDING');
        } elseif ($this->status == 1) {
            return __('site.APPROVE');
        } elseif ($this->status == 2) {
            return __('site.REJECTED');
        }
    }

}
