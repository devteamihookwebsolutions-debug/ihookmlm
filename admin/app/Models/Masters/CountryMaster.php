<?php

namespace Admin\App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryMaster extends Model {
    use HasFactory;

    protected $table = 'ihook_country_master_table';
    protected $primaryKey = 'country_master_id';
    public $incrementing = true;
    // Enable auto-increment for country_master_id
    protected $fillable = [ 'sortname', 'country_master_name' ];


    public function cities() {
        return $this->hasMany( City::class, 'country_id', 'country_master_id' );
    }
}