<?php

namespace App\Models\Network;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Display\Network\DWaitingRoom;
use App\Models\Mongodb\MUpdateCollection; // Assumed path
use App\Models\Mongodb\MTotalDownlineUpdate; // Assumed path
use Admin\App\Models\Middleware\MMatrixDetails;

class MWaitingRoom
{
    /**
     * This public static function is used to get waiting list
     * @return HTML data
     */
    public static function showDownlineUser()
    {
        $user_id  = session('default.customer_id');
        // $sql   = "SELECT b.members_username, b.members_doj, b.members_country,b.members_firstname, b.members_lastname,b.members_email,b.members_id,a.matrix_id FROM " . env('IHOOK_PREFIX') . "matrix_members_link_table AS a LEFT JOIN " . env('IHOOK_PREFIX') . "members_table AS b ON b.members_id = a.members_id WHERE a.direct_id = '" . $user_id . "' AND a.position_status='0' AND spillover_id='0'";
        $sql   = "SELECT b.members_username, b.members_doj, b.members_country,b.members_firstname, b.members_lastname,b.members_email,b.members_id,a.matrix_id FROM " . env('IHOOK_PREFIX') . "matrix_members_link_table AS a LEFT JOIN " . env('IHOOK_PREFIX') . "members_table AS b ON b.members_id = a.members_id WHERE a.direct_id = '" . $user_id . "' AND a.position_status='0' AND spillover_id!='0' AND a.matrix_doj BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
        $records = DB::select($sql);
        return DWaitingRoom::showDownlineUser($records);
    }

    public static function getMemberList($searchval,$matrix_id){
        $matrix_where='AND b.matrix_id='.$matrix_id.' AND spillover_id != 0';
        $members_id = session('default.customer_id');

        $selectedUserId =request()->query('sub2');
        // $wherecondition = ' AND FIND_IN_SET("'.$members_id .'",b.members_parents) OR b.members_id='.$members_id.'';
        $wherecondition = ' AND FIND_IN_SET("'.$members_id .'",b.members_parents) and b.members_id!='.$selectedUserId.'';
        $where=($searchval!='') ? 'WHERE members_username LIKE "' . $searchval . '%" '.$matrix_where.''.$wherecondition.'' :'';
        $sql = "SELECT  a.members_username,a.members_id,b.matrix_id FROM " . env('IHOOK_PREFIX') . "members_table as a LEFT JOIN " . env('IHOOK_PREFIX') . "matrix_members_link_table as b ON a.members_id=b.members_id $where   GROUP BY members_id LIMIT 0,50 ";
        $records = DB::select($sql);
        return DWaitingRoom::getMemberList($records);
    }

    public static function waitingListAction(){
        $members_id              = trim(request('members_id'));
        $matrix_id               = trim(request('matrix_id'));
        $select_position = trim(request('searchbox'));
        $userdetail = explode("_", $select_position);
        $position_str = $userdetail[1];
        $position_mem_id = $userdetail[0];
        $sql_member = "SELECT members_id FROM " . env('IHOOK_PREFIX') . "members_table
        WHERE members_username='".$position_mem_id."'";
        $position_mem_id = DB::select($sql_member)[0]->members_id;
        $position_str = explode("POSITION", $position_str);
        $position = $position_str[1];
        $where= 'members_id="' . $position_mem_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $root 					 = $matrixmemberlinkdetails[0]['root'];
        $members_parents 		 = $matrixmemberlinkdetails[0]['members_parents'];
        $spillover_id 			 =  $matrixmemberlinkdetails[0]['spillover_id'];
        $direct_id 				 =  $matrixmemberlinkdetails[0]['direct_id'];
        $sqlwidth = "SELECT matrix_key,matrix_value FROM  " . env('IHOOK_PREFIX') . "matrix_configuration_table
            WHERE matrix_id  = '" . $matrix_id . "' AND matrix_key='level_width'";
        $level_width = DB::select($sqlwidth)[0]->matrix_value;
        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
        $matrix_type_id = $matrixdetails['matrix_type_id'];
        if($matrix_type_id == '1'){
            $level_width = 2;
        }
        if($spillover_id != 0 || $direct_id == 0){
            $childroot = $root + 1;
            $childrenmembers_parents = $members_parents.",".$position_mem_id;
            $sql = "SELECT count(*) as total FROM " . env('IHOOK_PREFIX') . "matrix_members_link_table WHERE spillover_id='" . $position_mem_id . "' AND position='".$position."'";
            $records = DB::select($sql)[0]->total;
            // echo '----->'.count((array)$records);
            if(empty($records)){
                DB::update("UPDATE " . env('IHOOK_PREFIX') . "matrix_members_link_table SET
                spillover_id='" . $position_mem_id . "',
                root='" . $childroot . "',
                members_parents= '" . $childrenmembers_parents . "',position='".$position."',position_status ='1'
                WHERE members_id='" . $members_id . "'");
                $spillover_id    = $position_mem_id;
                //start update Mongo DB
                $members_id = (int)$members_id;
                $where=['members_id'=>$members_id,'matrix_id'=>$matrix_id];
                $update=['matrix.spillover_id'=>"".$direct_id."",'matrix.members_parents'=>"".$childrenmembers_parents."",'matrix.root'=>"".$childroot.""];
                MUpdateCollection::updateCollection($update,$where,"members");
                MTotalDownlineUpdate::updateTotalDownline($members_id,$matrix_id,$direct_id);
                $filled_sql   = "SELECT b.members_username,b.members_id FROM " . env('IHOOK_PREFIX') . "matrix_members_link_table AS a
                                LEFT JOIN " . env('IHOOK_PREFIX') . "members_table AS b ON b.members_id = a.members_id
                                WHERE a.spillover_id = '" . $position_mem_id . "'";
                $filled_record = DB::select($filled_sql);
                if(!empty($filled_record)){
                    if(count($filled_record)==2){
                        DB::update("UPDATE ".env('IHOOK_PREFIX')."matrix_members_link_table SET
                            members_filled_status ='1' WHERE members_id ='" . $position_mem_id . "'");
                    }
                }
                // echo 'Member Placed Successfully';exit;
                session()->put('success_message', __('Member Placed Successfully'));
                return redirect(env('FCPATH') . "/waitingroom");
            }else{
                // echo 'Position Already Placed';exit;
                session()->put('error_message', __('Position Already Placed'));
                return redirect(env('FCPATH') . "/waitingroom");
            }
        }else{

            // echo 'The placement of this member can only occur in a sequenced manner once your enroller has completed the task of placing you into the organisation.';exit;
            session()->put('error_message', __('The placement of this member can only occur in a sequenced manner once your enroller has completed the task of placing you into the organisation.'));
            return redirect(env('FCPATH') . "/waitingroom");
        }
    }
}
