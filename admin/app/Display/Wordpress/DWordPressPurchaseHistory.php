<?php

namespace Admin\App\Display\Wordpress;

use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Wordpress\MWordpressOrderItems;
use Admin\App\Models\Wordpress\MWordpressOrderItemsMeta;
use Admin\App\Models\Wordpress\MWordpressPostMeta;


class DWordPressPurchaseHistory
{

    public static function getPurchaseHistory($recordsdetails, $iTotal)
    {
        $mem_data = [];  // Initialize the array to store member data

        foreach ($recordsdetails as $record) {
            $where = "WHERE order_id='" . $record['post_id'] . "' ORDER BY order_item_id ASC";
            $orderitemdetails = MWordpressOrderItems::getOrderedItems($where);
            $order_item_id = $orderitemdetails[0]['order_item_id'];
            $where = 'WHERE order_item_id="' . $order_item_id . '" AND meta_key="_qty"';
            $qty = MWordpressOrderItemsMeta::getShopOrderItemMeta($where);
            $qty = $qty[0]['meta_value'];
            $qtyitems = $qty . '&nbsp;Items';

            $where = 'WHERE post_id="' . $record['post_id'] . '" AND meta_key="_order_total"';
            $total = MWordpressPostMeta::getShopPostMeta($where);
            $total = $total[0]['meta_value'];

            $where = 'WHERE post_id="' . $record['post_id'] . '" AND meta_key="_payment_method_title"';
            $payment = MWordpressPostMeta::getShopPostMeta($where);
            $payment = $payment[0]['meta_value'];

            // Get customer details
            if ($record['meta_value'] > 0) {
                $where = 'WHERE members_shop_id="' . trim($record['meta_value']) . '"';
                $customer = MMemberDetails::getWhereMemberDetails($where);
            } else {
                $where = 'WHERE post_id="' . $record['post_id'] . '" AND meta_key="_billing_email"';
                $customer = MWordpressPostMeta::getShopPostMeta($where);
                $customer[0]['members_username'] = $customer[0]['meta_value'];
            }

            // Order status
            $post_status = $record['post_status'];
            $status = explode("wc-", $post_status);
            $post_status = ($status[1] != '') ? ucfirst($status[1]) : 'Trash';

            $orderdate = MFormatDate::formatingDate($record['post_date_gmt']);

            // Add data to the response array
            if ($record['meta_value'] != '') {
                $mem_data[] = [
                    'orderid' => $record['post_id'],
                    'cutomer' => '<a aria-label="link" href="' . $_ENV['BCPATH'] . '/memberarea/show/' . $customer[0]['members_id'] . '">' . $customer[0]['members_username'] . '</a>',
                    'purcahsed' => $qtyitems,
                    'status' => $post_status,
                    'total' => $_SESSION['site_settings']['site_currency'].' ' . MFormatNumber::formatingNumberCurrency($total),
                    'paymentmethod' => $payment,
                    'date' => $orderdate,
                    'action' => '<a aria-label="link" href="#"  title="View" onclick="viewOrderDetails(' . $record['post_id'] . ')"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
  <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg></a>'
                ];
            }
        }

        // If no data, return an empty array
        if (empty($mem_data)) {
            $mem_data = [];
        }

        // Prepare the response array and output as JSON
        $res_array = [
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $mem_data
        ];

        echo json_encode($res_array);
        exit();
    }


    public static function showOrderDetails($records, $recordsitems)
    {
        $customer_data = [];
        foreach ($records as $value) {
            switch ($value['meta_key']) {
                case '_billing_first_name': $firstname = $value['meta_value'];
                    break;
                case '_billing_last_name': $lastname = $value['meta_value'];
                    break;
                case '_billing_address_1': $address1 = $value['meta_value'];
                    break;
                case '_billing_address_2': $address2 = $value['meta_value'];
                    break;
                case '_billing_city': $city = $value['meta_value'];
                    break;
                case '_billing_state': $state = $value['meta_value'];
                    break;
                case '_billing_postcode': $postcode = $value['meta_value'];
                    break;
                case '_billing_country': $country = $value['meta_value'];
                    break;
                case '_shipping_address_1': $sh_address1 = $value['meta_value'];
                    break;
                case '_shipping_address_2': $sh_address2 = $value['meta_value'];
                    break;
                case '_shipping_city': $sh_city = $value['meta_value'];
                    break;
                case '_shipping_state': $sh_state = $value['meta_value'];
                    break;
                case '_shipping_postcode': $sh_pocode = $value['meta_value'];
                    break;
                case '_shipping_country': $sh_country = $value['meta_value'];
                    break;
                case '_shipping_first_name': $sh_firstname = $value['meta_value'];
                    break;
                case '_shipping_last_name': $sh_lastname = $value['meta_value'];
                    break;
            }
        }

        // Build the HTML output for order details
        $output = '<h3>' . __('Order ID') . ' #' . $records[0]['post_id'] . ' </h3>';
        $output .= '<div class="row"><div class="col-md-6 purch_detail"><div class="view-bill"><h6><b>' . __('Billing Details') . '</b></h6>';
        $output .= '<div class="bill-details"><p>' . $firstname . ' ' . $lastname . ' </p>' .
                   '<p>' . $address1 . ' </p>' .
                   '<p>' . $address2 . ' </p>' .
                   '<p>' . $city . ' </p>' .
                   '<p>' . $state . ' </p>' .
                   '<p>' . $country . ' </p>' .
                   '<p>' . $postcode . ' </p></div></div></div>';
        $output .= '<div class="col-md-6"><div class="view-ship"><h6><b>' . __('Shipping Details') . '</b></h6>';
        $output .= '<div class="ship-detail"><p>' . $sh_firstname . ' ' . $sh_lastname . ' </p>' .
                   '<p>' . $sh_address1 . ' </p>' .
                   '<p>' . $sh_address2 . ' </p>' .
                   '<p>' . $sh_city . ' </p>' .
                   '<p>' . $sh_state . ' </p>' .
                   '<p>' . $sh_country . ' </p>' .
                   '<p>' . $sh_pocode . ' </p></div></div></div></div>';

        $output .= '<div class="row"><div class="col-md-12"><h6><b>' . __('Item Details') . '</b></h6>
                    <table class="table table-sm m-table m-table--head-bg-brand">
                    <thead class="thead-inverse">
                    <tr>
                    <th scope="row">' . __('Item') . '</th>
                    <th scope="row">' . __('Cost') . '</th>
                    <th scope="row">' . __('Quantity') . '</th>
                    <th scope="row">' . __('Total') . '</th>
                    </tr>
                    </thead>
                    <tbody>';

        if (!empty($recordsitems)) {
            foreach ($recordsitems as $item) {
                $order_item_id = $item['order_item_id'];
                $where = 'WHERE order_item_id="' . $order_item_id . '" AND meta_key="_qty"';
                $qty = MWordpressOrderItemsMeta::getShopOrderItemMeta($where);
                $qty = $qty[0]['meta_value'];

                $where = 'WHERE order_item_id="' . $order_item_id . '" AND meta_key="_line_total"';
                $total = MWordpressOrderItemsMeta::getShopOrderItemMeta($where);
                $total = $total[0]['meta_value'];

                $cost = $total / $qty;

                $output .= '<tr>
                            <td>' . $item['order_item_name'] . '</td>
                            <td>' . $cost . '</td>
                            <td>' . $qty . '</td>
                            <td>' . $total . '</td>
                            </tr>';
            }
        }

        $output .= '</tbody></table></div></div></div>';
        echo $output;
    }
}
