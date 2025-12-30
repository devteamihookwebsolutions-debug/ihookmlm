<?php

namespace Admin\App\Http\Controllers\PremiumLearning;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Grants\MPrevillage;
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
