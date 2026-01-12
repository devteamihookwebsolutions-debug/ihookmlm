<?php

/**
 * This class contains public functions related to tax settings
 * @package         CTaxSettings
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
use Admin\App\Models\Integrations\MTaxSettings;
use Exception;
	class TaxSettingsController extends Controller
	{
			public static function showTaxSettings()
		{
			try{



			$output['tax_settings'] = count($Err->messages) ? $Err->values : MTaxSettings::getTaxSettings($Err);

			return view('integrations/avalarathirdparty.html', $output);
			unset($_SESSION['success_message']);
			unset($_SESSION['error_message']);
		}catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/avalara");
                exit();
             }
            }
		/**
		 * This public static function is used to updateTaxSettings
		 */
		public static function updateTaxSettings()
		{
			try{


			Model\Integrations\MTaxSettings::updateTaxSettings();
			header('Location:' . $_ENV['BCPATH'] . '/integration');
			exit();
		}catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/avalara/update");
                exit();
             }
            }
	}
	?>
