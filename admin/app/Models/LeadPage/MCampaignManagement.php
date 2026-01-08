<?php
namespace Admin\App\Models\LeadPage;

use Admin\App\Models\Middleware\MAmazonCloudFront;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
// use App\Mail\NewsletterMail;
use Admin\App\Mail\NewsletterMail;

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
// public static function sendNewsletter(Request $request)
// {
//     $prefix = config('services.ihook.prefix');
//     // dd($prefix);
//     $request->validate([
//         'cate_temp_id' => 'required',
//         'news_subject' => 'required',
//         'user_list'    => 'required|array',
//     ]);

//     // dd($request->all());
//     // Prepare message content

//     $categoryTemplate = DB::table($prefix . '_newsletter_buildertemplate_table')
//         ->where('category_templates_id', trim($request->cate_temp_id))
//         ->first();

//    $catpath = str_replace(
//     "uploads/templatesbuilderformnews/",
//     "uploads/templatesbuilderformnews/body_",
//     $categoryTemplate->category_templates_file_path
// );

// // If file is LOCAL
// $fullPath = public_path($catpath);

// if (!file_exists($fullPath)) {
//     throw new \Exception("Newsletter template not found: {$fullPath}");
// }

// $message = file_get_contents($fullPath);
// dd($message);

//     $mailTemplate = DB::table($prefix . '_mailtemplates_table')
//         ->where('mail_default_name', 'newsletter_notification')
//         ->where('mail_status', 1)
//         ->where('mail_lang', 1)
//         ->first();

//     $body = $mailTemplate->mail_content;
//     $body = str_replace('[name]', 'User', $body);
//     $body = str_replace('[mail_subject]', $request->news_subject, $body);
//     $body = str_replace('[date]', now()->format('d-m-Y H:i'), $body);
//     $body = str_replace('[msg]', $message, $body);

//     // Send emails in chunks
//     $chunks = array_chunk($request->user_list, 250);
//     foreach ($chunks as $chunk) {
//         foreach ($chunk as $email) {
//             Mail::to($email)->queue(new NewsletterMail($request->news_subject, $body));
//         }
//     }

//     return back()->with('success', 'Newsletter has been sent successfully.');
// }

// public static function sendNewsletter(Request $request)
// {
//     $prefix = config('services.ihook.prefix');

//     $request->validate([
//         'cate_temp_id' => 'required',
//         'news_subject' => 'required',
//         'user_list'    => 'required|array',
//     ]);

//     // Get template record
//     $categoryTemplate = DB::table($prefix . '_newsletter_buildertemplate_table')
//         ->where('category_templates_id', trim($request->cate_temp_id))
//         ->first();

//     if (!$categoryTemplate) {
//         return back()->withErrors('Newsletter template record not found.');
//     }
//     $relativePath = ltrim($categoryTemplate->category_templates_file_path, '/');
//     $fullPath = public_path($relativePath);
//     if (!file_exists($fullPath)) {
//         return back()->withErrors("Newsletter template file not found: {$relativePath}");
//     }

//     $message = file_get_contents($fullPath);
//     // dd($message);
//     // Get mail template
//     $mailTemplate = DB::table($prefix . '_mailtemplates_table')
//         ->where('mail_default_name', 'newsletter_notification')
//         ->where('mail_status', 1)
//         ->where('mail_lang', 1)
//         ->first();

//     if (!$mailTemplate) {
//         return back()->withErrors('Mail wrapper template not found.');
//     }

//     // Replace placeholders
//     $body = $mailTemplate->mail_content;
//     $body = str_replace('[name]', 'User', $body);
//     $body = str_replace('[mail_subject]', $request->news_subject, $body);
//     $body = str_replace('[date]', now()->format('d-m-Y H:i'), $body);
//     $body = str_replace('[msg]', $message, $body);

//     // Send mails
//     foreach (array_chunk($request->user_list, 250) as $chunk) {
//         foreach ($chunk as $email) {
//             Mail::to($email)->queue(
//                 new NewsletterMail($request->news_subject, $body)
//             );
//         }
//     }

//     return back()->with('success', 'Newsletter has been sent successfully.');
// }
// public static function sendNewsletter(Request $request)
//     {
//         $prefix = config('services.ihook.prefix');

//         // Get template record
//         $categoryTemplate = DB::table($prefix . '_newsletter_buildertemplate_table')
//             ->where('category_templates_id', trim($request->cate_temp_id))
//             ->first();

//         if (!$categoryTemplate) {
//             throw new \Exception('Newsletter template record not found.');
//         }

//         $relativePath = ltrim($categoryTemplate->category_templates_file_path, '/');
//         $fullPath = public_path($relativePath);

//         if (!file_exists($fullPath)) {
//             throw new \Exception("Newsletter template file not found: {$relativePath}");
//         }

//         $message = file_get_contents($fullPath);

//         // Mail wrapper
//         $mailTemplate = DB::table($prefix . '_mailtemplates_table')
//             ->where('mail_default_name', 'newsletter_notification')
//             ->where('mail_status', 1)
//             ->where('mail_lang', 1)
//             ->first();

//             // dd($mailTemplate);
//         if (!$mailTemplate) {
//             throw new \Exception('Mail wrapper template not found.');
//         }

//         // Replace placeholders
//         $body = str_replace(
//             ['[name]', '[mail_subject]', '[date]', '[msg]'],
//             ['User', $request->news_subject, now()->format('d-m-Y H:i'), $message],
//             $mailTemplate->mail_content
//         );
//         // dd($body);
//         // SEND MAIL (TEMP: send instead of queue)
//         foreach ($request->user_list as $email) {
//             Mail::to($email)->send(
//                 new NewsletterMail($request->news_subject, $body)
//             );
//         }

//         return true;
//     }



// public static function sendNewsletter(Request $request)
// {
//     $prefix = config('services.ihook.prefix');


//     $categoryTemplate = DB::table($prefix . '_newsletter_buildertemplate_table')
//         ->where('category_templates_id', trim($request->cate_temp_id))
//         ->first();

//     // dd($categoryTemplate);
//     if (!$categoryTemplate) {
//         throw new \Exception('Newsletter template record not found.');
//     }

//     $relativePath = ltrim($categoryTemplate->category_templates_file_path, '/');
//     $fullPath = public_path($relativePath);

//     if (!file_exists($fullPath)) {
//         throw new \Exception("Newsletter template file not found: {$relativePath}");
//     }

//     $message = file_get_contents($fullPath);
//     $formatDate = now()->format('d-m-Y H:i');

//     $mailTemplate = DB::table($prefix . '_mailtemplates_table')
//         ->where('mail_default_name', 'newsletter_notification')
//         ->where('mail_status', 1)
//         ->where('mail_lang', 1)
//         ->first();
//     // dd($mailTemplate);

//     if (!$mailTemplate) {
//         throw new \Exception('Mail wrapper template not found.');
//     }

//     // -------------------------
//     DB::table($prefix . '_mailtemplates_table')
//         ->where('mail_default_name', 'newsletter_notification')
//         ->update(['mail_subject' => $request->news_subject]);

//     $bodyStep1   = str_replace('[name]', 'User', $mailTemplate->mail_content);
//     // dd($bodyStep1);
//     $bodyStep2   = str_replace('[mail_subject]', $request->news_subject, $bodyStep1);
//     $bodyStep3   = str_replace('[date]', $formatDate, $bodyStep2);
//     $finalBody   = str_replace('[msg]', $message, $bodyStep3);

//     if ($request->listusers == 8) {
//         // Single-send mode
//         foreach ($request->user_list as $email) {
//             Mail::to($email)->send(new NewsletterMail($request->news_subject, $finalBody));
//         }
//     } else {
//         // Bulk-send mode: chunks of 250
//         $userChunks = array_chunk($request->user_list, 250);

//         foreach ($userChunks as $chunk) {
//             foreach ($chunk as $email) {
//                 Mail::to($email)->send(new NewsletterMail($request->news_subject, $finalBody));
//             }
//         }
//     }

//     return true;
// }


public static function sendNewsletter(Request $request)
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

    $mailTemplate = DB::table($prefix . '_mailtemplates_table')
        ->where('mail_default_name', 'newsletter_notification')
        ->where('mail_status', 1)
        ->where('mail_lang', 1)
        ->first();

    if (!$mailTemplate) {
        throw new \Exception('Mail wrapper template not found.');
    }


    $bodyStep1 = str_replace('[name]', 'User', $mailTemplate->mail_content);
    $bodyStep2 = str_replace('[mail_subject]', $request->news_subject, $bodyStep1);
    $bodyStep3 = str_replace('[date]', $formatDate, $bodyStep2);
    $finalBody = str_replace('[msg]', $message, $bodyStep3);

    DB::table($prefix . '_mailtemplates_table')
        ->where('mail_default_name', 'newsletter_notification')
        ->where('mail_lang', 1)
        ->update([
            'mail_subject' => $request->news_subject,
            'mail_content' => $finalBody,
            'modified_at'  => now(),
            'modified_by'  =>  1,
        ]);


    if ($request->listusers == 8) {
      
        foreach ($request->user_list as $email) {
            Mail::to($email)->send(
                new NewsletterMail($request->news_subject, $finalBody)
            );
        }
    } else {
        // Bulk send (250 per batch)
        $userChunks = array_chunk($request->user_list, 250);

        foreach ($userChunks as $chunk) {
            foreach ($chunk as $email) {
                Mail::to($email)->send(
                    new NewsletterMail($request->news_subject, $finalBody)
                );
            }
        }
    }

    return true;
}

}