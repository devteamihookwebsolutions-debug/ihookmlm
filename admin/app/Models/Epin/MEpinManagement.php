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
