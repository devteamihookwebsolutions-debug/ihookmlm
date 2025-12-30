<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
     protected $table = 'ihook_package_table';
     public $timestamps = false;
     protected $primaryKey = 'package_id';
}
