<?php

/**
 * This class contains public functions related to social api
 *
 * @package         CSocialLoginApi
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
?><?php
namespace Admin\App\Http\Controllers\Integrations;
use Admin\App\Http\Controllers\Controller;
use Admin\Models\Integrations\MSocialLoginApi;
use Exception;
class SocialLoginApiController extends Controller
{

    public static function updateSocialLoginApi()
    {
        try{

        MSocialLoginApi::updateSocialLoginApi();
        header('Location:' . $_ENV['BCPATH'] . '/integration');
        exit();
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/socialloginapi/update");
            exit();
            }
        }
}
?>
