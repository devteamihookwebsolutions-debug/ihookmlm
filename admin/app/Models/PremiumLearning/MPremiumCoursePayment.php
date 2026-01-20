<?php

/**
 * This class contains public functions related to MPremiumCoursePayment
 *
 * @package         MPremiumCoursePayment
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\PremiumLearning;

use Admin\App\Display\PremiumLearning\DPremiumCoursePayment;
use Admin\App\Models\MemberArea\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MPremiumCoursePayment
{
    // Show course payment
    public function showCoursePayment(Request $request)
    {
        $course_id = $request->query('sub1');
        $lesson_id = $request->query('sub2');

        $records = PaymentHistory::where('paymenthistory_type', 'elearning')->get();

        return DPremiumCoursePayment::showCoursePayment($records);
    }

    public function changePaymentStatus(Request $request)
    {
        $course_id = $request->query('sub1');
        $member_id = $request->query('sub2');

        PaymentHistory::where('paymenthistory_member_id', $member_id)
            ->where('course_id', $course_id)
            ->update(['paymenthistory_status' => 'paid']);

        return response()->json(['status' => 'Payment status updated successfully']);
    }

    // Cancel payment
    public function cancelPayment(Request $request)
    {
        $course_id = $request->query('sub1');
        $member_id = $request->query('sub2');

        $deleted = PaymentHistory::where('paymenthistory_member_id', $member_id)
            ->where('course_id', $course_id)
            ->delete();

        if ($deleted) {
            Session::flash('success_message', __('Courses payment canceled successfully'));
        } else {
            Session::flash('error_message', __('No payment record found to cancel'));
        }

        return redirect()->back();
    }
}
