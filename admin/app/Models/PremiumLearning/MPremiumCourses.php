<?php

namespace Admin\App\Models\PremiumLearning;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Admin\App\Display\PremiumLearning\DPremiumCourses;
use Admin\App\Models\Middleware\MAmazonS3;

class MPremiumCourses extends Model
{
    protected $table;
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    protected $fillable = ['course_key', 'course_value', 'created_on'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ihook.prefix', 'ihook');
        $this->setTable($prefix . '_premium_courses');
    }

    // Delete Course + Lessons
    public function deleteCourse(Request $request)
    {
        $id = $request->query('sub1');
        $prefix = config('ihook.prefix', 'ihook');

        try {
            DB::beginTransaction();

            DB::table($prefix . '_premium_courses')
                ->where('course_id', $id)
                ->delete();

            DB::table($prefix . '_premium_courses_lesson')
                ->where('course_id', $id)
                ->delete();

            DB::commit();

            return redirect('elearning/showallelearning')
                ->with('success_message', __('Course Deleted Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('elearning/showallelearning')
                ->with('error_message', __('Course Not Deleted') . ': ' . $e->getMessage());
        }
    }

    // Update Course (including banner upload)
    public static function updateCourses(Request $request)
    {
        $courseId = $request->input('course_id');
        $bannerPath = $request->input('hidden_banner');
        $prefix = config('ihook.prefix', 'ihook');

        // Handle banner upload
        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {
            $file = $request->file('site_logo');
            $ext = $file->getClientOriginalExtension();
            $filename = hash('sha256', $file->getClientOriginalName()) . '.' . $ext;
            $path = 'uploads/site_logo/' . $filename;

            MAmazonS3::amazonUpload($file->getClientOriginalName(), $file->getPathname(), $file->getMimeType(), $path);
            $bannerPath = $path;
        } elseif ($request->filled('banner')) {
            $imgData = $request->input('banner');
            preg_match('/^data:image\/(png|jpg|jpeg|gif);base64,/', $imgData, $matches);
            $mime = $matches[1] ?? 'png';

            $img = str_replace('data:image/' . $mime . ';base64,', '', $imgData);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $randomName = bin2hex(random_bytes(16)) . '.' . $mime;
            $localPath = storage_path('app/public/shift/' . $randomName);
            file_put_contents($localPath, $data);

            $s3Path = 'uploads/lesson_image/' . $randomName;
            MAmazonS3::amazonFileCreation($localPath, 'image/' . $mime, $s3Path);

            @unlink($localPath);
            $bannerPath = $s3Path;
        }

        if ($bannerPath) {
            DB::table($prefix . '_premium_courses')->updateOrInsert(
                ['course_id' => $courseId, 'course_key' => 'banner_path'],
                ['course_value' => $bannerPath]
            );
        }

        foreach ($request->except(['_token', 'course_id', 'banner', 'site_logo', 'hidden_banner']) as $key => $value) {
            DB::table($prefix . '_premium_courses')->updateOrInsert(
                ['course_id' => $courseId, 'course_key' => $key],
                ['course_value' => $value]
            );
        }

        return redirect($_ENV['BCPATH'] . '/elearning/editelearning/next/' . $courseId);
    }

    // Get single course value
    public static function getCourses($id, $key)
    {
        $prefix = config('ihook.prefix', 'ihook');
        return DB::table($prefix . '_premium_courses')
            ->where('course_id', $id)
            ->where('course_key', $key)
            ->value('course_value');
    }

    // Get all courses for management
    public static function getManageCourses()
    {
        $prefix = config('ihook.prefix', 'ihook');
        $courses = DB::table($prefix . '_premium_courses')
            ->select('course_id')
            ->groupBy('course_id')
            ->get();

        return DPremiumCourses::getManageCourses($courses);
    }

    // Show course material
    public static function showCourseMaterial(Request $request)
    {
        $courseId = $request->query('sub1');
        $lessonId = $request->query('sub2');
        $prefix = config('ihook.prefix', 'ihook');

        $record = DB::table($prefix . '_premium_courses_lesson')
            ->where('course_id', $courseId)
            ->where('courses_lesson_id', $lessonId)
            ->first();

        return DPremiumCourses::showCourseMaterial(collect([$record]));
    }

    // Update status (AJAX)
    public static function updateStatus(Request $request)
    {
        $courseId = session('course_id');
        $prefix = config('ihook.prefix', 'ihook');

        foreach ($request->all() as $key => $value) {
            $value = ($key === 'user_type' || $key === 'course_status') ? ($value ?? '0') : $value;

            DB::table($prefix . '_premium_courses')->updateOrInsert(
                ['course_id' => $courseId, 'course_key' => $key],
                ['course_value' => $value]
            );
        }

        return response()->json(['success' => true]);
    }

    // Show subtitles
    public static function showSubTitle(Request $request)
    {
        $id = $request->input('id');
        $totalLevel = $request->input('totallevel');
        $output = '';

        for ($i = 1; $i <= $totalLevel; $i++) {
            $title = self::getCourses($id, 'subtitle' . $i);
            $output .= '<div class="form-group col-md-6">
                            <label>' . __('subtitle') . $i . '</label>
                            <input type="text" class="form-control form-control-solid form-control-lg"
                                   id="subtitle' . $i . '" name="subtitle' . $i . '" value="' . $title . '" required>
                            <div class="submiterrors"><a class="col" id="error" style="color:red;"></a></div>
                        </div>';
        }

        return $output;
    }

    // Update edit status
    public static function updateEditStatus(Request $request)
    {
        $courseId = $request->query('sub1');
        $prefix = config('ihook.prefix', 'ihook');

        foreach ($request->all() as $key => $value) {
            $value = ($key === 'user_type' || $key === 'course_status') ? ($value ?? '0') : $value;

            DB::table($prefix . '_premium_courses')->updateOrInsert(
                ['course_id' => $courseId, 'course_key' => $key],
                ['course_value' => $value]
            );
        }

        return response()->json(['success' => true]);
    }

    // Check title uniqueness
    public static function checkTitle(Request $request)
    {
        $title = $request->input('title');
        $prefix = config('ihook.prefix', 'ihook');

        $exists = DB::table($prefix . '_premium_courses')
            ->where('course_key', 'title')
            ->where('course_value', $title)
            ->exists();

        return response()->json($exists ? '1' : '0');
    }

    // Add Announcement
    public static function addAnnouncement(Request $request)
    {
        $courseId = $request->query('sub1');
        $prefix = config('ihook.prefix', 'ihook');

        foreach ($request->except('_token') as $key => $value) {
            DB::table($prefix . '_premium_courses_details')->updateOrInsert(
                ['courses_id' => $courseId, 'courses_key' => $key],
                ['courses_values' => $value, 'status' => 1]
            );
        }

        return response()->json('Announcement successfully updated');
    }

    // Add Course Details (clear old except announcement)
    public static function addCourcedetails(Request $request)
    {
        $courseId = $request->input('id');
        $prefix = config('ihook.prefix', 'ihook');

        DB::table($prefix . '_premium_courses_details')
            ->where('courses_id', $courseId)
            ->where('courses_key', '!=', 'announcement')
            ->delete();

        foreach ($request->except(['_token', 'do', 'action', 'id']) as $key => $value) {
            if ($value !== '') {
                DB::table($prefix . '_premium_courses_details')->insert([
                    'courses_id' => $courseId,
                    'courses_key' => $key,
                    'courses_values' => $value,
                    'status' => 1
                ]);
            }
        }

        return true;
    }

public static function getAnnouncement($id, $key)
{
   $prefix = config('ihook.prefix', 'ihook');

    return self::on(config("{$prefix}_premium_courses_details"))
               ->where('courses_id', $id)
               ->where('courses_key', $key)
               ->value('courses_values');
}
}
