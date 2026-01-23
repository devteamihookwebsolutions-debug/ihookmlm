<?php
/**
 * This class contains public static functions related to shopify products
 *
 * @package         DShopifyProducts
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Admin\App\Display\Shopify;

class DShopifyProducts
{

    public static function shopifyProducts($records, $shop_url)
    {
        if (count((array)$records) > 0) {
            $currency = $_SESSION['site_settings']['site_currency'];
            for ($i = 0;$i < count((array)$records);$i++) {
                $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "shopify_products WHERE
                product_shopify_id=" . $records[$i]['id'] . "";
                $obj_site = new Bin_Query();
                $obj_site->executeQuery($sql_site);
                $recordsSite = $obj_site->records[0];
                $sno = $i + 1;
                $output .= '<tr>
                        <td><a aria-label="link" href="https://' . $shop_url . '/products/' . $records[$i]['handle'] . '" target="_blank" rel="noopener" ><img alt="image" src="' . $records[$i]['image']['src'] . '" style="width:100px;" /></a></td>
                        <td><a aria-label="link" href="https://' . $shop_url . '/products/' . $records[$i]['handle'] . '" target="_blank" rel="noopener" >' . $records[$i]['title'] . '</a></td>
                        <td>' . $currency . ' ' . $records[$i]['variants'][0]['price'] . '</td>
                        <td>' . $recordsSite['shopify_pv'] . '</td>
                        <td><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' . __('Active') . '</span></td>
                        <td>' . date('Y-m-d h:i:s', strtotime($records[$i]['created_at'])) . '</td>
                        <td>
                          <div class="btn-group">
                            <a aria-label="link" href="' . $_ENV['BCPATH'] . '/shopifyproducts/edit/' . $records[$i]['id'] . '"> <button aria-label="button" type="button"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black dark:text-white">
  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
</svg></button></a>
                         <a aria-label="link" href="javascript:void(0);" class="suspenduser" onclick="deleteproducts(' . $records[$i]['id'] . ');" >
                         <button aria-label="button"  type="button"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2 icon-color dark:text-white">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg></button></a>
                          </div>
                        </td>
                    </tr>';
            }
        }
        return $output;
    }
}
?>
