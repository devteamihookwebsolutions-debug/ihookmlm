<?php

/**
 * This class contains public functions related to Member
 *
 * @package         Member
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Member extends Authenticatable
{
  use  Notifiable;

    protected $table = 'ihook_members_table';
       protected $primaryKey = 'members_id';
     public $timestamps = false;

    protected $fillable = [
        'members_email',
        'members_password',
    ];

    protected $hidden = [
        'members_password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'members_password' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->members_password;
    }


     public function getAuthIdentifierName()
    {
        return 'members_email';
    }

}
