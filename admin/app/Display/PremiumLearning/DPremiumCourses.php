<?php

namespace Admin\App\Display\PremiumLearning;

use Admin\App\Models\Middleware\MAmazonCloudFront;
use Admin\App\Models\PremiumLearning\MPremiumCourses;
use Illuminate\Support\Collection;

class DPremiumCourses
{
    /**
     * Display course material (video, pdf, image)
     */
    public static function showCourseMaterial($records)
    {
        // $records is now a Collection with one item (from model: collect([$record]))
        $record = $records->first();

        if (!$record) {
            return '<p>No material found.</p>';
        }

        $type = request()->query('sub3'); // safer than $_GET

        $video_path = MAmazonCloudFront::getCloudFrontUrl($record->video_path ?? '');
        $pdf_url    = MAmazonCloudFront::getCloudFrontUrl($record->doc_path ?? '');
        $image_path = MAmazonCloudFront::getCloudFrontUrl($record->image_path ?? '');

        $output = '';

        if ($type == 1 && $video_path) {
            $output .= '<iframe width="100%" height="500" src="' . $video_path . '" frameborder="0" allowfullscreen></iframe>';
        } elseif ($type == 2 && $pdf_url) {
            $output .= '<object data="' . $pdf_url . '#scrollbar=0&view=FitH" type="application/pdf" width="100%" height="600px">
                            <p>Your browser does not support PDFs.
                               <a href="' . $pdf_url . '">Download the PDF</a>
                            </p>
                        </object>';
        } elseif ($type == 3 && $image_path) {
            $output .= '<img src="' . $image_path . '" alt="Course Image" class="max-w-full h-auto rounded-lg shadow-lg">';
        }

        return $output;
    }

    /**
     * Display list of all courses in manage table
     */
    public static function getManageCourses(Collection $records)
    {
        if ($records->isEmpty()) {
            return '<tr><td colspan="6" class="text-center py-8 text-gray-500">' . __('No courses found') . '</td></tr>';
        }

        $output = '';
        $sno = 1;

        foreach ($records as $record) {
            $id = $record->course_id;

            $title       = MPremiumCourses::getCourses($id, 'title') ?: 'Untitled';
            $totaltitle  = MPremiumCourses::getCourses($id, 'totaltitle') ?: '-';
            $course_status = MPremiumCourses::getCourses($id, 'course_status');

            $statusBadge = $course_status == 1
                ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400 dark:bg-neutral-900 dark:text-green-400">' . __('Active') . '</span>'
                : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400 dark:bg-neutral-900 dark:text-red-400">' . __('Suspend') . '</span>';

            $createdDate = $record->created_on
                ? date('Y-m-d', strtotime($record->created_on))
                : '-';

            $editUrl   = env('BCPATH') . "/elearning/editelearning/" . $id;
            $deleteJs  = "deleteCourse({$id})";

            $output .= '<tr>
                <td>' . $sno . '</td>
                <td>' . htmlspecialchars($title) . '</td>
                <td>' . htmlspecialchars($totaltitle) . '</td>
                <td>' . $statusBadge . '</td>
                <td>' . $createdDate . '</td>
                <td>
                    <div class="flex space-x-3">
                        <a href="' . $editUrl . '" title="' . __('Edit') . '" aria-label="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>

                        <a href="javascript:void(0);" onclick="' . $deleteJs . '" title="' . __('Delete') . '" aria-label="Delete">
                            <svg class="w-6 h-6 text-black dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>';

            $sno++;
        }

        return $output;
    }

    /**
     * Show Package & Rank dropdowns (for announcement/edit)
     */
    public static function showPakRank($records)
    {
        $courseId = request()->query('sub2'); // safer than $_GET
        $matrixId = request()->query('sub1');

        $package_id = MPremiumCourses::getAnnouncement($courseId, 'package_id');
        $rank_id    = MPremiumCourses::getAnnouncement($courseId, 'rank_id');

        // Package Dropdown
        $output = '<div class="mb-5">
                    <label>' . __('Package') . '</label>
                    <select name="package_id" id="package_id" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                        <option value="">' . __('Select Package') . '</option>';

        foreach ($records as $pkg) {
            $selected = $pkg['package_id'] == $package_id ? 'selected' : '';
            $output .= '<option value="' . $pkg['package_id'] . '" ' . $selected . '>' . htmlspecialchars($pkg['package_name']) . '</option>';
        }

        $output .= '</select></div>';

        // Rank Dropdown (from ihook_ranksetting)
        $prefix = config('ihook.prefix', 'ihook');
        $ranks = \Illuminate\Support\Facades\DB::table($prefix . '_ranksetting')
            ->where('matrix_id', $matrixId)
            ->groupBy('rank_id')
            ->get();

        $output .= '<div class="mb-5">
                    <label>' . __('Rank') . '</label>
                    <select name="rank_id" id="rank_id" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                        <option value="">' . __('Select Rank') . '</option>';

        foreach ($ranks as $rank) {
            $selected = $rank->rank_id == $rank_id ? 'selected' : '';
            $output .= '<option value="' . $rank->rank_id . '" ' . $selected . '>' . htmlspecialchars($rank->rank_value) . '</option>';
        }

        $output .= '</select></div>';

        return $output;
    }
}
