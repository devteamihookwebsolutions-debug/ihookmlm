<?php

namespace Admin\App\Http\Controllers\PremiumLearning;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Middleware\MMatrixList;
use Admin\App\Models\PremiumLearning\MPremiumCourses;
use Admin\App\Models\PremiumLearning\MPremiumInsertCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PremiumCoursesController extends Controller
{
    public function showELearning()
{
    try {
        $output = [
            'show_courses' => MPremiumCourses::getManageCourses(),
            'matrixtype'   => MMatrixList::showMatrixList('', '', 'matrix_id', 'onchange="showpackgerank(this.value);"'),

            'title'            => '',
            'banner_path'      => '',
            'description'      => '',
            'totaltitle'       => '',
            'payment_amount'   => '',
            'course_method'    => '',
            'user_type'        => '1',
            'course_status'    => '1',
            'announcement'     => '',
            'price'            => '',
            'duration'         => '',
            'videoduration'    => '',
            'banner_pathlink'  => asset('assets/img/noimage.png'), // fallback image
            'course_id'        => '',
        ];

        Session::forget(['success_message', 'error_message', 'course_id', 'lession_id']);

        return view('premiumlearning.elearningcource', $output);
    } catch (\Exception $e) {
        Session::flash('error_message', $e->getMessage());
        return redirect()->route('admin.elearning.show');
    }
}

    public function insertCourse(Request $request)
    {
        try {
            MAdminActivityLog::log('COURSES - Add');
            (new MPremiumInsertCourse())->insertCourse($request);
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertcourse');
        }
    }

    public function finalStage()
    {
        try {
            Session::forget(['course_id', 'lession_id']);
            Session::flash('success_message', __('Course added successfully'));
            return redirect()->route('admin.elearning.show');
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.finalstage');
        }
    }

    public function deleteCourse(Request $request)
    {
        try {
            MAdminActivityLog::log('COURSES - Delete');
            MPremiumCourses::deleteCourse($request); // Pass $request

            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.deletecourse');
        }
    }

    public function updateCourses(Request $request)
    {
        try {
            MAdminActivityLog::log('COURSES - Edit');
            MPremiumCourses::updateCourses($request); // Pass $request

            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.updatecourses');
        }
    }

    public function showCourseMaterial(Request $request)
    {
        try {
            return response(MPremiumCourses::showCourseMaterial($request));
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showcoursematerial');
        }
    }

    public function finalEditStage()
    {
        try {
            Session::flash('success_message', __('Course updated successfully'));
            return redirect()->route('admin.elearning.show');
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.finaleditstage');
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            MPremiumCourses::updateStatus($request);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function checkTitle(Request $request)
    {
        try {
            return response(MPremiumCourses::checkTitle($request));
        } catch (\Exception $e) {
            return response('Error', 500);
        }
    }

    public function showAllELearning()
    {
        try {
            $output = [
                'show_courses' => MPremiumCourses::getManageCourses(),
            ];

            Session::forget(['success_message', 'error_message']);

            return view('premiumlearning.managepremiumcourses', $output);
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.showallelearning');
        }
    }

    public function updateEditStatus(Request $request, $sub1)
    {
        try {
            MPremiumCourses::updateEditStatus($request, $sub1);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showSubTitle(Request $request)
    {
        try {
            return response(MPremiumCourses::showSubTitle($request));
        } catch (\Exception $e) {
            return response('Error', 500);
        }
    }

    public function showPakRank(Request $request, $sub1)
    {
        try {
            return response(MPremiumCourses::showPakRank($request, $sub1));
        } catch (\Exception $e) {
            return response('Error', 500);
        }
    }

    public function addAnnouncement(Request $request, $sub1)
    {
        try {
            return response(MPremiumCourses::addAnnouncement($request, $sub1));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function addCourcedetails(Request $request)
    {
        try {
            MPremiumCourses::addCourcedetails($request);
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.insertcourcedetails');
        }
    }

    public function updateQuizLession(Request $request)
    {
        try {
            MPremiumCourses::addCourcedetails($request);
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('admin.elearning.updatequizlession');
        }
    }

}
