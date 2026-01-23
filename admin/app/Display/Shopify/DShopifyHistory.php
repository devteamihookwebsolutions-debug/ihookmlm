<?php

namespace Admin\App\Display\Shopify;

use Admin\App\Models\Middleware\MFormatDate;

class DShopifyHistory
{

    public static function getPurchaseHistory($records)
    {
        if (count($records) > 0) {
            $currency = $_SESSION['site_settings']['site_currency'];
            $output = '';

            foreach ($records as $i => $order) {
                $sno = $i + 1;

                // Count line items and properly handle pluralization
                $count = count($order['line_items']) . ' ' . ($order['line_items'] > 1 ? __('Items') : __('Item'));

                // Check financial status
                $status = ($order['financial_status'] === 'paid')
                    ? '<span>' . __('Paid') . '</span>'
                    : '<span>' . ucfirst($order['financial_status']) . '</span>';

                $output .= '<tr>
                    <td>' . htmlspecialchars($order['order_number']) . '</td>
                    <td>' . htmlspecialchars($order['customer']['first_name']) . ' ' . htmlspecialchars($order['customer']['last_name']) . '</td>
                    <td>' . $count . '</td>
                    <td>' . $status . '</td>
                    <td>' . $currency . ' ' . htmlspecialchars($order['total_price']) . '</td>
                    <td>' . htmlspecialchars($order['payment_gateway_names'][0]) . '</td>
                    <td>' . MFormatDate::formatingDate($order['created_at']) . '</td>
                    <td>
                        <a aria-label="link" href="javascript:void(0);" class="suspenduser" onclick="viewOrderDetails(' . (int)$order['id'] . ');">
                            <button aria-label="button"  type="button"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
  <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg></button>
                        </a>
                    </td>
                </tr>';
            }
        } else {
            $output = '<tr>
                <td colspan="8">' . __('No data available') . '</td>
            </tr>';
        }

        return $output;
    }


    public static function showOrderDetails($records)
    {

        $billing_first_name = $records['billing_address']['first_name'] != '' ? $records['billing_address']['first_name'] : $records['customer']['first_name'];
        $billing_last_name = $records['billing_address']['last_name'] != '' ? $records['billing_address']['last_name'] : $records['customer']['last_name'];
        $billing_address_1 = $records['billing_address']['address1'] != '' ? $records['billing_address']['address1'] : $records['customer']['default_address']['address1'];
        $billing_address_2 = $records['billing_address']['address1'] != '' ? $records['billing_address']['address2'] : $records['customer']['default_address']['address2'];
        $billing_zip = $records['billing_address']['address1'] != '' ? $records['billing_address']['zip'] : $records['customer']['default_address']['zip'];
        $billing_city = $records['billing_address']['city'] != '' ? $records['billing_address']['city'] : $records['customer']['default_address']['city'];
        $billing_country = $records['billing_address']['country_code'] != '' ? $records['billing_address']['country_code'] : $records['customer']['default_address']['country_code'];
        $billing_state = $records['billing_address']['province_code'] != '' ? $records['billing_address']['province_code'] : $records['customer']['default_address']['province_code'];

        $shipping_first_name = $records['shipping_address']['first_name'] != '' ? $records['shipping_address']['first_name'] : $records['customer']['first_name'];
        $shipping_last_name = $records['shipping_address']['last_name'] != '' ? $records['shipping_address']['last_name'] : $records['customer']['last_name'];
        $shipping_address_1 = $records['shipping_address']['address1'] != '' ? $records['shipping_address']['address1'] : $records['customer']['default_address']['address1'];
        $shipping_address_2 = $records['shipping_address']['address1'] != '' ? $records['shipping_address']['address2'] : $records['customer']['default_address']['address2'];
        $shipping_zip = $records['shipping_address']['address1'] != '' ? $records['shipping_address']['zip'] : $records['customer']['default_address']['zip'];
        $shipping_city = $records['shipping_address']['city'] != '' ? $records['shipping_address']['city'] : $records['customer']['default_address']['city'];
        $shipping_country = $records['shipping_address']['country_code'] != '' ? $records['shipping_address']['country_code'] : $records['customer']['default_address']['country_code'];
        $shipping_state = $records['shipping_address']['province_code'] != '' ? $records['shipping_address']['province_code'] : $records['customer']['default_address']['province_code'];

        $currency = $_SESSION['site_settings']['site_currency'];
        $date = MFormatDate::formatingDate($records['created_at']);
        $fulfillment_status = empty($records['fulfillment_status']) ? __('Unfullfilled') : $records['fulfillment_status'];



        $output = '<div class="">';
        $output .= '<div class="grid grid-cols-2 md:grid-cols-2 gap-5">
            <div class="">
                <h4 class="text-lg font-semibold pb-2">' . __('Billing Address') . '</h4>
                <p class="text-md font-semibold py-2 mb-3">' . __('Payment Status') . ': ' . ucfirst($records['financial_status']) . '</p>
                <p>' . $billing_first_name . ' ' . $billing_last_name . '<br>' . $billing_address_1. ' ' . $billing_address_2 . '<br>' . $billing_zip . ' ' . $billing_city . ' ' . $billing_state . '<br>' . $billing_country . '</p>
            </div>
            <div class="">
                <h4 class="text-lg font-semibold pb-2">' . __('Shipping Address') . '</h4>
                <p class="text-md font-semibold py-2 mb-3">' . __('Fullfillment Status') . ': ' . ucfirst($fulfillment_status) . '</p>
                <p>' . $shipping_first_name . ' ' . $shipping_last_name . '<br>' . $shipping_address_1 . ' ' . $shipping_address_2 . '<br>' . $shipping_zip . ' ' . $shipping_city . ' ' . $shipping_state . '<br>' . $shipping_country . '</p>
            </div>
        </div>';

        $output .= '<div class="grid grid-cols-1 md:grid-cols-1 mt-4">
            <h3 class="class="text-xl font-bold">' . __('Order') . ' #' . htmlspecialchars($records['order_number']) . '</h3><p>' . __('Placed On') . ' ' . $date . '</p>
            <table id="responsive-table" class="responsive-table mt-4">
                <thead>
                    <tr>
                        <th style="width:25%">' . __('Product') . '</th>
                        <th style="width:25%">' . __('SKU') . '</th>
                        <th style="width:25%">' . __('Price') . '</th>
                        <th style="width:25%">' . __('Quantity') . '</th>
                        <th style="width:25%">' . __('Total') . '</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($records['line_items'] as $item) {
            $output .= '<tr class="responsive-table__row">
                <td data-label="Product" class="text-center">' . htmlspecialchars($item['title']) . '</td>
                <td data-label="SKU" class="text-center">' . htmlspecialchars($item['sku']) . '</td>
                <td data-label="Price" class="text-center">' . htmlspecialchars($item['price']) . '</td>
                <td data-label="Quantity" class="text-center">' . (int)$item['quantity'] . '</td>
                <td data-label="Total" class="text-center">' . ($item['price'] * $item['quantity']) . '</td>
            </tr>';
        }

        $output .= '</tbody>
            <tfoot>
                <tr class="responsive-table__row">
                    <td colspan="4" class="small--hide">' . __('Subtotal') . '</td>
                    <td data-label="Subtotal">' . htmlspecialchars($records['subtotal_price']) . '</td>
                </tr>
                <tr>
                    <td colspan="4" class="small--hide">' . __('Shipping Standard') . '</td>
                    <td data-label="Shipping (' . htmlspecialchars($records['shipping_lines'][0]['title']) . ')">' . htmlspecialchars($records['shipping_lines'][0]['price']) . '</td>
                </tr>
                <tr>
                    <td colspan="4" class="small--hide">' . __('Tax') . ' (IGST 18.0%)</td>
                    <td data-label="Tax (' . htmlspecialchars($records['tax_lines'][0]['title']) . ' ' . htmlspecialchars($records['tax_lines'][0]['rate']) . '%)">' . htmlspecialchars($records['tax_lines'][0]['price']) . '</td>
                </tr>
                <tr>
                    <td colspan="4" class="small--hide"><strong>' . __('Total') . '</strong></td>
                    <td data-label="Total"><strong>' . $currency . '' . htmlspecialchars($records['total_price']) . '</strong></td>
                </tr>
            </tfoot>
        </table>
        </div>';

        echo $output;
    }
}
