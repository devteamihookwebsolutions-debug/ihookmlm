<?php

/**
 * This class contains public functions related to MEmailTemplate
 *
 * @package         MEmailTemplate
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

namespace Admin\App\Models\Mail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class MEmailTemplate extends Model
{

    // protected $table = 'ihook_mailtemplates_table';

    protected $table;

    public static function getAllTemplates($prefix = null)
    {
        // $table = $prefix ? $prefix . 'ihook_mailtemplates_table' : 'mailtemplates_table';
        $prefix = config('services.ihook.prefix');

        $table = $prefix . '_mailtemplates_table';


        return DB::table($table)
            ->select('mail_id', 'mail_name', 'mail_default_name')
            ->where('mail_name', '!=', '')
            ->groupBy('mail_default_name', 'mail_id', 'mail_name')
            ->orderBy('mail_id', 'ASC')
            ->get();
    }

    public static function getTemplateByDefaultName($defaultName)
    {
        $prefix = config('services.ihook.prefix');

        $table = $prefix . '_mailtemplates_table';

        return DB::table($table)
            ->where('mail_default_name', $defaultName)
            ->where('mail_status', 1)
            ->first();
    }


     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_mailtemplates_table';
    }
}
