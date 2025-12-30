<?php
/**
 * This class contains public static functions related to user network
 *
 * @package         DInactiveNetwork
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace User\App\Display\Network;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MPackageDetails;
use Query\Bin_Query;
use Model\Middleware\MFormatDate;
use Model\Middleware\MMembersDetails;

class DInactiveNetwork
{
    /**
     * This public static function is used to show in active network details of member
     * @param array  $records
     *
     * @return HTML data
     */
public static function showInactiveNetworkDetails($records)
{
    $output = ''; // Initialize $output

    if (count($records) > 0) {
        foreach ($records as $record) { // Use foreach instead of indexed for loop
            $matrix_id = $record->matrix_id; // Use -> not ['']

            // Get matrix configuration details
            $matrix_config = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_account_type');

            // Check if matrix_config is not empty and has data
            if ($matrix_config && isset($matrix_config[0]['matrix_value'])) {
                $entrycriteria = '';
                $membership_type = '';

                if ($matrix_config[0]['matrix_value'] == '1') {
                    $membership_type = __('Free');
                    $entrycriteria = '0';
                } elseif ($matrix_config[0]['matrix_value'] == '2') {
                    $matrix_config = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_paid_account_type');
                    if ($matrix_config && isset($matrix_config[0]['matrix_value'])) {
                        if ($matrix_config[0]['matrix_value'] == '1') {
                            $membership_type = __('Subscription');
                            $entrycriteria = '2';
                        } else {
                            $membership_type = __('One time registration');
                            $entrycriteria = '1';
                        }
                    }
                } elseif ($matrix_config[0]['matrix_value'] == '3') {
                    $membership_type = __('Free and upgrade');
                    $entrycriteria = '3';
                    $matrix_config = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_paid_account_type');
                    if ($matrix_config && isset($matrix_config[0]['matrix_value'])) {
                        if ($matrix_config[0]['matrix_value'] == '1') {
                            $membership_type = __('Subscription');
                            $entrycriteria = '2';
                        } else {
                            $membership_type = __('One time registration');
                            $entrycriteria = '1';
                        }
                    }
                }

                // Fix undefined variable
                $members_subscription_plan = $record->members_subscription_plan ?? 0;
                if ($members_subscription_plan > 0) {
                    $package = MPackageDetails::getPackageDetails($members_subscription_plan);
                    $members_subscription_plan = $package['package_name'] ?? '-';
                } else {
                    $members_subscription_plan = '-';
                }

                $matrix_description = substr($record->matrix_description ?? '', 0, 100);
                $matrix_name = $record->matrix_name ?? '';

                $output .= '<option value="' . $matrix_id . '_' . $entrycriteria . '">' . $matrix_name . '</option>';
            }
            // Optional: else log error
        }
    }

    return $output;
}
    public static function getMatrixTypeDetais($where)
    {
        $sql = "SELECT * FROM  " . $_ENV['IHOOK_PREFIX'] . "matrix_type_table " . $where . "";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return $records;
    }
}
?>
