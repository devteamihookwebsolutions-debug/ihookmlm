<?php

namespace Admin\App\Display\Integrations;

use Admin\App\Models\Middleware\MAmazonCloudFront;

class DIntegrations
{
    public static function getIntegrationList($records, $recordscat)
    {
        // Initialize output
        $output = '';

        // Get sub1 from request (default to 'all')
        $sub1 = request()->get('sub1', 'all');

        // Categories tabs
        if (count((array)$recordscat) > 0) {
            $output .= '<div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="integration-tab"
                data-tabs-toggle="#integration-tab-content" role="tablist">';

                $whereclassall = ($sub1 == 'all' || $sub1 == '' || $sub1 === null) ? 'selectedcat' : '';
                $output .= '<li class="me-2" role="presentation">
                    <a href="' . env('BCPATH') . '/admin/integration/show/all"
                    class="inline-block p-4 border-b-2 rounded-t-lg text-xs text-gray-600 ' . $whereclassall . '"
                    id="all-tab" aria-controls="all" aria-selected="false">' . __('All') . '</a>
                </li>';

                foreach ($recordscat as $cat) {
                    $catId = trim($cat->thirdpartyintegration_categories_id);
                    $whereclass = ($sub1 == $catId) ? 'selectedcat' : '';

                    $output .= '<li class="me-2" role="presentation">
                        <a href="' . env('BCPATH') . '/admin/integration/show/' . $catId . '"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-xs text-gray-600 dark:text-gray-300 ' . $whereclass . '"
                        id="' . $catId . '-tab"
                        aria-controls="tab-' . $catId . '"
                        aria-selected="false">' . __($cat->thirdpartyintegration_categories_name) . '</a>
                    </li>';
                }

            $output .= '</ul></div>';
        }

        // Tab content
        $sub1 = ($sub1 == '') ? 'all' : $sub1;

        $output .= '<div id="integration-tab-content">
            <div class="p-4 rounded-lg bg-neutral-50 dark:bg-neutral-900" id="tab-' . $sub1 . '" aria-labelledby="all-tab">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-5">';

        if (count((array)$records) > 0) {
            foreach ($records as $rec) {

                $status = (trim($rec->thirdpartyintegration_modules_status) == '1') ? __('Active') : __('In-Active');

                $mailviewimport = in_array(trim($rec->thirdpartyintegration_modules_default_name), ['mailchimp', 'sendgrid']) ? '1' : '0';

                $viewflag = '1';
                if (trim($rec->thirdpartyintegration_modules_default_name) == 'shopify') {
                    $viewflag = (strpos(file_get_contents(MAmazonCloudFront::getCloudFrontUrl('uploads/allowmenu.txt')), 'shopify') !== false) ? '1' : '0';
                }

                if ($viewflag == '1') {
                    $output .= '<div class="bg-white border p-6 border-neutral-300 rounded-lg dark:bg-neutral-900 dark:border-neutral-700 group h-40 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex flex-col items-center justify-center p-5 rounded-lg">
                            <img class="w-full object-contain rounded-t-lg transition-transform transform group-hover:scale-110 p-8"
                                 src="' . env('UI_ASSET_URL') . '/assets/img/integration/' . trim($rec->thirdpartyintegration_modules_image_path) . '" alt="image">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 gap-2">
                                <a href="' . env('BCPATH') . '/integration/configure/' . trim($rec->thirdpartyintegration_modules_default_name) . '"
                                    class="p-2 bg-neutral-500 text-white rounded-full hover:bg-neutral-600">
                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
                                    </svg>
                                </a>';

                    if ($mailviewimport == '1') {
                        $output .= '<a href="' . env('BCPATH') . '/integration/' . trim($rec->thirdpartyintegration_modules_default_name) . 'import"
                            class="p-2 bg-neutral-500 text-white rounded-full hover:bg-neutral-600">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
                            </svg>
                        </a>';
                    }

                    $output .= '</div></div></div>';
                }
            }
        }

        $output .= '</div></div></div>';

        return $output;
    }
}
