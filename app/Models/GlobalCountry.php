<?php

namespace App\Models;

use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class GlobalCountry extends Model
{
    protected $table = 'global_country';

    protected $fillable = ['sort', 'status', 'buy', 'sell'];
    protected $appends = [
        'phone_code', 'activate', 'flag',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function getPhoneCodeAttribute()
    {
        return str_replace('+', '', $this->country_code);
    }

    public function getActivateAttribute()
    {
        if ($this->status == 0) {
            return 'Disabled';
        } else {
            return 'Enabled';
        }

    }
    public function getFlagAttribute()
    {

        return url('/images/flag/' . $this->name_en) . '.png';
    }
}
