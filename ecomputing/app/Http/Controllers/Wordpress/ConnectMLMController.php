<?php

/**
 * This class contains public functions related to ConnectMLMController
 *
 * @package         ConnectMLMController
 * @category        Controller
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
namespace Ecomputing\App\Http\Controllers\Wordpress;

use Ecomputing\App\Http\Controllers\Controller;

use Ecomputing\App\Model\Wordpress\MConnectMLM;
class ConnectMLMController extends Controller
{
	/**
     * This public function is used  to constructor of this class
    */
    public function __construct() {
        $apikey=trim($_SERVER['HTTP_APIKEY']);
       if($apikey!='xUS0VYMyvlpziO3H0tN6xz'){
            echo  "Invalid users"; exit;
        }
    }
    /**
     * This public function is used  to insert connect mlm plugin datas
     *
     */
    public static function wpGetOrders()
    {
		MConnectMLM::wpGetOrders();
    }
	public static function wpGetProduct()
    {
        MConnectMLM::wpGetProduct($_POST);
    }
	public static function wpGetUser()
    {
        MConnectMLM::wpGetUser($_POST);
    }
	public static function wpUserUpdate()
    {
        MConnectMLM::wpUserUpdate($_POST);
    }
	 public static function wpTrashPost()
    {
       MConnectMLM::wpTrashPost($_POST);
    }
     public static function wpProductAddUpdate()
    {
       MConnectMLM::wpProductAddUpdate($_POST);
    }
    public static function wpreFundOrders()
    {
        MConnectMLM::wpreFundOrders();
    }
    public static function wpUpdateOrderVolume()
    {
       MConnectMLM::wpUpdateOrderVolume($_POST);
    }

}

