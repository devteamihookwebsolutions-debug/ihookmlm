<?php

/**
 * This class contains public functions related to MWebApp
 *
 * @package         MWebApp
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
class MWebApp
{
	 /**
     * This public static function is used to updateWebapp
     */
	public static function updateWebapp()
    {
         if($_POST['webapp_status']=='1')
                            {
                                $value = '1';
                            }
                            else
                            {
                                $value = '0';
                            }
            $query = new Bin_Query();
            $sql_site = "SELECT * FROM ".$_ENV['PROMLM_PREFIX']."sitesettings_table
            WHERE sitesettings_description='webappsettings'
            AND sitesettings_name='webapp_status'";
            if($query->executeQuery($sql_site))
            {
                  $sql="UPDATE ".$_ENV['PROMLM_PREFIX']."sitesettings_table
                    SET sitesettings_value='".$value."'
                    WHERE sitesettings_name='webapp_status' AND
                    sitesettings_description='webappsettings'";
                    $obj=new Bin_Query();
                    $obj->updateQuery($sql);
            }
            else
            {
                        $sql="INSERT INTO ".$_ENV['PROMLM_PREFIX']."sitesettings_table
                        (sitesettings_value,sitesettings_name,sitesettings_description)
                        VALUES('".$value."','webapp_status','webappsettings')";
                        $obj=new Bin_Query();
                        $obj->updateQuery($sql);
            }
        $_SESSION['success_message'] = __('Web app settings has been updated successfully');
    }
}
?>
