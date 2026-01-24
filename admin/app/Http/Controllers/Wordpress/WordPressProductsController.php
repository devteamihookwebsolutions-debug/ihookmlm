<?php
/**
 * This class contains public functions related to woo products
 *
 * @package         WordPressProducts
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\Wordpress;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Lib\ValidateInputs;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Wordpress\MWordPressProducts;
use Exception;
use Illuminate\Support\Facades\Log;
class WordPressProductsController extends Controller
{

    public static function showWordPressProducts()
    {

        $output['products'] = MWordPressProducts::showWordPressProducts();
// dd($output['products']);
        return view('wordpress/wordpressproductslist', $output);
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        }

    public static function showAddProducts()
    {

        if (isset($_GET['sub1'])) {
            $result = MWordPressProducts::editProducts($_GET['sub1']);
            $output['post_title'] = $result['post_title'];
            $output['post_name'] = $result['post_name'];
            $output['post_content'] = $result['post_content'];
            $output['regular_price'] = $result['regular_price'];
            $output['sales_price'] = $result['sales_price'];
        }
        $sitesettings_val =MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="woocommerce_secret"');
        $output['woocommerce_secret'] = $sitesettings_val[0]['sitesettings_value'];

        return view('wordpress/worpressaddproducts', $output);
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

}

    public function insertProducts()
    {
        Log::info('WordPress product insertion/update started', [
            'user_id' => auth()->id() ?? 'guest',
            'ip' => request()->ip(),
            'post_data' => request()->except(['product_image'])
        ]);

        new ValidateInputs('e_product');

        $model = new MWordPressProducts();

        try {
            if (isset($_POST['id']) && $_POST['id'] != "") {
                Log::info('Updating existing product', ['product_id' => $_POST['id']]);
                MAdminActivityLog::getAdminActivity('Wordpress - Update Product');
                $model->updateProducts(request());
                Log::info('Product update completed successfully', ['product_id' => $_POST['id']]);
            } else {
                Log::info('Creating new product');
                MAdminActivityLog::getAdminActivity('Wordpress - Insert Product');
                $model->insertProducts(request());
                Log::info('New product insertion completed');
            }

            header('Location:' . $_ENV['BCPATH'] . '/wordpressproducts');
            exit();
        } catch (Exception $e) {
            Log::error('Product insert/update failed in controller', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'post_data' => request()->all()
            ]);

            // Optional: session flash message
            $_SESSION['error_message'] = 'Product save failed. Please check logs.';
            header('Location:' . $_ENV['BCPATH'] . '/wordpressproducts');
            exit();
        }
    }

public function deleteProducts($id)
{
    $id = (int) $id;

    if ($id <= 0) {
        return redirect()->back()->with('error', 'Invalid product ID');
    }

    try {
        if (auth()->check()) {
            MAdminActivityLog::getAdminActivity('Wordpress - Delete Product');
        }

        // Model-ல delete logic call
        MWordPressProducts::deleteProduct($id);

        return redirect($_ENV['BCPATH'] . '/wordpressproducts')
            ->with('success', 'Product deleted successfully');

    } catch (Exception $e) {
        \Log::error('Product delete failed', [
            'id' => $id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
    }
}
    // WordPressProductsController.php
public function showEditProducts($id)
{
    $id = (int) $id;

    if ($id < 1) {
        return redirect()
            ->route('wordpressproducts.show')
            ->with('error', 'Invalid Product ID');
    }

    $product = MWordPressProducts::editProducts($id);

    if (empty($product) || isset($product->code)) {
        \Log::warning("Product fetch failed for edit", [
            'id' => $id,
            'error' => $product->message ?? 'Unknown error'
        ]);
        return redirect()
            ->route('wordpressproducts.show')
            ->with('error', 'Product not found or API error');
    }

$output = [
    'post_title'     => $product->name ?? '',
    'post_content'   => strip_tags($product->description ?? ''),
    'post_name'      => strip_tags($product->short_description ?? ''),
    'regular_price'  => $product->regular_price ?? '',
    'sales_price'    => $product->sale_price ?? '',
    'productimage'   => $product->images[0]->src ?? '',
    'sub1'           => $id,
];

    $sitesettings_val = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="woocommerce_secret"');
    $output['woocommerce_secret'] = $sitesettings_val[0]['sitesettings_value'] ?? '';

    return view('wordpress.wordpressediteproducts', $output);
}
    public static function getProducts()
    {
        echo MWordPressProducts::allWordPressProducts();

}

    public function showProductDetails($id)
    {
        // Force clean integer
        $id = (int) trim($id ?? 0);

        \Log::info("showProductDetails called", [
            'received_id' => $id,
            'raw_input'   => request()->all(),
            'url'         => request()->fullUrl()
        ]);

        if ($id < 1) {
            return '<div class="p-8 text-center text-red-700 bg-red-50 rounded-xl border border-red-200 shadow-sm">
                <h3 class="text-xl font-bold mb-2">Invalid Product ID</h3>
                <p>ID received: ' . e($id) . '<br>Please try clicking the button again.</p>
            </div>';
        }

        $html = MWordPressProducts::getProductDetails($id);

        return response($html)->header('Content-Type', 'text/html');
    }

    public static function allWordPressProducts()
    {
        echo MWordPressProducts::allWordPressProducts();
        exit;

}
}
