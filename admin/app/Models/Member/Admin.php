<?php

/**
 * This class contains public functions related to Admin
 *
 * @package         Admin
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

// namespace App\Models;
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table;
    protected $primaryKey = 'admin_id';
         public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_admin_table';
    }
    public $timestamps = false;

      protected $fillable = [
        'admin_username',
        'admin_password',
        'admin_status',
        'intro_status',
        'admin_email',
        'admin_phone',
        'allaccess_control',
        'admin_login_verified',
        'admin_otp_decrypt',
        'admin_otp',
        'push_token',
        'admin_profile_image',
        'admin_type',
        'created_on'
    ];
}
