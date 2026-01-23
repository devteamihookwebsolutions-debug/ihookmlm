<?php

/**
 * This class contains public functions related to MCartConfig
 *
 * @package         MCartConfig
 * @category        Model
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

namespace Admin\App\Models\CartConfig;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use Illuminate\Support\Facades\DB;

class MCartConfig
{
    public static function validateCartConfig(Request $request)
    {
        if (!Session::has('cart_id')) {
            Session::put('cart_id', $request->input('cart_id'));
        }

        $allowedKeys = [
            'cart_id', 'hostname', 'woousername', 'woopassword', 'woodbname', 'wooprefix',
            'woocommerce_path', 'woocommerce_secret', 'woocommerce_key', 'product_check',
            'orders_check', 'autoship_check', 'discount_check', 'pv_check', 'product_level_check',
            'shop_name', 'api_key', 'api_secret_key', 'cshostname', 'csusername', 'cspassword',
            'csdbname', 'csprefix', 'cscart_path', 'cscart_api', 'cscart_mail'
        ];

        $cartConfig = [];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $allowedKeys, true)) {
                $cartConfig[$key] = $value;
            }
        }

        Session::put('cartconfig', $cartConfig);

        return $request->input('cart_id');
    }

    public static function completeCart(Request $request)
    {
        // dd($request->all());
            $prefix = config('services.ihook.prefix', 'ihook');
            $formData = $request->all();

            // Delete previous cart setup
            $updateFields = [
                'hostname', 'woousername', 'woopassword', 'woodbname', 'wooprefix',
                'woocommerce_path', 'woocommerce_secret', 'woocommerce_key', 'product_check',
                'orders_check', 'autoship_check', 'discount_check', 'pv_check', 'product_level_check',
                'shop_name', 'api_key', 'api_secret_key', 'cshostname', 'csusername', 'cspassword',
                'csdbname', 'csprefix', 'cscart_path', 'cscart_api', 'cscart_mail'
            ];

            foreach ($updateFields as $field) {
                DB::table($prefix.'_sitesettings_table')
                    ->where('sitesettings_name', trim($field))
                    ->delete();
            }

            DB::table($prefix.'_sitesettings_table')
                ->whereIn('sitesettings_description', ['wordpressconnection', 'shopifyconnection', 'cscartconnection'])
                ->delete();

            // Insert/update cart_id
            $cartId = trim($formData['cart_id']);
            $cartRow = DB::table($prefix.'_sitesettings_table')->where('sitesettings_name', 'cart_id')->first();

            if ($cartRow) {
                DB::table($prefix.'_sitesettings_table')
                    ->where('sitesettings_name', 'cart_id')
                    ->update(['sitesettings_value' => $cartId, 'last_updated' => now()]);
            } else {
                DB::table($prefix.'_sitesettings_table')->insert([
                    'sitesettings_value' => $cartId,
                    'sitesettings_name' => 'cart_id',
                    'sitesettings_description' => 'wordpressconnection',
                    'last_updated' => now(),
                ]);
            }

            // Process cart-specific settings
            if ($cartId === "1") {
                // WordPress cart
                $restrictedKeys = [
                    'cshostname', 'csusername', 'cspassword', 'csdbname', 'csprefix',
                    'cscart_path','cscart_api','cscart_mail','cart_product_level_check',
                    'cart_discount_check','cart_autoship_check','cart_orders_check','cart_product_check',
                    'shopify_product_level_check','shopify_discount_check','shopify_autoship_check','shopify_orders_check','shopify_product_check'
                ];

                $stripPrefixKeys = [
                    'wordpress_product_level_check','wordpress_discount_check',
                    'wordpress_autoship_check','wordpress_orders_check','wordpress_product_check'
                ];

                foreach ($formData as $key => $value) {
                    if ($key !== 'cart_id' && !in_array($key, $restrictedKeys, true)) {
                        $adjustedKey = in_array($key, $stripPrefixKeys, true) ? str_replace('wordpress_', '', $key) : $key;

                        DB::table($prefix.'_sitesettings_table')
                            ->updateOrInsert(
                                [
                                    'sitesettings_description' => 'wordpressconnection',
                                    'sitesettings_name' => trim($adjustedKey)
                                ],
                                [
                                    'sitesettings_value' => $value,
                                    'last_updated' => now()
                                ]
                            );
                    }
                }

            } elseif ($cartId === "3") {
                // CS-Cart
                $restrictedKeys = [
                    'woousername','woopassword','woodbname','wooprefix','woocommerce_path',
                    'woocommerce_secret','woocommerce_key','shopify_product_level_check','shopify_discount_check',
                    'shopify_autoship_check','shopify_orders_check','shopify_product_check','wordpress_product_level_check',
                    'wordpress_discount_check','wordpress_autoship_check','wordpress_orders_check','wordpress_product_check'
                ];

                $stripPrefixKeys = [
                    'cart_product_level_check','cart_discount_check','cart_autoship_check','cart_orders_check','cart_product_check'
                ];

                foreach ($formData as $key => $value) {
                    if ($key !== 'cart_id' && !in_array($key, $restrictedKeys, true)) {
                        $adjustedKey = in_array($key, $stripPrefixKeys, true) ? str_replace('cart_', '', $key) : $key;

                        DB::table($prefix.'_sitesettings_table')
                            ->updateOrInsert(
                                [
                                    'sitesettings_description' => 'cscartconnection',
                                    'sitesettings_name' => trim($adjustedKey)
                                ],
                                [
                                    'sitesettings_value' => $value,
                                    'last_updated' => now()
                                ]
                            );
                    }
                }

            } else {
                // Shopify
                $restrictedKeys = ['installation'];
                $stripPrefixKeys = [
                    'shopify_product_level_check','shopify_discount_check','shopify_autoship_check','shopify_orders_check','shopify_product_check'
                ];

                foreach ($formData as $key => $value) {
                    if ($key !== 'cart_id' && !in_array($key, $restrictedKeys, true)) {
                        $adjustedKey = in_array($key, $stripPrefixKeys, true) ? str_replace('shopify_', '', $key) : $key;

                        DB::table($prefix.'_sitesettings_table')
                            ->updateOrInsert(
                                [
                                    'sitesettings_description' => 'shopifyconnection',
                                    'sitesettings_name' => trim($adjustedKey)
                                ],
                                [
                                    'sitesettings_value' => $value,
                                    'last_updated' => now()
                                ]
                            );
                    }
                }
            }

            // Delete old user menus
            $usermenusdel = ['eproducts', 'cscart_products'];
            foreach ($usermenusdel as $menu) {
                DB::table($prefix.'_user_menus')
                    ->where('default_menu_name', trim($menu))
                    ->delete();
            }


            // Delete old user menus
            $usermenusToDelete = ['eproducts', 'cscart_products'];

            DB::table($prefix . '_user_menus')
                ->whereIn('default_menu_name', $usermenusToDelete)
                ->delete();

            // Insert new menu depending on cart type
            $createdOn = now(); // Current timestamp

            if ($cartId === "1") {
                DB::table($prefix . '_user_menus')->insert([
                    'menu_id' => 11,
                    'menu_name' => 'E-Products',
                    'default_menu_name' => 'eproducts',
                    'parent_menu_id' => 5,
                    'menu_order' => 11,
                    'menus_status' => 1,
                    'menu_content' => '',
                    'created_on' => $createdOn,
                    'created_by' => 0,
                    'updated_on' => $createdOn,
                    'updated_by' => 0,
                ]);
            } elseif ($cartId === "3") {
                DB::table($prefix . '_user_menus')->insert([
                    'menu_id' => 78,
                    'menu_name' => 'Cscart Products',
                    'default_menu_name' => 'cscart_products',
                    'parent_menu_id' => 0,
                    'menu_order' => 26,
                    'menus_status' => 1,
                    'menu_content' => '',
                    'created_on' => $createdOn,
                    'created_by' => 0,
                    'updated_on' => $createdOn,
                    'updated_by' => 0,
                ]);
            }

            // Set success message in session
            Session::flash('success_message', __('Cart configured successfully'));

            return response()->json([
                'status' => 'success',
                'message' => __('Cart configured successfully'),
            ]);
    }

    public static function getCartDetails()
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        // Fetch cart_id from sitesettings_table
        $cartSetting = DB::table($prefix.'_sitesettings_table')
            ->where('sitesettings_name', 'cart_id')
            ->first();

        $cart_id = $cartSetting?->sitesettings_value ?? 0;

        // Determine which cart connection to use
        $whereCondition = [];
        if ($cart_id == 1) {
            $whereCondition = 'wordpressconnection';
        } elseif ($cart_id == 2) {
            $whereCondition = 'shopifyconnection';
        } elseif ($cart_id == 3) {
            $whereCondition = 'cscartconnection';
        }

        // Build the query
        $query = DB::table($prefix.'_sitesettings_table');

        if ($whereCondition) {
            $query->where(function ($q) use ($whereCondition) {
                $q->where('sitesettings_description', $whereCondition)
                ->orWhere('sitesettings_description', '');
            });
        }

        // Fetch records using cursor() to save memory
        $fields = [];
        foreach ($query->cursor() as $record) {
            $key = strtolower(str_replace(' ', '_', $record->sitesettings_name));
            $fields[$key] = $record->sitesettings_value;
        }

        return $fields;
    }

}
