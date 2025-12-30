<?php

namespace Admin\App\Models\Epin;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Epin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Admin\App\Display\Epin\DSendEpins;
use Admin\App\Models\Middleware\MMatrixConfiguration;
class MSendEpins
{

   public static function getEpinType(): string
{
    // Direct table names
    $packageTable = 'ihook_package_table';
    $matrixTable  = 'ihook_matrix_table';
    $matrixConfig = 'ihook_matrix_configuration_table';

    // ----- Query 1 -----
    $records = DB::table("$packageTable as a")
        ->leftJoin("$matrixTable as b", 'a.matrix_id', '=', 'b.matrix_id')
        ->where('b.matrix_status', 1)
        ->select('a.package_id', 'a.package_name', 'a.package_price', 'b.*')
        ->get();

    // ----- Query 2 -----
    $recordsmatrix = DB::table("$matrixConfig as a")
        ->leftJoin("$matrixTable as b", 'a.matrix_id', '=', 'b.matrix_id')
        ->where('a.matrix_key', 'registration_fee')
        ->where('b.matrix_status', 1)
        ->select('a.*', 'b.*')
        ->get();

    return DSendEpins::showEpinType($records, $recordsmatrix);
}

public static function updateEpins(Request $request)
{
    $request->validate([
        'user_list' => 'required|array|min:1',
        'user_list.*' => 'required|integer|exists:ihook_members_table,members_id',
        'count' => 'required|integer|min:1',
        'epin_type' => 'required|string',
        'epin_amount_package' => 'nullable|string',
        'epin_amount' => 'nullable|string',
    ]);

    $userList = $request->input('user_list');
    $count = $request->input('count');
    $epinTypeInput = $request->input('epin_type');
    $epinAmountPackage = $request->input('epin_amount_package');
    $epinAmount = $request->input('epin_amount');

    // Split package and matrix once
    $epinSplit = explode(',', $epinTypeInput);
    $epinPackage = $epinSplit[0];
    $epinMatrixId = $epinSplit[1];

    foreach ($userList as $userId) {
        if (!empty($userId)) {
            for ($i = 0; $i < $count; $i++) {

                // Generate a 10-character EPIN code
                $code = substr(str_shuffle('123456789ABCDEFGHIJKLMNPQRSTUVWXYZ'), 0, 10);

                // Determine fee
                $fee = ($epinPackage == '100000000000001' && $epinAmount)
                    ? preg_replace('/[^0-9]+/', '', $epinAmount)
                    : preg_replace('/[^0-9]+/', '', $epinAmountPackage);

                // Insert EPIN
                try {
                    Epin::create([
                        'epin_member_id'     => $userId,
                        'epin_code'          => $code,
                        'epin_amount'        => $fee,
                        'epin_date'          => now(),
                        'epin_package'       => $epinPackage,
                        'epin_matrix_id'     => $epinMatrixId,
                        'epin_status'        => 0,
                        'epin_user_id'       => 0,
                        'epin_used_date'     => null,
                        'payment_history_id' => 0,
                    ]);
                    Session::flash('success_message', 'EPIN created successfully');
                } catch (\Exception $e) {
                    \Log::error('EPIN creation failed: '.$e->getMessage());
                    Session::flash('error_message', 'EPIN could not be created');
                }
            }
        } else {
            Session::flash('error_message', 'No valid user selected');
        }
    }

        return redirect()->route('sendpin')->with('success', 'EPIN(s) created successfully');
}




public static function getPackageAmount($id, $type)
{

    $packageTable = 'ihook_package_table';

    if ($type == 1) {

        // Fetch package amount
        $amount = DB::table($packageTable)
                    ->where('package_id', $id)
                    ->value('package_price');

    } else {

        // Fetch matrix registration fee
        $matrix = MMatrixConfiguration::getMatrixConfigurationDetails($id, 'registration_fee');
        $amount = $matrix[0]['matrix_value'] ?? 0;
    }

    return $amount ?? 0;
}


}
