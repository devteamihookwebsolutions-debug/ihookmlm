<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    
       protected $table = 'ihook_feature_table';
       protected $fillable = [
        'feature_name',
        'feature_description',
        'feature_status',
        'created_on'
    ];

        public $timestamps = false;
}

