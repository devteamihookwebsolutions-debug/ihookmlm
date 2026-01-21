<?php

/**
 * This class contains public functions related to MatrixMemberLinks
 *
 * @package         MatrixMemberLinks
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

// namespace App\Models\Admin;
// namespace Admin\Models\Member;
// namespace Admin\App\Models\MemberLinks;
namespace Admin\App\Models\Member;


use Illuminate\Database\Eloquent\Model;

class MatrixMemberLinks extends Model
{
       protected $table;

       protected $primaryKey = 'id';
            public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_matrix_members_link_table';
    }
       public $timestamps = false;


}
