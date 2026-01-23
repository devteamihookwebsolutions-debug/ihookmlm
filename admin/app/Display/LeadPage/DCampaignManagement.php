<?php

/**
 * This class contains public functions related to DCampaignManagement
 *
 * @package         DCampaignManagement
 * @category        Display
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
namespace Admin\App\Display\LeadPage;
class DCampaignManagement
{

public static function showNewsletterSettings($user_list, $temp_records, $memlist, $user_type = null)
{
    // dd($temp_records);
    // If $user_type is not passed, fallback to $_GET or null
    $user_type = $user_type ?? ($_GET['user_type'] ?? null);

    $output = '';

    /* =======================
       Subject field
    ======================== */
    $output .= '<div class="mb-5">
        <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">' . __('Subject') . '</label>
        <input type="text" name="news_subject" id="news_subject"
            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
            value="" placeholder="' . __('Subject') . '" aria-describedby="news_subject-error" required>
        <p id="news_subject-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
            Please enter a valid Subject
        </p>
    </div>';

    /* =======================
       User List Dropdown
    ======================== */
    $output .= '<div class="mb-5">
        <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">' . __('Select User List') . '</label>
        <select id="listusers" name="listusers"
            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2
                   dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
            onchange="selectUsers(this.value);" aria-describedby="listusers-error" required>

            <option value="">' . __('Select') . '</option>
            <option value="0">All Users</option>
            <option value="1">Active Users</option>
            <option value="2">Suspended Users</option>
            <option value="3">Only Subscribe Users</option>
            <option value="4">Premium Users</option>
            <option value="5">Free Users</option>
            <option value="6">Unverified Users</option>
            <option value="7">Custom Users</option>';

    /* =======================
       Dynamic User List
       (Skip duplicate keys 0–7)
    ======================== */
    foreach ($user_list as $key => $item) {

        if (in_array($key, range(0, 7))) {
            continue;
        }

        $label = is_object($item) ? ($item->name ?? '') : $item;
        $selected = ($user_type == $key) ? 'selected' : '';

        $output .= '<option value="' . $key . '" ' . $selected . '>'
                 . htmlspecialchars($label) .
                 '</option>';
    }

    /* =======================
       Member List
       (Skip duplicate keys 0–7)
    ======================== */
    foreach ($memlist as $key1 => $item1) {

        if (in_array($key1, range(0, 7))) {
            continue;
        }

        $label = is_object($item1) ? ($item1->name ?? '') : $item1;
        $selected = ($user_type == $key1) ? 'selected' : '';

        $output .= '<option value="' . $key1 . '" ' . $selected . '>'
                 . htmlspecialchars($label) .
                 '</option>';
    }

        $output .= '</select><p id="listusers-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please Select any option</p></div>';
        $output .= '<div class="mb-5"><label for="" class="block mb-2 text-sm font-medium text-black dark:text-white"></label>
      <div  class="mb-5" id="showuseremail">
      </div>
      </div>';

    /* =======================
       Template Dropdown
    ======================== */
    $output .= '<div class="mb-5">
        <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">' . __('Template') . '</label>
        <select id="newslettertemplate" name="newslettertemplate"
            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2
                   dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
            onchange="showPay(this.value);" aria-describedby="newslettertemplate-error" required>

            <option value="">' . __('Select') . '</option>';

    foreach ($temp_records as $record) {
        $id   = $record->category_templates_id ?? '';
        $name = $record->category_templates_name ?? '';

        $output .= '<option value="' . $id . '">'
                 . htmlspecialchars($name) .
                 '</option>';
    }

    $output .= '</select>
        <p id="newslettertemplate-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
            Please Select any option
        </p>
    </div>';

    /* =======================
       News Content Section
    ======================== */
    $output .= '<div class="hidden items-center space-x-4" id="showimagenews">
        <label class="block mb-2 text-sm font-medium text-black dark:text-white">' . __('News Content') . '</label>
        <div class="w-full" id="showimage">
    <iframe id="templateFrame"
            class="w-full border rounded-lg"
            frameborder="0">
    </iframe>
</div>

    </div>';

    return $output;
}


public static function showNewsletterUserlists($records, $user_type)
{
    // Convert to collection if not already
    $records = collect($records);

    $output = '<select id="user_list" name="user_list[]"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>';

    if ($records->count() > 0) {

        foreach ($records as $record) {

            // Special input for user_type 8
            if ($user_type == 8) {
                $output .= '<input type="text" name="totallevel" id="totallevel"
                                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light" value=""  onclick="creatmaillist();"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>

                                    <button
                                      aria-label="button"
                                      id="closelevel"
                                      type="button"
                                      class="closebtns flex items-center justify-center rounded-full border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white p-2 transition duration-200"
                                      onclick="deletemaillist();"
                                    ><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                  </svg>
                                  </i>
                                    </button>
                                    <br>
                                    <div id="nolevelinputgift"></div>';
            }

            // Determine the email safely
            $email = $record->members_email ?? $record->email ?? '';

            if (in_array((string)$user_type, ['1', '2', '3', '4'])) {
                $output .= '<option selected value="' . $email . '">' . $email . '</option>';
            } elseif ((string)$user_type === '5') {
                $output .= '<option selected value="' . ($record->email ?? '') . '">' . ($record->email ?? '') . '</option>';
            } elseif (str_starts_with((string)$user_type, 'lead_')) {
                // Safe lead check
                $output .= '<option selected value="' . ($record->email ?? '') . '">' . ($record->email ?? '') . '</option>';
            } else {
                $output .= '<option selected value="' . $email . '">' . $email . '</option>';
            }
        }
    }

    $output .= '</select>';

    return $output;
}


}
