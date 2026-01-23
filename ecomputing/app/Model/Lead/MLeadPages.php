<?php
/**
 * This class contains public functions related to page builder
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
namespace Model\Lead;
use Query\Bin_Query;
use Model\Middleware\MAmazonCloudFront;

class MLeadPages
{

    public static function getLeadPageLink(){

        $randomid=$_POST['randomid'];
        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "page_builder_templates WHERE randomid='" . $randomid . "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $category_templates_file_path=$records[0]['category_templates_file_path'];
        $cryptlink=MAmazonCloudFront::getCloudFrontUrl($category_templates_file_path);
        return $cryptlink;

    }
    public static function getPartyLeadPageLink(){

        $randomid=$_POST['randomid'];
        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "party_setup WHERE setup_name='randomid' AND setup_value='" .$randomid. "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $setup_party_id=$records[0]['setup_party_id'];

        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "party_setup WHERE setup_name='category_templates_file_path' AND setup_party_id='" .$setup_party_id. "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $category_templates_file_path=$records[0]['setup_value'];

        $cryptlink=MAmazonCloudFront::getCloudFrontUrl($category_templates_file_path);
        return $cryptlink;

    }
}
?>
