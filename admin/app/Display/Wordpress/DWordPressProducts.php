<?php
/**
 * This class contains public static functions related to woocommerce products
 *
 * @package         DWordPressProducts
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php

namespace Admin\App\Display\Wordpress;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Support\Facades\DB;

class DWordPressProducts
{

    public static function showWordPressProducts($records)
    {
        $storePrefix = config('services.ihook.store_prefix');
        $output = '';

        if (!empty($records)) {
            foreach ($records as $record) {
                // Use object syntax → $record->product_id instead of $record['product_id']
                $id = $record->product_id;

                // Fetch product image (guid from attachment where post_parent = product ID)
                $imgRecord = DB::table($storePrefix . '_posts')
                    ->where('post_type', 'attachment')
                    ->where('post_parent', $id)
                    ->value('guid'); // returns single string or null

                // Fetch stock info (_stock and _stock_status)
                $stockRecords = DB::table($storePrefix . '_postmeta')
                    ->whereIn('meta_key', ['_stock', '_stock_status'])
                    ->where('post_id', $id)
                    ->pluck('meta_value')
                    ->toArray();

                $productStock = $stockRecords[0] ?? null;          // _stock quantity
                $productStockStatus = $stockRecords[1] ?? 'instock'; // fallback to instock

                $productImage = !empty($imgRecord)
                    ? $imgRecord
                    : $_ENV['UI_ASSET_URL'] . "/assets/img/empty_product.png";

                $output .= '<div class="bg-white p-6 rounded-lg dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 group relative">
                    <div class="relative overflow-hidden text-center cursor-default p-5 rounded-lg">
                        <img class="w-full h-80 object-contain rounded-t-lg p-10" alt="image" src="' . $productImage . '">
                        <div class="absolute inset-0 flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button onclick="showEproductDetails(' . $id . ')" class="block p-2 bg-neutral-500 text-white rounded-full hover:bg-neutral-600" type="button">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg>
                            </button>
                            <a href="' . $_ENV['BCPATH'] . '/wordpressproducts/edit/' . $id . '" class="p-2 bg-neutral-500 text-white rounded-full hover:bg-neutral-600">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
                                </svg>
                            </a>
                            <button type="button" onclick="deleteeproducts(' . $id . ')" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block p-2 bg-red-500 text-white rounded-full hover:bg-red-600">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <h5 class="text-lg font-medium text-black dark:text-white">' . htmlspecialchars($record->product_name) . '</h5>
                        <div class="flex justify-between mt-2">
                            <span class="text-sm text-blue-600 font-bold">' . ($_SESSION['site_settings']['site_currency'] ?? '$') . ' ' . MFormatNumber::formatingNumberCurrency($record->regular_price) . '</span>
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-lg text-xs">' . ucfirst($productStockStatus ?? 'instock') . '</span>
                        </div>
                    </div>
                </div>';
            }
        }
        return $output;
    }

    public static function allWordPressProducts($records)
    {
        if (count((array)$records) > 0) {
            for ($i = 0;$i < count((array)$records);$i++) {
                // $id = $records[$i]->id;
                $id = $records[$i]['product_id'];

                $image_Sql = "SELECT guid FROM " . $_ENV['STORE_PREFIX'] . "posts WHERE post_type='attachment' AND post_parent=" .$id;
                $query = new Bin_Query();
                $query->executeQuery($image_Sql);
                $img_records = $query->records[0]['guid'];


                //for stack details
                $stack_Sql = "SELECT * FROM `" . $_ENV['STORE_PREFIX'] . "postmeta` WHERE `meta_key` IN( '_stock','_stock_status') AND post_id=".$id;
                $stack = new Bin_Query();
                $stack->executeQuery($stack_Sql);
                $stack_records = $stack->records;
                $productstack = $stack_records[0]['meta_value'];
                $productstock_status = $stack_records[1]['meta_value'];

                $productimage = !empty($img_records) ? $img_records : $_ENV['UI_ASSET_URL']. "/assets/img/empty_product.png";
                // if ($records[$i]->images[0]->src != '') {
                //     $productimage = $records[$i]->images[0]->src;
                // } else {
                //     $productimage = $_ENV['UI_ASSET_URL']."/assets/img/empty_product.png";
                // }
                $output .= '<div
              class="bg-white border p-6 border-neutral-300 rounded-lg dark:bg-neutral-900 dark:border-neutral-700 group relative">
              <div class="relative overflow-hidden text-center cursor-default p-5 rounded-lg">
                <!-- Product Image -->
                <img class="w-full h-80 object-contain rounded-t-lg p-10" alt="image"
                  src="' . $productimage . '">

                <!-- Action Icons -->
                <div
                  class="absolute inset-0 flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                  <!-- Show Product Details Button -->
                  <button onclick="showEproductDetails(' . $id . ')"
                    class="block p-2 bg-neutral-500 text-white rounded-full hover:bg-neutral-600" type="button">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                      fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-width="2"
                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z">
                      </path>
                      <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                    </svg>
                  </button>



                  <!-- Edit Product Link -->
                  <a href="' . $_ENV['BCPATH'] . '/wordpressproducts/edit/' . $id . '"
                    class="p-2 bg-neutral-500 text-white rounded-full hover:bg-neutral-600">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                      fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28">
                      </path>
                    </svg>
                  </a>

                  <!-- Delete Confirmation Button -->
                  <button type="button" onclick="deleteeproducts(' . $id . ')" data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                    class="block p-2 bg-red-500 text-white rounded-full hover:bg-red-600">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                      fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z">
                      </path>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Product Info -->
              <div class="p-4 text-center">
                <h5 class="text-lg font-medium text-black dark:text-white">' .  $records[$i]['product_name'] . '</h5>
                <div class="flex justify-between mt-2">
                  <span class="text-sm text-blue-600 font-bold">'. $_SESSION['site_settings']['site_currency'] .' '. MFormatNumber::formatingNumberCurrency($records[$i]['regular_price']) . '</span>
                  <span class="px-2 py-1 bg-green-100 text-green-600 rounded-lg text-xs">' .ucfirst($records[$i]['productstock_status']). '</span>
                </div>
              </div>
            </div>';
            }
        }
        return $output;
    }

public static function showProductDetails($product)  // better name than $records
{
    $output = '';

    // ── Default image ───────────────────────────────
    $defaultImage = $_ENV['UI_ASSET_URL'] . "/assets/img/empty_product.png";

    // ── Get product image safely ─────────────────────
    $image = $defaultImage;

    if (!empty($product->images) && is_array($product->images)) {
        $firstImage = $product->images[0] ?? null;

        if ($firstImage && !empty($firstImage->src)) {
            $image = $firstImage->src;
        }
    }

    // You can also do shorter version (personal favorite):
    // $image = $product->images[0]->src ?? $defaultImage;

    // ── Build HTML ───────────────────────────────────
    $output .= '
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div class="flex justify-center items-center bg-gray-50 rounded-lg p-4">
                <img
                    src="' . htmlspecialchars($image) . '"
                    alt="' . htmlspecialchars($product->name ?? 'Product') . '"
                    class="rounded-lg shadow-lg w-full max-w-sm object-contain"
                    onerror="this.src=\'' . htmlspecialchars($defaultImage) . '\'"
                >
            </div>

            <div class="flex flex-col justify-start">
                <div class="text-start">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">
                        ' . htmlspecialchars($product->name ?? 'No name') . '
                    </h3>

                    <p class="text-xl md:text-2xl font-bold text-blue-600">
                        ' . ($product->get_price() ?? '<span class="text-gray-500">Price not available</span>') . '
                    </p>
                </div>

                <div class="mt-6 md:mt-10 text-start">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                        Description
                    </h4>
                    <div class="text-gray-700 dark:text-gray-300 prose max-w-none">
                        ' . ($product->description ?? '<p class="text-gray-500">No description available</p>') . '
                    </div>
                </div>
            </div>
        </div>';

    return $output;
}
}

