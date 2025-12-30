<?php

namespace  Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Exception;

// // Add your models here using appropriate namespaces
// use App\Models\Grants\Previllage;
use Admin\App\Models\Middleware\MatrixTypeDetails;
use App\Models\Middleware\MatrixConfigurationWholeDetails;
// use App\Models\Middleware\MatrixTypes;
// use App\Models\Middleware\AmazonCloudFront;
use App\Models\MatrixConfig\DefaultMatrix;
use App\Models\MatrixConfig\MatrixPackageDetails;
// use App\Models\Middleware\WalletType;
// use App\Models\Middleware\SiteDetails;
// use App\Models\Middleware\CryptoCurrency;
use App\Models\MatrixConfig\MatrixBinary;
use App\Models\MatrixConfig\StairStep;
use App\Models\Middleware\PaymentGatewayDetails;
// use App\Models\Middleware\AdminActivityLog;
use App\Models\Middleware\PackageDetails;
use App\Models\MatrixConfig\SetMatrixConfiguration;

class MatrixConfigController extends Controller
{
    public function __construct()
    {
        // Apply middleware for admin auth
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect(env('BCPATH') . '/adminlogin');
            }

            Previllage::getPrevillage(); // You might replace this with Laravel's Gate or Policy
            return $next($request);
        });
    }

    public function setMatrixConfiguration(Request $request)
    {
        try {
            $matrixId = $request->query('sub1');
            $output['matrix_id'] = $matrixId;

            $output['matrix_details'] = MatrixTypeDetails::getMatrixTypeDetails();

            $errval = Session::get('error_messages') ?? MatrixConfigurationWholeDetails::getMatrixConfigurationWholeDetails();
            $output['errval'] = $errval;

            $output['matrix_types'] = MatrixTypes::getMatrixTypes($output['matrix_details']['matrix_type_id']);
            $output['onetime_image'] = AmazonCloudFront::getCloudFrontUrl($output['errval']['onetime_image'] ?? '');

            $matrixTypeId = $output['matrix_details']['matrix_type_id'];

            // Load allowmenu file for unilevel
            if ($matrixTypeId == 3) {
                $allowFile = public_path('uploads/allowmenu.txt');
                if (File::exists($allowFile) && str_contains(File::get($allowFile), 'dynamiccompression')) {
                    $output['compressionenabled'] = '1';
                }
            }

            $output['default_sponsor1'] = DefaultMatrix::getDefaultSponsor($output['errval']['default_sponsor'] ?? '', $matrixId);
            $output['package'] = MatrixPackageDetails::getMatrixPackageDetails($output['errval']);

            $output['direct_referrel_commission_wallet_type'] = WalletType::getWalletType("direct_referrel_commission_wallet_type", "", $output['errval']['direct_referrel_commission_wallet_type'] ?? '');

            // Dashboard type & crypto
            $dashboardTypeSetting = SiteDetails::getSiteSettingsDetails("WHERE sitesettings_name ='dashboard_type'");
            $dashboardType = $dashboardTypeSetting[0]['sitesettings_value'] ?? 1;
            $output['dashboard_type'] = $dashboardType;

            if ($dashboardType == 2) {
                $output['cryptocurrency'] = CryptoCurrency::getCryptoCurrency($output['errval']['cryptocurrency'] ?? '', $output['matrix_details']['matrix_type_id']);
            }

            // BINARY configurations (type_id = 1)
            if ($matrixTypeId == 1) {
                $binaryKeys = [
                    'instantbinary', 'dailybinary', 'weeklybinary', 'monthlybinary'
                ];
                foreach ($binaryKeys as $key) {
                    $output["{$key}_commission_wallet_type"] = WalletType::getWalletType("{$key}_commission_wallet_type", "", $errval["{$key}_commission_wallet_type"] ?? '');
                    $output["{$key}_sales_volume"] = MatrixBinary::getBinaryRatio("{$key}_sales_volume", "", $errval["{$key}_sales_volume"] ?? '');
                    $output["{$key}_carryover"] = MatrixBinary::getCarryOver("{$key}_carryover", "", $errval["{$key}_carryover"] ?? '');
                }
            }

            // StairStep Config (type_id = 7)
            if ($matrixTypeId == 7) {
                $output['stairstep'] = StairStep::getMatrixStairStepDetails($output['errval']);
            }

            // Joining Commission
            $output['joining_commission_wallet_type'] = WalletType::getWalletType("joining_commission_wallet_type", "", $output['errval']['joining_commission_wallet_type'] ?? '');

            // Chargebee Gateway
            $chargebeeDetails = PaymentGatewayDetails::getPaymentGatewayDetails('WHERE paymentsettings_default_name="chargebee"');
            if ($chargebeeDetails['paymentsettings_status'] === 'Active') {
                $output['chargebee_paymentsettings_status'] = '1';
                $output['chargebeeplanname'] = $output['matrix_details']['matrix_name'] . '_onetimeregister';
            } else {
                $output['chargebee_paymentsettings_status'] = '0';
            }

            // CryptoCurrency Names for Binary
            if ($dashboardType == 2) {
                $cryptoKeys = ['instantbinary', 'dailybinary', 'weeklybinary', 'monthlybinary'];
                foreach ($cryptoKeys as $key) {
                    $output["{$key}_cryptocurrency"] = CryptoCurrency::getCryptoCurrencyname("{$key}_cryptocurrency", "{$key}_cryptocurrency", $errval["{$key}_cryptocurrency"] ?? '', "", "");
                }

                $output['join_commission_cryptocurrency'] = CryptoCurrency::getCryptoCurrencyname("join_commission_cryptocurrency", "join_commission_cryptocurrency", $errval['join_commission_cryptocurrency'] ?? '', "", "");

                if ($matrixTypeId == 5) { // xupmatrix
                    $output['passup_commission_cryptocurrency'] = CryptoCurrency::getCryptoCurrencyname("passup_commission_cryptocurrency", "passup_commission_cryptocurrency", $errval['passup_commission_cryptocurrency'] ?? '', "", "");
                }
            }

            $output['randomString'] = Str::random(10);

            // clear session
            Session::forget('success');
            Session::forget('error_message');

            return view('matrixconfig.matrixconfiguration', $output);
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect(env('BCPATH') . '/plan');
        }
    }

    public function updateSubscription(Request $request)
    {
        try {
            AdminActivityLog::getAdminActivity('PLANS - Add Subscription');

            $packageId = $request->query('sub1');
            $output['errval'] = PackageDetails::showPackage($packageId);

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
            return redirect(env('BCPATH') . '/matrix');
        }
    }

    public function getUserCount()
    {
        try {
            return DefaultMatrix::getUserCount();
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect(env('BCPATH') . '/matrix');
        }
    }

    public function validateSetMatrixConfig()
    {
        try {
            return SetMatrixConfiguration::insertMatrixConfiguration();
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect(env('BCPATH') . '/matrix');
        }
    }
}
