<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';

    protected $fillable = [
        'user_id', 'title', 'body', 'add_time', 'rebody', 'ruid', 'lan', 're_time', 'type', 'user_read', 'admin_read',
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
