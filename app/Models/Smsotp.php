<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smsotp extends Model
{
    protected $table = 'sms_otp';

    protected $fillable = ['contact', 'otp', 'status']; //only the field names inside the array can be mass-assign

    // otp_type 1 = sms , 2 = email

    public $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generate_string($input, $strength = 8)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}
