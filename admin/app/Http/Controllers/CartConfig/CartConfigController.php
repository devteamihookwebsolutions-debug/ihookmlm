<?php

/**
 * This class contains public functions related to CartConfigController
 *
 * @package         CartConfigController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\CartConfig;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\CartConfig\MCartConfig;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Middleware\MSiteDetails;
use Exception;
use Illuminate\Http\Request;
    class CartConfigController extends Controller
    {
        public static function showCartConfig()
        {
            $output['cartconfigs'] = MCartConfig::getCartDetails();

           return view('cartconfig/cartconfig', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
            unset($_SESSION['cartconfig']);
            unset($_SESSION['cart_id']);

        }
        /**
         * This public static function is used  to validateCartConfig  page
         */
        public static function validateCartConfig(Request $request)
        {
            try {

             //Admin Activity Log
          MAdminActivityLog::getAdminActivity('CARTCONFIG - Add');
            //Admin Activity Log
            MCartConfig::validateCartConfig($request);
            }catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location:".$_ENV['BCPATH']."/cartconfig");
                exit();
            }
        }
        /**
         * This public static function is used  to completeCart  page
         */
      public function completeCart(Request $request)
    {
        // dd('test');
        $response = MCartConfig::completeCart($request);

        if (session()->has('cart_id')) {
            session()->forget('cart_id');
        }
        if (session()->has('cartconfig')) {
            session()->forget('cartconfig');
        }

        return $response;
    }


       // In controller
        public function testWooConnection(Request $request)
        {
            $validated = $request->validate([
                'woocommerce_path'   => 'required|url',
                'woocommerce_key'    => 'required|string',
                'woocommerce_secret' => 'required|string',
            ]);

            try {
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL            => rtrim($validated['woocommerce_path'], '/') . '/wp-json/wc/v3/products',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST  => 'GET',
                    CURLOPT_HTTPHEADER     => [
                        'Authorization: Basic ' . base64_encode($validated['woocommerce_key'] . ':' . $validated['woocommerce_secret']),
                    ],
                    CURLOPT_TIMEOUT        => 15,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);

                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error    = curl_error($ch);
                curl_close($ch);

                if ($error) {
                    return response()->json(['error' => $error], 500);
                }

                if ($httpCode === 200) {
                    return response()->json(['status' => 'success']);
                }

                $decoded = json_decode($result, true);
                $message = $decoded['message'] ?? 'HTTP ' . $httpCode;

                return response()->json(['error' => $message], $httpCode >= 400 ? $httpCode : 400);

            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        /**
         * This public static function is used  to test shopify connection
         */

        public static function testSyConnection(Request $request)
        {
            try {
                $store_url = trim($request->input('shop_name'));
                $api_key   = trim($request->input('api_key'));

                $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
                $access_token = $sitesettings[0]['sitesettings_value'] ?? '';

                if (!$store_url || !$api_key || !$access_token) {
                    return response('Missing Shopify credentials', 400);
                }

                $url = "https://{$api_key}:{$access_token}@{$store_url}.myshopify.com/admin/products.json";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                $result = curl_exec($ch);
                curl_close($ch);

                $records = json_decode($result, true);
                $error_message = $records['errors'] ?? '';

                return $error_message === ''
                    ? response('Shopify Connection SuccessFully!!!', 200)
                    : response($error_message, 400);
            } catch (Exception $e) {
                return response($e->getMessage(), 500);
            }
        }

    }
    ?>
