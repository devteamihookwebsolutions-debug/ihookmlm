<?php

/**
 * This class contains public functions related to MPaymentGatewayDetails
 *
 * @package         MPaymentGatewayDetails
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
                $prefix = config('services.ihook.prefix');

        return DB::table($prefix.'_paymentsettings_table')
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

       public static function getPaymentGatewayDetailss($where = "")
    {
                $prefix = config('services.ihook.prefix');

        $table = $prefix."_paymentsettings_table";

        $sql = "SELECT * FROM $table $where LIMIT 1";

        return collect(DB::select($sql))->first();
    }

    /**
     * Get all payment methods
     */
    public static function getAllPayments()
    {
        return Payment::all();
    }
}
