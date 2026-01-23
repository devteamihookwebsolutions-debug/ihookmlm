<?php

/**
 * This class contains public functions related to LeadContactsController
 *
 * @package         LeadContactsController
 * @category        Controller
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
namespace Admin\App\Http\Controllers\LeadPage;

use Admin\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Admin\App\Models\LeadPage\MCampaignManagement;
use Exception;
use Illuminate\Container\Attributes\Log;

class  CampaignManagementController extends Controller
{

   public function showNewsletterSettings()
    {

        // dd('function reached or not');
            $output['show_newsletter'] =
                MCampaignManagement::showNewsletterSettings();

            // Clear flash messages (if needed)
            // Session::forget(['success_message', 'error_message']);

            return view('leadpage.newslettercampaign', $output);

    }

   public function showNewsletterUserlists(Request $request)
{
        // dd('function reached or not');
        return MCampaignManagement::showNewsletterUserlists($request);

        return redirect()->route('newsletter.selectusers');

}

public function viewMailTemplate(Request $request, $id)
{
    // Pass both request and id to the model
    return MCampaignManagement::viewMailTemplate($request, $id);
}

// public function sendNewsletter(Request $request)
// {
//     MCampaignManagement::sendNewsletter($request);

//     return redirect()->back()
//         ->with('success', 'Newsletter sent successfully.');
// }
public function sendNewsletter(Request $request)
{
    $request->validate([
        'cate_temp_id' => 'required',
        'news_subject' => 'required',
        'user_list'    => 'required|array',
    ]);

    MCampaignManagement::sendNewsletter($request);

    return redirect()->back()
        ->with('success', 'Newsletter sent successfully.');
}
}
