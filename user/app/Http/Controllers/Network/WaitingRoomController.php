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
