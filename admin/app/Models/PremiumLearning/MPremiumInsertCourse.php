<?php

/**
 * This class contains public functions related to MPremiumInsertCourse
 *
 * @package         MPremiumInsertCourse
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // <-- Add this

class MPremiumInsertCourse
{
    public function insertCourse(Request $request)
    {
        Log::info('=== Premium Course Insert Started ===');
        Log::info('Request all data:', $request->all());

        $bannerimagepath = '';
        $imageCrop = $request->input('banner');

        Log::info('Raw banner value from request:', ['banner' => substr($imageCrop ?? '', 0, 200)]); // first 200 chars

        /* ---------- Banner Upload ---------- */
        if ($request->hasFile('banner') && empty($imageCrop)) {
            Log::info('Uploading from file input...');

            $file = $request->file('banner');
            $name = hash('sha256', $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $bannerimagepath = 'uploads/lesson_image/' . $name;

            Storage::disk('s3')->put($bannerimagepath, file_get_contents($file));
            Log::info('File uploaded to S3:', ['path' => $bannerimagepath]);
        }
        // Cropped image from Cropper.js (base64)
        elseif (!empty($imageCrop)) {
            Log::info('Processing cropped base64 image...');

            try {
                $imageParts = explode('base64,', $imageCrop);
                if (count($imageParts) !== 2) {
                    Log::error('Invalid base64 image format');
                    throw new \Exception('Invalid cropped image data');
                }

                $mimePart = explode('/', explode(';', $imageParts[0])[0])[1];
                $data = base64_decode($imageParts[1]);

                if ($data === false) {
                    Log::error('base64_decode failed');
                    throw new \Exception('Failed to decode base64 image');
                }

                $name = bin2hex(random_bytes(16)) . '.' . $mimePart;
                $bannerimagepath = 'uploads/lesson_image/' . $name;

                Storage::disk('s3')->put($bannerimagepath, $data);
                Log::info('Cropped image saved to S3:', ['path' => $bannerimagepath]);
            } catch (\Exception $e) {
                Log::error('Banner crop upload failed: ' . $e->getMessage());
                // Continue anyway – banner is optional in some cases
            }
        }
        // No banner at all (fallback)
        else {
            Log::warning('No banner provided (neither file nor cropped image)');
            $bannerimagepath = trim($request->input('banner', ''));
        }
        $prefix = config('services.ihook.prefix');

        /* ---------- Get Next Course ID ---------- */
        try {
            $lastCourse = DB::table($prefix . '_premium_courses')
                ->orderByDesc('course_id')
                ->first();

            $courseId = $lastCourse ? $lastCourse->course_id + 1 : 1;
            Log::info('Generated new course_id:', ['course_id' => $courseId]);
        } catch (\Exception $e) {
            Log::error('Failed to get last course_id: ' . $e->getMessage());
            return response()->json(['error' => 'Database error generating ID'], 500);
        }

        /* ---------- Insert Course Data ---------- */
        $insertedRows = 0;
        try {
            foreach ($request->all() as $key => $value) {
                // Skip files and the banner base64 (we handle banner separately)
                if ($key === '_token' || $key === 'banner') {
                    continue;
                }

                DB::table($prefix . '_premium_courses')->insert([
                    'course_id'    => $courseId,
                    'course_key'   => $key,
                    'course_value' => is_string($value) ? $value : json_encode($value),
                    'created_on'   => now()
                ]);

                $insertedRows++;
                Log::info('Inserted row:', ['key' => $key, 'value_length' => strlen(is_string($value) ? $value : json_encode($value))]);
            }

            Log::info("Total main fields inserted: {$insertedRows}");
        } catch (\Exception $e) {
            Log::error('Failed during main fields insert: ' . $e->getMessage());
            Log::error('Stack trace:', ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Insert failed'], 500);
        }

        /* ---------- Insert Banner Path ---------- */
        if (!empty($bannerimagepath)) {
            try {
                DB::table($prefix . '_premium_courses')->insert([
                    'course_id'    => $courseId,
                    'course_key'   => 'banner_path',
                    'course_value' => $bannerimagepath,
                    'created_on'   => now()
                ]);
                Log::info('Banner path inserted:', ['path' => $bannerimagepath]);
            } catch (\Exception $e) {
                Log::warning('Failed to insert banner_path: ' . $e->getMessage());
            }
        }

        /* ---------- Remove old banner key (if any) ---------- */
        try {
            $deleted = DB::table($prefix . '_premium_courses')
                ->where('course_id', $courseId)
                ->where('course_key', 'banner')
                ->delete();

            if ($deleted > 0) {
                Log::info("Cleaned up {$deleted} old 'banner' row(s)");
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete old banner row: ' . $e->getMessage());
        }

        /* ---------- Session & Final Return ---------- */
        Session::put('course_id', $courseId);
        Log::info('Course creation completed successfully', ['course_id' => $courseId]);

        // Return only the course_id as plain text (or JSON – both work with JS)
        return $courseId; // This matches your JS: response.text() → data = course_id
        // OR return response()->json(['course_id' => $courseId, 'success' => true]);
    }
}
