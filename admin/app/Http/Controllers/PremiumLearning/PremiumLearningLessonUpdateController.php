<?php

/**
 * This class contains public functions related to PremiumLearningLessonUpdateController
 *
 * @package         PremiumLearningLessonUpdateController
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
use Admin\App\Models\PremiumLearning\MPremiumLearningLessonUpdate;
use Illuminate\Http\Request;
use Exception;


class PremiumLearningLessonUpdateController extends Controller
{

   public function updateLession(Request $request)
    {
        try {
            $updater = new MPremiumLearningLessonUpdate();
            $updater->updateLession($request);

            return back()->with('success_message', 'Lesson updated successfully');

        } catch (Exception $e) {
            return back()->with('error_message', $e->getMessage());
        }
    }
}
