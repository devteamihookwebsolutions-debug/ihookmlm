<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class  CurrencySetting extends Model
{

   protected $table = 'ihook_currencysettings_table';
       protected $primaryKey = 'currency_id'; // adjust if different
    public $timestamps = false;
}