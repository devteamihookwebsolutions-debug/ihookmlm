<?php
/**
 * This class contains public static functions related PremiumLearningLesson
 *
 * @package         CEvents
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright        Copyright (c) 2017 - 2020, Sunsofty.
 * @version         Version 7.2
 */
/****************************************************************************
    * Licence Agreement:
     *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
    *****************************************************************************/
?>
<?php

namespace Admin\App\Models\PremiumLearning;

use Admin\App\Display\PremiumLearning\DPremiumLearningLesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MPremiumLearningLesson
{
    protected static function table($tableName)
    {
        return DB::table($_ENV['IHOOK_PREFIX'] . $tableName);
    }

    /**
     * Get first lesson details by course_id
     */
    public static function getLessionDetails($id)
    {
        return self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->first();
    }

    /**
     * Get quiz details
     */
    public static function getquizdetails($id, $lessonid)
    {
        return self::table('premium_setting_quiz')
            ->where('course_id', $id)
            ->where('courses_lesson_id', $lessonid)
            ->first();
    }

    /**
     * Get single lesson by course_id and courses_lesson_id
     */
    public static function getLessions($id, $lessonid)
    {
        return self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->where('courses_lesson_id', $lessonid)
            ->first();
    }

    /**
     * Get all lessons for video path processing
     */
    public static function getVideoPath($id)
    {
        $records = self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->get();

        return DPremiumLearningLesson::getVideoPath($records);
    }

    /**
     * View lesson (used in frontend)
     */
    public static function viewLession()
    {
        $id = request()->route('sub1');
        $records = self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->get();

        return DPremiumLearningLesson::viewLession($records);
    }

    public static function viewlinklession()
    {
        $id = request()->route('sub1');
        $records = self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->get();

        return DPremiumLearningLesson::viewlinklession($records);
    }

    /**
     * Main method to display all sections and lessons in edit page
     */
    public static function showLession()
    {
        $id = request()->route('sub1');
        $totaltitels = MPremiumCourses::getCourses($id, 'totaltitle');
        $output = '';

        for ($i = 0; $i < $totaltitels; $i++) {
            $j = $i + 1;
            $key = "subtitle" . $j;
            $subtitle = MPremiumCourses::getCourses($id, $key);

            $subtitleRecord = DB::table($_ENV['IHOOK_PREFIX'] . 'premium_courses')
                ->where('course_id', $id)
                ->where('course_key', $key)
                ->first();

            $subtitle_id = $subtitleRecord?->id ?? 0;

            $lessons = self::table('premium_courses_lesson')
                ->where('courses_topics_id', $subtitle_id)
                ->get();

            if ($lessons->isNotEmpty()) {
                $output .= '<div id="accordion-item-' . $j . '" class="mb-3">
                     <h2>
                        <button type="button"
                           class="flex flex-col items-start w-full p-4 font-medium text-left text-black bg-neutral-100 hover:bg-neutral-200 border border-neutral-200 rounded-lg focus:ring-0 transition-all"
                           data-accordion-target="#accordion-body-' . $j . '" aria-expanded="false" aria-controls="accordion-body-' . $j . '">
                           <div class="flex items-center justify-between w-full">
                                 <span>Section ' . $j . '</span>
                                 <svg class="w-5 h-5 shrink-0 transition-transform" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                       d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z"
                                       clip-rule="evenodd"></path>
                                 </svg>
                           </div>
                           <input placeholder="Section title (required)" id="subtitle' . $i . '" name="subtitle' . $i . '" value="' . $subtitle . '"
                                 class="w-full mt-2 p-2 text-sm text-black dark:text-white bg-white border-2 border-dotted border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all subtitlelession" />
                        </button>
                     </h2>
                     <div id="accordion-body-' . $j . '" class="hidden p-4 border border-t-0 border-neutral-200 rounded-b-xl bg-neutral-50">';

                foreach ($lessons as $lesson) {
                    if ($lesson->cource_type == '1') {
                        $output .= self::renderLessonItem($id, $lesson, 1, 'addlession');
                    } elseif ($lesson->cource_type == '2') {
                        $output .= self::renderLessonItem($id, $lesson, 2, 'quizlession');
                    } elseif ($lesson->cource_type == '3') {
                        $output .= self::renderLessonItem($id, $lesson, 3, 'addlession');
                    }
                }

                $output .= self::renderTabsSection($j, $id, $subtitle_id);
                $output .= '</div></div>';
            } else {
                $output .= self::renderEmptySection($j, $subtitle, $id, $subtitle_id);
            }
        }

        return $output;
    }

    // Helper to render lesson item (to avoid code duplication)
    private static function renderLessonItem($courseId, $lesson, $type, $jsFunction)
    {
        return '<div class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md border my-3">
                    <div class="flex items-center space-x-3">
                        <div class="cursor-grab text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="14" viewBox="0 0 6 14">
                                <path d="M0,0H2V2H0V0ZM4,0H6V2H4V0ZM0,4H2V6H0V4ZM4,4H6V6H4V4ZM4,8H6v2H4V8ZM0,8H2v2H0V8ZM0,4H2V6H0V4ZM4,4H6V6H4V4ZM0,8H2v2H0V8ZM4,8H6v2H4V8Zm0,4H6v2H4V12ZM0,12H2v2H0V12Z"></path>
                            </svg>
                        </div>
                        <div class="text-blue-500">
                            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                            </svg>
                        </div>
                        ' . htmlspecialchars($lesson->lesson_title) . '
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="deletelesson(' . $courseId . ',' . $lesson->courses_lesson_id . ',' . $type . ');"
                            class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-300 dark:bg-red-900 dark:hover:bg-red-800">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                            </svg>
                        </button>
                        <button type="button" onclick="' . $jsFunction . '(' . $courseId . ',' . $lesson->courses_lesson_id . ',' . $type . ');"
                            class="p-2 text-green-600 bg-green-100 rounded-lg hover:bg-green-200 focus:ring-2 focus:ring-green-300 dark:bg-green-900 dark:hover:bg-green-800">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>';
    }

    private static function renderTabsSection($j, $id, $subtitle_id)
    {
        return '
            <ul class="flex flex-wrap gap-2 text-sm font-medium text-center" data-tab-group="tabs-' . $j . '">
                <li><button class="tab-button bg-neutral-100 p-2 px-4 rounded-lg" data-tab="lesson-' . $j . '"> ' . __('Lesson') . ' </button></li>
                <li><button class="tab-button bg-green-100 p-2 px-4 rounded-lg" data-tab="quiz-' . $j . '">' . __('Quiz') . '</button></li>
                <li><button class="tab-button bg-yellow-100 p-2 px-4 rounded-lg hidden" data-tab="assignment-' . $j . '">'. __('Assignment') .'</button></li>
            </ul>
            <div id="tabs-' . $j . '">
                <div id="lesson-' . $j . '" class="tab-content mt-4 relative w-full">
                    <input type="text" placeholder="Enter Lesson title" class="w-full p-3 text-sm text-black dark:text-white bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all sublessionvalues">
                    <button type="button" onclick="submitLesson(' . $id . ',' . $subtitle_id . ',1);" class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg hover:bg-neutral-800">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"></path>
                        </svg>
                    </button>
                </div>
                <div id="quiz-' . $j . '" class="hidden tab-content mt-4 relative w-full">
                    <input type="text" placeholder="Enter Quiz title" class="w-full p-3 text-sm text-black dark:text-white bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all subquizvalues">
                    <button type="button" onclick="submitLesson(' . $id . ',' . $subtitle_id . ',2);" class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg hover:bg-neutral-800">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"></path>
                        </svg>
                    </button>
                </div>
                <div id="assignment-' . $j . '" class="hidden tab-content mt-4 relative w-full">
                    <input type="text" placeholder="Enter Assignment title" class="w-full p-3 text-sm text-black dark:text-white bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <button type="button" onclick="submitLesson(' . $id . ',' . $subtitle_id . ',3);" class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg hover:bg-neutral-800">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"></path>
                        </svg>
                    </button>
                </div>
            </div>';
    }

    private static function renderEmptySection($j, $subtitle, $id, $subtitle_id)
    {
        return '
            <div id="accordion-item-' . $j . '" class="mb-3 check">
                <h2>
                    <button type="button"
                        class="flex flex-col items-start w-full p-4 font-medium text-left text-black bg-neutral-100 hover:bg-neutral-200 border border-neutral-200 rounded-lg focus:ring-0 transition-all"
                        data-accordion-target="#accordion-body-' . $j . '" aria-expanded="false" aria-controls="accordion-body-' . $j . '">
                        <div class="flex items-center justify-between w-full">
                            <span>Section ' . $j . '</span>
                            <svg class="w-5 h-5 shrink-0 transition-transform" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input placeholder="Section title (required)" id="subtitle' . $j . '" name="subtitle' . $j . '" value="' . $subtitle . '"
                            class="w-full mt-2 p-2 text-sm text-black dark:text-white bg-white border-2 border-dotted border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all subtitlelession" />
                    </button>
                </h2>
                <div id="accordion-body-' . $j . '" class="hidden p-4 border border-t-0 border-neutral-200 rounded-b-xl bg-neutral-50">
                    ' . self::renderTabsSection($j, $id, $subtitle_id) . '
                </div>
            </div>';
    }

    public static function showReview()
    {
        $id = request()->route('sub1');
        $records = self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->get();

        return DPremiumLearningLesson::showReview($records);
    }

    public static function showFullReview()
    {
        $id = request()->route('sub1');
        $records = self::table('premium_courses_lesson')
            ->where('course_id', $id)
            ->get();

        return DPremiumLearningLesson::showFullReview($records);
    }

    public static function getCourseDetails($id, $key)
    {
        return DB::table($_ENV['IHOOK_PREFIX'] . 'premium_courses')
            ->where('course_id', $id)
            ->where('course_key', $key)
            ->value('course_value');
    }

    public static function showCourseSubTitle()
    {
        // Implementation depends on POST data — kept as-is or move to controller later
        // For now, returning empty if needed
        return '';
    }

    public static function getVideototalPath($id, $lessonid)
    {
        return self::table('premium_courses_lesson_path')
            ->where('course_id', $id)
            ->where('sub_cource_id', $lessonid)
            ->where('course_key', 'video_path')
            ->count();
    }

    public static function getcoursesubCourses($id, $key, $i)
    {
        return self::table('premium_courses_lesson_path')
            ->where('course_id', $id)
            ->where('sub_cource_id', $key)
            ->where('course_key', 'video_path')
            ->offset($i)
            ->first();
    }

    public static function showCourseFaq()
    {
        $course_id = request()->route('sub1');
        $records = self::table('premium_courses_faq')
            ->where('courses_id', $course_id)
            ->get();

        return DPremiumLearningLesson::showCourseFaq($records);
    }

    public static function showCourseAddQuiz()
    {
        $course_id = request()->route('sub1');
        $records = self::table('premium_courses_quiz')
            ->where('courses_id', $course_id)
            ->get();

        return DPremiumLearningLesson::showCourseAddQuiz($records);
    }

    public static function showSubLession()
    {
        $course_id = request()->route('sub1');
        $records = DB::table($_ENV['IHOOK_PREFIX'] . 'premium_courses')
            ->where('courses_id', $course_id)
            ->get();

        return DPremiumLearningLesson::showSubLession($records);
    }

    public static function getFaqLession()
    {
        $course_id = request()->route('sub1');
        $records = self::table('premium_courses_faq')
            ->where('courses_id', $course_id)
            ->get();

        return DPremiumLearningLesson::getFaqLession($records);
    }

    public static function deleteFaqLession()
    {
        $course_id = request()->route('sub1');
        $fid = request()->route('sub2');

        self::table('premium_courses_faq')
            ->where('courses_id', $course_id)
            ->where('id', $fid)
            ->delete();

        return redirect($_ENV['BCPATH'] . "/elearning/editelearning/" . $course_id);
    }

    public static function deleteLession()
    {
        $course_id = request()->route('sub1');
        $lessionid = request()->route('sub2');

        self::table('premium_courses_lesson')
            ->where('course_id', $course_id)
            ->where('courses_lesson_id', $lessionid)
            ->delete();

        return redirect($_ENV['BCPATH'] . "/elearning/editelearning/" . $course_id);
    }

    public static function getquiz()
    {
        $course_id = request()->route('sub1');
        $records = self::table('premium_courses_quiz')
            ->where('courses_id', $course_id)
            ->get();

        return DPremiumLearningLesson::getquiz($records);
    }

    public static function deletequiz()
    {
        $course_id = request()->route('sub1');
        $fid = request()->route('sub2');

        self::table('premium_courses_faq')
            ->where('courses_id', $course_id)
            ->where('id', $fid)
            ->delete();

        return redirect($_ENV['BCPATH'] . "/elearning/editelearning/" . $course_id);
    }

    public static function editLession()
    {
        $id = request()->route('sub1');
        $totaltitels = MPremiumCourses::getCourses($id, 'totaltitle');
        $output = '';

        for ($i = 0; $i < $totaltitels; $i++) {
            $j = $i + 1;
            $key = "subtitle" . $j;
            $subtitle = MPremiumCourses::getCourses($id, $key);

            $subtitleRecord = DB::table($_ENV['IHOOK_PREFIX'] . 'premium_courses')
                ->where('course_id', $id)
                ->where('course_key', $key)
                ->first();

            $subtitle_id = $subtitleRecord?->id ?? 0;
            $_SESSION['lession_id'] = $subtitle_id;

            $output .= '<div id="m_repeater_1" class="mt-4">
                           <div class="form-group">
                               <label>' . __('subtitle') . ' ' . $j . '</label>
                               <input type="text" readonly class="form-control form-control-solid form-control-lg m-input" value="' . $subtitle . '">
                               <div class="submiterrors"><a class="col" id="error" style="color:red;"></a></div>
                               <div data-repeater-create="" class="btn btn btn-focus m-btn m-btn--icon" onclick="addlession(' . $id . ',' . $subtitle_id . ');">
                                   <span>
                                      <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                                      </svg>
                                      <span>' . __('Edit') . '</span>
                                   </span>
                               </div>
                           </div>
                       </div>';
        }

        return $output;
    }
}
