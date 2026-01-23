<?php

/**
 * This class contains public functions related to Member
 *
 * @package         Member
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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use User\App\Models\MemberArea\MemberAreaSocialMedia;
use User\App\Models\MemberArea\MemberAreaWebsite;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table;
         public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_members_table';
    }
    public $timestamps = false;
    protected $primaryKey = 'members_id';

    protected $fillable = [
        'members_email',
        'members_password',
        'members_firstname',
        'members_lastname',
        'members_phone',
        'members_company_name',
        'members_address',
        'members_address2',
        'members_city',
        'members_state',
        'members_zip',
        'members_country',
        'members_image',
        'members_thumb_image',
        'members_subdomain',
        'members_two_fact',
        'members_transaction_password',
        'members_ssn_number',
        'members_ein_number',
        'members_alternate_email',
        // add more as needed
    ];

    protected $hidden = [
        'members_password',
        'members_transaction_password',
        'remember_token',
    ];

    protected $casts = [
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

    public function card(): HasOne
    {
        return $this->hasOne(Member::class, 'members_id', 'members_id');
    }

    public function social(): HasOne
    {
        return $this->hasOne(MemberAreaSocialMedia::class, 'members_id', 'members_id');
    }

    public function site(): HasOne
    {
        return $this->hasOne(MemberAreaWebsite::class, 'members_id', 'members_id');
    }

    public function notification(): HasOne
    {
        return $this->hasOne(Member::class, 'members_id', 'members_id');
    }
}
