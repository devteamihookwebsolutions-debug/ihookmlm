<?php
/**
 * This class contains public static functions related PremiumCoursePayment
 *
 * @package         MPremiumCoursePayment
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: ...
*****************************************************************************/

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
