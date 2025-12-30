<?php

namespace Admin\App\Models\PremiumLearning;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MPremiumLearningLessonUpdate
{
    public function updateLession(Request $request)
    {
        $course_id        = $request->query('sub1');
        $courses_lesson_id = $request->query('sub2');

        $lesson_title         = $request->input('lesson_title');
        $lesson_description   = $request->input('lesson_description');
        $video_duration       = $request->input('edit_video_duration');
        $video_mode           = $request->input('edit_video_mode');
        $courses_content      = $request->input('content');
        $lesson_status        = $request->input('edit_lesson_status');
        $totaltitleone        = $request->input('totaltitleone', 0);

        $created_by = Auth::guard('admin')->id();

        DB::table(config('ihook.prefix', '') . 'premium_courses_lesson_path')
            ->where('course_id', $course_id)
            ->where('sub_cource_id', $courses_lesson_id)
            ->delete();

        for ($i = 1; $i <= $totaltitleone; $i++) {
            $editembedtitle = $request->input("edit_embed_name{$i}", '');
            $editembedvideo = $request->input("edit_embed_video{$i}", '');

            if ($editembedtitle !== '' || $editembedvideo !== '') {
                DB::table(config('ihook.prefix', '') . 'premium_courses_lesson_path')->insert([
                    'course_title'  => $editembedtitle,
                    'course_key'    => 'video_path',
                    'course_path'   => $editembedvideo,
                    'course_id'     => $course_id,
                    'sub_cource_id' => $courses_lesson_id,
                ]);
            }
        }

        $video_path   = '';
        $uploadedName = '';

        if ($request->hasFile('edit_video_path') && $request->file('edit_video_path')->isValid()) {
            $file = $request->file('edit_video_path');
            $ext  = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;

            $video_path   = 'uploads/lesson_video/' . $flnm;
            $uploadedName = $file->getClientOriginalName();

            Storage::disk('s3')->put($video_path, file_get_contents($file), 'public');
        } else {
            if ($video_mode == 1) {
                $path = $request->input('video_path1', ',');
                [$video_path, $uploadedName] = explode(',', $path . ',');
            } elseif ($video_mode == 3) {
                $video_path = $request->input('edit_embed_video');
                $uploadedName = '';
            } elseif ($video_mode == 2) {
                $old = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                    ->where('course_id', $course_id)
                    ->where('courses_lesson_id', $courses_lesson_id)
                    ->first();

                $video_path   = $old->video_path ?? '';
                $uploadedName = $old->video_name ?? '';
            }
        }

        $doc_path = $uploadeddocName = '';
        if ($request->hasFile('edit_doc_path') && $request->file('edit_doc_path')->isValid()) {
            $file = $request->file('edit_doc_path');
            $ext  = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;

            $doc_path = 'uploads/lesson_doc/' . $flnm;
            $uploadeddocName = $file->getClientOriginalName();
            Storage::disk('s3')->put($doc_path, file_get_contents($file), 'public');
        } else {
            $old = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->first();

            $doc_path = $old->doc_path ?? '';
            $uploadeddocName = $old->doc_name ?? '';
        }

        $audio_path = $uploadedaudioName = '';
        if ($request->hasFile('edit_audio_path') && $request->file('edit_audio_path')->isValid()) {
            $file = $request->file('edit_audio_path');
            $ext  = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;

            $audio_path = 'uploads/lesson_audio/' . $flnm;
            $uploadedaudioName = $file->getClientOriginalName();
            Storage::disk('s3')->put($audio_path, file_get_contents($file), 'public');
        } else {
            $old = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->first();

            $audio_path = $old->audio_path ?? '';
            $uploadedaudioName = $old->audio_name ?? '';
        }

        $image_path = $uploadedimageName = '';
        if ($request->hasFile('edit_image_path') && $request->file('edit_image_path')->isValid()) {
            $file = $request->file('edit_image_path');
            $ext  = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;

            $image_path = 'uploads/lesson_image/' . $flnm;
            $uploadedimageName = $file->getClientOriginalName();
            Storage::disk('s3')->put($image_path, file_get_contents($file), 'public');
        } else {
            $old = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->first();

            $image_path = $old->image_path ?? '';
            $uploadedimageName = $old->image_name ?? '';
        }

        $image_contpath = $uploadedconimageName = '';
        if ($request->hasFile('contentimage_path') && $request->file('contentimage_path')->isValid()) {
            $file = $request->file('contentimage_path');
            $ext  = $file->getClientOriginalExtension();
            $flnm = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;

            $image_contpath = 'uploads/lesson_image/' . $flnm;
            $uploadedconimageName = $file->getClientOriginalName();
            Storage::disk('s3')->put($image_contpath, file_get_contents($file), 'public');
        } else {
            $fallback = $request->input('contentimage_path', ',');
            $parts = explode(',', $fallback . ',');
            $image_contpath = $parts[0] ?? '';

            if (empty($image_contpath)) {
                $old = DB::table(config('ihook.prefix', '') . 'premium_courses_lesson')
                    ->where('course_id', $course_id)
                    ->where('courses_lesson_id', $courses_lesson_id)
                    ->first();
                $image_contpath = $old->contentimage_path ?? '';
                $uploadedconimageName = $old->contentimage_name ?? '';
            }
        }

        $table = config('ihook.prefix', '') . 'premium_courses_lesson';

        $exists = DB::table($table)
            ->where('course_id', $course_id)
            ->where('courses_lesson_id', $courses_lesson_id)
            ->exists();

        $data = [
            'video_duration'      => $video_duration,
            'video_path'          => $video_path,
            'video_name'          => $uploadedName,
            'video_mode'          => $video_mode,
            'doc_path'            => $doc_path,
            'doc_name'            => $uploadeddocName,
            'audio_path'          => $audio_path,
            'audio_name'          => $uploadedaudioName,
            'image_path'          => $image_path,
            'image_name'          => $uploadedimageName,
            'courses_content'     => $courses_content,
            'contentimage_path'   => $image_contpath,
            'contentimage_name'   => $uploadedconimageName,
            'status'              => $lesson_status,
        ];

        if ($exists) {
            DB::table($table)
                ->where('course_id', $course_id)
                ->where('courses_lesson_id', $courses_lesson_id)
                ->update($data);
        } else {
            $data = array_merge($data, [
                'course_id'         => $course_id,
                'courses_lesson_id' => $courses_lesson_id,
                'created_on'        => now(),
                'created_by'        => $created_by,
            ]);
            DB::table($table)->insert($data);
        }

        return response()->json(['success' => true]);
    }
}
