<?php
    /**
     * This class contains public static functions related to my account
     *
     * @package         CMySite
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

    class Controller_Profile_CMySite extends BaseController
    {
        /**
         * This public static function is used  to constructor of this class
         *
         */
        public function __construct()
        {
            $output = [];
           if (empty($_SESSION['default']['customer_id'])) {
                header("Location:" . $_ENV['FCPATH'] . "/login");
                exit();
            }
            parent::getSiteDetails();
        }
        /**
         * This public static function is used  to update mywebsite details
         * @return HTML data
         */
        public static function updateWebsiteDetails()
        {
            try {
                $user_id  = $_SESSION['default']['customer_id'];
                $meta_key = Model\Profile\MMySite::getWebsiteDetails($user_id);
                Model\Profile\MMySite::updateWebsiteDetails($meta_key);
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location:" . $_ENV['FCPATH'] . "/dashboard");
                exit();
            }
        }

}