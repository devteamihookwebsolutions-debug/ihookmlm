<?php

/**
 * This class contains public functions related to SmtpSetting
 *
 * @package         SmtpSetting
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

namespace Admin\App\Models\Member;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
  protected $table;
    public $timestamps = false;
    protected $primaryKey = 'smtp_id';
     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_smtp_settings_table';
    }

    protected $fillable = [
        'smtp_hname', 'smtp_port', 'smtp_user', 'smtp_pass',
        'sender_email', 'sender_name', 'smtp_perfer',
        'activated_mail_send_status', 'mailjet_public_key',
        'mailjet_private_key', 'sendgrid_api_key'
    ];
    public function getSmtpPassAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }
}
