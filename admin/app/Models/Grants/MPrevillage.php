<?php
/**
 * This class contains functions related to previllage.
 *
 * @package         MPrevillage
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2017 - 2020, Sunsofty.
 * @version         Version 7.4
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Grants;
use Query\Bin_Query;

use Model\Middleware\MAmazonCloudFront;
use Model\Factories\MSiteSettings;
class MPrevillage
{
    /**
     * This function is used to get sub admin details
     * @return html data
     **/
    public static function getPrevillage()
    {
        //start : for addon side bar hide code
        // $resmenufile=MAmazonCloudFront::getCloudFrontUrl('uploads/allowmenu.txt');
        // $siteaddondetails = file_get_contents($resmenufile);
        // $siteaddondetails = explode(',', $siteaddondetails);
        // foreach ($siteaddondetails as $keyaddonite => $valueaddonsite) {
        //     if (trim($valueaddonsite) == 'sms' || trim($valueaddonsite) == 'shopreplicated' || trim($valueaddonsite) == 'elearning' || trim($valueaddonsite) == 'partyplan' || trim($valueaddonsite) == 'salesfunnel' || trim($valueaddonsite) == 'premiumelearning' || trim($valueaddonsite) == 'socialmediaengine' || trim($valueaddonsite) == 'epin' || trim($valueaddonsite) == 'shopify' || trim($valueaddonsite) == 'ticketcenter' || trim($valueaddonsite) == 'messagecenter' || trim($valueaddonsite) == 'matomoanalytics') {
        //         $_SESSION['addon'][$valueaddonsite] = '1';
        //     }
        // }

        //end : for addon side bar hide code
        // $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "admin_table WHERE admin_id ='" . $_SESSION['admin']['id'] . "'";
        // $qry = new Bin_Query();
        // $qry->executeQuery($sql);
        //  $control = $qry->records[0]['allaccess_control'];
        // if ($control != 1) {
        //     $do     = trim($_GET['do']);
        //     $do     = $_GET['do'];
        //     $action = $_GET['action'];
        //     $sqlpro = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "subadmintablemenu_table where (subadmin_doname='" . $do . "' AND subadmin_action like '%" . $action . "%') or (alloweddo_name like '%" . $do . "%' AND subadmin_action like '%" . $action . "%')  order by subadmin_id DESC";
        //     $qrypro = new Bin_Query();
        //     $qrypro->executeQuery($sqlpro);
        //     $variableid = $qrypro->records[0]['subadmin_id'];
        //      $sqlsub     = "SELECT COUNT(*) AS total FROM " . $_ENV['PROMLM_PREFIX'] . "subadmin_link_table where subadmin_id='" . $_SESSION['admin']['id'] . "' AND FIND_IN_SET('" . $variableid . "',`accesscontrol_id`)";
        //     $qrysub     = new Bin_Query();
        //     $qrysub->executeQuery($sqlsub);
        //     $subadmin = $qrysub->records[0]['total'];
        //     if ($subadmin == 0 && $do != 'adminhome') {
        //         $_SESSION['privilege_message'] = '' . ucfirst($do) . ".";
        //         header("Location:" . $_ENV['BCPATH'] . "/subadminprivilege");
        //         exit();
        //     }
        // }

        return true;
    }
}
?>
