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
