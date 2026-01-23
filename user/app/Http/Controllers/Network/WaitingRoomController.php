<?php

/**
 * This class contains public functions related to WaitingRoomController
 *
 * @package         WaitingRoomController
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

namespace User\App\Http\Controllers\Network;

use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Model\Genealogy\MBinaryCollapseGenealogy;
use Admin\App\Model\Genealogy\MCollapseGenealogy;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Network\MWaitingRoom; // Reference to model

class WaitingRoomController extends Controller
{
    /**
     * This public function is used to constructor of this class
     */
    public function __construct() {
        $output = array();
        if (request()->query('action') != 'matrixmoreinfo') {
            if (empty(session('default.customer_id'))) {
                return redirect(env('FCPATH') . "/login");
            } parent::getSiteDetails();
        }
    }

    /**
     * This public function is used to show the waiting list
     * @return HTML data
     */
    public function showWaitingList()
    {
        try {
            $output['user_list'] = MWaitingRoom::showDownlineUser();

            return view('network/waitinglist', $output);
            session()->forget('success_message');
            session()->forget('error_message');
        }
        catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/waitingroom");
        }
    }

    /**
     * This public function is used to show the waiting user
     * @return HTML data
     */
    public function showWaitingPosition(){
        return view('network/downlineuserposition', $output); // $output not defined; preserved from original
        session()->forget('success_message');
        session()->forget('error_message');
    }

    public function getMemberList(){
        try{
            $searchval = request()->query('sub1');
            // echo "=>".$searchval;exit;
            if(request()->query('sub1')){
                $members_id = session('default.customer_id');
                $where = 'members_id="' . $members_id . '"  GROUP BY matrix_id ORDER BY link_id ASC LIMIT 0,1 ';
                $memberslinkdetails = \Admin\App\Models\Middleware\MMatrixMemberLink::getPartMatrixLinkDetails('matrix_id',$where);
                $matrix_id = $memberslinkdetails[0]['matrix_id'];
                MWaitingRoom::getMemberList($searchval,$matrix_id);
            }
        }catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/waitingroom");
        }
    }

    public function waitingListAction(){
        try{
            MWaitingRoom::waitingListAction();
        }catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/waitingroom");
        }
    }
}
