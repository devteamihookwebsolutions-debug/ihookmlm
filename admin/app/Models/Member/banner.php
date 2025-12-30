<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
     protected $table = 'ihook_banners_table';
        public $timestamps = false; 
       protected $fillable = [
        'banner_title',
        'banner_image',
        'banner_status',
        'banner_type',   // <-- ADD THIS LINE
    ];
}
