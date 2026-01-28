<?php
/**
 * This class contains public functions related to page builder
 *
 * @package         CPagebuilder
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
class Controller_Lead_CLeadPages
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
    public static function getLeadPageLink(){

        echo  Model\Lead\MLeadPages::getLeadPageLink();
     }
     public static function getPartyLeadPageLink(){

        echo  Model\Lead\MLeadPages::getPartyLeadPageLink();
     }


}
?>
