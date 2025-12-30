<?php
/**
 * This class contains public static functions related to bonus cron
 *
 * @package         CCommonBonus
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php
use Controller\BaseController;
class Controller_Scheduler_Bonus_CCommonBonus
{
    /**
     * This public static function is used  to bonus cron 
     * @return Void data
    */
    public static function commonBonusCron() {
        Model\Scheduler\Bonus\MCommonBonus::commonBonusCron($_GET['sub1']);
    }
}
?>