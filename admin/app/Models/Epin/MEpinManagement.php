<?php

/**
 * This class contains public functions related to MEpinManagement
 *
 * @package         MEpinManagement
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

namespace Admin\App\Models\Epin;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Epin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Admin\App\Display\Epin\DEpinManagement;
use Admin\App\Models\Middleware\MMatrixConfiguration;
class MEpinManagement
{

public static function showEpinManagement()
{
    $request = request(); // get current request
    $columns = [
        'epin_id', 'epin_member_id', 'epin_code', 'epin_amount',
        'epin_date', 'epin_status', 'epin_package', 'epin_user_id',
        'epin_used_date', 'epin_matrix_id'
    ];

    $limit = 10;
    $page = $request->query('page', 1);
    $offset = ($page - 1) * $limit;

    $records = Epin::select($columns)->offset($offset)->limit($limit)->get();
    $iTotal = Epin::count();
//  dd($records);
    return DEpinManagement::showEpinManagement($records, $iTotal);
}
     }
