<?php
/**
 * This class contains public static functions related to Customer manager.
 *
 * @package         Model_MUserManager
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright        Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@alphabettechs.com.
*****************************************************************************/
?>
<?php

namespace Admin\App\Models\CustomerManager;

class MCustomerManager
{
    /**
    * This public static function is used to show users list.
    * @param int matrix_id
    * @return array data
    */
    public static function showCustomerManager()
    {
        $obj = new Bin_Query();
        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customers";
        $obj->executeQuery($sql);
        $records = $obj->records;
        // return DCustomerManager::showCustomerManager($records);

    }
    public static function getCustomerManagerRecords()
    {

        $obj = new Bin_Query();
        $link = $obj->getConnection();

        // Add pagination (example: limit 10 records per page)
        $limit = isset($_GET['perPage']) ? intval($_GET['perPage']) : 10; // Records per page
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $columnIndex = (int)$_GET['columnIndex'];
        $wheres = '';


        $sql = "SELECT *
            FROM " . $_ENV['PROMLM_PREFIX'] . "customers
            LIMIT $offset, $limit";
        $obj->executeQuery($sql);
        $records = $obj->records;

        $sQuery_count = "SELECT COUNT(DISTINCT(customers_id)) as id FROM " . $_ENV['PROMLM_PREFIX'] . "customers";
        $query_count = new Bin_Query();
        $query_count->executeQuery($sQuery_count);
        $iTotal = $query_count->records[0]['id'];

        return DCustomerManager::showCustomerManager($records, $iTotal);
    }


}
?>
