<?php
/**
 * This class contains public static functions related to integration api.
 *
 * @package         Model_MIntegrationapi
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php

namespace Admin\App\Models\Integrations;

use Admin\App\Display\Integrations\DIntegrations;
use Illuminate\Support\Facades\DB;

class MIntegrations
{
    /**
     * @param string $sub1
     */
    public static function getIntegrationList($sub1 = 'all')
    {
         // Build the query for modules
    $query = DB::table(env('IHOOK_PREFIX') . '_thirdpartyintegration_modules')
        ->where('thirdpartyintegration_modules_default_name', '!=', 'shopify')
        ->where('thirdpartyintegration_modules_default_name', '!=', 'wordpress');

        // Category filter
        if ($sub1 !== 'all' && $sub1 !== '' && is_numeric($sub1)) {
            $query->where('thirdpartyintegration_categories_id', (int) $sub1);
        }

        $records = $query->get();

        $recordscat = DB::table(env('IHOOK_PREFIX') . '_thirdpartyintegration_categories')
            ->where('thirdpartyintegration_categories_status', 1)
            ->where('thirdpartyintegration_categories_default_name', '!=', 'shopping')
            ->get();

        return DIntegrations::getIntegrationList($records, $recordscat);
    }
}
