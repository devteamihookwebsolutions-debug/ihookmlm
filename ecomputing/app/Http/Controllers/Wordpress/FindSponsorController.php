<?php

/**
 * This class contains public functions related to FindSponsorController
 *
 * @package         FindSponsorController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Ecomputing\App\Http\Controllers\Wordpress;

use Ecomputing\App\Http\Controllers\Controller;
use Ecomputing\App\Model\Wordpress\MFindSponsor;
class FindSponsorController extends Controller
{
	/**
     * This public function is used  to constructor of this class
    */
    public function __construct() {
        $apikey=trim($_SERVER['HTTP_APIKEY']);
        if($apikey!='xUS0VYMyvlpziO3H0tN6xz'){
            echo  "Invalid users"; exit;
        }
    }
    /**
     * This public function is used  to get sponsor list from mlm
     *
     */
    public function getSponsorDetails()
    {
        $findSponsor = new MFindSponsor();
        $findSponsor->getSponsorDetails();
    }

    /**
     * Get sponsor list from MLM
     */
    public function getDistributors()
    {
        $findSponsor = new MFindSponsor();
        echo $findSponsor->getDistributors();
    }

    /**
     * Get sponsor list from MLM based on ZIP
     */
    public function getDistributorsbyZip()
    {
        $findSponsor = new MFindSponsor();
        echo $findSponsor->getDistributorsbyZip();
    }

    /**
     * Get distributor sponsor
     */
    public function getDistribtrSponsor()
    {
        $findSponsor = new MFindSponsor();
        echo $findSponsor->getDistribtrSponsor();
    }

    /**
     * Get member name from MLM
     */
    public function getMembersName()
    {
        $memid = $_GET['sub1'];
        $findSponsor = new MFindSponsor();
        echo $findSponsor->getMembername($memid);
    }

}
?>


