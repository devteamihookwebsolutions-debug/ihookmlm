<?php
/**
 * This class contains public static functions related to insert  customer
 *
 * @package         MInsertCustomerDetails
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
?><?php
namespace Admin\App\Models\CustomerManager;
use Admin\App\Models\Middleware\MSendMail;
use Admin\App\Models\ShopAncillary\MShopUserInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
class MInsertCustomerDetails{


public static function insertCustomerDetails(
    $members_username,
    $members_password,
    $members_email,
    $members_ip_address,
    $members_firstname,
    $members_lastname,
    $members_state,
    $members_city,
    $members_address,
    $members_address2,
    $members_address3,
    $members_phone,
    $members_zip,
    $members_country,
    $members_alternate_email,
    $members_password_open,
    $sponsor,
    $shipname,
    $shipaddress,
    $shipaddress2,
    $shipaddress3,
    $shipcountry,
    $shipstate,
    $shipcity,
    $shipzipcode,
    $shipphone
)
{

    $prefix      = config('services.ihook.prefix');
    $storeprefix = config('services.ihook.store_prefix');

    if (empty($members_username) || empty($members_email)) {
        return false;
    }

    $customers_shop_id = MShopUserInsert::insertShopUsers(
        $members_username,
        $members_password_open,
        $members_email,
        now(),
        $members_firstname,
        $members_lastname,
        $members_phone,
        $members_address,
        $members_city,
        $members_zip
    );

    $customers_lang = session('sitelang_id', 1);
    $site_url = 'Customers dont have Unique URL';

    $insertData = [
        'customers_username'        => $members_username,
        'customers_password'        => $members_password,
        'customers_firstname'       => $members_firstname,
        'customers_lastname'        => $members_lastname,
        'customers_dob'             => null,
        'customers_email'           => $members_email,
        'customers_alternate_email' => $members_alternate_email,
        'customers_phone'           => $members_phone,
        'customers_doj'             => Carbon::now(),
        'customers_ip_address'      => Request::ip(),
        'customers_address'         => $members_address,
        'customers_address2'        => $members_address2,
        'customers_address3'        => $members_address3,
        'customers_city'            => $members_city,
        'customers_state'           => $members_state,
        'customers_zip'             => $members_zip,
        'customers_country'         => $members_country,
        'customers_image'           => 'uploads/customers/avatar.png',
        'customers_thumb_image'     => 'uploads/customers/thumb/avatar.png',
        'created_on'                => Carbon::now(),
        'customers_lang'            => $customers_lang,
        'customers_shop_id'         => $customers_shop_id,
        'customers_sponsor_id'      => $sponsor,
        'customers_status'          => 1,
        'customers_shopify_id'      => $customers_shop_id,

        // Shipping
        'shipping_name'             => $shipname,
        'shipping_address'          => $shipaddress,
        'shipping_address2'         => $shipaddress2,
        'shipping_address3'         => $shipaddress3,
        'shipping_country'          => $shipcountry,
        'shipping_state'            => $shipstate,
        'shipping_city'             => $shipcity,
        'shipping_zipcode'          => $shipzipcode,
        'shipping_phone'            => $shipphone,
    ];

    $customers_id = DB::table($prefix . '_customers')->insertGetId($insertData);

    $mail_lang = session('sitelang_id', 1);

    $template = DB::table($prefix . '_mailtemplates_table')
        ->where('mail_default_name', 'registration_mail')
        ->where('mail_status', 1)
        ->where('mail_lang', $mail_lang)
        ->first();

    if (!$template) {
        $template = DB::table($prefix . '_mailtemplates_table')
            ->where('mail_default_name', 'registration_mail')
            ->where('mail_status', 1)
            ->where('mail_lang', 1)
            ->first();
    }

    if ($template) {
        $message = str_replace(
            ['[name]', '[username]', '[pass]', '[url]'],
            [$members_username, $members_email, $members_password_open, $site_url],
            $template->mail_content
        );

       MSendMail::send(
            $template,
            $members_email,
            $message,
            null,
            $members_username
       );

    }

    return $customers_id;
}

}
