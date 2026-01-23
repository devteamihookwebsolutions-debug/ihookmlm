<?php
/**
 * This class contains public static functions related to purchase history.
 *
 * @package         Model_MPurchaseHistory
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
use Display\Wordpress\DWordPressPurchaseHistory;
use Illuminate\Support\Facades\DB;

class MWordPressPurchaseHistory {


    public static function getPurchaseHistory()
    {
        $storeprefix = config('services.ihook.store_prefix');

        $columns = [
            'a.post_type',
            'a.post_date_gmt',
            'b.meta_value',
            'b.meta_key',
            'b.post_id',
            'a.post_status'
        ];

        $query = DB::table($storeprefix . '_posts AS a')
            ->leftJoin($storeprefix . '_postmeta AS b', function ($join) {
                $join->on('b.post_id', '=', 'a.ID')
                    ->where('b.meta_key', '_customer_user');
            })
            ->where('a.post_type', 'shop_order')
            ->where('a.post_status', '!=', 'auto-draft');

        // Global search / column filters
        if (!empty($_POST['columns'])) {

            // Filter by Post ID
            if (!empty($_POST['columns'][0]['search']['value'])) {
                $query->where('b.post_id', $_POST['columns'][0]['search']['value']);
            }

            // Filter by member username
            if (!empty($_POST['columns'][1]['search']['value'])) {
                $member = DB::table($storeprefix . '_members_table')
                            ->select('members_shop_id')
                            ->where('members_username', trim($_POST['columns'][1]['search']['value']))
                            ->first();
                if ($member) {
                    $query->where('b.meta_value', $member->members_shop_id);
                }
            }

            // Filter by quantity (_qty)
            if (!empty($_POST['columns'][2]['search']['value'])) {
                $qtyRecords = DB::table($storeprefix . '_woocommerce_order_itemmeta')
                                ->where('meta_key', '_qty')
                                ->where('meta_value', $_POST['columns'][2]['search']['value'])
                                ->pluck('order_item_id');

                if ($qtyRecords->isNotEmpty()) {
                    $orderItemDetails = DB::table($storeprefix . '_woocommerce_order_items')
                                        ->whereIn('order_item_id', $qtyRecords)
                                        ->pluck('order_id');
                    if ($orderItemDetails->isNotEmpty()) {
                        $query->whereIn('b.post_id', $orderItemDetails);
                    }
                }
            }

            // Filter by post status
            if (!empty($_POST['columns'][3]['search']['value'])) {
                $query->where('a.post_status', $_POST['columns'][3]['search']['value']);
            }

            // Filter by order total (_order_total)
            if (!empty($_POST['columns'][4]['search']['value'])) {
                $totals = DB::table($storeprefix . '_postmeta')
                            ->where('meta_key', '_order_total')
                            ->where('meta_value', $_POST['columns'][4]['search']['value'])
                            ->pluck('post_id');

                if ($totals->isNotEmpty()) {
                    $query->whereIn('b.post_id', $totals);
                }
            }

            // Filter by payment method (_payment_method_title)
            if (!empty($_POST['columns'][5]['search']['value'])) {
                $payments = DB::table($storeprefix . '_postmeta')
                            ->where('meta_key', '_payment_method_title')
                            ->where('meta_value', $_POST['columns'][5]['search']['value'])
                            ->pluck('post_id');

                if ($payments->isNotEmpty()) {
                    $query->whereIn('b.post_id', $payments);
                }
            }

            // Filter by date range
            if (!empty($_POST['columns'][6]['search']['value'])) {
                [$startDate, $endDate] = explode('|', $_POST['columns'][6]['search']['value']);
                $query->whereDate('a.post_date_gmt', '>=', date("Y-m-d", strtotime($startDate)))
                    ->whereDate('a.post_date_gmt', '<=', date("Y-m-d", strtotime($endDate)));
            }
        }

        // Ordering
        if (!empty($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $orderColumnIndex = intval($_POST['order'][0]['column']);
            $orderDir = in_array(strtolower($_POST['order'][0]['dir']), ['asc','desc']) ? $_POST['order'][0]['dir'] : 'asc';

            $orderColumns = ['b.post_id', 'members_username', '', '', '', '', 'a.post_date_gmt'];
            if (isset($orderColumns[$orderColumnIndex]) && $orderColumns[$orderColumnIndex] != '') {
                $query->orderBy($orderColumns[$orderColumnIndex], $orderDir);
            }
        }

        // Pagination
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;
        $query->offset($start)->limit($length);

        $records = $query->groupBy('b.post_id')->get();

        // Total count
        $totalQuery = DB::table($storeprefix . '_posts AS a')
                        ->leftJoin($storeprefix . '_postmeta AS b', function ($join) {
                            $join->on('b.post_id', '=', 'a.ID')
                                ->where('b.meta_key', '_customer_user');
                        })
                        ->where('a.post_type', 'shop_order')
                        ->where('a.post_status', '!=', 'auto-draft');

        $iTotal = $totalQuery->groupBy('b.post_id')->count();

        return DWordPressPurchaseHistory::getPurchaseHistory($records, $iTotal);
    }


public static function getOrderDetails()
{
    $storeprefix = config('services.ihook.store_prefix');
    $post_id = request()->query('sub1'); // Using Laravel request helper

    // Get order meta
    $orderdetails = DB::table($storeprefix . '_postmeta')
                        ->where('post_id', $post_id)
                        ->orderBy('meta_id', 'asc')
                        ->get();

    // Get order items
    $orderitemdetails = DB::table($storeprefix . '_woocommerce_order_items')
                            ->where('order_id', $post_id)
                            ->orderBy('order_item_id', 'asc')
                            ->get();

    return DWordPressPurchaseHistory::showOrderDetails($orderdetails, $orderitemdetails);
}

/**
 * Update unseen orders
 */
public static function updateUnseenOrder()
{
    $storeprefix = config('services.ihook.store_prefix');

    // Get orders where notification_status is null
    $recordsorder = DB::table($storeprefix . '_posts AS a')
        ->leftJoin($storeprefix . '_postmeta AS b', function ($join) {
            $join->on('b.post_id', '=', 'a.ID')
                 ->where('b.meta_key', 'notification_status');
        })
        ->where('a.post_type', 'shop_order')
        ->where('a.post_status', '!=', 'auto-draft')
        ->whereNull('b.meta_value')
        ->select('a.ID')
        ->get();

    if ($recordsorder->isNotEmpty()) {
        $insertData = [];
        $currentTime = now(); // Optional if you want to store timestamp

        foreach ($recordsorder as $record) {
            $insertData[] = [
                'post_id'   => $record->ID,
                'meta_key'  => 'notification_status',
                'meta_value'=> '1',
            ];
        }

        // Bulk insert for efficiency
        DB::table($storeprefix . '_postmeta')->insert($insertData);
    }
}

}
?>
