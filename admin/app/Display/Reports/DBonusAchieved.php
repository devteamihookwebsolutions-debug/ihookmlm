<?php
namespace Admin\App\Display\Reports;

use Admin\App\Models\Middleware\MFormatDate;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
class DBonusAchieved
{





public static function bonusAchieved($records, $totalPages, $totalRecords)
{
    $site_currency = Session::get('site_settings.site_currency', '$');
    $mem_data = [];

    if (!empty($records)) {
        foreach ($records as $index => $record) {
            // Status badge
            $status = $record->bonus_status == 0
                ? '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">' . __('Pending') . '</span>'
                : '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">' . __('Active') . '</span>';

            // Bonus result (amount or gift)
            $bonusresult = $record->bonusresult == 0
                ? $record->bonusamt
                : $record->bonusgift;

            //Date format
            $formatdate = MFormatDate::formatingDate($record->achieveddate ?? '');

            $bonusachieved_id = $record->bonusachieved_id ?? null;
            $sno = $index + 1;

            //Actions (Send + Delete)
            $actions = '
                <a href="' . env('BCPATH') . '/sendbonusachieved/send/' . $bonusachieved_id . '" aria-label="Send Bonus" title="Send Bonus">
                    <button type="button" class="text-white brand-color hover:bg-neutral-800 font-medium rounded-full text-sm p-1 me-3 inline-flex items-center">
                        <svg class="w-8 h-8 text-neutral-100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.93935 12.6464L7.69211 11.8973C5.3389 11.1129 4.16229 10.7207 4.16229 9.99997C4.16229 9.27921 5.3389 8.88701 7.69212 8.10261L16.2053 5.26488C17.8611 4.71295 18.689 4.43699 19.126 4.87401C19.563 5.31102 19.287 6.13892 18.7351 7.79471L15.8974 16.3079C15.113 18.6611 14.7208 19.8377 14 19.8377C13.2793 19.8377 12.8871 18.6611 12.1026 16.3079L11.3536 14.0606L15.7071 9.70708C16.0976 9.31656 16.0976 8.68339 15.7071 8.29287C15.3166 7.90234 14.6834 7.90234 14.2929 8.29287L9.93935 12.6464Z" fill="currentcolor"></path>
                        </svg>
                    </button>
                </a>
                <a href="javascript:void(0);" onclick="delconfirm(' . $bonusachieved_id . ');" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </a>
            ';

            // Push record
            $mem_data[] = [
                'No' => $sno,
                'name' => $record->members_username ?? '',
                'bonusname' => $record->bonus_name ?? '',
                'bonustype' => $record->bonustype ?? '',
                'amount' => $site_currency . ' ' . $bonusresult,
                'status' => $status,
                'formatdate' => $formatdate,
                'action' => $actions,
            ];
        }
    }

    //Final response
    // $res_array = [
    //     'total_pages' => $totalPages,
    //     'records' => $mem_data,
    //     'total_records' => $totalRecords,
    // ];
    // // dd($res_array);
    // return response()->json($res_array);

    return[
        'total_pages' => $totalPages,
        'records' => $mem_data,
        'total_records' => $totalRecords,
    ];
}
}
