<?php

/**
 * This class contains public functions related to MatrixConfigurationController
 *
 * @package         MatrixConfigurationController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\MatrixConfig;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Middleware\MMatrixtTypeDetails;
use Admin\App\Models\Middleware\MMatrixConfigurationWholeDetails;
use Admin\App\Models\Middleware\MMatrixTypes;
use Admin\App\Models\MatrixConfig\MDefaultMatrix;
use Admin\App\Models\MatrixConfig\MMatrixPackageDetails;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\Middleware\MWalletType;
use Admin\App\Models\MatrixConfig\MMatrixBinary;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\PackageDetails;
use Admin\App\Models\MatrixConfig\MSetMatrixConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Exception;


class MatrixConfigurationController extends Controller
{

    public function showMatrixConfiguration(Request $request,$matrix_id)
    {
         return $this->setMatrixConfiguration($request, $matrix_id);
    }


    public function setMatrixConfiguration(Request $request,$matrix_id)
    {



            $matrixId = $matrix_id;
            $output['matrix_id'] = $matrixId;


           $matrixDetails = new MMatrixtTypeDetails();
           $output['matrix_details'] = $matrixDetails->getMatrixTypeDetails($matrixId);


            $errval = Session::get('error_messages') ?? MMatrixConfigurationWholeDetails::getMatrixConfigurationWholeDetails($matrixId);

            $output['errval'] = $errval;



            $output['matrix_types'] = MMatrixTypes::getMatrixTypes($output['matrix_details']['matrix_type_id']);
            // $output['onetime_image'] = AmazonCloudFront::getCloudFrontUrl($output['errval']['onetime_image'] ?? '');

            $matrixTypeId = $output['matrix_details']['matrix_type_id'];


            // Load allowmenu file for unilevel
            // if ($matrixTypeId == 3) {
            //     $allowFile = public_path('uploads/allowmenu.txt');
            //     if (File::exists($allowFile) && str_contains(File::get($allowFile), 'dynamiccompression')) {
            //         $output['compressionenabled'] = '1';
            //     }
            // }


            $output['default_sponsor1'] = MDefaultMatrix::getDefaultSponsor($output['errval']['default_sponsor'] ?? '', $matrixId);


            $output['package'] = MMatrixPackageDetails::getMatrixPackageDetails($output['errval']??'', $matrixId);




     $output['default_sponsor1'] = MDefaultMatrix::getDefaultSponsor($output['errval']['default_sponsor'] ?? '', $matrixId) ?: 1;

            $output['package'] = MMatrixPackageDetails::getMatrixPackageDetails($output['errval']??'', $matrixId);

            //wallet type - step -3
            $walletTypeKey = $output['errval']['direct_referrel_commission_wallet_type'] ?? '';

            $output['direct_referrel_commission_wallet_type'] = MWalletType::getWalletType('direct_referrel_commission_wallet_type','',$walletTypeKey);


            // Dashboard type & crypto
            // $dashboardTypeSetting = SiteDetails::getSiteSettingsDetails("WHERE sitesettings_name ='dashboard_type'");
            // $dashboardType = $dashboardTypeSetting[0]['sitesettings_value'] ?? 1;
            // $output['dashboard_type'] = $dashboardType;

            // if ($dashboardType == 2) {
            //     $output['cryptocurrency'] = CryptoCurrency::getCryptoCurrency($output['errval']['cryptocurrency'] ?? '', $output['matrix_details']['matrix_type_id']);
            // }

            // BINARY configurations (type_id = 1)
            if ($matrixTypeId == 1) {
                $binaryKeys = [
                    'instantbinary', 'dailybinary', 'weeklybinary', 'monthlybinary'
                ];
                foreach ($binaryKeys as $key) {
                    $output["{$key}_commission_wallet_type"] = MWalletType::getWalletType("{$key}_commission_wallet_type", "", $errval["{$key}_commission_wallet_type"] ?? '');
                    $output["{$key}_sales_volume"] = MMatrixBinary::getBinaryRatio("{$key}_sales_volume", "", $errval["{$key}_sales_volume"] ?? '');
                    $output["{$key}_carryover"] = MMatrixBinary::getCarryOver("{$key}_carryover", "", $errval["{$key}_carryover"] ?? '');
                }
            }

            // StairStep Config (type_id = 7)
            // if ($matrixTypeId == 7) {
            //     $output['stairstep'] = StairStep::getMatrixStairStepDetails($output['errval']);
            // }

            // Joining Commission
            $output['joining_commission_wallet_type'] = MWalletType::getWalletType("joining_commission_wallet_type", "", $output['errval']['joining_commission_wallet_type'] ?? '');

                        // Chargebee Gateway
            $chargebeeDetails = MPaymentGatewayDetails::getPaymentGatewayDetail(['paymentsettings_default_name' => 'chargebee']);

            $output['chargebee_paymentsettings_status'] = '0'; // default
            $output['chargebeeplanname'] = ''; // ALWAYS SET THIS

            if (
                is_array($chargebeeDetails) &&
                ($chargebeeDetails['paymentsettings_status'] ?? '') === 'Active' &&
                !empty($output['matrix_details']['matrix_name'] ?? '')
            ) {
                $output['chargebee_paymentsettings_status'] = '1';
                $output['chargebeeplanname'] = $output['matrix_details']['matrix_name'] . '_onetimeregister';
            }

            // CryptoCurrency Names for Binary
            // if ($dashboardType == 2) {
            //     $cryptoKeys = ['instantbinary', 'dailybinary', 'weeklybinary', 'monthlybinary'];
            //     foreach ($cryptoKeys as $key) {
            //         $output["{$key}_cryptocurrency"] = CryptoCurrency::getCryptoCurrencyname("{$key}_cryptocurrency", "{$key}_cryptocurrency", $errval["{$key}_cryptocurrency"] ?? '', "", "");
            //     }

            //     $output['join_commission_cryptocurrency'] = CryptoCurrency::getCryptoCurrencyname("join_commission_cryptocurrency", "join_commission_cryptocurrency", $errval['join_commission_cryptocurrency'] ?? '', "", "");

            //     if ($matrixTypeId == 5) { // xupmatrix
            //         $output['passup_commission_cryptocurrency'] = CryptoCurrency::getCryptoCurrencyname("passup_commission_cryptocurrency", "passup_commission_cryptocurrency", $errval['passup_commission_cryptocurrency'] ?? '', "", "");
            //     }
            // }

            $output['randomString'] = Str::random(10);

            // clear session
            Session::forget('success');
            Session::forget('error_message');

            return view('matrixconfig.matrixconfiguration', $output);
    }


     public static function generateAlphaString($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function updateSubscription(Request $request)
    {
        try {
            MAdminActivityLog::getAdminActivity('PLANS - Add Subscription');

            $packageId = $request->query('sub1');
            $output['errval'] = MPackageDetails::getPackageDetails($packageId);

            $packPaymentSer = unserialize($output['errval']['pack_payment']);
            $packPaymentArr = [];
            foreach ($packPaymentSer as $value) {
                $packPaymentArr[$value] = "1";
            }

            $output['pack_payment'] = $packPaymentArr;
            $output['pack_payment_fields'] = unserialize($output['errval']['pack_payment_fields']);

            return view('matrixconfig.subscription', $output);
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect(config('app.ADMINPATH'). '/matrix');
        }
    }

    public function getUserCount()
    {
        try {
            return DefaultMatrix::getUserCount();
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect(config('app.ADMINPATH') . '/matrix');
        }
    }

    public function validateSetMatrixConfig(Request $request,$matrix_id)
    {

        try {

            return MSetMatrixConfiguration::insertMatrixConfiguration($request,$matrix_id);
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.plans');
        }
    }
}
