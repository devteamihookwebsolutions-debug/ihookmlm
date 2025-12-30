<?php

namespace Admin\App\Models\Middleware;

use Admin\App\Models\Member\Payment;
use Illuminate\Support\Facades\DB;

class MPaymentGatewayDetails
{
    /**
     * Get payment gateway details by multiple conditions (safe query builder)
     *
     * @param array $conditions Example: ['paymentsettings_name' => 'paypal', 'paymentsettings_status' => 'Active']
     * @return object|null
     */
    public static function getPaymentGatewayDetails(array $conditions = []): ?object
    {
        return DB::table('ihook_paymentsettings_table')
            ->where($conditions)
            ->first();
    }

    /**
     * Legacy method (if still used elsewhere) - returns first active PayPal gateway
     */
    public static function getPayPalGateway(): ?object
    {
        return self::getPaymentGatewayDetails([
            'paymentsettings_name'   => 'paypal',
            'paymentsettings_type'   => 'gateway',
            'paymentsettings_status' => 'Active',
        ]);
    }

    /**
     * Get gateway details by paymentsettings_id
     */
    public static function getPaymentGatewayDetail($paymenthistory_mode)
    {
        return Payment::where('paymentsettings_id', $paymenthistory_mode)->first();
    }

    /**
     * Get all payment methods
     */
    public static function getAllPayments()
    {
        return Payment::all();
    }
}
