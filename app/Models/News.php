<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'description',
        'news_type',
        'language',
        'banner',
        'is_display',
        'is_pop',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    protected $appends = [
        'public_path',
    ];

    public function getPublicPathAttribute()
    {

        return url('storage' . $this->banner);
    }
}
