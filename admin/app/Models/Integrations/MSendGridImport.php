<?php

namespace Admin\App\Models\Integrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class MSendGridImport
{
    /**
     * This public static function is used to get the SendGrid Import page data
     * @return mixed
     */
    public static function getSendGridImport()
    {
        $prefix = config('services.ihook.prefix');
        $records = DB::table( $prefix. '_members_table')
            ->where('sendgrid_import', '!=', '1')
            ->get();

        return $records;
    }

    /**
     * This public static function is used to handle SendGrid integration and import
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function updateSendGridImport()
    {
        try {
                    $prefix = config('services.ihook.prefix');
            // Get SendGrid API Key
            $apiConfig = DB::table($prefix . '_thirdpartyintegration')
                ->where('module', 'sendgrid')
                ->where('metakey', 'sendgrid_apikey')
                ->first();

            $sendgrid_apikey = $apiConfig->metavalue ?? null;
            $integration_status = $apiConfig->integration_status ?? null;

            // Get SendGrid List ID
            $listConfig = DB::table($prefix . '_thirdpartyintegration')
                ->where('module', 'sendgrid')
                ->where('metakey', 'sendgrid_listid')
                ->first();

            $sendgrid_list_id = $listConfig->metavalue ?? null;

            // If no list ID and integration is active, create a new list
            if (empty($sendgrid_list_id) && $integration_status == '1') {
                $rand = rand(100, 999);
                $url = 'https://api.sendgrid.com/v3/contactdb/lists';
                $json_data = ['name' => "test{$rand}"];

                $response = self::sendGridAccess($url, $sendgrid_apikey, $json_data);

                $sendgrid_list_id = $response['id'] ?? null;

                if (empty($sendgrid_list_id)) {
                    Session::flash('error_message', __('SendGrid error - Please check your configuration details'));
                    return Redirect::to('/integration');
                }

                DB::table($prefix . '_thirdpartyintegration')->insert([
                    'module' => 'sendgrid',
                    'metakey' => 'sendgrid_listid',
                    'metavalue' => $sendgrid_list_id,
                    'integration_status' => '1',
                ]);
            }

            // Process selected members (assuming checkboxes are sent as 'check' array in request)
            $selectedMembers = request()->input('check', []);

            if (!empty($selectedMembers)) {
                foreach ($selectedMembers as $members_id) {
                    $member = DB::table($prefix . '_members_table')
                        ->where('members_id', $members_id)
                        ->first();

                    if (!$member) {
                        continue;
                    }

                    $members_firstname = $member->members_firstname ?? '';
                    $members_lastname  = $member->members_lastname ?? '';
                    $members_email     = $member->members_email ?? '';

                    // Prepare last_name (your original logic had a strange condition)
                    $lname = $members_lastname ?: 'testing';

                    $json_data = [
                        [
                            'email'     => $members_email,
                            'last_name' => $lname,
                        ]
                    ];

                    $url = 'https://api.sendgrid.com/v3/contactdb/recipients';
                    $response = self::sendGridAccess($url, $sendgrid_apikey, $json_data);

                    $persisted_recipient = $response['persisted_recipients'][0] ?? null;

                    if (empty($persisted_recipient)) {
                        continue; // Skip if no recipient ID
                    }

                    // Add to list
                    $url = "https://api.sendgrid.com/v3/contactdb/lists/{$sendgrid_list_id}/recipients/{$persisted_recipient}";
                    $response = self::sendGridAccess($url, $sendgrid_apikey, []);

                    if (!empty($persisted_recipient)) {
                        DB::table($prefix . '_members_table')
                            ->where('members_id', $members_id)
                            ->update(['sendgrid_import' => '1']);
                    }
                }
            }

            Session::flash('success_message', __('Sendgrid import has been done successfully'));
            return Redirect::to('/integration');

        } catch (\Exception $e) {
            Log::error('SendGrid Import Error: ' . $e->getMessage());
            Session::flash('error_message', __('An error occurred during SendGrid import'));
            return Redirect::to('/integration');
        }
    }

    /**
     * This public static function is used to make SendGrid API calls
     * @param string $url
     * @param string $api_key
     * @param array|string $json_data
     * @return mixed
     */
    public static function sendGridAccess($url, $api_key, $json_data)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        // Convert array to JSON if it's an array
        $body = is_array($json_data) ? json_encode($json_data) : $json_data;

        $response = Http::withHeaders($headers)
            ->timeout(60)
            ->withOptions(['verify' => false]) // Note: Not recommended for production
            ->post($url, $body);

        if ($response->failed()) {
            throw new \Exception('SendGrid API failed: ' . $response->body());
        }

        return $response->json();
    }
}
