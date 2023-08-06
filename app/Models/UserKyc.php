<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UserKyc extends Model
{
    protected $table = 'user_kyc';
    protected $fillable = [
        'user_id', 'ic_front', 'ic_back', 'passport',
    ];
  
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = [
        'user','public_path',
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
    public function getPublicPathAttribute()
    {

        return url('storage' . $this->banner);
    }
}
