<?php

namespace Admin\App\Http\Controllers\PremiumLearning;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\PremiumLearning\MPremiumCoursePayment;
use Illuminate\Http\Request;                    // ← CORRECT IMPORT

class PremiumCoursePaymentController extends Controller
{
    /**
     * Display the course payment page
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function coursePayment(Request $request)
    {
           $paymentModel = new MPremiumCoursePayment();
            $output['course_payment'] = $paymentModel->showCoursePayment($request);

            return view('premiumlearning.showcoursepayment', $output);

    }

    public function changePaymentStatus(Request $request)
    {
        try {
            $paymentModel = new MPremiumCoursePayment();
            return $paymentModel->changePaymentStatus($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancelPayment(Request $request)
    {
        try {
            $paymentModel = new MPremiumCoursePayment();
            return $paymentModel->cancelPayment($request);
        } catch (\Exception $e) {
            session()->flash('error_message', $e->getMessage());
            return redirect()->back();
        }
    }
}
