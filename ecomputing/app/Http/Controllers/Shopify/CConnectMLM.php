<?php
/**
 * This class contains public functions related to connect mlm for wordpress
 *
 * @package         CConnectMLM
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
?><?php
class Controller_Shopify_CConnectMLM
{

    /**
     * This public function is used  to insert connect mlm plugin datas
     *
     */
    public static function syUserInsert()
    {
        Model\Shopify\MConnectMLM::syUserInsert();
    }
    public static function syOrderInsert()
    {
        Model\Shopify\MConnectMLM::syOrderInsert();
    }
    public static function syProductInsert(){
        Model\Shopify\MConnectMLM::syProductInsert();
    }
    public static function syOrderFulfillment()
    {
        Model\Shopify\MConnectMLM::syOrderFulfillment();
    }
    public static function syUserUpdate()
    {
        Model\Shopify\MUpdateConnectMLM::syUserUpdate();
    }
    public static function syProductUpdate(){
        Model\Shopify\MUpdateConnectMLM::syProductUpdate();
    }
    public static function syProductDelete(){
        Model\Shopify\MUpdateConnectMLM::syProductDelete();
    }
    public static function syOrderUpdate(){
        Model\Shopify\MUpdateConnectMLM::syOrderUpdate();
    }
    public static function syOrderCancel(){
        Model\Shopify\MUpdateConnectMLM::syOrderCancel();
    }

}
?>


