<?php

namespace App\Models;

use App\Models\GameList;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    protected $table = 'user_game';

    protected $fillable = [
        'user_id',
        'game_id',
        'username',
        'password',
        'player_id',
        'point',
    ];
    protected $appends = [
        'user', 'game',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getUserAttribute()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }
    public function getGameAttribute()
    {
        return GameList::where('id', $this->game_id)->first();
    }
}
