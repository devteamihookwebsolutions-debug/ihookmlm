<?php
/**
 * This class contains public static functions related to premier e learning
 *
 * @package         DPremiumLearningLesson
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php

namespace Admin\App\Display\PremiumLearning;

use Admin\App\Models\Middleware\MAmazonCloudFront;
use Admin\App\Models\PremiumLearning\MPremiumCourses;

class DPremiumLearningLesson
{

    public static function getVideoPath($records)
    {
        $courses_topics_id = $_GET['sub2'];
        if (count((array)$records) > 0) {
            $output = '<select aria-label="label" name="video_path1" id="video_path1" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"  '.$select.'>';
            for ($i = 1;$i < count((array)$records);$i++) {
                if ($courses_topics_id == $records[$i]['courses_topics_id']) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="'.$records[$i]['video_path'].','.$records[$i]['video_name'].'"  '.$selected.'>
                ' . $records[$i]['video_name'] . '</option>';
            }
            $output .= '</select>';
        } else {
            $output = '<select aria-label="label" name="video_path1" id="video_path1"
            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
            <option value="">'.__('No data available').'</option>';
            $output .= '</select>';
        }
        return $output;
    }

    public static function showReview($records)
    {
        $id = $_GET['sub1'];
        $course_id      = $id;
        $courses_name = MPremiumCourses::getCourses($id, 'title');
        $totaltitle = MPremiumCourses::getCourses($id, 'totaltitle');
        $output .= '<div class="m-portlet__head border-0">
           <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
                '.$courses_name.'
            </h3>
            </div>
            </div>
        </div>
        <div class="m-portlet__body">';
        for ($i = 0;$i < 1;$i++) {
            $j = $i + 1;
            $video_duration = $records[$i]['video_duration'];
            if ($records[$i]['video_mode'] == 3) {
                $video_path = $records[$i]['video_path'];
            } else {
                $video_path = $records[$i]['video_path'];
                $video_pathlink = MAmazonCloudFront::getCloudFrontUrl($records[$i]['video_path']);
            }

            $subtitle = MPremiumCourses::getCourses($id, 'subtitle'.$j);
            $pdf_url = $records[$i]['doc_path'];
            $pdf_url = MAmazonCloudFront::getCloudFrontUrl($pdf_url);
            $image_path = $records[$i]['image_path'];
            $image_path = MAmazonCloudFront::getCloudFrontUrl($image_path);
            $audio_path = $records[$i]['audio_path'];
            $audio_path = MAmazonCloudFront::getCloudFrontUrl($audio_path);


            $course_id      = $records[0]['course_id'];
            $coursemethod   = MPremiumCourses::getCourses($course_id, 'coursemethod');
            $payment_amount = MPremiumCourses::getCourses($course_id, 'payment_amount');
            $course_status  = MPremiumCourses::getCourses($course_id, 'course_status');
            $title          = MPremiumCourses::getCourses($course_id, 'title');
            $description    = MPremiumCourses::getCourses($course_id, 'description');
            $banner_path    = MPremiumCourses::getCourses($course_id, 'banner_path');
            $banner_path    = MAmazonCloudFront::getCloudFrontUrl($banner_path);
            $img            = $banner_path;

            $sql_check   = "SELECT count(*) as total FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson where course_id = " . $course_id . " AND status = 1";

            $obj_check   = new Bin_Query();
            $obj_check->executeQuery($sql_check);
            $gettotallession        = $obj_check->records[0]['total'];

            $output .= '<div class="col-xl-4 elearn_sec">
                            <div class="my-courses">
                            <div role="presentation" tabindex="-1" class="card card--learning" data-purpose="enrolled-course-card">

                            <div class="card__image play-button-trigger">
                            <img src="' . $img . '" alt="q2">
                            <div class="play-button"></div>
                            </div>
                            <div class="card__details"><strong class="details__name">' . $title . '  </strong>
                            <div class="details__instructor">'.$description.'
                            </div>
                            <div class="details__bottom"><span class="details__progress">';
            $output .= ' </div>
                            </div>
                            </div>
                            </div>
                            </div>';
        }
        $output .= '</div>';
        echo $output;
    }


    public static function viewlinklession($records)
    {


        $id = $_GET['sub1'];
        if (isset($_GET['sub2'])) {
            $courcelessid = 'and id="'.$_GET['sub3'].'"';
        } else {
            $courcelessid = '';
        }


        if ($_GET['sub4'] == '') {

            $courceid = 'And courses_topics_id="'.$_GET['sub2'].'"';

        } else {
            $courceid = '';
        }


        $sql_checksub = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson_path where course_id = '" . $id . "'  " . $courcelessid. " AND course_key = 'video_path'";
        $obj_checksub = new Bin_Query();
        $obj_checksub->executeQuery($sql_checksub);
        $recordsubvideo = $obj_checksub->records;


        $sql_check = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson where course_id = '" . $_GET['sub1'] . "' ".$courceid." AND status = '1'";
        $obj_check = new Bin_Query();
        $obj_check->executeQuery($sql_check);
        $recordvideo = $obj_check->records;

        if ($recordsubvideo != '') {
            $videopath = $recordsubvideo[0]['course_path'];
        } else {
            $videopath = $recordvideo[0]['video_path'];
            $videopath     = MAmazonCloudFront::getCloudFrontUrl($videopath);
        }


        $pdf_url = $records[0]['doc_path'];
        $pdf_url = MAmazonCloudFront::getCloudFrontUrl($pdf_url);
        $image_path = $records[0]['image_path'];
        $image_path = MAmazonCloudFront::getCloudFrontUrl($image_path);
        $audio_path = $records[0]['audio_path'];
        $audio_path = MAmazonCloudFront::getCloudFrontUrl($audio_path);
        $output = '';

        if ($_GET['sub4'] == '1') {
            $output .= '  <audio src="'.$audio_path.'" width="100%" type="audio/mpeg" controls>';
        } elseif ($_GET['sub4'] == '2') {
            $output .= '  <img src="'.$image_path.'" width="100%" height="500">';
        } elseif ($_GET['sub4'] == '3') {
            $output .= '  <iframe src="'.$pdf_url.'"  id="myVideo" width="100%" height="600" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
        } else {
            $output .= '  <iframe src="'.$videopath.'"  id="myVideo" width="100%" height="600" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
        }
        echo  $output;
    }



    public static function viewLession($records)
    {
        $id = $_GET['sub1'];
        $subCourseId = isset($_GET['sub2']) ? $_GET['sub2'] : null;
        $lessonId = isset($_GET['sub3']) ? $_GET['sub3'] : null;
        $contentType = $_GET['sub4'] ?? '';

        $videopath = self::getVideoPathLesson($id, $lessonId);
        $courses_overview = self::getCourseContent($id, 'overview');
        $courses_bookmark = self::getCourseContent($id, 'bookmark');
        $courses_announcements = self::getCourseContent($id, 'announcements');

        $output = '<div class="m-content">';
        $output .= self::generateVideoContent($contentType, $videopath, $records);
        $output .= self::generateTabs($courses_overview, $courses_bookmark, $courses_announcements);
        $output .= '</div>';

        return $output;
    }

    private static function getVideoPathLesson($id, $lessonId)
    {
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson_path WHERE course_id = '$id' AND course_key = 'video_path' AND id = '$lessonId'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        return $obj->records ? MAmazonCloudFront::getCloudFrontUrl($obj->records[0]['course_path']) : '';
    }

    private static function getCourseContent($id, $type)
    {
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson WHERE course_id = '$id' AND status = '1'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $record = $obj->records;
        return $record ? $record[0][$type] : "<div class='empty-view--zero-data-content'>No $type created yet</div>";
    }

    private static function generateVideoContent($contentType, $videopath, $records)
    {
        $output = '';
        $pdf_url = MAmazonCloudFront::getCloudFrontUrl($records[0]['doc_path']);
        $image_path = MAmazonCloudFront::getCloudFrontUrl($records[0]['image_path']);
        $audio_path = MAmazonCloudFront::getCloudFrontUrl($records[0]['audio_path']);

        switch ($contentType) {
            case '1':
                $output .= "<audio src='$audio_path' controls>";
                break;
            case '2':
                $output .= "<img src='$image_path' width='100%' height='500'>";
                break;
            case '3':
                $output .= "<iframe src='$pdf_url' width='100%' height='600' frameborder='0'></iframe>";
                break;
            default:
                $output .= "<iframe src='$videopath' width='100%' height='600' frameborder='0'></iframe>";
                break;
        }

        return $output;
    }

    private static function generateTabs($courses_overview, $courses_bookmark, $courses_announcements)
    {
        return "
            <ul class='nav nav-tabs'>
                <li class='nav-item'><a class='nav-link active' data-toggle='tab' href='#overview'>Overview</a></li>
                <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#bookmark'>Bookmarks</a></li>
                <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#announcements'>Announcements</a></li>
            </ul>
            <div class='tab-content'>
                <div class='tab-pane active' id='overview'>$courses_overview</div>
                <div class='tab-pane' id='bookmark'>$courses_bookmark</div>
                <div class='tab-pane' id='announcements'>$courses_announcements</div>
            </div>
        ";
    }






    public static function showFullReview($records)
    {
        $id = $_GET['sub1'];
        $courcelessid = isset($_GET['sub2']) ? 'AND id="' . $_GET['sub3'] . '"' : '';

        $sql_checksub = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson_path WHERE course_id = '" . $id . "' " . $courcelessid . " AND course_key = 'video_path'";
        $obj_checksub = new Bin_Query();
        $obj_checksub->executeQuery($sql_checksub);
        $recordsubvideo = $obj_checksub->records;

        $sql_check = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson WHERE course_id = '" . $_GET['sub1'] . "' AND status = '1'";
        $obj_check = new Bin_Query();
        $obj_check->executeQuery($sql_check);
        $recordvideo = $obj_check->records;

        $videopath = ($recordsubvideo != '') ? $recordsubvideo[0]['course_path'] : MAmazonCloudFront::getCloudFrontUrl($recordvideo[0]['video_path']);

        $courses_overview = $recordvideo[0]['courses_overview'] ?: '<div class="empty-view--zero-data-content--UHopy"><h2>No bookmarks created yet</h2><p> Add bookmarks while watching lectures to save moments of a course for later. Bookmarks you’ve saved will show up here.</p><p>Hint: Use the keyboard shortcut "b" to create bookmarks while watching video lectures.</p></div>';

        $courses_bookmark = $recordvideo[0]['courses_bookmark'] ?: '<div class="empty-view--zero-data-content--UHopy"><h2>No bookmarks created yet</h2><p> Add bookmarks while watching lectures to save moments of a course for later. Bookmarks you’ve saved will show up here.</p><p>Hint: Use the keyboard shortcut "b" to create bookmarks while watching video lectures.</p></div>';

        $courses_announcements = $recordvideo[0]['courses_announcements'] ?: '<div class="empty-view--zero-data-content--UHopy"><h2>No announcements posted yet</h2><p>The instructor hasn’t added any announcements to this course yet. Announcements are used to inform you of updates or additions to the course.</p></div>';

        $course_id = $records[0]['course_id'];
        $courses_lesson_id = $records[0]['courses_lesson_id'];

        $output = '<div class="m-content">
                        <div class="col-md-12 m-portlet--bordered-semi m-portlet--half-height m-portlet--fit next_rank">
                        <div class="m-portlet__body">
                            <div class="row">
                            <div class="col-xl-7">
                                <div class="video_link">
                                    <iframe src="' . $videopath . '" id="myVideo" width="100%" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                </div>

                                <div class="comment_learn">
                                    <ul class="nav nav-tabs nav-tabs-line mb-5">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
                                                <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                                <span class="nav-text">Overview</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">
                                                <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
                                                <span class="nav-text">Announcements</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content mt-5" id="myTabContent">
                                        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                            <div class="course-overview--grid-row--1nKqQ">' . $courses_overview . '</div>
                                        </div>

                                        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                            <div class="course-overview--grid-row--1nKqQ">' . $courses_announcements . '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-5">
                                <div class="accordion accordion-toggle-arrow sugg_video" id="accordionExample4">';

        $sql_vpath = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson_path WHERE course_id = '" . $id . "' AND course_key = 'video_path' GROUP BY sub_cource_id";
        $obj_vpath = new Bin_Query();
        $obj_vpath->executeQuery($sql_vpath);
        $recordpath = $obj_vpath->records;

        foreach ($recordpath as $i => $path) {
            $sql_vpath1 = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson WHERE course_id = '" . $id . "' AND  courses_topics_id = '" . $path['sub_cource_id'] . "'";
            $obj_vpath1 = new Bin_Query();
            $obj_vpath1->executeQuery($sql_vpath1);
            $recordlession1 = $obj_vpath1->records;

            $j = $i + 1;
            $title = MPremiumCourses::getCourses($course_id, 'subtitle' . $j);

            $output .= '<div class="card">
                            <div class="card-header" id="headingOne4' . $j . '">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne4' . $j . '">
                                    <i class="flaticon2-layers-1"></i> <b>' . ucfirst($title) . '</b> - ' . $recordlession1[0]['video_duration'] . ' min
                                </div>
                            </div>
                            <div id="collapseOne4' . $j . '" class="collapse" data-parent="#accordionExample4">
                                <div class="card-body">
                                    <div class="checkbox-list">';

            $sql_vpath1 = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "premium_courses_lesson_path WHERE course_id = '" . $id . "' AND sub_cource_id='" . $path['sub_cource_id'] . "' AND course_key = 'video_path'";
            $obj_vpath1 = new Bin_Query();
            $obj_vpath1->executeQuery($sql_vpath1);
            $recordvideo = $obj_vpath1->records;

            foreach ($recordvideo as $k => $video) {
                $sno = $k + 1;
                $titlesub = $video['course_title'];
                $titleid = $video['id'];
                $url = '<a href="' . $_ENV['BCPATH'] . '/elearning/showfullreview/' . $id . '/' . $path['sub_cource_id'] . '">' . $sno . '.' . ucfirst($titlesub) . '</a>';

                $output .= '<div class="next_sugg">
                                <label class="checkbox">
                                    <input type="checkbox" onclick="detailview(' . $id . ',' . $video['sub_cource_id'] . ',' . $titleid . ')" checked="checked" />' . $sno . '.' . ucfirst($titlesub) . '
                                    <span></span>
                                </label>
                                <div class="sugg_video">
                                    <i class="far fa-play-circle"></i>
                                </div>
                            </div>';
            }

            $output .= '   </div>
                            </div>
                        </div>
                    </div>';
        }

        $output .= '</div></div></div></div></div>';
        echo $output;
    }



    public static function showCourseFaq($records)
    {
        $id = $_GET['sub1'];
        $course_id      = $id;
        // $courses_name = MPremiumCourses::getCourses($id,'title');
        //$totaltitle = MPremiumCourses::getCourses($id,'totaltitle');


        $output .= '';
        for ($i = 0;$i < count((array)$records);$i++) {

            $faq_question = $records[$i]['faq_question'];
            $faqanswer = $records[$i]['faq_answer'];
            $faqid = $records[$i]['id'];
            $j = $i + 1;
            //  $output.='  <div class="elearn-faq row  ">

            //  <span class="svg-icon svg-icon-primary svg-icon-2x">
            //               <a href="javascript:void(0);"  title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">

            //                                       <h4>Question ('.$j.')</h4>
            //                                   </div>
            //                                   <div class="elearn-curri-form col-xl-12 pb-5">

            //                                       <textarea class="form-control form-control-solid subquest" name="faqquestion'.$j.'" placeholder="Enter FAQ question"  id="faqquestion" rows="7" value="'.$faq_question.'">'.$faq_question.'</textarea>
            //                                   </div>
            //                                   <div class="elearn-curri-form col-xl-12 pb-4">
            //                                       <textarea class="form-control form-control-solid subans" name="faqanswer'.$j.'" placeholder="Enter FAQ Answer"  id="faqanswer" rows="7" value="'.$faqanswer.'">'.$faqanswer.'</textarea>
            //                                   </div>
            //                               </div>';

            $output .= '<div class="mb-5">
                <div class="flex mb-5 justify-between">

                    <h3>Question ('.$j.')</h3>
                    <a href="javascript:void(0);" title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                    </svg></a>
                </div>
                <div class="mb-5">
                    <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subquest" name="faqquestion'.$j.'" placeholder="Enter FAQ question"  id="faqquestion" rows="2" value="'.$faq_question.'">'.$faq_question.'</textarea>
                </div>
                <div class="mb-5">
                    <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subans" name="faqanswer'.$j.'" placeholder="Enter FAQ Answer"  id="faqanswer" rows="3" value="'.$faqanswer.'">'.$faqanswer.'</textarea>
                </div>
            </div>';

        }

        echo $output;

    }


    public static function showSubLession($records)
    {
        $id = $_GET['sub1'];
        $course_id      = $id;
        // $courses_name = MPremiumCourses::getCourses($id,'title');
        //$totaltitle = MPremiumCourses::getCourses($id,'totaltitle');


        $output .= '';
        for ($i = 0;$i < count((array)$records);$i++) {

            $faq_question = $records[$i]['faq_question'];
            $faqanswer = $records[$i]['faq_answer'];
            $faqid = $records[$i]['id'];
            $j = $i + 1;
            $output .= '  <div class="elearn-faq row  ">
                           <span class="svg-icon svg-icon-primary svg-icon-2x">

                          <a href="javascript:void(0);"  title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        </a>


                         </span>  <div class="elearn_head col-xl-12">
                                                  <h4>Question ('.$j.')</h4>
                                              </div>
                                              <div class="elearn-curri-form col-xl-12 pb-5">

                                                  <textarea class="form-control form-control-solid subquest" name="faqquestion'.$j.'" placeholder="Enter FAQ question"  id="faqquestion" rows="7" value="'.$faq_question.'">'.$faq_question.'</textarea>
                                              </div>
                                              <div class="elearn-curri-form col-xl-12 pb-4">
                                                  <textarea class="form-control form-control-solid subans" name="faqanswer'.$j.'" placeholder="Enter FAQ Answer"  id="faqanswer" rows="7" value="'.$faqanswer.'">'.$faqanswer.'</textarea>
                                              </div>
                                          </div>';

        }

        echo $output;

    }

    public static function getFaqLession($records)
    {
        $id = $_GET['sub1'];
        $course_id      = $id;
        $output .= '';
        for ($i = 0;$i < count((array)$records);$i++) {

            $faq_question = $records[$i]['faq_question'];
            $faqanswer = $records[$i]['faq_answer'];
            $faqid = $records[$i]['id'];
            $j = $i + 1;

            $output .= '<div class="mb-5">
            <div class="flex mb-5 justify-between">

                <h3>Question ('.$j.')</h3>
                <a href="javascript:void(0);" title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                </svg></a>
            </div>
            <div class="mb-5">
                <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subquest" name="faqquestion'.$j.'" placeholder="Enter FAQ question"  id="faqquestion" rows="2" value="'.$faq_question.'">'.$faq_question.'</textarea>
            </div>
            <div class="mb-5">
                <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subans" name="faqanswer'.$j.'" placeholder="Enter FAQ Answer"  id="faqanswer" rows="3" value="'.$faqanswer.'">'.$faqanswer.'</textarea>
            </div>
        </div>';

            //              $output.='  <div class="elearn-faq row  ">  <span class="svg-icon svg-icon-primary svg-icon-2x">
            //                           <a href="javascript:void(0);"  title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            //   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            // </svg>
            // </a></span>
            //                                 <div class="elearn_head col-xl-12">
            //                                                   <h4>Question ('.$j.')</h4>
            //                                               </div>
            //                                           <div class="elearn-curri-form col-xl-12 pb-5">

            //                                               <textarea class="form-control form-control-solid subquest" name="faqquestion'.$j.'" placeholder="Enter FAQ question"  id="faqquestion" rows="7" value="'.$faq_question.'">'.$faq_question.'</textarea>
            //                                           </div>
            //                                           <div class="elearn-curri-form col-xl-12 pb-4">
            //                                               <textarea class="form-control form-control-solid subans" name="faqanswer'.$j.'" placeholder="Enter FAQ Answer"  id="faqanswer" rows="7" value="'.$faqanswer.'">'.$faqanswer.'</textarea>
            //                                           </div>
            //                                           </div>';

        }

        echo $output;

    }



    public static function showCourseAddQuiz($records)
    {
        $id = $_GET['sub1'];
        $course_id      = $id;
        // $courses_name = MPremiumCourses::getCourses($id,'title');
        //$totaltitle = MPremiumCourses::getCourses($id,'totaltitle');


        $output .= '';
        for ($i = 0;$i < count((array)$records);$i++) {

            $quiz_question = $records[$i]['quiz_question'];
            $quizanswer = $records[$i]['quiz_answer'];
            $quizid = $records[$i]['id'];
            $j = $i + 1;
            //  $output.='  <div class="elearn-faq row  ">  <span class="svg-icon svg-icon-primary svg-icon-2x">
            //               <a href="javascript:void(0);"  title="Auto Login" onclick="removefaq('.$course_id.','.$quizid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">

            //                     <div class="elearn_head col-xl-12">
            //                                       <h4>Question ('.$j.')</h4>
            //                                   </div>
            //                               <div class="elearn-curri-form col-xl-12 pb-5">

            //                                   <input type="text" class="form-control form-control-solid subquest" name="quizquestion'.$j.'" placeholder="Enter Quiz question"  id="quizquestion" rows="7" value="'.$quiz_question.'">
            //                               </div>
            //                               <div class="elearn-curri-form col-xl-12 pb-4">
            //                                   <textarea class="form-control form-control-solid subans" name="quizanswer'.$j.'" placeholder="Enter Quiz Answer"  id="quizanswer" rows="7" value="'.$quizanswer.'">'.$quizanswer.'</textarea>
            //                               </div>
            //                               </div>';
            $output .= '
            <div class="mb-5">
            <div class="flex mb-5 justify-between">

                <h3>Question ('.$j.')</h3>
                <a href="javascript:void(0);" title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                </svg></a>
            </div>

            <div class="mb-5">
                <input type="text" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" name="quizquestion'.$j.'" placeholder="Enter Quiz question"  id="quizquestion" rows="7" value="'.$quiz_question.'">

            </div>
            <div class="mb-5">
                <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subans" name="quizanswer'.$j.'" placeholder="Enter Quiz Answer"  id="quizanswer" rows="7" value="'.$quizanswer.'">'.$quizanswer.'</textarea>
            </div>
            ';

        }

        echo $output;

    }



    public static function getquiz($records)
    {
        $id = $_GET['sub1'];
        $course_id      = $id;
        // $courses_name = MPremiumCourses::getCourses($id,'title');
        //$totaltitle = MPremiumCourses::getCourses($id,'totaltitle');


        $output .= '';
        for ($i = 0;$i < count((array)$records);$i++) {

            $quiz_question = $records[$i]['quiz_question'];
            $quizanswer = $records[$i]['quiz_answer'];
            $quizid = $records[$i]['id'];
            $j = $i + 1;
            $output .= '<div class="mb-5">
          <div class="flex mb-5 justify-between">

              <h3>Question ('.$j.')</h3>
              <a href="javascript:void(0);" title="Auto Login" onclick="removefaq('.$course_id.','.$faqid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
              </svg></a>
          </div>
          <div class="mb-5">
              <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subquest" name="quizquestion'.$j.'" placeholder="Enter Quiz question"  id="quizquestion" rows="2" value="'.$quiz_question.'">'.$quiz_question.'</textarea>
          </div>
          <div class="mb-5">
              <textarea class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400 subans" name="quizanswer'.$j.'" placeholder="Enter Quiz Answer"  id="quizanswer" rows="3" value="'.$quizanswer.'">'.$quizanswer.'</textarea>
          </div>
      </div>';

            //              $output.='  <div class="elearn-faq row  ">  <span class="svg-icon svg-icon-primary svg-icon-2x">
            //                           <a href="javascript:void(0);"  title="Auto Login" onclick="removefaq('.$course_id.','.$quizid.');"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            //   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            // </svg>
            // </a></span>
            //                                 <div class="elearn_head col-xl-12">
            //                                                   <h4>Question ('.$j.')</h4>
            //                                               </div>
            //                                           <div class="elearn-curri-form col-xl-12 pb-5">

            //                                               <input type="text" class="form-control form-control-solid subquest" name="quizquestion'.$j.'" placeholder="Enter Quiz question"  id="quizquestion" rows="7" value="'.$quiz_question.'">
            //                                           </div>
            //                                           <div class="elearn-curri-form col-xl-12 pb-4">
            //                                               <textarea class="form-control form-control-solid subans" name="quizanswer'.$j.'" placeholder="Enter Quiz Answer"  id="quizanswer" rows="7" value="'.$quizanswer.'">'.$quizanswer.'</textarea>
            //                                           </div>
            //                                           </div>';

        }

        echo $output;

    }

}
?>
