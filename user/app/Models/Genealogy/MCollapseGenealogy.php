<?php
/**
 * This class contains public static functions related to genealogy
 *
 * @package         MGenealogy
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace User\App\Models\Genealogy;

use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MMemberDetails;
class MCollapseGenealogy
{
     /**
     * This public static function is used  to get collapse genealogy data
     * @param int $members_id
     * @param int $matrix_id
     * @return bool
    */
   public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $userdetails          = MMemberDetails::getPartMembersDetails('members_username',$members_id);
        $members_username     = $userdetails['members_username'];
        $output               = '{ "name" : "' . $members_username . '",';
        $where                = 'spillover_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '"
         ORDER BY position  ASC ';


        $referralslinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $output .= '"children":[';
        if (count((array)$referralslinkdetails) > '0') {
             $cnt=count((array)$referralslinkdetails);
             for ($i=0; $i < $cnt; $i++) {

                $userdetails      = MMemberDetails::getPartMembersDetails('members_username',$referralslinkdetails[$i]['members_id']);
                $members_username = $userdetails['members_username'];
                $count            = 0;
                $output .= '{
                    "name" : "' . $members_username . '","link" :"' . $_ENV['BCPATH'] . '/collapsegenealogy/viewtree/' . $matrix_id . '/' . $referralslinkdetails[$i]['members_id'] . '/' . $referralslinkdetails[$i]['members_id'] . '",';
                $output .= self::getDepthGenelogyDetails($referralslinkdetails[$i]['members_id'], $matrix_id, $count);
                $output .= '},';
            }
        } else {
            $output .= '{"name" :"Empty"}';
        }
        $output .= ']};';
        $output    = 'var treeData=' . $output . '';
	   /*
        $upladfile = fopen("../".$_ENV['CURRENT_UPATH']."/shift/usercoll" . $members_id . "" . $matrix_id . ".js", "w");
        fwrite($upladfile, $output);
        fclose($upladfile);
        start:amazonupload
        $flnm          = '../'.$_ENV['CURRENT_UPATH'].'/shift/usercoll' . $members_id . $matrix_id . ".js";
        $amaname       = 'usercoll' . $members_id . $matrix_id . ".js";
        $genealogyfile = 'uploads/genealogydata/' . $amaname;
        MAmazonS3::amazonFileCreation($flnm, 'text/js', $genealogyfile);
        end:amazonupload*/
        return $output;
    }
    public static function getDepthGenelogyDetails($members_id, $matrix_id,$count)
    {
        if ($count < 6) {
            $where                = 'spillover_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '"
            ORDER BY position ASC ';
            $referralslinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
            if (count((array)$referralslinkdetails) > '0') {
                $output .= '"children":[';

               $cnt=count((array)$referralslinkdetails);
               for ($i=0; $i < $cnt; $i++) {
                    $userdetails      = MMemberDetails::getPartMembersDetails('members_username',$referralslinkdetails[$i]['members_id']);
                    $members_username = $userdetails['members_username'];
                    $count            = $count + 1;
                    $output .= '{
                        "name" : "' . $members_username . '","link" :"' . $_ENV['BCPATH'] . '/collapsegenealogy/viewtree/' . $matrix_id . '/' . $referralslinkdetails[$i]['members_id'] . '/' . $referralslinkdetails[$i]['members_id'] . '",';
                    $output .= self::getDepthGenelogyDetails($referralslinkdetails[$i]['members_id'], $matrix_id, $count);
                    $output .= '},';
                }
                $output .= ']';
            }
            return $output;
        }
    }

}
?>
