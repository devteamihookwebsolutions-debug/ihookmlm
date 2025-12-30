<?php

namespace Admin\App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'ihook_state_table';
    protected $primaryKey = 'state_id';
    public $incrementing = true; // Enable auto-increment for state_id
    protected $fillable = ['state_code', 'state_name', 'country_code'];

    public function country()
    {
        return $this->belongsTo(CountryMaster::class, 'country_code', 'country_master_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'state_id');
    }
}