<?php

/**
 * This class contains public functions related to NewsLetterManagementController
 *
 * @package         NewsLetterManagementController
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

namespace Admin\App\Http\Controllers\NewsLetter;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\NewsLetter\MNewsLetterManagement;
use Admin\App\Models\Member\NewsletterTemplate;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
class NewsLetterManagementController extends Controller
{

  public function newsletterTemplate()
    {

            $records = MNewsLetterManagement::newsLetterMail();
            return view('newsletter.newslettertemplates', compact('records'))
                   ->with('success_message', session()->pull('success_message'))
                   ->with('error_message', session()->pull('error_message'));

    }


public function addNewsTemplate()
    {
        try {

            return view('newsletter.addnewstemplates');

        } catch (Exception $e) {

            return redirect()
                ->route('addnewstemplate')
                ->with('error_message', $e->getMessage());
        }
    }

public static function validAddNewsTemplate(Request $request)
{

        MNewsLetterManagement::storeTemplate($request);

        return redirect()
            ->route('newslettertemplate')
            ->with('success', 'Newsletter Template added successfully');
}

public function deletetemplate($id)
    {
        // dd($id);
        try {
            $template = NewsLetterTemplate::where('randomid', $id)->first();
            // dd($template);
            if (!$template) {
                return response()->json([
                    'message' => 'Template not found'
                ], 404);
            }

            $template->delete();

            return response()->json([
                'message' => 'Template deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Delete failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function edittemplate($id)
{
    $template = NewsLetterTemplate::findOrFail($id);
    // dd($template);
    return view('newsletter.editnewsmailsubjects', [
        'template' => $template,
        'sub1' => $id,
    ]);
}

public function updatetemplate(Request $request, $id)
{
    // dd($id);
    $request->validate([
        'template_name' => 'required|string|max:255',
        'status' => 'required|in:0,1',
    ]);

    // dd($request);
    $template = NewsLetterTemplate::findOrFail($id);
    $template->category_templates_name = $request->template_name;
    $template->category_templates_status = $request->status;
    $template->updated_on = now();
    // dd($template);
    $template->save();
    return redirect()->route('newslettertemplate')
                     ->with('success', 'Template updated  successfully!');
}

public function templateDocumentsNews($filename, $id)
{
    $output = [];
    $output['sub1'] = $filename;
    $output['sub2'] = $id;
    $output['site_logo'] = session('site_settings.admin_site_logo');
    $output['sitename']  = session('site_settings.site_name');

    $folderPath = public_path('uploads/templatesbuilderformnews');

    // Create folder if not exists
    if (!File::exists($folderPath)) {
        File::makeDirectory($folderPath, 0755, true);
    }

    $filePath = $folderPath . '/body_' . $filename . '.html';

    // Load file OR return empty html
    $output['funnnelpagecontent'] = File::exists($filePath)
        ? File::get($filePath)
        : '';

    return view('newsletter.include_template_buildernews', $output);
}

public function imageUpload(Request $request)
{
    // dd('function  reached or not');
    if (!$request->hasFile('file')) {
        return response()->json([
            'status' => false,
            'message' => 'No file uploaded'
        ], 400);
    }

    $file = $request->file('file');
    $name = time().'_'.$file->getClientOriginalName();

    $file->move(public_path('uploads/newsbuilder'), $name);

    return response()->json([
        'status' => true,
        'url' => asset('uploads/newsbuilder/'.$name)
    ]);
}


public function saveContent(Request $request)
{
    $prefix = config('services.ihook.prefix');
    $data = $request->json()->all();

    // dd($data);
    $table =  '' . $prefix . '_newsletter_buildertemplate_table';
    $categoryTemplatesId = trim($data['template_name']);

    // Get template

       $template = DB::table($table)
        ->where('category_templates_id', $categoryTemplatesId)
        ->first();

    if (!$template) {
        return response()->json([
            'success' => false,
            'message' => 'Template not found'
        ], 404);
    }

    $oldFilename     = $template->randomid;
    $newRandomNumber = sprintf("%06d", mt_rand(100000, 999999));

    $htmlContent = $data['html_content'];


    $finalFilename = $newRandomNumber . '.html';
    $publicPath = public_path('uploads/templatesbuilderformnews/' . $finalFilename);

    if (!file_exists(dirname($publicPath))) {
        mkdir(dirname($publicPath), 0755, true);
    }

    file_put_contents($publicPath, $htmlContent);


    $s3Path = 'uploads/templatesbuilderformnews/' . $finalFilename;

    Storage::disk('s3')->put(
        $s3Path,
        $htmlContent,
        ['ContentType' => 'text/html']
    );

    if ($oldFilename) {
        Storage::disk('s3')->delete(
            'uploads/templatesbuilderformnews/' . $oldFilename . '.html'
        );
    }
     DB::table($table)
        ->where('category_templates_id', $categoryTemplatesId)
        ->update([
            'category_templates_file_path' => $s3Path,
            'randomid' => $newRandomNumber,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Newsletter Template updated successfully',
            'redirect' => route('newslettertemplate')
        ]);
}


public function preview($id)
{
    // dd($id);
    $filename = $id . '.html';
    // dd($filename);
    $path = public_path('uploads/templatesbuilderformnews/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }
    $html = file_get_contents($path);
    return response($html)
        ->header('Content-Type', 'text/html; charset=UTF-8');
}



}
