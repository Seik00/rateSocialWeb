<?php

namespace App\Models;

use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'name',
        'name_en',
        'price',
        'status',
        'image',
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

        return url('storage/image' . $this->image);
    }
}
