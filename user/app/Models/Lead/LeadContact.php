<?php

/**
 * This class contains public functions related to LeadContact
 *
 * @package         LeadContact
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
namespace User\App\Models\Lead;

use Illuminate\Database\Eloquent\Model;

class LeadContact extends Model
{
    protected $table;
    protected $primaryKey = 'leadcontacts_id';
     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_leadcontacts';
    }

    public $timestamps = false;

    protected $fillable = [
        'leads_member_id',
        'leads_first_name',
        'leads_last_name',
        'leads_phonenumber',
        'leads_address',
        'leads_city',
        'leads_state',
        'leads_country',
        'leads_email',
        'leads_notes',
        'leads_task',
        'leads_birthday',
        'leads_social',
        'leads_tag',
        'leads_status',
        'created_on',
        'modify_on'
    ];

    public static function checkEmail($email)
    {
        return self::where('leads_email', $email)->exists();
    }

    public static function getAllLeads($member_id)
    {
        return self::where('leads_member_id', $member_id)->get();
    }
}
