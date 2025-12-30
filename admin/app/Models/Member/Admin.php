<?php

// namespace App\Models;
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'ihook_admin_table';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'admin_email',
        'admin_password',
    ];
}
