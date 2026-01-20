<?php

/**
 * This class contains public functions related to Admin
 *
 * @package         Admin
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
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
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'ihook_admin_table';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'admin_username',
        'admin_password',
        'admin_email',
        'admin_phone',
        'admin_profile_image',
        'admin_status',
        'admin_type',
        'admin_otp',               // make sure it's fillable
        'admin_otp_expires_at',
    ];

    protected $hidden = [
        'admin_password',
        'remember_token',
        // We do NOT hide admin_otp because we need to read it plainly
    ];

    // ────────────────────────────────────────────────
    // Force plain storage & reading for OTP fields
    // (prevents any accidental encryption from traits or global casts)
    // ────────────────────────────────────────────────

    public function setAdminOtpAttribute($value)
    {
        $this->attributes['admin_otp'] = $value; // plain value - no encrypt()
    }

    public function getAdminOtpAttribute($value)
    {
        return $value; // plain value - no decrypt()
    }

    public function setAdminOtpExpiresAtAttribute($value)
    {
        $this->attributes['admin_otp_expires_at'] = $value;
    }

    public function getAdminOtpExpiresAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Laravel auth expects 'password' field name
    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    // Optional: if login uses email
    public function getAuthIdentifierName()
    {
        return 'admin_email';
    }
}
