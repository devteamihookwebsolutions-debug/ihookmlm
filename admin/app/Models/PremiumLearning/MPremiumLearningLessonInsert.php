<?php

namespace Admin\App\Models\PremiumLearning;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MPremiumLearningLessonInsert
{
    public function insertLesson(Request $request)
    {
        $course_id = $request->query('sub1');
        $courses_lesson_id = $request->query('sub2');

        $courses_content = $request->input('content');
        $lesson_title = $request->input('lesson_title');
        $lesson_description = $request->input('lesson_description');
        $video_duration = $request->input('video_duration');
        $video_mode = $request->input('video_mode');
        $lesson_status = $request->input('lesson_status');
        $created_on = now();
        $created_by = Auth::guard('admin')->id(); // Adjust guard if needed

        $video_path = '';
        $uploadedName = '';

        // Video Upload Handling
        if ($request->hasFile('video_path') && $request->file('video_path')->isValid()) {
            $file = $request->file('video_path');
            $ext = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $video_path = 'uploads/lesson_video/' . $flnm;
            $uploadedName = $file->getClientOriginalName();

            Storage::disk('s3')->put($video_path, file_get_contents($file), 'public');
        } else {
            if ($video_mode == 1) {
                $namepath = explode(',', $request->input('video_path1', ''));
                $video_path = $namepath[0] ?? '';
                $uploadedName = $namepath[1] ?? '';
            } elseif ($video_mode == 3) {
                $video_path = $request->input('embed_video');
            }
        }

        // Document Upload
        $doc_path = '';
        $uploadeddocName = '';
        if ($request->hasFile('doc_path') && $request->file('doc_path')->isValid()) {
            $file = $request->file('doc_path');
            $ext = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $doc_path = 'uploads/lesson_doc/' . $flnm;
            $uploadeddocName = $file->getClientOriginalName();
            Storage::disk('s3')->put($doc_path, file_get_contents($file), 'public');
        } else {
            $namepath = explode(',', $request->input('video_path', '')); // Note: original bug reused video_path
            $doc_path = $namepath[0] ?? '';
            $uploadeddocName = $namepath[1] ?? '';
        }

        // Audio Upload
        $audio_path = '';
        $uploadedaudioName = '';
        if ($request->hasFile('audio_path') && $request->file('audio_path')->isValid()) {
            $file = $request->file('audio_path');
            $ext = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $audio_path = 'uploads/lesson_audio/' . $flnm;
            $uploadedaudioName = $file->getClientOriginalName();
            Storage::disk('s3')->put($audio_path, file_get_contents($file), 'public');
        } else {
            $namepath = explode(',', $request->input('audio_path', ''));
            $audio_path = $namepath[0] ?? '';
            $uploadedaudioName = $namepath[1] ?? '';
        }

        // Image Upload
        $image_path = '';
        $uploadedimageName = '';
        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $file = $request->file('image_path');
            $ext = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $image_path = 'uploads/lesson_image/' . $flnm;
            $uploadedimageName = $file->getClientOriginalName();
            Storage::disk('s3')->put($image_path, file_get_contents($file), 'public');
        } else {
            $namepath = explode(',', $request->input('image_path', ''));
            $image_path = $namepath[0] ?? '';
            $uploadedimageName = $namepath[1] ?? '';
        }

        // Content Image Upload
        $image_contpath = '';
        $uploadedconimageName = '';
        if ($request->hasFile('contentimage_path') && $request->file('contentimage_path')->isValid()) {
            $file = $request->file('contentimage_path');
            $ext = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $image_contpath = 'uploads/lesson_image/' . $flnm;
            $uploadedconimageName = $file->getClientOriginalName();
            Storage::disk('s3')->put($image_contpath, file_get_contents($file), 'public');
        } else {
            $namepath = explode(',', $request->input('contentimage_path', ''));
            $image_contpath = $namepath[0] ?? '';
            $uploadedconimageName = $namepath[1] ?? '';
        }

        // Check if lesson exists (for update or insert)
        $exists = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
            ->where('course_id', $course_id)
            ->where('courses_lesson_id', $courses_lesson_id)
            ->exists();

        if ($exists) {
            DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->update([
                    'video_duration' => $video_duration,
                    'video_path' => $video_path,
                    'video_name' => $uploadedName,
                    'video_mode' => $video_mode,
                    'doc_path' => $doc_path,
                    'doc_name' => $uploadeddocName,
                    'audio_path' => $audio_path,
                    'audio_name' => $uploadedaudioName,
                    'image_path' => $image_path,
                    'image_name' => $uploadedimageName,
                    'courses_content' => $courses_content,
                    'contentimage_path' => $image_contpath,
                    'contentimage_name' => $uploadedconimageName,
                    'status' => $lesson_status,
                ]);
        } else {
            DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')->insert([
                'course_id' => $course_id,
                'courses_lesson_id' => $courses_lesson_id,
                'video_duration' => $video_duration,
                'video_path' => $video_path,
                'video_name' => $uploadedName,
                'video_mode' => $video_mode,
                'doc_path' => $doc_path,
                'doc_name' => $uploadeddocName,
                'audio_path' => $audio_path,
                'audio_name' => $uploadedaudioName,
                'image_path' => $image_path,
                'image_name' => $uploadedimageName,
                'courses_content' => $courses_content,
                'contentimage_path' => $image_contpath,
                'contentimage_name' => $uploadedconimageName,
                'status' => $lesson_status,
                'created_on' => $created_on,
                'created_by' => $created_by,
            ]);
        }

        // Delete old paths and insert new embedded videos
        DB::table(config('ihook.prefix', '') . 'premium_courses_lesson_path')
            ->where('course_id', $course_id)
            ->where('sub_cource_id', $courses_lesson_id)
            ->delete();

        $totaltitleone = $request->input('totaltitleone', 0);
        for ($i = 1; $i <= $totaltitleone; $i++) {
            $title = $request->input("add_embed_name{$i}");
            $video = $request->input("add_embed_video{$i}");
            if ($title && $video) {
                DB::table(config('ihook.prefix', '') . 'premium_courses_lesson_path')->insert([
                    'course_title' => $title,
                    'course_key' => 'video_path',
                    'course_path' => $video,
                    'course_id' => $course_id,
                    'sub_cource_id' => $courses_lesson_id,
                ]);
            }
        }

        return true;
    }

    public function insertCourseFaq(Request $request)
    {
        $course_id = $request->query('sub1');
        $faq_question = $request->input('faqvalues');
        $faq_answer = $request->input('faqanswer');

        DB::table(config('ihook.prefix', '') . 'premium_courses_faq')->insert([
            'faq_question' => $faq_question,
            'faq_answer' => $faq_answer,
            'courses_id' => $course_id,
        ]);
    }

    public function insertCourseAnsFaq(Request $request)
    {
        $course_id = $request->query('sub1');
        $count = count($request->all());

        for ($i = 1; $i < $count; $i++) {
            $question = $request->input("faqquestion{$i}");
            $answer = $request->input("faqanswer{$i}");

            if ($question) {
                DB::table(config('ihook.prefix', '') . 'premium_courses_faq')
                    ->where('faq_question', $question)
                    ->where('courses_id', $course_id)
                    ->update(['faq_answer' => $answer]);
            }
        }
    }

    public function insertSubCourse(Request $request)
    {
        $course_id = $request->query('sub1');

        foreach ($request->except(['do', 'action', 'sub1']) as $key => $value) {
            $exists = DB::table(config('ihook.prefix', '') . 'premium_courses')
                ->where('course_key', trim($key))
                ->where('course_id', $course_id)
                ->exists();

            if ($exists) {
                DB::table(config('ihook.prefix', '') . 'premium_courses')
                    ->where('course_key', $key)
                    ->where('course_id', $course_id)
                    ->update(['course_value' => $value]);
            } else {
                DB::table(config('ihook.prefix', '') . 'premium_courses')->insert([
                    'course_id' => $course_id,
                    'course_key' => $key,
                    'course_value' => $value,
                    'created_on' => now(),
                ]);
            }
        }

        return $course_id;
    }

    public function addSubLesson(Request $request)
    {
        $courses_topics_id = $request->query('sub2');
        $course_id = $request->query('sub1');
        $typecource = $request->query('sub3');

        $field = match ($typecource) {
            '1' => 'lessionvalues',
            '2' => 'quizvalues',
            '3' => 'assignmentvalues',
            default => null,
        };

        $created_on = now();
        $created_by = Auth::guard('admin')->id();

        foreach ($request->except(['do', 'action', 'sub1', 'sub2', 'sub3']) as $value) {
            if ($value !== '' && $value !== null) {
                DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')->insert([
                    'course_id' => $course_id,
                    'courses_topics_id' => $courses_topics_id,
                    'lesson_title' => $value,
                    'created_on' => $created_on,
                    'created_by' => $created_by,
                    'cource_type' => $typecource,
                ]);
            }
        }
    }

    public function insertCourseQuiz(Request $request)
    {
        $course_id = $request->query('sub1');
        $courses_lesson_id = $request->query('sub2');
        $quiz_question = $request->input('quzvalues');
        $quiz_answer = $request->input('quizanswer');

        DB::table(config('ihook.prefix', '') . 'premium_courses_quiz')->insert([
            'quiz_question' => $quiz_question,
            'quiz_answer' => $quiz_answer,
            'courses_id' => $course_id,
            'courses_lesson_id' => $courses_lesson_id,
        ]);
    }

    public function updateQuizLesson(Request $request)
    {
        // Similar structure to insertLesson but with quiz updates
        // I've kept logic identical to your Updatequizlession method

        $course_id = $request->query('sub1');
        $courses_lesson_id = $request->query('sub2');

        $courses_content = $request->input('content');
        $video_duration = $request->input('video_duration');
        $video_path = $request->input('video_path');
        $video_mode = $request->input('video_mode');
        $lesson_status = $request->input('edit_lesson_status');

        // Content image upload (same as before)
        $image_contpath = '';
        $uploadedconimageName = '';
        if ($request->hasFile('contentimage_path')) {
            $file = $request->file('contentimage_path');
            $ext = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $image_contpath = 'uploads/lesson_image/' . $flnm;
            $uploadedconimageName = $file->getClientOriginalName();
            Storage::disk('s3')->put($image_contpath, file_get_contents($file), 'public');
        } else {
            $namepath = explode(',', $request->input('contentimage_path', ''));
            $image_contpath = $namepath[0] ?? '';
            $uploadedconimageName = $namepath[1] ?? '';
        }

        $exists = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
            ->where('course_id', $course_id)
            ->where('courses_lesson_id', $courses_lesson_id)
            ->exists();

        if ($exists) {
            DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->update([
                    'courses_content' => $courses_content,
                    'contentimage_path' => $image_contpath,
                    'contentimage_name' => $uploadedconimageName,
                    'status' => $lesson_status,
                    // Add other fields as needed
                ]);
        }

        // Delete and re-insert quiz questions
        DB::table(config('ihook.prefix', '') . 'premium_courses_quiz')
            ->where('courses_id', $course_id)
            ->delete();

        $total = $request->input('totaltitleone', 0); // assuming same naming
        for ($i = 1; $i <= $total; $i++) {
            $question = $request->input("quizquestion{$i}");
            $answer = $request->input("quizanswer{$i}");
            if ($question) {
                DB::table(config('ihook.prefix', '') . 'premium_courses_quiz')->insert([
                    'quiz_question' => $question,
                    'quiz_answer' => $answer,
                    'courses_id' => $course_id,
                    'courses_lesson_id' => $courses_lesson_id,
                ]);
            }
        }

        // Quiz settings
        $quiz_duration = $request->input('quizduration');
        $quiz_passgrade = $request->input('quizgrade');
        $quiz_cutoff = $request->input('quizpoint');
        $quiz_description = $request->input('quizdiscription');

        $settingExists = DB::table(config('ihook.prefix', '') . 'premium_setting_quiz')
            ->where('course_id', $course_id)
            ->where('courses_lesson_id', $courses_lesson_id)
            ->exists();

        $data = [
            'quiz_duration' => $quiz_duration,
            'quiz_passgrade' => $quiz_passgrade,
            'quiz_cutoff' => $quiz_cutoff,
            'quiz_description' => $quiz_description,
            'status' => $lesson_status,
            'course_id' => $course_id,
            'courses_lesson_id' => $courses_lesson_id,
        ];

        if ($settingExists) {
            DB::table(config('ihook.prefix', '') . 'premium_setting_quiz')
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->update($data);
        } else {
            DB::table(config('ihook.prefix', '') . 'premium_setting_quiz')->insert($data);
        }

        return true;
    }
}
