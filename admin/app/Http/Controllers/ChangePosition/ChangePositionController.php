<?php

/**
 * This class contains public functions related to ChangePositionController
 *
 * @package         ChangePositionController
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

namespace Admin\App\Http\Controllers\CartConfig;
use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\ChangePosition\MChangePosition;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMemberDetails;
use Exception;
class ChangePositionController extends Controller
{

    public static function showChangePosition()
    {   try {
        $members_id                      = $_GET['sub1'];
        $matrix_id                       = $_GET['sub2'];
        $currentsposnor                  = $_GET['sub3'];

        //member list
        $recordsmembersdetails           = MMemberDetails::getUserDetails($members_id);
        $output['members_username']      = $recordsmembersdetails['members_username'];
        $output['viewusers']             = MChangePosition::viewUsers();
        $recordscurrentmembersdetails    = MMemberDetails::getUserDetails($currentsposnor);
        $output['members_email_sponsor'] = $recordscurrentmembersdetails['members_username'];
        $matrixdetails                   = MMatrixDetails::getMatrixDetails($matrix_id);
        $output['matrix_name']           = ucfirst($matrixdetails['matrix_name']);


       return view('changeposition/showchangeposition.html', $output);
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
        }catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location:".$_ENV['BCPATH']."/cartconfig");
                exit();
            }
    }

    public static function updateChangePosition()
    {   try {
        $members_id                 = $_GET['sub1'];
        $matrix_id                  = $_GET['sub2'];
        $change_member_id           = $_POST['change_member_id'];
        $output['change_member_id'] = $_POST['change_member_id'];

        $membersdetails             = MMemberDetails::getUserDetails($members_id);
        $output['members_username'] = $membersdetails['members_username'];
        $matrixdetails              = MMatrixDetails::getMatrixDetails($matrix_id);
        $output['matrix_name']      = ucfirst($matrixdetails['matrix_name']);
        $matrix_type_id             = $matrixdetails['matrix_type_id'];
        if (isset($_POST['preview'])) {

            $output['genealogy'] = MChangePosition::getChangePosition($members_id, $matrix_id, $change_member_id, $matrix_type_id);
            //$output['genealogy'] = 'uploads/genealogydata/previewuser' . $members_id . '' . $matrix_id . '.js';
            return view('changeposition/view_genealogy_changeposition.html', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }
        if (isset($_POST['showchnpomit'])) {
            //Admin Activity Log
            MAdminActivityLog::getAdminActivity('CHANGEPOSITION - Add');
            //Admin Activity Log
           MChangePosition::getChangePosition($members_id, $matrix_id, $change_member_id, $matrix_type_id);
           MChangePosition::updateChangePosition($members_id, $matrix_id, $change_member_id);
            header('Location:' . $_ENV['BCPATH'] . '/usermanager');
            exit();
        }
         }catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location:".$_ENV['BCPATH']."/cartconfig");
                exit();
            }
    }
}
?>
