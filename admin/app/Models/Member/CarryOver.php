<?php
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class CarryOver extends Model
{
    protected $table = 'ihook_carryover';
    public $timestamps = false;
      protected $primaryKey = 'carryover_id';
 
}