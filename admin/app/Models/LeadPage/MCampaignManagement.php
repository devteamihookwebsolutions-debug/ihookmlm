<?php

/**
 * This class contains public functions related to MCampaignManagement
 *
 * @package         MCampaignManagement
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
namespace Admin\App\Models\LeadPage;

use Admin\App\Models\Middleware\MAmazonCloudFront;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Admin\App\Models\Middleware\MSendMail;
use Admin\App\Models\Middleware\MSendBulkMail;
use Admin\App\Display\LeadPage\DCampaignManagement;

class MCampaignManagement {

public static function showNewsletterSettings()
{
$prefix = config('services.ihook.prefix');
// dd($prefix);

    /* -------------------------------------------------
     * 1. Get distinct csv_user_name from leadcontact
     * ------------------------------------------------- */
    $temp_records1 = DB::table($prefix . '_leadcontact')
        ->select('csv_user_name')
        ->where('csv_user_name', '!=', '0')
        ->distinct()
        ->get();

        // dd($temp_records1);
    $user_list = [];
    foreach ($temp_records1 as $row) {
        $ind = 'lead_' . $row->csv_user_name;
        $user_list[$ind] = $row->csv_user_name;
    }

    /* -------------------------------------------------
     * 2. Get active categories
     * ------------------------------------------------- */
    $temp_records12 = DB::table($prefix . '_catagories')
        ->select('cat_name')
        ->where('cat_status', '1')
        ->distinct()
        ->get();

    $memlist = [];
    $count = 8;

    foreach ($temp_records12 as $row) {
        $count++;
        $memlist[$count] = $row->cat_name;
    }

    // dd($temp_records12);
    $output = [];
    /* -------------------------------------------------
     * 4. Get newsletter templates
     * ------------------------------------------------- */
    $temp_records = DB::table($prefix . '_newsletter_buildertemplate_table')
        ->where('category_templates_status', '1')
        ->get();

        // dd($temp_records);
    /* -------------------------------------------------
     * 5. Return result
     * ------------------------------------------------- */
    return DCampaignManagement::showNewsletterSettings(
        $user_list,
        $temp_records,
        $memlist,
        $output

    );

}
public  static function showNewsletterUserlists(Request $request)
{
    $user_type = $request->input('usertype');
    // dd($user_type);
    $user      = explode('_', $user_type);
    // dd($user);
$prefix = config('services.ihook.prefix');
    $records = collect();

    /* =============================
       USER TYPES 1 – 8
    ============================== */
    if (in_array($user_type, ['0','1','2','3','4','5','6','7'])) {

        // 1. All Users
        if ($user_type == 0) {
            $records = DB::table($prefix . '_members_table')
                ->select('members_id', 'members_email')
                ->get();
        }

        // 2. Active Users
        elseif ($user_type == 1) {
            $records = DB::table($prefix . '_members_table')
                ->select('members_id', 'members_email')
                ->where('members_verified', 1)
                ->where('members_status', 1)
                ->get();
        }

        // 3. Suspended Users
        elseif ($user_type == 2) {
            $records = DB::table($prefix . '_members_table')
                ->select('members_id', 'members_email')
                ->where('members_verified', 1)
                ->where('members_status', 0)
                ->get();
        }

        // 4. Only Subscribe Users
    elseif ($user_type == 3) {

    $records = DB::table($prefix . '_members_table as a')
        ->leftJoin(
            $prefix . '_matrix_members_link_table as b',
            'a.members_id',
            '=',
            'b.members_id'
        )
        ->select('a.members_id', 'a.members_email')
        ->where('b.members_subscription_plan', '!=', 0)
        ->groupBy('a.members_id', 'a.members_email')
        ->get();
}

        // 5. Premium Users
       elseif ($user_type == 4) {
            $records = DB::table($prefix . '_members_table as a')
                ->leftJoin($prefix . '_matrix_members_link_table as b', 'a.members_id', '=', 'b.members_id')
                ->select('a.members_id', 'a.members_email')
                ->where('b.members_account_status', '!=', 0)
                ->groupBy('a.members_id', 'a.members_email')
                ->get();
        }
        // 6. Free Users
       elseif ($user_type == 5) {
            $records = DB::table($prefix . '_members_table as a')
                ->leftJoin($prefix . '_matrix_members_link_table as b', 'a.members_id', '=', 'b.members_id')
                ->select('a.members_id', 'a.members_email')
                ->where('b.members_account_status', 0)
                ->groupBy('a.members_id', 'a.members_email')
                ->get();
        }

        // 7. Unverified Users
          elseif ($user_type == 6) {
            $records = DB::table($prefix . '_members_table')
                ->select('members_id', 'members_email')
                ->where('members_verified', 0)
                ->get();
        }
    }

    return DCampaignManagement::showNewsletterUserlists(
        $records,
        $user_type
    );
}


public static function viewMailTemplate(Request $request, $id)
{
    $templateId = $id;
    $prefix = config('services.ihook.prefix');

    $record = DB::table($prefix . '_newsletter_buildertemplate_table')
        ->where('category_templates_id', $templateId)
        ->first();

    if (!$record) {
        return response()->json(['error' => 'Template not found'], 404);
    }

    // USE DB PATH AS-IS
    $relativePath = $record->category_templates_file_path;

    $fullPath = public_path($relativePath);

    if (!file_exists($fullPath)) {
        return response()->json([
            'error' => 'File not found',
            'path'  => $fullPath
        ], 404);
    }

    $html = file_get_contents($fullPath);

    return response($html)->header('Content-Type', 'text/html');
}



    public static function sendNewsletter(Request $request): bool
    {
        $prefix = config('services.ihook.prefix');

        /* -------------------------------
         | 1. Get Newsletter Template
         * ------------------------------- */
        $categoryTemplate = DB::table($prefix . '_newsletter_buildertemplate_table')
            ->where('category_templates_id', trim($request->cate_temp_id))
            ->first();

        if (!$categoryTemplate) {
            throw new \Exception('Newsletter template record not found.');
        }

        $relativePath = ltrim($categoryTemplate->category_templates_file_path, '/');
        $fullPath = public_path($relativePath);

        if (!file_exists($fullPath)) {
            throw new \Exception("Newsletter template file not found: {$relativePath}");
        }

        $message = file_get_contents($fullPath);
        $formatDate = now()->format('d-m-Y H:i');

        /* -------------------------------
         | 2. Get Mail Wrapper Template
         * ------------------------------- */
        $mailTemplate = DB::table($prefix . '_mailtemplates_table')
            ->where('mail_default_name', 'newsletter_notification')
            ->where('mail_status', 1)
            ->where('mail_lang', 1)
            ->first();

        if (!$mailTemplate) {
            throw new \Exception('Mail wrapper template not found.');
        }

        /* -------------------------------
         | 3. Replace placeholders
         * ------------------------------- */
        $body = str_replace(
            ['[name]', '[mail_subject]', '[date]', '[msg]'],
            ['User', $request->news_subject, $formatDate, $message],
            $mailTemplate->mail_content
        );

        /* -------------------------------
         | 4. Update mail template
         * ------------------------------- */
        DB::table($prefix . '_mailtemplates_table')
            ->where('mail_default_name', 'newsletter_notification')
            ->where('mail_lang', 1)
            ->update([
                'mail_subject' => $request->news_subject,
                'mail_content' => $body,
                'modified_at'  => now(),
                'modified_by'  => 1,
            ]);

        /* -------------------------------
         | 5. Prepare Mail Object
         * ------------------------------- */

        $recordsMail = (object) [
            'mail_from'      => $mailTemplate->mail_from,
            'mail_from_name' => $mailTemplate->mail_from_name,
            'mail_subject'   => $request->news_subject,
            'mail_content'   => $body
        ];
        // dd($recordsMail);
        /* -------------------------------
        | 6. Send Newsletter
        * ------------------------------- */
        $userList = (array) $request->user_list;
        // dd($userList);
        // dd($request->listusers);
        if ($request->listusers == 8) {
            // Single send
            // dd('funcrion reached or not');

            foreach ($userList as $email) {

                MSendMail::send(
                    $recordsMail,
                    $email,
                    $body,
                    null,
                    null
                );
            }
        } else {
            // Bulk send (250 per batch)
            $userChunks = array_chunk($userList, 250);

            foreach ($userChunks as $chunk) {
                MSendBulkMail::send(
                    $recordsMail,
                    $chunk,
                    $body,
                    null,
                    null
                );
            }
        }

        return true;
    }
}

