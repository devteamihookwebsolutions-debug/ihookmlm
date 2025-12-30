<?php


namespace Admin\App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
     protected $table = 'ihook_country_master_table';
      protected $primaryKey = 'id';
    public $timestamps = false; // if your table does not have created_at/updated_at
    protected $fillable = ['country_master_name', 'sortname'];
}
