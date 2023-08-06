<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $table = 'uploaded_file';

    protected $fillable = [
        'user_id',
        'path',
        'file_name',
    ];

    protected $appends = [
        'public_image_path',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    public function getPublicImagePathAttribute()
    {
        return url($this->path);
    }
}
