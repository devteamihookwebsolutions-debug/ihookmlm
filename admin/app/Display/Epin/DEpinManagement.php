<?php
namespace Admin\App\Display\Epin;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MFormatDate;
use Illuminate\Support\Facades\DB;
class DEpinManagement
{
public static function showEpinManagement($records, $iTotal)
{
    if (count($records) == 0) {
        return response()->json([
            'records' => [],
            'total_records' => 0
        ]);
    }

    // ---- Get Site Currency ----
$site_currency = DB::table('ihook_sitesettings_table')
                    ->where('sitesettings_name', 'site_currency')
                    ->value('sitesettings_value');

$site_currency = !empty($site_currency) ? $site_currency : '$';


    $mem_data = [];

    foreach ($records as $rec) {

        // ---- Status Badge ----
        $status = ($rec->epin_status == '0')
            ? '<span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded-sm dark:bg-pink-900 dark:text-pink-300">Unused</span>'
            : '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Used</span>';

        // ---- Package Name ----
        if ($rec->epin_package == '0') {

            $matrixname = DB::table('ihook_matrix_table')
                            ->where('matrix_id', $rec->epin_matrix_id)
                            ->value('matrix_name');

            $package_name = $matrixname . ' Registration';

        } elseif ($rec->epin_package == '100000000000001') {

            $package_name = 'Ewallet';

        } else {
            $package_name = DB::table('ihook_package_table')
                                ->where('package_id', $rec->epin_package)
                                ->value('package_name');
        }

        // ---- Used Date ----
        if ($rec->epin_used_date == '0000-00-00 00:00:00') {
            $used_date = '-';
        } else {
            $used_date = MFormatDate::formatingDate($rec->epin_used_date);
        }

        // ---- Used By (Member Username) ----
        if (empty($rec->epin_user_id)) {
            $used_by_link = '-';
        } else {

            $username = DB::table('ihook_members_table')
                        ->where('members_id', $rec->epin_user_id)
                        ->value('members_username');

            $used_by_link = '<a href="' . env('BCPATH') . '/memberarea/show/' . $rec->epin_user_id . '">' 
                            . ucfirst($username) . 
                            '</a>';
        }

        // ---- EPIN Owner ----
        if ($rec->epin_member_id == '0') {

            $owner_name = 'Admin';

        } else {
            $owner_name = DB::table('ihook_members_table')
                            ->where('members_id', $rec->epin_member_id)
                            ->value('members_username');
        }

        // ---- Member Link ----
        $owner_link = '<a href="' . env('BCPATH') . '/memberarea/show/' . $rec->epin_member_id . '">' 
                      . $owner_name . 
                      '</a>';

        // ---- Build Row ----
        $mem_data[] = [
            'membername'    => $owner_link,
            'epin_code'     => $rec->epin_code,
            'epin_amount'   => $site_currency . $rec->epin_amount,
            'package_name'  => $package_name,
            'formatdate'    => MFormatDate::formatingDate($rec->epin_date),
            'status'        => $status,
            'useddate'      => $used_date,
            'epin_user_id'  => $used_by_link
        ];
    }

    // dd($mem_data);
    return response()->json([
        'records' => $mem_data,
        'total_records' => $iTotal
    ]);
}

}