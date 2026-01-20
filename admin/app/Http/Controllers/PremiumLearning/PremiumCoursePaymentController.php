<?php

/**
 * This class contains public functions related to PremiumCoursePaymentController
 *
 * @package         PremiumCoursePaymentController
 * @category        Controller
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
