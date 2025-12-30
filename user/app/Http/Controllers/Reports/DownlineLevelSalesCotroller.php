<?php
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MDownlineLevelSales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MMatrixList;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MFormatDate;


use Exception;

class DownlineLevelSalesCotroller  extends Controller
{

public function showDownlineSalesReport(Request $request)
{
    // dd('function reached');
    try {

        // Input values
        $matrix_id = $request->input('matrix_id');

        // Logged-in user ID
        $userId = Auth::user()->members_id;
        // dd($userId);
        // Username
        $membersname = MMemberDetails::getPartMembersDetails(
            'members_username',
            $userId
        );
        // dd($membersname);
        $output['name'] = $membersname['members_username'];
        // dd($output);
        // Matrix list (fix $where according to your logic)
        $where = "";
        $output['matrix'] = MMatrixList::showMatrixList(
        $matrix_id,       // selected value
        'matrix_id',      // name/id
        ''                // onchange script
        );

        // dd($output['matrix']);
        // Default sponsor
        $default_sponsor = MMatrixConfiguration::getMatrixConfigurationDetail(
            $matrix_id,
            'default_sponsor'
        )->first();

        $output['default_sponsor'] = $default_sponsor->matrix_value ?? '';


        // dd($output);
        // Handle Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {

            $output['start_date'] = MFormatDate::formatingDate(
                $request->input('start_date')
            );

            $output['end_date'] = MFormatDate::formatingDate(
                $request->input('end_date')
            );

            $output['members_id'] = $request->input('members_id');

            // downline based on posted list
            $output['userlist'] = MDownlineLevelSales::getdownlinedetailsnew(
                $request->input('user_list')
            );

        } else {

            // default case
            $output['start_date'] = "";
            $output['end_date'] = "";
            $output['members_id'] = 0;

            $output['userlist'] = MDownlineLevelSales::getdownlinedetailsnew(
                $userId
            );
            // dd($output);
        }

        // Site currency (put in config or session once)
        $output['site_currency'] = session('site_settings.site_currency');

        // Return blade view
        return view('user::reports.downlinelevelsalesreportcopy', $output);

    } catch (\Exception $e) {

        return redirect()
            ->route('user.dashboard')
            ->with('error_message', $e->getMessage());
    }
}
}
