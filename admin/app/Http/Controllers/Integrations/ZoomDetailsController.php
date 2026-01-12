<?php

/**
 * This class contains public functions related to TwilioSettings
 *
 * @package         CTwilioSettings  
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php
class Controller_Integrations_CZoomDetails
{
    /**
     * This public function is used  to constructor of this class
     */
    public function __construct()
    {
        $output = array();
        if (empty($_SESSION['admin']['id'])) {
            header('Location:' . $_ENV['BCPATH'] . '/adminlogin');
            exit();
        }
        Model\Grants\MPrevillage::getPrevillage();
    }
    /**
     * This public static function is used to updateTwilioSettings
     */
    public static function updateIntegration()
    {
        try{
        
        
        Model\Integrations\MZoomDetails::updateIntegration();
        header('Location:' . $_ENV['BCPATH'] . '/integration');
        exit();
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/integration/update");
            exit();
         }
        }
}
?>