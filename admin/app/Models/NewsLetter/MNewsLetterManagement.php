<?php

namespace Admin\App\Models\NewsLetter;

use Illuminate\Database\Eloquent\Model;
use Admin\App\Models\Member\NewsletterTemplate;
use Admin\App\Display\NewsLetter\DNewsLetterManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Admin\App\Models\Member\Admin;
use Illuminate\Support\Str;

class MNewsLetterManagement extends Model
{


public static function newsLetterMail()
{
    // dd('here');

  $admin_id = session('admin_id');

    if (!$admin_id) {
        // dd('Admin ID not found in session');
    }

    // 2 Fetch admin record
    $admin = Admin::where('admin_id', $admin_id)->first();
    // dd($admin);
    $records = NewsletterTemplate::where('created_by', 1)
                 ->get();
    // dd($records);
    return $records;
}




public static function storeTemplate(Request $request)
{
    $request->validate([
        'template_name'  => 'required|string|max:255',

        'status'         => 'nullable',
    ]);

    // dd($request);
    $admin = Admin::first();
    // dd($admin);
    if (!$admin) {
        return back()->withErrors('Admin not found');
    }
$table = config('services.ihook.prefix') . '_newsletter_buildertemplate_table';

    $randomNumber = sprintf('%06d', mt_rand(100000, 999999));

    // File handling (example)
    // $builderFilePath = 'uploads/templatesbuilderformnews/' . $randomNumber . '.html';
    // file_put_contents(storage_path("app/{$builderFilePath}"), "<html>Email content</html>");

    $alias = $request->input('template_name');
if (empty($alias)) {
    $alias = Str::slug($request->input('template_name')); // fallback
}
    DB::table($table)->insert([
    'category_templates_name'       => $request->input('template_name'),
    'category_templates_name_alias' => $alias,
    'category_templates_file_path'  => 0,
    'category_templates_status'     => $request->boolean('status') ? 1 : 0,
    'randomid'                      => $randomNumber,
    'created_on'                    => now(),
    'created_by'                    => $admin->admin_id,
    'user_type'                     => 1,
    'members_id'                    => 0,
    'campaign_id'                   => 0,
    'updated_on'                    => now(),
    'updated_by'                    => $admin->admin_id,
]);

    return redirect()->back()->with('success', 'Template inserted successfully');
}


    public static function getMediaPopup()
    {
        $imagepopcontent = "
            <div id='contenutoimmagini'></div>

            <form enctype='multipart/form-data' id='form-id'>
                <input name='nomefile' type='file' id='file-input' />
                <button type='button' class='btn btn-info' id='upload-btn'>Upload</button>
            </form>

            <progress id='upload-progress' value='0'></progress>

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    function uploadFile() {
                        const form = document.getElementById('form-id');
                        const formData = new FormData(form);
                        const progressBar = document.getElementById('upload-progress');

                        fetch('".$_ENV['BCPATH']."/emailbuilder/mediapopup/newfile', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Upload failed');
                            return response.text();
                        })
                        .then(() => {
                            loadImages();
                        })
                        .catch(() => {
                            alert('Errore caricamento');
                        });
                    }

                    function loadImages() {
                        fetch('".$_ENV['BCPATH']."/emailbuilder/mediapopup/immagini', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'nome='
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('contenutoimmagini').innerHTML = html;
                        })
                        .catch(err => console.error('Error loading images:', err));
                    }

                    document.getElementById('upload-btn').addEventListener('click', uploadFile);
                    loadImages();
                });

                function insertImage(element) {
                    const image = element.dataset.image;
                    const imageUrlInput = document.getElementById('image-url');

                    imageUrlInput.value = image;
                    const id = imageUrlInput.dataset.id;

                    document.getElementById(id).src = image;
                    document.getElementById(id).width = document.getElementById('image-w').value;
                    document.getElementById(id).height = document.getElementById('image-h').value;

                    document.getElementById('previewimg').classList.add('hidden'); // Hide modal
                }
            </script>";

        return $imagepopcontent;
    }

}
