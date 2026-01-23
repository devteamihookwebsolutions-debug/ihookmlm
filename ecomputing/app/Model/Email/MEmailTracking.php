<?php
/**
 * This class contains public functions related to email tracking
 *
 * @package         MPagebuilder
 * @category        Model
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
namespace Model\Email;
use Query\Bin_Query;

class MEmailTracking
{

    public function updateEmailStatus(){

        $track_code=$_GET['sub1'];
        $base64url = strtr($track_code, '-_,', '=');
        $track_codedecode           = base64_decode($base64url);
        $trackcodeparse      = explode('SWqh7LvxKqI', $track_codedecode);
        if (count($trackcodeparse)=='2') {
            $track_code=$trackcodeparse[1];
            $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "newsletter_reports_table SET view_status='1' WHERE track_code='" . $track_code . "'";
            $obj = new Bin_Query();
            $obj->updateQuery($sql);
        }else{
            echo "Invalid users";
            exit();
        }


    }

}
?>
