<?php

/**
 * This class contains public functions related to MMailChimpImport
 *
 * @package         MMailChimpImport
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

namespace Admin\App\Models\Integrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Exception;

class MMailChimpImport
{
    /**
     * Get members who are not yet imported to MailChimp
     */
    public static function getMailChimpImport()
    {
        $prefix = config('services.ihook.prefix'); // or env('PROMLM_PREFIX') / your config key

        $members = DB::table("{$prefix}_members_table")
            ->where('mailchimp_import', '!=', '1')
            ->get();

        return $members;
    }

    /**
     * Import selected members to MailChimp audience (list)
     */
    public static function updateMailChimpImport()
    {
        try {
            $prefix = config('services.ihook.prefix');

            // Get MailChimp credentials from thirdpartyintegration table
            $config = DB::table("{$prefix}_thirdpartyintegration")
                ->where('module', 'mailchimp')
                ->whereIn('metakey', [
                    'mailchimp_apikey',
                    'mailchimp_apiurl',
                    'mailchimp_listid'
                ])
                ->pluck('metavalue', 'metakey')
                ->toArray();

            $apiKey       = $config['mailchimp_apikey'] ?? null;
            $apiUrl       = $config['mailchimp_apiurl'] ?? null; // e.g. https://usX.api.mailchimp.com/3.0/
            $listId       = $config['mailchimp_listid'] ?? null;

            $integrationStatus = DB::table("{$prefix}_thirdpartyintegration")
                ->where('module', 'mailchimp')
                ->where('metakey', 'mailchimp_apikey')
                ->value('integration_status');

            if (!$apiKey || !$apiUrl) {
                throw new Exception('MailChimp API credentials are not configured properly.');
            }

            // Create audience (list) if not exists
            if (empty($listId) && $integrationStatus == '1') {
                $listId = self::createMailChimpAudience($apiKey, $apiUrl);

                // Save list id
                DB::table("{$prefix}_thirdpartyintegration")->updateOrInsert(
                    [
                        'module'  => 'mailchimp',
                        'metakey' => 'mailchimp_listid',
                    ],
                    [
                        'metavalue'          => $listId,
                        'integration_status' => '1',
                        'updated_at'         => now(),
                    ]
                );
            }

            if (empty($listId)) {
                throw new Exception('Failed to get/create MailChimp audience.');
            }

            // Get selected member ids
            $selectedIds = request()->input('check', []);

            if (empty($selectedIds)) {
                Session::flash('warning_message', 'No members selected for import.');
                return redirect()->back();
            }

            $successCount = 0;

            foreach ($selectedIds as $memberId) {
                $member = DB::table("{$prefix}_members_table")
                    ->where('members_id', $memberId)
                    ->first();

                if (!$member) {
                    continue;
                }

                // Skip already imported
                if ($member->mailchimp_import == '1') {
                    continue;
                }

                $result = self::addMemberToMailChimp(
                    $apiKey,
                    $apiUrl,
                    $listId,
                    $member->members_email,
                    $member->members_firstname ?? '',
                    $member->members_lastname ?? ''
                );

                if ($result === true) {
                    DB::table("{$prefix}_members_table")
                        ->where('members_id', $memberId)
                        ->update(['mailchimp_import' => '1']);

                    $successCount++;
                }
            }

            Session::flash('success_message', "Successfully imported {$successCount} contact(s) to MailChimp.");
            return redirect()->route('admin.integration.index'); // or your integration page route

        } catch (Exception $e) {
            Log::error('MailChimp Import Error: ' . $e->getMessage());
            Session::flash('error_message', 'MailChimp import failed: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Create a new audience (list) in MailChimp
     */
    private static function createMailChimpAudience(string $apiKey, string $baseUrl): ?string
    {
        $dc = substr($apiKey, strpos($apiKey, '-') + 1); // data center

        $payload = [
            'name'              => 'ProMLM Imported Contacts ' . now()->format('Y-m-d'),
            'contact'           => [
                'company'   => config('app.name', 'Your Company'),
                'address1'  => 'Test Street',
                'address2'  => '',
                'city'      => 'Test City',
                'state'     => 'Test State',
                'zip'       => '00000',
                'country'   => 'US',
                'phone'     => '',
            ],
            'permission_reminder' => 'You are receiving this because you signed up.',
            'campaign_defaults'   => [
                'from_name'  => 'Your Business',
                'from_email' => config('mail.from.address', 'no-reply@yourdomain.com'),
                'subject'    => 'Welcome',
                'language'   => 'en',
            ],
            'email_type_option'   => true,
        ];

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("user:{$apiKey}"),
        ])
            ->timeout(60)
            ->post("{$baseUrl}lists", $payload);

        if ($response->successful()) {
            return $response->json('id');
        }

        throw new Exception('Failed to create MailChimp audience: ' . $response->body());
    }

    /**
     * Add single member to MailChimp list
     *
     * @return bool success
     */
    private static function addMemberToMailChimp(
        string $apiKey,
        string $baseUrl,
        string $listId,
        string $email,
        string $firstName = '',
        string $lastName = ''
    ): bool {
        $subscriberHash = self::getMailChimpSubscriberHash($email);

        $payload = [
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME' => $firstName,
                'LNAME' => $lastName,
            ],
        ];

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("user:{$apiKey}"),
        ])
            ->timeout(60)
            ->put("{$baseUrl}lists/{$listId}/members/{$subscriberHash}", $payload);

        // 200 = updated, 201 = created → both are success
        return $response->successful();
    }

    /**
     * Generate MailChimp subscriber hash (MD5 lowercase email)
     */
    private static function getMailChimpSubscriberHash(string $email): string
    {
        return md5(strtolower(trim($email)));
    }
}
