<?php
/**
 * This class contains public static functions related to WordPress/WooCommerce integration.
 *
 * @package         MWordPressEshop
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Wordpress;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MWordPressUserInsert
{
    /**
     * Insert new customer into WooCommerce via REST API with full billing/shipping details
     *
     * @param string $members_username
     * @param string $plain_password   // IMPORTANT: PLAIN TEXT password (not hashed!)
     * @param string $members_email
     * @param string $members_doj
     * @param array  $registrationData  // Full data from registration form/session
     * @return int|null                 WooCommerce customer ID or null
     */
    public static function wpRestInsert(
        $members_username,
        $plain_password,
        $members_email,
        $members_doj,
        array $registrationData = []
    ) {
        $prefix = config('services.ihook.prefix', 'ihook');

        $settings = DB::table($prefix . '_sitesettings_table')
            ->whereIn('sitesettings_name', [
                'woocommerce_path',
                'woocommerce_key',
                'woocommerce_secret'
            ])
            ->pluck('sitesettings_value', 'sitesettings_name')
            ->toArray();

        $path               = trim($settings['woocommerce_path'] ?? '');
        $woocommerce_key    = trim($settings['woocommerce_key'] ?? '');
        $woocommerce_secret = trim($settings['woocommerce_secret'] ?? '');

        Log::info('Fetched WooCommerce settings from DB', [
            'path'          => $path,
            'key_prefix'    => substr($woocommerce_key ?? '', 0, 10) . '...',
            'secret_prefix' => substr($woocommerce_secret ?? '', 0, 10) . '...',
        ]);

        if (empty($path) || empty($woocommerce_key) || empty($woocommerce_secret)) {
            Log::error('WooCommerce credentials missing');
            return null;
        }

        // ────────────────────────────────────────────────
        // Extract real values from registration data
        // ────────────────────────────────────────────────
        $first_name = $registrationData['first_name']   ?? $members_username;
        $last_name  = $registrationData['last_name']    ?? $members_username;
        $phone      = $registrationData['phone']        ?? '';
        $address    = $registrationData['address']      ?? '';
        $city       = $registrationData['city']         ?? '';
        $state      = $registrationData['state']        ?? '';     // your state code like "1266"
        $postcode   = $registrationData['zipcode']      ?? '';     // zipcode = postcode in Woo
        $country    = $registrationData['country']      ?? 'IN';   // country code like "DZ"

        // Build billing & shipping objects (WooCommerce format)
        $billing = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'address_1'  => $address,
            'address_2'  => '',                 // add if you have second line
            'city'       => $city,
            'state'      => $state,
            'postcode'   => $postcode,
            'country'    => $country,
            'email'      => $members_email,
            'phone'      => $phone,
        ];

        // Usually shipping = billing unless you have separate fields
        $shipping = $billing;

        $payload = [
            'email'      => $members_email,
            'username'   => $members_username,
            'password'   => $plain_password,   // ← PLAIN TEXT only!
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'billing'    => $billing,
            'shipping'   => $shipping,
        ];

        $json_payload = json_encode($payload);

        // Use /index.php to avoid 307 redirect (nginx/WordPress issue)
        $url = rtrim($path, '/') . '/index.php/wp-json/wc/v3/customers'
             . '?consumer_key=' . urlencode($woocommerce_key)
             . '&consumer_secret=' . urlencode($woocommerce_secret);

        Log::info('Sending to WooCommerce', [
            'url'     => $url,
            'payload' => array_merge($payload, ['password' => '***hidden***']),
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $json_payload,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response   = curl_exec($curl);
        $http_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);

        Log::info('WooCommerce API response', [
            'http_code'    => $http_code,
            'curl_error'   => $curl_error,
            'raw_response' => substr($response ?? '', 0, 4000),
        ]);

        if ($curl_error) {
            Log::error('cURL failed', ['error' => $curl_error]);
            curl_close($curl);
            return null;
        }

        curl_close($curl);

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data['id'])) {
            Log::error('Invalid JSON or no customer ID', [
                'json_error' => json_last_error_msg(),
                'http_code'  => $http_code,
            ]);
            return null;
        }

        if ($http_code >= 200 && $http_code < 300) {
            Log::info('Customer created with full billing/shipping', [
                'customer_id' => $data['id'],
                'billing'     => $data['billing'] ?? 'missing',
                'shipping'    => $data['shipping'] ?? 'missing',
            ]);
            return (int) $data['id'];
        }

        Log::error('WooCommerce returned error', ['response' => $data]);
        return null;
    }
}
