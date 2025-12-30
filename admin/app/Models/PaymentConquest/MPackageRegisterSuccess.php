<?php
namespace Admin\App\Models\PaymentConquest;
use Admin\App\Models\Member\PaymentHistory;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\PackageLevelCommission;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\Package;
use Admin\App\Models\PaymentConquest\MSentDirectCommissionSuccess;
use Admin\App\Models\PaymentConquest\MSentPackageLevelCommissionSuccess;
use Admin\App\Models\PaymentConquest\MSentPVSuccess;

use DateTime;

class MPackageRegisterSuccess
{

 public static function packageRegisterSuccess(
        $members_id,
        $direct_id,
        $matrix_id,
        $entry_criteria,
        $payment_amt_exclusive,
        $package_id,
        $memberName,
        $matrix_type_id
    ) {

        MSentDirectCommissionSuccess::sentDirectCommission(
            $members_id,
            $direct_id,
            $matrix_id,
            $entry_criteria,
            $payment_amt_exclusive,
            0,
            $package_id,
            $memberName
        );

       //  Get spillover ID
        $spillover_id = MemberLinks::where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->value('spillover_id');



        if ($spillover_id > 0) {
            //  Get max level from package level commission table
            $maxlevel = PackageLevelCommission::where('matrix_id', $matrix_id)
                ->max('levels');



            //  Get dynamic compression configuration
            $dynamiccompressiondata = MatrixConfiguration::where('matrix_id', $matrix_id)
                ->where('matrix_key', 'pack_dynamic_compression_status')
                ->first();

            $dynamic_compression_status = $dynamiccompressiondata->matrix_value ?? '0';

            //  Determine which field to check for direct/spillover
            $directcheck = ($matrix_type_id == '3' && $dynamic_compression_status != '1')
                ? 'direct_id'
                : 'spillover_id';

            //  Send Package Level Commission
            MSentPackageLevelCommissionSuccess::sentPackageLevelCommission(
                $members_id,
                $matrix_id,
                $spillover_id,
                $memberName,
                $package_id,
                1,
                $maxlevel,
                $dynamic_compression_status,
                $directcheck
            );
        }
        //  dd('after spillover');
        $package = Package::where('package_id', $package_id)
            ->where('matrix_id', $matrix_id)
            ->first(['package_pv']);
        // dd($package);
        if (!empty($package) && $package->package_pv != '0') {
            MSentPVSuccess::sentPV(
                $members_id,
                $package->package_pv,
                $matrix_id,
                $package_id,
                $spillover_id
            );
        }
        // dd(!empty($package) && $package->package_pv != '0');
    }


}
