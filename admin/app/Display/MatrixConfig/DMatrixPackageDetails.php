<?php


namespace Admin\App\Display\MatrixConfig;
use Illuminate\Http\Request;

class DMatrixPackageDetails
{
    /**
     * This function is used for package list
     * @param array $recordSet
     * @param array $records1
     * @param array $Err
     * @return HTML data
     */
    public static function showMatrixPackageDetails($records, $Err)
    {


        $output = '';

      if ($records->isNotEmpty()) {
    foreach ($records as $i => $record) {
        $no = $i + 1;

                  $checked = array_key_exists($record->package_name, $Err ?? []) ? 'checked=checked' : '';

                 if ($record->package_paymentmethod == "0") {
            $package_paymentmethod = "Manual Package";
            $package_duration = $record->package_duration . " Days";
        } elseif ($record->package_paymentmethod == "1") {
            $package_paymentmethod = "Auto Subscription";

            $pack_payment_fields = @unserialize($record->pack_payment_fields);

            if (is_array($pack_payment_fields)) {
                if (($pack_payment_fields['interval_selector'] ?? '') === "custom") {
                    $package_duration = "Every {$pack_payment_fields['interval_custom_count']} {$pack_payment_fields['interval_custom_selector']}";
                } else {
                    $package_duration = "Every {$pack_payment_fields['interval_selector']}";
                }
            } else {
                $package_duration = ""; // fallback
            }
        } elseif ($record->package_paymentmethod == "2") {
            $package_paymentmethod = "Manual Package and Auto Subscription";

            $pack_payment_fields = @unserialize($record->pack_payment_fields);
            $interval = is_array($pack_payment_fields) && isset($pack_payment_fields['interval_selector'])
                ? $pack_payment_fields['interval_selector']
                : '';

            $package_duration = "{$record->package_duration} Days & Every {$interval}";
        } else {
            $package_paymentmethod = "Unknown";
            $package_duration = "";
        }


                $output .= '
                    <tr>
                        <td>' . htmlspecialchars($record->package_name) . '</td>
                        <td>' . $package_paymentmethod . '</td>
                        <td>' . htmlspecialchars($record->package_price) . '</td>
                        <td>' . $package_duration . '</td>
                        <td>' . htmlspecialchars($record->package_direct_commission) . '</td>
                        <td>' . htmlspecialchars($record->package_direct_commission_method) . '</td>
                        <td>' . htmlspecialchars($record->package_pv) . '</td>
                        <td class="flex gap-2">';

                $output .= '<a aria-label="link" href="javascript:void(0);" onclick="showEditPackage(' . $record->package_id . ');"  >
                    <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                    </svg>
                </a>';

                $output .= '<a aria-label="link" href="javascript:void(0);" onclick="deletePackage(' . $record->package_id . ');"  title="' . __('Delete') . '">
                    <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                </a>';

                $output .= '<a aria-label="link" data-toggle="modal" data-target="#package_commission_status" onclick="setPackageLevelCommission(' . $record->package_id . ')"  title="' . __('Set level commision') . '">
                    <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M17.44 3a1 1 0 0 1 .707.293l2.56 2.56a1 1 0 0 1 0 1.414L18.194 9.78 14.22 5.806l2.513-2.513A1 1 0 0 1 17.44 3Zm-4.634 4.22-9.513 9.513a1 1 0 0 0 0 1.414l2.56 2.56a1 1 0 0 0 1.414 0l9.513-9.513-3.974-3.974ZM6 6a1 1 0 0 1 1 1v1h1a1 1 0 0 1 0 2H7v1a1 1 0 1 1-2 0v-1H4a1 1 0 0 1 0-2h1V7a1 1 0 0 1 1-1Zm9 9a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1v-1a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                        <path d="M19 13h-2v2h2v-2ZM13 3h-2v2h2V3Zm-2 2H9v2h2V5ZM9 3H7v2h2V3Zm12 8h-2v2h2v-2Zm0 4h-2v2h2v-2Z"/>
                    </svg>
                </a>';

                if ($record->package_paymentmethod != 0) {
                    $output .= '<a aria-label="link" href="javascript:void(0);" onclick="updateSubscription(' . $record->package_id . ');"  title="' . __('Auto subscription') . '">
                        <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
                        </svg>
                    </a>';
                }

                $output .= '</td></tr>';
            }
        }
 

    return $output;

    }
}