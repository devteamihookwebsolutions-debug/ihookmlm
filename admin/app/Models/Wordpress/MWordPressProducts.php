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
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\DB;

class MWordPressProducts{

   public static function showWordPressProducts() {
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


    $storePrefix = config('services.ihook.store_prefix'); // e.g., 'wp_'

    // Table names
    $postsTable       = $storePrefix . '_posts';
    $postmetaTable    = $storePrefix . '_postmeta';
    $termRelTable     = $storePrefix . '_term_relationships';
    $termTaxTable     = $storePrefix . '_term_taxonomy';
    $termsTable       = $storePrefix . '_terms';

    // Query using Laravel Query Builder
    $records = DB::table($postsTable . ' as p')
        ->leftJoin($postmetaTable . ' as pm', function ($join) {
            $storePrefix = config('services.ihook.store_prefix');
            $join->on('p.ID', '=', 'pm.post_id')
                ->where('pm.meta_key', '_regular_price');
        })
        ->leftJoin($termRelTable . ' as tr', 'p.ID', '=', 'tr.object_id')
        ->leftJoin($termTaxTable . ' as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
        ->leftJoin($termsTable . ' as t', 'tt.term_id', '=', 't.term_id')
        ->select(
            'p.ID as product_id',
            'p.post_title as product_name',
            'pm.meta_value as regular_price',
            't.name as category_name'
        )
        ->where('p.post_type', 'product')
        ->where('p.post_status', 'publish')
        ->where('p.post_parent', 0)
        ->where('tt.taxonomy', 'product_cat')
        ->orderBy('p.post_date', 'desc')
        ->limit(10)
        ->get()
        ->toArray();

        return DWordPressProducts::showWordPressProducts($records);
    }
     /**
     * This public static function is used to get the update woocommerce products.
     * @return void $records
    */
   public static function updateProducts() {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $post_name = $_POST['post_name'];
        $post_content = $_POST['post_content'];
        $post_price = $_POST['post_price'];
        $post_regprice = $_POST['post_regprice'];
        $currentDateTime = date('Y-m-d H:i:s');
        $editposttitle = $_POST['editposttitle'];
        $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        $woocommerce_key = $sitesettings[0]['sitesettings_value'];
        $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
        $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
        $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        $path = $sitesettings[0]['sitesettings_value'];
        $uploaded_path = '../'.$_ENV['CURRENT_UPATH'].'/uploads/wp_uploads/';
         if ($_FILES['product_image']['size'] > 0) {
            $uploadedName = $_FILES['product_image']['name'];
        //     $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
        //     $flnm = hash('sha256', $uploadedName) . '.' . $ext;
        //     $headerimagepath = 'uploads/wp_uploads/' . $flnm;
        //     MAmazonS3::amazonUpload($_FILES['product_image']['name'],$_FILES['product_image']['tmp_name'],$_FILES['product_image']['type'],$headerimagepath);

            $uploaded_path = '../'.$_ENV['CURRENT_UPATH'].'/shift/';
            $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimage = $uploaded_path . "/" . $flnm;
            move_uploaded_file($_FILES['product_image']['tmp_name'], $headerimage);
        }
        $imagelink = $_ENV['FCPATH'] . "/shift/" . $flnm;

         if ($_FILES['product_image']['size'] > 0) {
        $data =  ['name' => $title, 'type' => 'simple', 'regular_price' => $post_regprice, 'description' => $post_content, 'short_description' => $post_name,'images' => [['src' => $imagelink, 'position' => 0]]];
         }
         else{
             $data =  ['name' => $title, 'type' => 'simple', 'regular_price' => $post_regprice, 'description' => $post_content, 'short_description' => $post_name];
         }
        $data_result = json_encode($data);
        try {
              $curl = curl_init();
              curl_setopt_array($curl, array(
              CURLOPT_URL =>  "".$path."/wp-json/wc/v3/products/".$id."?consumer_key=".$woocommerce_key."&consumer_secret=".$woocommerce_secret."",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $data_result,
              CURLOPT_HTTPHEADER => array(
                  "cache-control: no-cache",
                  "content-type: application/json",
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              //echo "cURL Error #:" . $err;
            }
        }
        catch(HttpClientException $e) {
            print_r($e);
        }
        $_SESSION['success_message'] = "" . __('Product updated successfully') . "";
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

    public static function deleteProducts()
    {
        $id = request()->query('sub1'); // safer than directly $_GET

        $storePrefix = config('services.ihook.store_prefix'); // e.g., 'wp_'

        // Delete postmeta
        DB::table($storePrefix . '_postmeta')->where('post_id', $id)->delete();

        // Delete post
        DB::table($storePrefix . '_posts')->where('ID', $id)->delete();

        // Get WooCommerce credentials
        $woocommerce_key = trim(MSiteDetails::getSiteSettingsDetails("WHERE sitesettings_name ='woocommerce_key' ")[0]['sitesettings_value']);
        $woocommerce_secret = trim(MSiteDetails::getSiteSettingsDetails("WHERE sitesettings_name ='woocommerce_secret' ")[0]['sitesettings_value']);
        $path = trim(MSiteDetails::getSiteSettingsDetails("WHERE sitesettings_name ='woocommerce_path' ")[0]['sitesettings_value']);

        // WooCommerce REST API URL
        $url = $path . "/wp-json/wc/v3/products/" . $id . "?consumer_key=" . $woocommerce_key . "&consumer_secret=" . $woocommerce_secret;

        // Delete via cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
                "content-type: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        $data_json = json_decode($response, true);
        $err = curl_error($curl);
        curl_close($curl);

        $_SESSION['success_message'] = __('Product deleted successfully');
    }

     /**
     * This public static function is used to get the insert woocommerce products.
     * @return void data
    */
    public static function insertProducts() {
        $title = $_POST['title'];
        $post_content = $_POST['post_content'];
        $post_name = $_POST['post_name'];
        $post_regprice = $_POST['post_regprice'];
        $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        $woocommerce_key = $sitesettings[0]['sitesettings_value'];
        $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
        $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
        $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        $path = $sitesettings[0]['sitesettings_value'];
        $uploaded_path = '../'.$_ENV['CURRENT_UPATH'].'/uploads/wp_uploads/';
        if ($_FILES['product_image']['size'] > 0) {
            $uploadedName = $_FILES['product_image']['name'];
            // $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            // $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            // $headerimagepath = 'uploads/wp_uploads/' . $flnm;
            // MAmazonS3::amazonUpload($_FILES['product_image']['name'],$_FILES['product_image']['tmp_name'],$_FILES['product_image']['type'],$headerimagepath);
            $uploaded_path = '../'.$_ENV['CURRENT_UPATH'].'/shift/';
            $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimage = $uploaded_path . "/" . $flnm;
            move_uploaded_file($_FILES['product_image']['tmp_name'], $headerimage);
        }
        $imagelink = $_ENV['FCPATH'] . "/shift/" . $flnm;
        try {
            $postdata = '{
                  "name": "' . $title . '",
                  "type": "simple",
                  "regular_price": "' . $post_regprice . '",
                  "description": "' . $post_content . '",
                  "short_description": "' . $post_name . '",
                  "images": [
                    {
                      "src": "' . $imagelink . '"
                    }
                  ]
                }';
            $curl = curl_init();
            curl_setopt_array($curl, array(CURLOPT_URL => "" . $path . "/wp-json/wc/v3/products?consumer_key=" . $woocommerce_key . "&consumer_secret=" . $woocommerce_secret . "", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $postdata, CURLOPT_HTTPHEADER => array("cache-control: no-cache", "content-type: application/json",),));
            $response = curl_exec($curl);

            $err = curl_error($curl);
            curl_close($curl);

        if ($err) {
            // cURL error handling (optional)
            // echo "cURL Error #:" . $err;
        } else {
            $data_json = json_decode($response, true);
            $storeprefix = config('services.ihook.store_prefix'); // e.g., 'wp_'
            $currenct_date = date("Y-m-d H:i:s"); // Laravel friendly format

            // Delete existing product post
            DB::table($storeprefix . 'posts')->where('ID', $data_json['id'])->delete();

            // Check if product exists
            $existingPost = DB::table($storeprefix . 'posts')->where('ID', $data_json['id'])->first();

            if (!$existingPost) {
                // Insert product image as attachment if exists
                if (!empty($data_json['images'][0]['id'])) {
                    DB::table($storeprefix . 'posts')->insert([
                        'ID' => $data_json['images'][0]['id'],
                        'post_author' => 1,
                        'post_date' => $currenct_date,
                        'post_date_gmt' => $currenct_date,
                        'post_content' => '',
                        'post_title' => $data_json['images'][0]['name'] ?? '',
                        'post_excerpt' => '',
                        'post_status' => 'inherit',
                        'comment_status' => 'open',
                        'ping_status' => 'closed',
                        'post_password' => $data_json['post_password'] ?? '',
                        'post_name' => $data_json['images'][0]['name'] ?? '',
                        'to_ping' => $data_json['to_ping'] ?? '',
                        'pinged' => $data_json['pinged'] ?? '',
                        'post_modified' => $data_json['date_modified'] ?? $currenct_date,
                        'post_modified_gmt' => $data_json['date_modified_gmt'] ?? $currenct_date,
                        'post_content_filtered' => $data_json['post_content_filtered'] ?? '',
                        'post_parent' => 0,
                        'guid' => $data_json['images'][0]['src'] ?? '',
                        'menu_order' => 0,
                        'post_type' => 'attachment',
                        'post_mime_type' => $data_json['post_mime_type'] ?? '',
                        'comment_count' => 0,
                    ]);
                }

                // Insert product post
                DB::table($storeprefix . 'posts')->insert([
                    'ID' => $data_json['id'],
                    'post_author' => 1,
                    'post_date' => $currenct_date,
                    'post_date_gmt' => $currenct_date,
                    'post_content' => $data_json['description'] ?? '',
                    'post_title' => $data_json['name'] ?? '',
                    'post_excerpt' => $data_json['name'] ?? '',
                    'post_status' => $data_json['status'] ?? 'publish',
                    'comment_status' => 'open',
                    'ping_status' => 'closed',
                    'post_password' => $data_json['post_password'] ?? '',
                    'post_name' => $data_json['name'] ?? '',
                    'to_ping' => $data_json['to_ping'] ?? '',
                    'pinged' => $data_json['pinged'] ?? '',
                    'post_modified' => $data_json['date_modified'] ?? $currenct_date,
                    'post_modified_gmt' => $data_json['date_modified_gmt'] ?? $currenct_date,
                    'post_content_filtered' => $data_json['post_content_filtered'] ?? '',
                    'post_parent' => $data_json['parent_id'] ?? 0,
                    'guid' => $data_json['permalink'] ?? '',
                    'menu_order' => 0,
                    'post_type' => 'product',
                    'post_mime_type' => $data_json['post_mime_type'] ?? '',
                    'comment_count' => 0,
                ]);

                // Insert post meta for stock and other fields
                $stockArray = self::getPostMetaarray(); // your defined meta keys

                foreach ($stockArray as $metaKey) {
                    if (isset($data_json[$metaKey])) {
                        DB::table($storeprefix . 'postmeta')->insert([
                            'post_id' => $data_json['id'],
                            'meta_key' => '_' . $metaKey,
                            'meta_value' => $data_json[$metaKey],
                        ]);
                    }
                }

                // Insert thumbnail ID
                if (!empty($data_json['images'][0]['id'])) {
                    DB::table($storeprefix . 'postmeta')->insert([
                        'post_id' => $data_json['id'],
                        'meta_key' => '_thumbnail_id',
                        'meta_value' => $data_json['images'][0]['id'],
                    ]);
                }
            }
        }

        }
        catch(HttpClientException $e) {
            //print_r($e);
        }
        $_SESSION['success_message'] = __('New Product added successfully');
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
            'pm.meta_value as regular_price',
            't.name as category_name'
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
    public static function editProducts($id) {

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

public static function showProductDetails($records)
{
        $id = trim($_POST['id']);
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
        return DWordPressProducts::showProductDetails($records);

    }


  }
