<?php

namespace Admin\App\Http\Controllers\PremiumLearning;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MAmazonCloudFront;
use Admin\App\Models\Middleware\MMatrixList;
use Admin\App\Models\PremiumLearning\MPremiumCourses;
use Admin\App\Models\PremiumLearning\MPremiumLearningLesson;
use Admin\App\Models\PremiumLearning\MPremiumLearningLessonInsert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class PremiumLearningLessonController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login');
            }
            return $next($request);
        });
    }

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
        try {
            $id = $request->query('sub1');
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

            // Repeated CloudFront calls in original - kept logic
            $output['bannerlogo'] = $output['banner_pathlink'];
            $output['banner_pathlink'] = MAmazonCloudFront::getCloudFrontUrl($output['bannerlogo']);

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.editelearningcource', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.editelearning');
        }
    }

    public function showLession()
    {
        try {
            return response(MPremiumLearningLesson::showLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showlession');
        }
    }

    public function editLession()
    {
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

            // If lesson already has content → redirect to edit
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
        try {
            return response(MPremiumLearningLesson::showCourseSubTitle());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showfullreview');
        }
    }

    public function insertCourseFaq(Request $request)
    {
        try {
            app('App\Models\MPremiumLearningLessonInsert')::insertCourseFaq();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertcoursefaq');
        }
    }

    public function showCourseFaq()
    {
        try {
            return response(MPremiumLearningLesson::showCourseFaq());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showcoursefaq');
        }
    }

    public function insertCourseAnsFaq(Request $request)
    {
        try {
            app('App\Models\MPremiumLearningLessonInsert')::insertCourseAnsFaq();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertcourseansfaq');
        }
    }

    public function insertSubCourse(Request $request)
    {
        try {
            // call instance method and pass the request object
            app(MPremiumLearningLessonInsert::class)->insertSubCourse($request);
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertsubcourse');
        }
    }

    public function showSubLession()
    {
        try {
            return response(MPremiumLearningLesson::showSubLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.login');
        }
    }

    public function addSubLession()
    {
        try {
            return response(app('App\Models\MPremiumLearningLessonInsert')::addSubLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.addsubtitlelession');
        }
    }

    public function getFaqLession()
    {
        try {
            return response(MPremiumLearningLesson::getFaqLession());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.getfaqlession');
        }
    }

    public function deleteFaqLession()
    {
        try {
            MPremiumLearningLesson::deleteFaqLession();
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.delete');
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
        try {
            return response(MPremiumLearningLesson::showCourseAddQuiz());
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showaddquiz');
        }
    }

    public function getQuiz()
    {
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
