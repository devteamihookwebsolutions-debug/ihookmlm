<?php

namespace User\App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'ihook_city_table';
    protected $primaryKey = 'city_id';
    public $incrementing = true;
    protected $fillable = ['city_name', 'country_id', 'state_id'];

    public function country()
    {
        return $this->belongsTo(CountryMaster::class, 'country_id', 'country_master_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }
}