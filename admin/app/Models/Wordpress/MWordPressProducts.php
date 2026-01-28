<?php
/**
 * This class contains public static functions related to woocommerce products
 *
 * @package         Model_ME_Products
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
use Admin\App\Display\Wordpress\DWordPressProducts;
use Admin\App\Models\Middleware\MSiteDetails;
use CURLFile;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Str;


class MWordPressProducts{

    public static function showWordPressProducts()
    {
        $storePrefix = config('services.ihook.store_prefix');
        $storePrefix = rtrim($storePrefix, '_') . '_'; // ensure trailing _

        $postsTable    = $storePrefix . 'posts';
        $postmetaTable = $storePrefix . 'postmeta';
        $termRelTable  = $storePrefix . 'term_relationships';
        $termTaxTable  = $storePrefix . 'term_taxonomy';
        $termsTable    = $storePrefix . 'terms';

        $records = DB::table($postsTable . ' as p')
            ->leftJoin($postmetaTable . ' as pm_price', function ($join) {
                $join->on('p.ID', '=', 'pm_price.post_id')
                    ->where('pm_price.meta_key', '=', '_regular_price');
            })
            ->leftJoin($postmetaTable . ' as pm_stock', function ($join) {
                $join->on('p.ID', '=', 'pm_stock.post_id')
                    ->where('pm_stock.meta_key', '=', '_stock_status');
            })
            ->leftJoin($termRelTable . ' as tr', 'p.ID', '=', 'tr.object_id')
            ->leftJoin($termTaxTable . ' as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
            ->leftJoin($termsTable . ' as t', 'tt.term_id', '=', 't.term_id')
            ->select(
                'p.ID as product_id',
                'p.post_title as product_name',
                DB::raw('COALESCE(MAX(pm_price.meta_value), "0") as regular_price'),
                DB::raw('MAX(pm_stock.meta_value) as productstock_status'),
                DB::raw('GROUP_CONCAT(t.name SEPARATOR ", ") as category_name')
            )
            ->where('p.post_type', '=', 'product')
            ->where('p.post_status', '=', 'publish')
            ->where('p.post_parent', '=', 0)
            ->groupBy('p.ID', 'p.post_title', 'p.post_date') // include all non-aggregated columns
            ->orderBy('p.post_date', 'desc')
            ->limit(50)
            ->get()
            ->toArray();

        // Debug – uncomment to check results
        // dd($records);

        return DWordPressProducts::showWordPressProducts($records);
    }
     /**
     * This public static function is used to get the update woocommerce products.
     * @return void $records
    */
    public static function updateProducts(Request $request)
    {
        Log::info('updateProducts() - Product update process started', [
            'start_time'   => now()->toDateTimeString(),
            'request_keys' => array_keys($request->all()),
            'has_image'    => $request->hasFile('product_image')
        ]);

        $transactionStarted = false;

        try {
            $id            = (int) $request->input('id');
            $title         = trim($request->input('title'));
            $post_content  = $request->input('post_content');
            $post_name     = $request->input('post_name');
            $post_regprice = trim($request->input('post_regprice'));

            if ($id < 1 || empty($title) || empty($post_regprice)) {
                throw new \Exception('Invalid product ID, title or regular price.');
            }

            Log::debug('Form data validated OK', [
                'id'    => $id,
                'title' => $title,
                'price' => $post_regprice,
            ]);

            // 2. WooCommerce credentials
            $wcKey    = MSiteDetails::getSiteSettingValue('woocommerce_key') ?? null;
            $wcSecret = MSiteDetails::getSiteSettingValue('woocommerce_secret') ?? null;
            $apiBase  = rtrim(MSiteDetails::getSiteSettingValue('woocommerce_path') ?? '', '/');

            if (!$apiBase || !$wcKey || !$wcSecret) {
                throw new \Exception('WooCommerce API credentials missing or incomplete.');
            }

            Log::debug('WooCommerce credentials loaded', ['api_base' => $apiBase]);

            // 3. Image handling – Upload new image only if changed
            $attachmentId = null;
            $newImageUploaded = false;

            if ($request->hasFile('product_image') && $request->file('product_image')->isValid()) {
                $file         = $request->file('product_image');
                $originalName = $file->getClientOriginalName();
                $ext          = strtolower($file->getClientOriginalExtension());
                $safeName     = hash('sha256', $originalName . time() . microtime(true)) . '.' . $ext;

                $uploadDir = rtrim($_ENV['CURRENT_UPATH'] ?? 'user', '/') . '/shift/';
                $fullPath  = base_path('../' . $uploadDir . $safeName);

                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                $moved = $file->move(dirname($fullPath), $safeName);
                if (!$moved) {
                    throw new \Exception('Failed to save uploaded image locally.');
                }

                $mimeType = mime_content_type($fullPath) ?: 'image/png';

                $wpUsername    = env('WP_APP_USERNAME', '');
                $wpAppPassword = env('WP_APP_PASSWORD', '');

                if (empty($wpUsername) || empty($wpAppPassword)) {
                    Log::warning('WP Application Password missing – image upload skipped.');
                } else {
                    $authString = base64_encode($wpUsername . ':' . $wpAppPassword);

                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL            => "$apiBase/wp-json/wp/v2/media",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST           => true,
                        CURLOPT_POSTFIELDS     => [
                            'file' => new CURLFile($fullPath, $mimeType, $originalName)
                        ],
                        CURLOPT_HTTPHEADER     => [
                            "Authorization: Basic {$authString}",
                            'Content-Disposition: attachment; filename="' . addslashes($originalName) . '"',
                        ],
                        CURLOPT_TIMEOUT        => 120,
                    ]);

                    $mediaResp = curl_exec($ch);
                    $mediaCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $mediaErr  = curl_error($ch);
                    curl_close($ch);

                    if ($mediaErr || $mediaCode >= 400) {
                        Log::error('Media upload failed', ['http' => $mediaCode, 'error' => $mediaErr]);
                        // You can continue without image or throw
                    } else {
                        $mediaData = json_decode($mediaResp, true);
                        if (!empty($mediaData['id'])) {
                            $attachmentId = (int) $mediaData['id'];
                            $newImageUploaded = true;
                            Log::info('New image uploaded', ['attachment_id' => $attachmentId]);
                        }
                    }
                }
            }

            // 4. Prepare WooCommerce payload
            $payload = [
                'name'              => $title,
                'type'              => 'simple',
                'regular_price'     => (string) $post_regprice,
                'description'       => $post_content ?? '',
                'short_description' => $post_name ?? '',
                'status'            => 'publish',
            ];

            if ($attachmentId) {
                $payload['images'] = [['id' => $attachmentId]];
            }

            $postdata = json_encode($payload);

            // 5. Update via WooCommerce REST API (PUT)
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => "$apiBase/wp-json/wc/v3/products/$id",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => 'PUT',
                CURLOPT_POSTFIELDS     => $postdata,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode("$wcKey:$wcSecret"),
                ],
                CURLOPT_TIMEOUT        => 60,
            ]);

            $wcResponse = curl_exec($ch);
            $wcCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $wcErr      = curl_error($ch);
            curl_close($ch);

            if ($wcErr) {
                throw new \Exception("cURL error: $wcErr");
            }

            if ($wcCode >= 400) {
                throw new \Exception("WooCommerce update failed - HTTP $wcCode: " . substr($wcResponse, 0, 500));
            }

            $wcProduct = json_decode($wcResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($wcProduct['id'])) {
                throw new \Exception('Invalid WooCommerce response');
            }

            Log::info('Product updated in WooCommerce', ['id' => $wcProduct['id']]);

            // 6. Sync local WordPress database – UPDATE instead of INSERT
            $prefix = rtrim(config('services.ihook.store_prefix', 'wp'), '_') . '_';
            $now    = date('Y-m-d H:i:s');

            DB::beginTransaction();
            $transactionStarted = true;

            // Update main product post (do NOT delete!)
            DB::table("{$prefix}posts")->updateOrInsert(
                ['ID' => $wcProduct['id']],
                [
                    'post_title'            => $wcProduct['name'],
                    'post_content'          => $wcProduct['description'] ?? '',
                    'post_excerpt'          => $wcProduct['short_description'] ?? '',
                    'post_status'           => $wcProduct['status'] ?? 'publish',
                    'post_name'             => $wcProduct['slug'] ?? Str::slug($wcProduct['name']),
                    'guid'                  => $wcProduct['permalink'] ?? '',
                    'post_modified'         => $now,
                    'post_modified_gmt'     => $now,
                    'post_type'             => 'product',
                    'post_author'           => 1,
                ]
            );

            Log::debug('Product post updated locally', ['id' => $wcProduct['id']]);

            // Handle attachment (only if new image uploaded)
            if ($newImageUploaded && !empty($wcProduct['images'][0]['id'])) {
                $img = $wcProduct['images'][0];

                // Update or insert attachment
                DB::table("{$prefix}posts")->updateOrInsert(
                    ['ID' => $img['id']],
                    [
                        'post_author'           => 1,
                        'post_date'             => $now,
                        'post_date_gmt'         => $now,
                        'post_title'            => $img['name'] ?? 'Product Image',
                        'post_status'           => 'inherit',
                        'comment_status'        => 'open',
                        'ping_status'           => 'closed',
                        'post_name'             => Str::slug($img['name'] ?? 'image'),
                        'post_modified'         => $now,
                        'post_modified_gmt'     => $now,
                        'post_parent'           => $wcProduct['id'],
                        'guid'                  => $img['src'] ?? '',
                        'post_type'             => 'attachment',
                        'post_mime_type'        => $img['mime_type'] ?? 'image/png',
                    ]
                );

                // Update thumbnail meta
                DB::table("{$prefix}postmeta")->updateOrInsert(
                    ['post_id' => $wcProduct['id'], 'meta_key' => '_thumbnail_id'],
                    ['meta_value' => $img['id']]
                );

                Log::debug('Attachment & thumbnail updated', ['attachment_id' => $img['id']]);
            }

            // Update price meta
            if (!empty($wcProduct['regular_price'])) {
                DB::table("{$prefix}postmeta")->updateOrInsert(
                    ['post_id' => $wcProduct['id'], 'meta_key' => '_regular_price'],
                    ['meta_value' => $wcProduct['regular_price']]
                );
            }

            // Update stock status
            $stockStatus = $wcProduct['stock_status'] ?? 'instock';
            DB::table("{$prefix}postmeta")->updateOrInsert(
                ['post_id' => $wcProduct['id'], 'meta_key' => '_stock_status'],
                ['meta_value' => $stockStatus]
            );

            DB::commit();
            $transactionStarted = false;

            Log::info('Local WordPress DB update completed successfully');

            $_SESSION['success_message'] = __('Product updated successfully');
            return redirect()->back()->with('success', 'Product updated successfully');

        } catch (\Exception $e) {
            if ($transactionStarted) {
                DB::rollBack();
            }

            Log::error('updateProducts failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Update failed: ' . $e->getMessage());
        }
    }
     /**
     * This public static function is used to get the edit woocommerce products.
     * @param int $id
     * @return array $records
    */
    public static function showProductsEdit($id) {
         $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
              $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
              $woocommerce_key = $sitesettings[0]['sitesettings_value'];
              $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
              $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
              $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
              $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
              $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
              $path = $sitesettings[0]['sitesettings_value'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products/'.$id.'?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $records=json_decode($result);
            return $records;
    }
    /**
     * This public static function is used to get the delete woocommerce products.
     * @return void data
    */

 /**
 * Delete product from WooCommerce API + local WordPress database
 * Same level of sync as insertProducts()
 */
public static function deleteProduct($id)
{
    $id = (int) $id;
    if ($id <= 0) {
        throw new \Exception("Invalid product ID");
    }

    Log::info("Attempting to delete product ID: {$id}");

    // WooCommerce credentials
    $wcKey    = MSiteDetails::getSiteSettingValue('woocommerce_key');
    $wcSecret = MSiteDetails::getSiteSettingValue('woocommerce_secret');
    $apiBase  = rtrim(MSiteDetails::getSiteSettingValue('woocommerce_path') ?? '', '/');

    if (empty($apiBase) || empty($wcKey) || empty($wcSecret)) {
        throw new \Exception("WooCommerce API credentials missing");
    }

    // Step 1: Delete from WooCommerce REST API (force=true = permanent delete)
    $url = "{$apiBase}/wp-json/wc/v3/products/{$id}?force=true";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'DELETE',
        CURLOPT_HTTPHEADER     => [
            'Authorization: Basic ' . base64_encode("{$wcKey}:{$wcSecret}"),
        ],
        CURLOPT_TIMEOUT => 20,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError || $httpCode >= 400) {
        Log::warning("WooCommerce delete API failed", [
            'http' => $httpCode,
            'response' => substr($response ?: 'No response', 0, 500),
            'curl_error' => $curlError
        ]);
    } else {
        Log::info("Product deleted from WooCommerce API", ['id' => $id]);
    }

    // Step 2: Clean local WordPress database (same prefix logic as insert)
    $prefix = rtrim(config('services.ihook.store_prefix', 'wp'), '_') . '_';

    DB::transaction(function () use ($prefix, $id) {

        DB::table("{$prefix}postmeta")->where('post_id', $id)->delete();

        DB::table("{$prefix}posts")->where('ID', $id)->delete();

        DB::table("{$prefix}term_relationships")->where('object_id', $id)->delete();

        Log::info("Local database records cleaned for product ID: {$id}");
    });

    Log::info("Product delete process completed", ['id' => $id]);
}
     /**
     * This public static function is used to get the insert woocommerce products.
     * @return void data
    */

    public static function insertProducts(Request $request)
    {
        Log::info('insertProducts() - Product creation process started', [
            'start_time'   => now()->toDateTimeString(),
            'request_keys' => array_keys($request->all()),
            'has_image'    => $request->hasFile('product_image')
        ]);

        $transactionStarted = false;

        try {
            // 1. Validate basic form data
            $title         = $request->input('title');
            $post_content  = $request->input('post_content');
            $post_name     = $request->input('post_name');
            $post_regprice = $request->input('post_regprice');

            if (empty($title) || empty($post_regprice)) {
                throw new \Exception('Title and regular price are required.');
            }

            Log::debug('Form data validated OK', [
                'title' => $title,
                'price' => $post_regprice,
                'slug'  => $post_name,
            ]);

            // 2. WooCommerce credentials
            $wcKey    = MSiteDetails::getSiteSettingValue('woocommerce_key') ?? null;
            $wcSecret = MSiteDetails::getSiteSettingValue('woocommerce_secret') ?? null;
            $apiBase  = rtrim(MSiteDetails::getSiteSettingValue('woocommerce_path') ?? '', '/');

            if (!$apiBase || !$wcKey || !$wcSecret) {
                throw new \Exception('WooCommerce API credentials missing or incomplete.');
            }

            Log::debug('WooCommerce credentials loaded', ['api_base' => $apiBase]);
// =============================================
// 3. Image handling – Upload to WP Media Library
// =============================================

$attachmentId = null;

if ($request->hasFile('product_image') && $request->file('product_image')->isValid()) {
    $file         = $request->file('product_image');
    $originalName = $file->getClientOriginalName();
    $ext          = strtolower($file->getClientOriginalExtension());
    $safeName     = hash('sha256', $originalName . time() . microtime(true)) . '.' . $ext;

    $uploadDir = rtrim($_ENV['CURRENT_UPATH'] ?? 'user', '/') . '/shift/';
    $fullPath  = base_path('../' . $uploadDir . $safeName);

    if (!file_exists(dirname($fullPath))) {
        mkdir(dirname($fullPath), 0755, true);
    }

    $moved = $file->move(dirname($fullPath), $safeName);
    if (!$moved) {
        Log::error('Failed to move uploaded image', ['target' => $fullPath]);
    } else {
        Log::info('Image saved locally', ['path' => $fullPath]);

        $mimeType = mime_content_type($fullPath) ?: $file->getMimeType() ?: 'image/png';

        // Get Application Password from .env
        $wpUsername    = env('WP_APP_USERNAME', '');
        $wpAppPassword = env('WP_APP_PASSWORD', '');

        if (empty($wpAppPassword) || empty($wpUsername)) {
            Log::warning('WP Application Password or Username missing in .env – image upload skipped. Add WP_APP_USERNAME & WP_APP_PASSWORD.');
        } else {
            $authString = base64_encode($wpUsername . ':' . $wpAppPassword);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => "$apiBase/wp-json/wp/v2/media",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => [
                    'file' => new CURLFile($fullPath, $mimeType, $originalName)
                ],
                CURLOPT_HTTPHEADER     => [
                    "Authorization: Basic {$authString}",
                    'Content-Disposition: attachment; filename="' . addslashes($originalName) . '"',
                ],
                CURLOPT_TIMEOUT        => 120,
            ]);

            $mediaResp = curl_exec($ch);
            $mediaCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $mediaErr  = curl_error($ch);
            curl_close($ch);

            if ($mediaErr || $mediaCode >= 400) {
                Log::error('Media library upload failed', [
                    'http'     => $mediaCode,
                    'response' => substr($mediaResp ?: 'No response', 0, 800),
                    'curl_err' => $mediaErr
                ]);
            } else {
                $mediaData = json_decode($mediaResp, true);
                if (json_last_error() === JSON_ERROR_NONE && !empty($mediaData['id'])) {
                    $attachmentId = (int) $mediaData['id'];
                    Log::info('Image successfully uploaded to WP Media Library', [
                        'attachment_id' => $attachmentId,
                        'source_url'    => $mediaData['source_url'] ?? '-'
                    ]);
                } else {
                    Log::error('Invalid media response', ['raw' => $mediaResp]);
                }
            }
        }
    }
}
            // =============================================
            // 4. Prepare WooCommerce product payload
            // =============================================

            $payload = [
                'name'              => $title,
                'type'              => 'simple',
                'regular_price'     => (string) $post_regprice,
                'description'       => $post_content ?? '',
                'short_description' => $post_name ?? '',
                'status'            => 'publish',
            ];

            if ($attachmentId) {
                $payload['images'] = [['id' => $attachmentId]];
            }

            $postdata = json_encode($payload);
            Log::debug('WooCommerce payload ready', $payload);

            // =============================================
            // 5. Create product via WooCommerce API
            // =============================================

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => "$apiBase/wp-json/wc/v3/products",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => $postdata,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode("$wcKey:$wcSecret"),
                ],
                CURLOPT_TIMEOUT        => 60,
            ]);

            $wcResponse = curl_exec($ch);
            $wcCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $wcErr      = curl_error($ch);
            curl_close($ch);

            if ($wcErr) {
                throw new \Exception("cURL error during product creation: $wcErr");
            }

            if ($wcCode >= 400) {
                Log::error('WooCommerce API error', [
                    'http'     => $wcCode,
                    'response' => substr($wcResponse ?: 'No response', 0, 1500)
                ]);
                throw new \Exception("WooCommerce returned error - HTTP $wcCode");
            }

            $wcProduct = json_decode($wcResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($wcProduct['id'])) {
                throw new \Exception('Invalid WooCommerce response');
            }

            Log::info('Product created in WooCommerce', [
                'id'          => $wcProduct['id'],
                'name'        => $wcProduct['name'] ?? '-',
                'has_image'   => !empty($wcProduct['images'])
            ]);

            // =============================================
            // 6. Local WordPress DB sync
            // =============================================
            $prefix = rtrim(config('services.ihook.store_prefix', 'wp'), '_') . '_';
            $now    = date('Y-m-d H:i:s');

            DB::beginTransaction();
            $transactionStarted = true;

            // Clean up old record if any
            DB::table("{$prefix}posts")->where('ID', $wcProduct['id'])->delete();
            Log::debug('Cleaned up any existing post with same ID');

           // Insert attachment if present
if (!empty($wcProduct['images'][0]['id'])) {
    $img = $wcProduct['images'][0];

    DB::table("{$prefix}posts")->insert([
        'ID'                    => $img['id'],
        'post_author'           => 1,
        'post_date'             => $now,
        'post_date_gmt'         => $now,
        'post_content'          => '',
        'post_title'            => $img['name'] ?? 'Product Image',
        'post_excerpt'          => '',
        'post_status'           => 'inherit',
        'comment_status'        => 'open',
        'ping_status'           => 'closed',
        'post_password'         => '',
        'post_name'             => Str::slug($img['name'] ?? 'image'),
        'to_ping'               => '',
        'pinged'                => '',
        'post_modified'         => $now,
        'post_modified_gmt'     => $now,
        'post_content_filtered' => '',
        'post_parent'           => $wcProduct['id'],   // ← இது மாற்று! product ID set பண்ணு
        'guid'                  => $img['src'] ?? '',
        'menu_order'            => 0,
        'post_type'             => 'attachment',
        'post_mime_type'        => $img['mime_type'] ?? 'image/png',
        'comment_count'         => 0,
    ]);

    Log::debug('Attachment inserted locally', ['id' => $img['id'], 'parent' => $wcProduct['id']]);
}
// Thumbnail meta
if (!empty($wcProduct['images'][0]['id'])) {
    DB::table("{$prefix}postmeta")->insert([
        'post_id'    => $wcProduct['id'],
        'meta_key'   => '_thumbnail_id',
        'meta_value' => $wcProduct['images'][0]['id'],
    ]);
    Log::debug('Thumbnail meta added');
}

// Add regular price meta (from WooCommerce response)
if (!empty($wcProduct['regular_price'])) {
    DB::table("{$prefix}postmeta")->insert([
        'post_id'    => $wcProduct['id'],
        'meta_key'   => '_regular_price',
        'meta_value' => $wcProduct['regular_price'],
    ]);
    Log::debug('Regular price meta added', ['price' => $wcProduct['regular_price']]);
}

// Add stock status meta (default instock)
$stockStatus = $wcProduct['stock_status'] ?? 'instock';
DB::table("{$prefix}postmeta")->insert([
    'post_id'    => $wcProduct['id'],
    'meta_key'   => '_stock_status',
    'meta_value' => $stockStatus,
]);
Log::debug('Stock status meta added', ['status' => $stockStatus]);

            // Insert product post
            DB::table("{$prefix}posts")->insert([
                'ID'                    => $wcProduct['id'],
                'post_author'           => 1,
                'post_date'             => $now,
                'post_date_gmt'         => $now,
                'post_content'          => $wcProduct['description'] ?? '',
                'post_title'            => $wcProduct['name'],
                'post_excerpt'          => $wcProduct['short_description'] ?? '',
                'post_status'           => $wcProduct['status'] ?? 'publish',
                'comment_status'        => 'open',
                'ping_status'           => 'closed',
                'post_password'         => '',                      // ← add this
                'post_name'             => $wcProduct['slug'] ?? Str::slug($wcProduct['name']),
                'to_ping'               => '',                      // ← add this (empty string)
                'pinged'                => '',                      // ← add this (empty string)
                'post_modified'         => $now,
                'post_modified_gmt'     => $now,
                'post_content_filtered' => '',                      // ← add this (empty string)
                'post_parent'           => 0,
                'guid'                  => $wcProduct['permalink'] ?? '',
                'menu_order'            => 0,
                'post_type'             => 'product',
                'post_mime_type'        => '',
                'comment_count'         => 0,
            ]);

            Log::debug('Product post inserted locally', ['wc_id' => $wcProduct['id']]);
            Log::debug('Product post inserted locally', ['wc_id' => $wcProduct['id']]);

            // Thumbnail meta
            if (!empty($wcProduct['images'][0]['id'])) {
                DB::table("{$prefix}postmeta")->insert([
                    'post_id'    => $wcProduct['id'],
                    'meta_key'   => '_thumbnail_id',
                    'meta_value' => $wcProduct['images'][0]['id'],
                ]);
                Log::debug('Thumbnail meta added');
            }

            DB::commit();
            $transactionStarted = false;

            Log::info('Local WordPress DB operations completed');
            $_SESSION['success_message'] = __('New Product added successfully');

            return redirect()->back()->with('success', 'Product created successfully');

        } catch (\Exception $e) {
            if ($transactionStarted) {
                DB::rollBack();
            }

            Log::error('insertProducts failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * This public static function is used to get the post meta array.
     * @return array $stockarray
    */
       public static function getPostMetaarray()
      {
        $stockarray = array('sku','regular_price','sale_price','sale_price_dates_from','sale_price_dates_to','tax_status','tax_class','backorders','low_stock_amount','weight','length','width','height','purchase_note','download_limit','product_image_gallery','stock_status','stock','thumbnail_id','wp_trash_meta_status','wp_desired_post_slug');
        return $stockarray;
      }
    /**
     * This public static function is used to get the edit woocommerce products.
     * @param int $id
     * @return array $records
    */
    public static function eProductsEdit($id) {
         $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
              $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
              $woocommerce_key = $sitesettings[0]['sitesettings_value'];
              $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
              $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
              $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
              $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
              $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
              $path = $sitesettings[0]['sitesettings_value'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products/'.$id.'?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $records=json_decode($result);
            return $records;
    }

   public static function allWordPressProducts() {
        //       $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
        //       $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        //       $woocommerce_key = $sitesettings[0]['sitesettings_value'];
        //       $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
        //       $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
        //       $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
        //       $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
        //       $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        //       $path = $sitesettings[0]['sitesettings_value'];
        // if(trim($_POST['search_product']!='')){
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret.'&search='.trim($_POST['search_product']));
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //     $result = curl_exec($ch);
        //     if (curl_errno($ch)) {
        //         echo 'No Produts Found';
        //     }
        //     curl_close($ch);
        // }
        // else{
        //     if(isset($_GET['sub1'])){
        //         $limit=$_GET['sub1'];
        //     }
        //     else{
        //         $limit=0;
        //     }
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret.'&per_page=8&offset='.$limit);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //     $result = curl_exec($ch);
        //     if (curl_errno($ch)) {
        //         echo 'Error:' . curl_error($ch);
        //     }
        //     curl_close($ch);
        // }
        // $records=json_decode($result);


    $offset = request()->query('sub1', 0); // Get 'sub1' from query, default 0
    $limit = 8; // Number of records per scroll

    $storeprefix = config('services.ihook.store_prefix'); // e.g., 'wp_'

    // Build the query using Laravel query builder
    $records = DB::table($storeprefix . 'posts as p')
        ->select(
            'p.ID as product_id',
            'p.post_title as product_name',
            DB::raw('COALESCE(MAX(pm_price.meta_value), "0") as regular_price'),
            DB::raw('MAX(pm_stock.meta_value) as productstock_status'),
            DB::raw('GROUP_CONCAT(t.name SEPARATOR ", ") as category_name')
        )
        ->leftJoin($storeprefix . 'postmeta as pm', function ($join) {
            $join->on('p.ID', '=', 'pm.post_id')
                ->where('pm.meta_key', '_regular_price');
        })
        ->leftJoin($storeprefix . 'term_relationships as tr', 'p.ID', '=', 'tr.object_id')
        ->leftJoin($storeprefix . 'term_taxonomy as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
        ->leftJoin($storeprefix . 'terms as t', 'tt.term_id', '=', 't.term_id')
        ->where('p.post_type', 'product')
        ->where('p.post_status', 'publish')
        ->where('p.post_parent', 0)
        ->where('tt.taxonomy', 'product_cat')
        ->orderBy('p.post_date', 'desc')
        ->offset($offset)
        ->limit($limit)
        ->get()
        ->toArray();

        return DWordPressProducts::allWordPressProducts($records);
    }
    /**
     * This public static function is used to get the edit woocommerce products.
     * @param int $id
     * @return array $records
    */
  public static function editProducts($id)
{
    $id = (int) $id;
    if ($id < 1) {
        return null;
    }

    $woocommerce_key   = MSiteDetails::getSiteSettingValue('woocommerce_key');
    $woocommerce_secret = MSiteDetails::getSiteSettingValue('woocommerce_secret');
    $path              = rtrim(MSiteDetails::getSiteSettingValue('woocommerce_path') ?? '', '/');

    if (!$path || !$woocommerce_key || !$woocommerce_secret) {
        \Log::critical("WooCommerce credentials missing in editProducts");
        return null;
    }

    // Protocol auto-fix
    if (!preg_match('#^https?://#i', $path)) {
        $path = 'https://' . ltrim($path, '/');
    }

    $url = "$path/wp-json/wc/v3/products/$id?consumer_key=" . urlencode($woocommerce_key) .
           "&consumer_secret=" . urlencode($woocommerce_secret);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error || $httpCode !== 200) {
        \Log::error("editProducts failed", [
            'id' => $id,
            'http' => $httpCode,
            'curl_error' => $error
        ]);
        return null;
    }

    $product = json_decode($result);

    if (json_last_error() !== JSON_ERROR_NONE || empty($product->get_id())) {
        return null;
    }

    return $product;
}
public static function getProductDetails($id)
{
    $id = (int) $id;

    if ($id < 1) {
        \Log::warning("Invalid ID passed to getProductDetails", ['id' => $id]);
        return '<div class="p-6 text-center text-red-600 bg-red-50 rounded-lg border border-red-200">
            Invalid product ID: ' . $id . '
        </div>';
    }

    $apiBase   = rtrim(MSiteDetails::getSiteSettingValue('woocommerce_path')   ?? '', '/');
    $wcKey     = MSiteDetails::getSiteSettingValue('woocommerce_key');
    $wcSecret  = MSiteDetails::getSiteSettingValue('woocommerce_secret');

    // Auto-fix missing protocol (very common bug)
    if (!preg_match('#^https?://#i', $apiBase)) {
        $apiBase = 'https://' . ltrim($apiBase, '/');
    }

    if (empty($apiBase) || empty($wcKey) || empty($wcSecret)) {
        \Log::critical("WooCommerce credentials missing in getProductDetails");
        return '<div class="p-8 text-center text-red-700 bg-red-50 rounded-xl border border-red-200 shadow">
            <h3 class="text-xl font-bold mb-3">Configuration Error</h3>
            <p>WooCommerce API settings (path/key/secret) are missing or invalid.<br>
               Please go to admin settings and verify.</p>
        </div>';
    }

    $url = $apiBase . '/wp-json/wc/v3/products/' . $id
         . '?consumer_key='    . urlencode($wcKey)
         . '&consumer_secret=' . urlencode($wcSecret);

    \Log::debug("Fetching product details", ['id' => $id, 'url' => $url]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 12,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,   // ← only dev; remove in production
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    if ($curlErr) {
        \Log::error("cURL failed in getProductDetails", ['id' => $id, 'error' => $curlErr]);
        return '<div class="p-6 bg-red-50 text-red-700 rounded-lg border border-red-200">
            Connection failed: ' . htmlspecialchars($curlErr) . '
        </div>';
    }

    if ($httpCode !== 200) {
        if ($httpCode === 404) {
            return '<div class="p-8 text-center text-yellow-700 bg-yellow-50 rounded-xl border border-yellow-200 shadow-sm">
                <h3 class="text-xl font-bold mb-2">Product Not Found</h3>
                <p>ID ' . $id . ' does not exist in WooCommerce.<br>
                   It may have been deleted or never created.</p>
            </div>';
        }

        \Log::warning("WooCommerce non-200 response", ['id' => $id, 'http' => $httpCode]);
        return '<div class="p-6 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
            WooCommerce API error (HTTP ' . $httpCode . ')
        </div>';
    }

    $product = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE || empty($product->get_id())) {
        return '<div class="p-6 bg-orange-50 text-orange-800 rounded-lg border border-orange-200">
            Invalid response format from WooCommerce
        </div>';
    }

    // Render using your display class
    return DWordPressProducts::showProductDetails($product);
}
  }
