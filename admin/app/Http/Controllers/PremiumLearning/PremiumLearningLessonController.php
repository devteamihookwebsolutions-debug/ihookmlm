<?php

/**
 * This class contains public functions related to PremiumLearningLessonController
 *
 * @package         PremiumLearningLessonController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\PremiumLearning;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MAmazonCloudFront;
use Admin\App\Models\Middleware\MMatrixList;
use Admin\App\Models\PremiumLearning\MPremiumCourses;
use Admin\App\Models\PremiumLearning\MPremiumLearningLesson;
use Admin\App\Models\PremiumLearning\MPremiumLearningLessonInsert;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PremiumLearningLessonController extends Controller
{

    public function viewLessonDetails(Request $request)
    {

        try {
            $id = $request->query('sub1');

            $output = [
                'lession'     => MPremiumLearningLesson::getLessionDetails($id),
                'videopath'   => MPremiumLearningLesson::getVideoPath($id),
                'viewlession' => MPremiumLearningLesson::viewLession(),
            ];

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.viewcoursedetails', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.viewlessondetails');
        }
    }

    public function viewLinkLession(Request $request)
    {
        // AJAX endpoint - no auth needed
        try {
            return response(MPremiumLearningLesson::viewlinklession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.viewlinklession');
        }
    }

    public function editELearning(Request $request)
    {


        try {
            $id = $request->query('sub1');

            $matrix_id = MPremiumCourses::getAnnouncement($id, 'matrix_id');

            $output = [
                'title'            => MPremiumCourses::getCourses($id, 'title'),
                'banner_path'      => MPremiumCourses::getCourses($id, 'banner_path'),
                'description'      => MPremiumCourses::getCourses($id, 'description'),
                'totaltitle'       => MPremiumCourses::getCourses($id, 'totaltitle'),
                'payment_amount'   => MPremiumCourses::getCourses($id, 'payment_amount'),
                'course_method'    => MPremiumCourses::getCourses($id, 'coursemethod'),
                'matrixtype'       => MMatrixList::showMatrixList('', $matrix_id, 'matrix_id', 'onchange="showpackgerank(this.value);"'),
                'user_type'        => MPremiumCourses::getAnnouncement($id, 'user_type'),
                'course_status'    => MPremiumCourses::getCourses($id, 'course_status'),
                'announcement'     => MPremiumCourses::getAnnouncement($id, 'announcement') ?? '',
                'price'            => MPremiumCourses::getAnnouncement($id, 'price'),
                'duration'         => MPremiumCourses::getAnnouncement($id, 'duration'),
                'videoduration'    => MPremiumCourses::getAnnouncement($id, 'videoduration'),
                'banner_pathlink'  => MAmazonCloudFront::getCloudFrontUrl(MPremiumCourses::getCourses($id, 'banner_path')),
                'course_id'        => $id,
            ];

            $output['bannerlogo'] = $output['banner_pathlink'];
            $output['banner_pathlink'] = MAmazonCloudFront::getCloudFrontUrl($output['bannerlogo']);

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.editelearningcource', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.editelearning');
        }
    }

    public function showLession(Request $request)
    {
        try {
            // Get course_id from route parameter or query
            $course_id = $request->route('id') ?? $request->query('id');

            if (!$course_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course ID is required'
                ], 400);
            }

            // Generate the lesson HTML using your existing logic
            $html = MPremiumLearningLesson::showLession($course_id);

            return response()->json([
                'success' => true,
                'html'    => $html
            ]);

        } catch (\Exception $e) {
            \Log::error('showLession AJAX error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load lessons. Please try again.'
            ], 500);
        }
    }

    public function editLession()
    {
        // AJAX - no auth
        try {
            return response(MPremiumLearningLesson::editLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.editlession');
        }
    }

    public function addLession(Request $request)
    {


        try {
            $id = $request->query('sub1');
            $sub2 = $request->query('sub2');

            $output['videopath'] = MPremiumLearningLesson::getVideoPath($id);

            $lessonRecords = MPremiumLearningLesson::getLessions($id, $sub2);

            if (
                !empty($lessonRecords) &&
                (!empty($lessonRecords['lesson_description']) ||
                 !empty($lessonRecords['video_path']) ||
                 !empty($lessonRecords['video_name']) ||
                 !empty($lessonRecords['video_duration']) ||
                 !empty($lessonRecords['doc_path']) ||
                 !empty($lessonRecords['doc_name']) ||
                 !empty($lessonRecords['audio_path']) ||
                 !empty($lessonRecords['audio_name']) ||
                 !empty($lessonRecords['image_path']) ||
                 !empty($lessonRecords['image_name']) ||
                 !empty($lessonRecords['courses_content']) ||
                 !empty($lessonRecords['contentimage_path']) ||
                 !empty($lessonRecords['contentimage_name']))
            ) {
                return redirect()->route('admin.elearning.editshowlession', [$id, $sub2, $request->query('sub3')]);
            }

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.addcourselesson', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.addlession');
        }
    }

    public function editShowQuiz(Request $request)
    {
        try {
            $id = $request->query('sub1');
            $lessonid = $request->query('sub2');

            $lession = MPremiumLearningLesson::getLessions($id, $lessonid);

            $output = [
                'videopath'         => MPremiumLearningLesson::getVideoPath($id),
                'countlession'      => MPremiumLearningLesson::getVideototalPath($id, $lessonid),
                'lession'           => $lession,
                'quizdetails'       => MPremiumLearningLesson::getquizdetails($id, $lessonid),
                'contentimage_path' => MAmazonCloudFront::getCloudFrontUrl($lession['contentimage_path'] ?? ''),
                'image_path'        => MAmazonCloudFront::getCloudFrontUrl($lession['image_path'] ?? ''),
            ];

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.editquiz', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.editshowquiz');
        }
    }

    public function editShowLession(Request $request)
    {


        try {
            $id = $request->query('sub1');
            $lessonid = $request->query('sub2');

            $lession = MPremiumLearningLesson::getLessions($id, $lessonid);

            $output = [
                'videopath'         => MPremiumLearningLesson::getVideoPath($id),
                'lession'           => $lession,
                'video_path'        => MAmazonCloudFront::getCloudFrontUrl($lession['video_path'] ?? ''),
                'doc_path'          => MAmazonCloudFront::getCloudFrontUrl($lession['doc_path'] ?? ''),
                'audio_path'        => MAmazonCloudFront::getCloudFrontUrl($lession['audio_path'] ?? ''),
                'image_path'        => MAmazonCloudFront::getCloudFrontUrl($lession['image_path'] ?? ''),
                'countlession'      => MPremiumLearningLesson::getVideototalPath($id, $lessonid),
                'contentimage_path' => MAmazonCloudFront::getCloudFrontUrl($lession['contentimage_path'] ?? ''),
            ];

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.editcourcelession', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.editshowlession');
        }
    }

    public function insertLession(Request $request)
    {


        try {
            app('App\Models\MPremiumLearningLessonInsert')::insertLession();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertlession');
        }
    }

    public function showReview()
    {
        try {
            MPremiumLearningLesson::showReview();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showreview');
        }
    }

    public function showFullReview()
    {
        try {
            MPremiumLearningLesson::showFullReview();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showfullreview');
        }
    }

    public function showCourseSubTitle()
    {
        // AJAX - no auth
        try {
            return response(MPremiumLearningLesson::showCourseSubTitle());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showfullreview');
        }
    }

    public function insertCourseFaq(Request $request, $course_id = 1)
    {
        $course_id = $course_id
            ?? $request->query('course_id')?? 1;
        if (!$course_id && Session::has('course_id')) {
            $course_id = Session::get('course_id');
            Log::info('FAQ → Course ID retrieved from session', ['course_id' => $course_id]);
        }

        if (is_string($course_id) && str_starts_with(trim($course_id), '{')) {
            $decoded = json_decode($course_id, true);

            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['course_id'])) {
                $course_id = $decoded['course_id'];
            }
        }

        $course_id = (int) $course_id;

        if ($course_id <= 0) {
            Log::warning('FAQ insert → Invalid course_id', ['course_id' => $course_id]);

            return response()->json([
                'success' => false,
                'message' => 'Course ID is missing or invalid. Please save the course first.'
            ], 422);
        }

        $faq_question = trim($request->input('faqvalues', ''));

        if ($faq_question === '') {
            return response()->json([
                'success' => false,
                'message' => 'FAQ question is required'
            ], 422);
        }

        try {
            $insertedId = DB::table(config('services.ihook.prefix', '') . '_premium_courses_faq')
                ->insertGetId([
                    'faq_question' => $faq_question,
                    'faq_answer'   => '',
                    'courses_id'   => $course_id,
                ]);

            return response()->json([
                'success'   => true,
                'message'   => 'FAQ added successfully!',
                'id'        => $insertedId,
                'course_id' => $course_id
            ], 200);

        } catch (\Exception $e) {
            Log::error('FAQ Insert Error', [
                'error' => $e->getMessage(),
                'course_id' => $course_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Database error. Please try again.'
            ], 500);
        }
    }


    public function showCourseFaq(Request $request, $course_id = 1)
    {
            $course_id = $request->query('sub1');

            if (!$course_id && Session::has('course_id')) {
                $course_id = Session::get('course_id');
                Log::info('Course ID retrieved from session', ['course_id' => $course_id]);
            }

            if (!$course_id) {
                Log::warning('No course_id found in query (sub1) or session.');
                return response()->json(['error' => 'Missing course_id. Please create a course first.'], 400);
            }

            Log::info('Using course_id for subcourse update:', ['course_id' => $course_id]);

        try {
            $html = MPremiumLearningLesson::showCourseFaq($request);

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function insertCourseAnsFaq(Request $request, $id)
    {
        $course_id = (int) $id;

        if ($course_id <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid course_id'], 400);
        }

        try {
            DB::beginTransaction();

            $new_questions = $request->input('faq_question', []);
            $new_answers   = $request->input('faq_answer', []);

            $insertData = [];
            foreach ($new_questions as $index => $question) {
                $question = trim($question ?? '');
                $answer   = trim($new_answers[$index] ?? '');
                if ($question !== '' && $answer !== '') {
                    $insertData[] = [
                        'courses_id'   => $course_id,
                        'faq_question' => $question,
                        'faq_answer'   => $answer,
                    ];
                }
            }

            if (!empty($insertData)) {
                DB::table('ihook_premium_courses_faq')->insert($insertData);
            }

            $existing_ids       = $request->input('existing_faq_id', []);
            $existing_questions = $request->input('existing_faq_question', []);
            $existing_answers   = $request->input('existing_faq_answer', []);

            foreach ($existing_ids as $index => $faq_id) {
                $faq_id = (int)$faq_id;
                if ($faq_id <= 0) continue;

                $question = trim($existing_questions[$index] ?? '');
                $answer   = trim($existing_answers[$index] ?? '');

                if ($question !== '' && $answer !== '') {
                    DB::table('ihook_premium_courses_faq')
                        ->where('id', $faq_id)
                        ->where('courses_id', $course_id)
                        ->update([
                            'faq_question' => $question,
                            'faq_answer'   => $answer,
                        ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'FAQs updated successfully!'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('FAQ Save Error', [
                'course_id' => $course_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'FAQ save failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function insertSubCourse(Request $request)
    {
        $response = app(MPremiumLearningLessonInsert::class)
                        ->insertSubCourse($request);

        return response()->json([
            'success' => true,
            'message' => 'Subcourses added successfully!',
            'course_id' => $response
        ], 200);
    }

    public function showSubLession()
    {
        // AJAX
        try {
            return response(MPremiumLearningLesson::showSubLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.login');
        }
    }

    public function addSubLession()
    {
        // AJAX
        try {
            return response(app('App\Models\MPremiumLearningLessonInsert')::addSubLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.addsubtitlelession');
        }
    }

    public function getFaqLession()
    {
        // AJAX
        try {
            return response(MPremiumLearningLesson::getFaqLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.getfaqlession');
        }
    }

    public function deleteFaqLession($course_id, $faq_id)
    {
        $course_id = (int) $course_id;
        $faq_id = (int) $faq_id;

        if ($course_id <= 0 || $faq_id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid course ID or FAQ ID'
            ], 400);
        }

        $deleted = DB::table('ihook_premium_courses_faq')
            ->where('courses_id', $course_id)
            ->where('id', $faq_id)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'FAQ deleted successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'FAQ not found or already deleted.'
            ], 404);
        }
    }


    public function deleteLession()
    {


        try {
            MPremiumLearningLesson::deleteLession();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.deletelession');
        }
    }

    public function insertCoursequiz(Request $request)
    {


        try {
            app('App\Models\MPremiumLearningLessonInsert')::insertCoursequiz();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertquiz');
        }
    }

    public function showCourseAddQuiz()
    {
        // AJAX
        try {
            return response(MPremiumLearningLesson::showCourseAddQuiz());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showaddquiz');
        }
    }

    public function getQuiz()
    {
        // AJAX
        try {
            return response(MPremiumLearningLesson::getquiz());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.getquiz');
        }
    }

    public function updateQuizLession(Request $request)
    {


        try {
            app('App\Models\MPremiumLearningLessonInsert')::Updatequizlession();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.updatequizlession');
        }
    }
}
