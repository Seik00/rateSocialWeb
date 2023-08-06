<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameList extends Model
{
    protected $table = 'game_list';

    protected $fillable = [
        'game_name',
        'status',
        'download_link',
        'game_link',
        'agent_point',
        'game_logo',
        'banner',
    ];

    /*public function getBannerAttribute($value)
{
$banner = explode(",", $value);
$file = Banner::wherein('id', $banner)->get();
return $file;

}*/

}
