<?php

/**
 * This class contains public functions related to MTaxSettings
 *
 * @package         MTaxSettings
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Integrations;
class MTaxSettings
{
	 /**
     * This public static function is used to getTaxSettings
     */
	public static function getTaxSettings($Err)
	{
		$output=array();
		$query = new Bin_Query();
		$sql_site = "SELECT * FROM ".$_ENV['PROMLM_PREFIX']."sitesettings_table WHERE sitesettings_description='taxsettings'";
		if($query->executeQuery($sql_site))
		{
			for($i=0;$i<$query->totrows;$i++)
			{
				$fields[$query->records[$i]['sitesettings_name']] =  $query->records[$i]['sitesettings_value'];
			}
			if(count((array)$Err->messages) > 0)
			{
				$fields = $Err->values;
			}
		}
		return $fields;
	}
	/**
     * This public static function is used to updateTaxSettings
     */
	public static function updateTaxSettings()
	{
		$sql="UPDATE ".$_ENV['PROMLM_PREFIX']."sitesettings_table
						SET sitesettings_value='0'
						WHERE sitesettings_name='tax_status' AND
						sitesettings_description='taxsettings'";
						$obj=new Bin_Query();
						$obj->updateQuery($sql);
		foreach ($_POST as $key => $value)
		{
			if ($key != 'do' && $key != 'submit' && $key != 'action') {
				if($key=='tax_status')
				{
					if($value=='1')
					{
						$value = '1';
					}
					else
					{
						$value = '0';
					}
				}
				$query = new Bin_Query();
				$sql_site = "SELECT * FROM ".$_ENV['PROMLM_PREFIX']."sitesettings_table
				WHERE sitesettings_description='taxsettings'
				AND sitesettings_name='".$key."'";
				if($query->executeQuery($sql_site))
				{
					if($key=='avatax_login_email' || $key=='avatax_login_password'){
						$value = MCryptoGraphy::encryptionDataExt($value);
					}
						$sql="UPDATE ".$_ENV['PROMLM_PREFIX']."sitesettings_table
						SET sitesettings_value='".$value."'
						WHERE sitesettings_name='".$key."' AND
						sitesettings_description='taxsettings'";
						$obj=new Bin_Query();
						$obj->updateQuery($sql);
				}
				else
				{
						foreach ($_POST as $key => $value)
						{
							if($key=='tax_status')
							{
								if($value=='1')
								{
									$value = '1';
								}
								else
								{
									$value = '0';
								}
							}
							if($key=='avatax_login_email' || $key=='avatax_login_password'){
								$value = MCryptoGraphy::encryptionDataExt($value);
							}
							$sql="INSERT INTO ".$_ENV['PROMLM_PREFIX']."sitesettings_table
							(sitesettings_value,sitesettings_name,sitesettings_description)
							VALUES('".$value."','".$key."','taxsettings')";
							$obj=new Bin_Query();
							$obj->updateQuery($sql);
						}
					}
				}
		}
		$_SESSION['success_message'] = __('Tax settings updated successfully');
	}
}
?>
