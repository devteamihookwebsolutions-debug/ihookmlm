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