<?php
/**
 * This class contains public static functions related to AddCoursesPremium
 *
 * @package         MPremiumInsertCourse
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\PremiumLearning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
class MPremiumInsertCourse
{

    public function insertCourse(Request $request)
    {
        $bannerimagepath = '';
        $imageCrop = $request->banner;

        /* ---------- Banner Upload ---------- */
        if ($request->hasFile('banner') && $imageCrop == '') {

            $file = $request->file('banner');
            $name = hash('sha256', $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $bannerimagepath = 'uploads/lesson_image/' . $name;

            Storage::disk('s3')->put($bannerimagepath, file_get_contents($file));

        } else {

            if ($imageCrop != '') {
                $imageParts = explode('base64,', $imageCrop);
                $mime = explode('/', explode(';', $imageParts[0])[0])[1];
                $data = base64_decode($imageParts[1]);

                $name = bin2hex(random_bytes(16)) . '.' . $mime;
                $bannerimagepath = 'uploads/lesson_image/' . $name;

                Storage::disk('s3')->put($bannerimagepath, $data);
            } else {
                $bannerimagepath = trim($request->banner);
            }
        }

        /* ---------- Get Next Course ID ---------- */
        $lastCourse = DB::table(env('IHOOK_PREFIX').'premium_courses')
            ->orderByDesc('course_id')
            ->first();

        $courseId = $lastCourse ? $lastCourse->course_id + 1 : 1;

        /* ---------- Insert Course Data ---------- */
        foreach ($request->all() as $key => $value) {
            DB::table(env('IHOOK_PREFIX').'premium_courses')->insert([
                'course_id'    => $courseId,
                'course_key'   => $key,
                'course_value' => $key === 'banner' ? '' : $value,
                'created_on'   => now()
            ]);
        }

        /* ---------- Insert Banner Path ---------- */
        if ($bannerimagepath != '') {
            DB::table(env('IHOOK_PREFIX').'premium_courses')->insert([
                'course_id'    => $courseId,
                'course_key'   => 'banner_path',
                'course_value' => $bannerimagepath,
                'created_on'   => now()
            ]);
        }

        /* ---------- Remove banner key ---------- */
        DB::table(env('IHOOK_PREFIX').'premium_courses')
            ->where('course_key', 'banner')
            ->delete();

        /* ---------- Session ---------- */
        Session::put('course_id', $courseId);

        return response()->json($courseId);
    }

}

