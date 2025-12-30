<?php
/**
 * This class contains public static functions related to dashboard rank slider
 *
 * @package         DDashBoardRankProgress
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace User\App\Display\Dashboard;


use Query\Bin_Query;
use Model\Middleware\MAmazonCloudFront;
use Model\Dashboard\Horizontal\MDashboardRankProgress;

class DDashboardRankProgress
{
    /**
     * This public static function is used  to show the dashboard top selling products
     * @param array $records;
     * @return HTML data
     */

    public static function showRankProgress($rankprogress,$matrix_id,$totalrank,$records2)
    {

        $user_id = $_SESSION['default']['customer_id'];
        $barvalue=0;


        $output.='<div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text text-white">
                                                    '. __('Next Rank Requirements').'
                                                </h3>
                                            </div>
                                        </div>
                                    </div>';
        if ($totalrank>0) {
            $output.='<div class="m-portlet__body">
            <div class="m-widget27 m-portlet-fit--sides">
            <div class="m-widget27__pic">
               <img src="'.$_ENV['UI_ASSET_URL'].'/assets/theme1/img/dashext.jpg" alt="">
               <h3 class="m-widget27__title m--font-light" style="text-align: center;">
                  <span><span>'. __('Rank information for').': '.$rankprogress['user_name'].'</span></span>
               </h3>
               <div class="m-widget27__btn">
               </div>
            </div>
            <div class="m-widget27__container">
            <ul class="m-widget27__nav-items nav nav-pills nav-fill" role="tablist">
               <li class="m-widget27__nav-item nav-item">
                  <a class="nav-link active" data-toggle="pill" href="#m_personal_income_quater_1">'. __('Current').'</a>
               </li>
               <li class="m-widget27__nav-item nav-item">
                  <a class="nav-link" data-toggle="pill" href="#m_personal_income_quater_2">'. __('Last').'</a>
               </li>
               <li class="m-widget27__nav-item nav-item">
                  <a class="nav-link" data-toggle="pill" href="#m_personal_income_quater_3">'. __('Highest').'</a>
               </li>
            </ul>
            <div class="m-widget27__tab tab-content m-widget27--no-padding">
            <div class="tab-pane active" id="m_personal_income_quater_1" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row  align-items-center">
            <div class="col">
            <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="home-tab">
            <div id="carousel-example-multi" class="carousel slide carousel-multi-item v-2" data-ride="carousel">';

            $output .= '
                                <!--Controls-->
                                <div class="controls-top"> <a class="btn-floating" href="#carousel-example-multi" data-slide="prev"><i class="fas fa-chevron-left"></i></a>
                                        <a class="btn-floating" href="#carousel-example-multi" data-slide="next"><i class="fas fa-chevron-right"></i></a>
                                    </div>
                                    <!--/.Controls-->';

            $output .='<div class="carousel-inner v-2" role="listbox">';

            if ($totalrank>0) {
                for ($i=0; $i <$totalrank; $i++) {
                    //carousel start
                    if ($i == 0) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    $rank_id=$records2[$i]['rank_id'];
                    $rank  = MDashboardRankProgress::getRankDetails($matrix_id, $rank_id);

                    $rank_name=$rank['ranktitle'];
                    $condition=MDashboardRankProgress::rankCondition($user_id, $matrix_id, $rank_id);
                    $total_condition=count($condition);
                    $bar_value = 0;
                    for ($z=0; $z <count((array)$condition); $z++) {

                        $bar_value += $condition[10]['bar'];
                    }

                    $percentage=$bar_value/$total_condition;
                    $percent = (int)$percentage ;
                    if ($percent<=0) {
                        $percent=0;
                    } elseif ($percent>100) {
                        $percent=100;
                    }

                    $n = $i+1;
                    $output .= '<div class="carousel-item '.$active.'">
                                            <div class="col-12 col-md-12">
                                                <div class="col-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="circle medium rank'.$n.'" data-fill="'.$percent.'" hour style="--color:#28a745;display:block;"> <span>'.$percent.'% <span class="circle_span" style="display: block; line-height: 0; margin-top: -50px; font-size: 16px;"> '. __('Complete').'</span></span>
                                                                <div class="bar"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 text-center embi_progress">
                                                            <div class="progress progress_rank m-progress--lg">
                                                                <div class="progress-bar progressbar_rank'.$n.'" role="progressbar" style="width: '.$percent.'%; background: #28a745;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$percent.'%</div>
                                                            </div>
                                                            <div class="progress_desc" style="margin-top: 5px">
                                                                <p style="float: left; margin-left: 15px;">'.$rank_name.'</p>

                                                            </div>
                                                            <button type="button" class="btn btn-primary btn_rank" data-toggle="modal" data-target="#rank_modal'.$rank_id.'" >'. __('View Rank Requirement').'</button>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>

                                        </div>';

                    //carousel end
                }
            }

            $output .= ' </div></div>
                </div>

        </div>   </div>
                                </div>

                            <div class="tab-pane fade" id="m_personal_income_quater_2" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row current_rank">
                                    <div class="col-md-12">
                                        <div class="rank_img">
                                          <img src="'.$rankprogress['last_rank_img'].'" alt="rank">
                                        </div>
                                        <h4>'.$rankprogress['last_rank_name'].'</h4>
                                        <div class="current_rank_dec">
                                            <p>'. __('Commission').' : <span>'.$rankprogress['commission'].'</span></p>
                                            <p>'. __('Bonus').' : <span>'.$rankprogress['bonus_period'].'</span></p>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="m_personal_income_quater_3" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row current_rank">
                                    <div class="col-md-12">
                                        <div class="rank_img">
                                          <img src="'.$rankprogress['higher_rank_img'].'" alt="rank">
                                        </div>
                                        <h4>'.$rankprogress['higher_rank_name'].'</h4>
                                        <div class="current_rank_dec">
                                            <p>'. __('First Achieved').' : <span>'.$rankprogress['first_achieved'].'</span></p>
                                            <p>'. __('Last Achieved').' : <span>'.$rankprogress['last_achieved'].'</span></p>
                                        </div>
                                      </div>
                                </div>
                            </div>

 </div>
                <!--begin::Tabs-->

                        <!--end::Tabs-->
                    </div>
                    </div>
                </div>
                    </div>
                </div>';

            for ($i=0; $i <$totalrank; $i++) {
                $rank_id=$records2[$i]['rank_id'];
                $rank  = MDashboardRankProgress::getRankDetails($matrix_id, $rank_id);

                $rank_name=$rank['ranktitle'];
                $condition=MDashboardRankProgress::rankCondition($user_id, $matrix_id, $rank_id);

                $output .= '<div class="modal fade circle_rank_modal" id="rank_modal'.$rank_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">'.$rank_name.'</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row_modal">';

                for ($t=0; $t <count((array)$condition); $t++) {

                    $bar = $condition[10]['bar'];
                    $barvalue=$bar+$barvalue;

                    $output .= '<div class="progress_modal">
                                                <div class="progress_desc" style="margin-bottom: 5px">
                                                    <p style="float: left; margin-left: 10px;">'.$condition[10]['name'].'</p>
                                                    <p style="float: right;">'.(int)$condition[10]['cval'].'/'.(int)$condition[10]['rval'].'</p>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width:'.(int)$condition[10]['bar'].'%"  aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">'.(int)$condition[10]['bar'].'%</div>
                                                </div>
                                            </div>';
                }
                $output .= '</div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }

            $output .= '</div>';
        } else {
			$output .= '<div class="m-portlet__body no_rank_section">
                    <div class="m-widget27 m-portlet-fit--sides">
						 <div class="m-widget27__pic">
							<img src="'.$_ENV['UI_ASSET_URL'].'/assets/theme1/img/dashext.jpg" alt="">
								<h3 class="m-widget27__title m--font-light" style="text-align: center;">'. __('The secret of getting ahead is getting started') .'<br><span class="quote-color">'. __('Mark Twain').'</span></h3>
						</div>
						<div class="m-widget27__container">
							<img src="'.$_ENV['UI_ASSET_URL'].'/assets/theme1/img/rocket.png" alt="">
						</div>
                </div>';
        }

        return $output;
    }

    public static function showranknew($rankprogress,$matrix_id,$totalrank,$recordst,$next_rank){
        $members_id = $_SESSION['default']['customer_id'];
        $sql = "SELECT sum(history_amount) as pv FROM promlm_history_table where history_member_id='". $members_id ."' AND history_type='pv' ";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records[0];
        $pv = $records['pv'];
        $pv = $pv == '' ? "0" : $pv;


        $sql1 = "SELECT sum(history_amount) as gpv FROM promlm_history_table where history_member_id='". $members_id ."' AND history_type='gpv' ";
        $obj1 = new Bin_Query();
        $obj1->executeQuery($sql1);
        $records1 = $obj1->records[0];
        $gpv = $records1['gpv'];

        $gpv = $gpv == '' ? "0" : $gpv;
        //echo $gpv;exit;
    //next rank
      $next_condition=$rankprogress['next_condition'];
      if(count((array)$next_condition)>0){
        $next_rank_bar=$next_condition[10]['bar'];
        $rval=$next_condition[10]['rval'];
      }else{
        $next_rank_bar='0';
        $rval='0';
      }

      $_SESSION['default']['next_rank_bar']=$next_rank_bar;

      if($pv>$rval){
          $required_pv=0;

      }else{
      $required_pv=$rval-$pv;
      }
       //end
       //current rank bar
      $curent_condition=$rankprogress['condition'];
      if($curent_condition!=""){
        $current_rank_bar=$curent_condition[10]['bar'];
      }else{
        $current_rank_bar='0';
      }
      //end
      $_SESSION['default']['current_rank_bar']=$current_rank_bar;
      $_SESSION['default']['next_rank_bar']=$next_rank_bar;
       $current_rankname=$rankprogress['current_rank_name'];
       if($current_rankname==""){
        $current_rankname=$rankprogress['last_rank_name'];
        $current_rank_image=$rankprogress['last_rank_img'];
       }else{
        $current_rank_image=$rankprogress['current_rank_image'];
       }
       $next_rank_name=$rankprogress['next_rank_name'];
       if($next_rank_name==""){
        $next_rank_name=$rankprogress['higher_rank_name'];
        $next_rank_img=$rankprogress['last_rank_img'];
       }else{
        $next_rank_img=$rankprogress['next_rank_image'];
       }
       $required_gpv=0;
        $image='<img src="'.$current_rank_image.'" alt="" class="img-fluid mr-4 w-50px" style="height: 100px;">';
        $image1='<img src="'.$next_rank_img.'" alt="" class="img-fluid mr-4 w-50px" style="height: 100px;">';
        $current_rank_id=$rankprogress['rank_id'];
        $rank_details='';
        $count=count((array)$recordst);
       //  echo"<pre>"; print_r($count);exit;
        for ($i=0; $i <count((array)$recordst); $i++) {
            $rank_id=$recordst[$i]['rank_id'];
            $rank  = MDashboardRankProgress::getRankDetails($matrix_id, $rank_id);
            $rank_name=$rank['ranktitle'];
            $rankimg1=$rank['rankimg'];
            $rankimg= $_ENV['CDNCLOUDEXTURL'].'/'.$rankimg1;
            if($current_rank_id>=$rank_id){
                $classname='rank-unlocked"';
                $style='';
            }else{
                $classname='rank-locked"';
                $style='style="filter: grayscale(1);"';
            }
            $rank_details.='
            <div '.$classname.'>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="lft-side">
                    <div class="d-flex align-items-center">
                        <img src="'.$rankimg.'" alt=""  class="w-50px img-fluid mr-4">
                        <div class="fs-4 text-white">'.$rank_name.'</div>
                    </div>
                    </div>
                    <div class="center-side">
                    <div class="fs-4 text-white"> </div>
                    </div>
                    <div class="rgt-side">
                    <img src="" '.$style.' alt="" class="img-fluid w-25px">
                    </div>
                </div>
            </div>';
        }
        $returnvalue = array(
                'current_rank_name'         => $current_rankname,
                'current_rank_image'     => $image,
                'next_rank_name'     => $next_rank_name,
                'next_rank_image'     =>  $image1,
                'rank_details'     =>  $rank_details,
                'current_percentage'            => $current_rank_bar,
                'next_rank_bar'            => $next_rank_bar,
                'pv'            => $pv,
                'gpv'            => $gpv,
                'required_pv'            => $required_pv,
                'required_gpv'            => $required_gpv,
                'downline_sales'        =>'0'
        );
      //  echo"dddddd";exit;
      return $returnvalue;

    }
}
?>
