<?php

namespace Admin\App\Http\Controllers\Settings;
use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Factories\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::pluck('sitesettings_value', 'sitesettings_name')->toArray();
        $matrices = DB::table('ihook_matrix_table')->pluck('matrix_name', 'matrix_id')->toArray();
        $default_logo = asset('assets/img/default-logo.png'); // Adjust path as needed
        $default_favicon = asset('assets/img/default-favicon.png'); // Adjust path as needed

        return view('Settings.site-settings', compact('settings', 'matrices', 'default_logo', 'default_favicon'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $fileFields = ['site_logo', 'site_logo_dark', 'login_site_logo', 'register_logo', 'site_favicon'];
            $settings = $request->except('_token', 'default_matrix'); // Exclude CSRF token and default_matrix

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('uploads/site_logo', $fileName, 'public');
                    $settings[$field] = $filePath; // Store file path
                } elseif ($request->input("hidden_$field")) {
                    $settings[$field] = $request->input("hidden_$field"); // Retain existing file path
                }
            }

            $checkboxFields = ['https_enble', 'subdomain_enble', 'waitingliststatus'];
            foreach ($checkboxFields as $field) {
                $settings[$field] = $request->has($field) ? 1 : 0;
            }

            foreach ($settings as $name => $value) {
                SiteSetting::updateOrCreate(
                    ['sitesettings_name' => $name],
                    ['sitesettings_value' => $value]
                );
            }

            if ($request->has('default_matrix')) {
                $matrixId = $request->input('default_matrix');
                $matrixName = DB::table('ihook_matrix_table')
                    ->where('matrix_id', $matrixId)
                    ->value('matrix_name');

                if ($matrixName) {
                    SiteSetting::updateOrCreate(
                        ['sitesettings_name' => 'default_matrix'],
                        ['sitesettings_value' => $matrixId]
                    );
                }
            }

            return redirect()->route('site-settings.index')->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('site-settings.index')->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }
}
