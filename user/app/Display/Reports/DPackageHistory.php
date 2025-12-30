<?php 
namespace User\App\Display\Reports;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DPackageHistory
{

public static function PackageHistory($records)
{
    // dd($records);
    $output = '';
    $userId = Auth::user()->members_id;

    foreach ($records as $row) {
//  dd($records);
        // Format date
        $date = MFormatDate::formatingDate($row->paymenthistory_date);
        $paymentDate = date('Y-m-d', strtotime($row->paymenthistory_date));

        // Format currency
        $amount = session('site_settings.site_currency') . ' ' .
                  MFormatNumber::formatingNumberCurrency($row->paymenthistory_amount);

        // Check current subscription
        $current = DB::table('ihook_matrix_members_link_table')
            ->where('members_subscription_plan', $row->paymenthistory_plan_id)
            ->where('matrix_id', $row->matrix_id)
            ->where('members_id', $userId)
            ->whereDate('members_subscription_date', $paymentDate)
            ->first();

        if ($current) {
            $currentstatus = '
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Yes
                </span><br>
                <small>Expiry On : '.$current->members_subscription_expirydate.'</small>
            ';
        } else {
            $currentstatus = '
                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    No
                </span>
            ';
        }

        // Status badge
        $paymentStatus = $row->paymenthistory_status == 'paid'
            ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Paid</span>'
            : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pending</span>';

        // Invoice link
        // $view = '<a href="'.route("package.invoice".$row->paymenthistory_id).'">view</a>';
        // $view = '<a href="'.route('user.package.invoice', $row->paymenthistory_id).'">View</a>';
        $view = '<a href="'.route('user.package.invoice', $row->paymenthistory_id).'">view</a>';



        // Build table row
        $output .= "
            <tr>
                <td>$date</td>
                <td>$row->planname</td>
                <td>$row->package_name</td>
                <td>$amount</td>
                <td>$paymentStatus</td>
                <td>$view</td>
                <td>$currentstatus</td>
            </tr>
        ";
    }
    // dd($output);
    return $output;
}


    public static function showPackageList($records, $select, $name)
    {

        // dd($records);
       if ($records->count() > 0) {
        $output = '';

    foreach ($records as $record) {
        if ($select == $record->package_id) {
                $output .= '<option selected value="'. $record->package_id .'">' . $record->package_name . '</option>';
            } else {
                $output .= '<option value="'. $record->package_id .'">' . $record->package_name . '</option>';
            }
        }

        // Debug and return
        // dd($output);
        return $output;
    }

    }

    public static function showMatrixList($records, $select, $name)
    {
        // dd($records);
        if ($records->count() > 0) {
        $output = '';
        foreach ($records as $record) {
            if ($select == $record->matrix_id) {
                $output .= '<option selected value="'. $record->matrix_id .'">' . $record->matrix_name . '</option>';
            } else {
                $output .= '<option value="'. $record->matrix_id .'">' . $record->matrix_name . '</option>';
            }
        }
        // dd($output);
        return $output;
    }

    }
}