<?php

namespace User\App\Http\Controllers\Package;

use Illuminate\Support\Facades\DB;
use User\App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function packageDetails()
    {
        $paidType = DB::table('ihook_matrix_configuration_table')
            ->where('matrix_key', 'members_paid_account_type')
            ->value('matrix_value');

        if ($paidType == '0') {
            // ONE TIME MODE
            $config = DB::table('ihook_matrix_configuration_table')
                ->whereIn('matrix_key', [
                    'onetime_image',
                    'registration_fee',
                    'registration_pv',
                    'matrix_description',
                    'direct_referrel_commission',
                    'direct_referrel_commission_type'
                ])
                ->pluck('matrix_value', 'matrix_key');

            $oneTimePackage = [
                'package_id'                   => 0,
                'package_name'                 => 'One Time Registration Fee',
                'package_price'                => $config['registration_fee'] ?? '0',
                'package_pv'                   => $config['registration_pv'] ?? '0',
                'package_direct_commission'    => $config['direct_referrel_commission'] ?? '0',
                'package_direct_commission_method' => $config['direct_referrel_commission_type'] ?? '0', // 0 or 1
                'package_image'                => $config['onetime_image']
                    ? asset($config['onetime_image'])
                    : asset('assets/img/register-package/free-registration.png'),
                'package_description'          => $config['matrix_description'] ?? 'One Time Registration Fee',
                'is_free_registration'         => true
            ];

            return response()->json([$oneTimePackage]);
        }

        // PAID PACKAGES MODE
        $packages = DB::table('ihook_package_table')
            ->where('package_status', 1)
            ->select(
                'package_id',
                'package_name',
                'package_price',
                'package_pv',
                'package_direct_commission',
                DB::raw("CASE
                    WHEN package_direct_commission_method = 'flat' THEN '0'
                    WHEN package_direct_commission_method = '%' THEN '1'
                    ELSE '0'
                END as package_direct_commission_method"),
                'package_icon as package_image',
                'package_description'
            )
            ->orderBy('package_price', 'asc')
            ->get();

        $packages->transform(function ($pkg) {
            $pkg->package_image = $pkg->package_image
                ? asset($pkg->package_image)
                : asset('assets/img/register-package/r2.png');
            $pkg->is_free_registration = false;
            return $pkg;
        });

        return response()->json($packages);
    }
}
