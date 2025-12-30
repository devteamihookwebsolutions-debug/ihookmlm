<?php

namespace Admin\App\Http\Controllers\MemberArea;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\MemberArea\MemberAreaSummary;
use Admin\App\Models\MemberArea\MemberAreaWebsite;
use Admin\App\Models\MemberArea\MemberAreaSocialMedia;
use Admin\App\Models\Masters\CountryMaster;
use Admin\App\Models\Masters\State;
use Admin\App\Models\MemberArea\MemberHistrory;
use Admin\App\Models\MemberArea\MemberPersonalPurchase;
use Admin\App\Models\MemberArea\PartySetup;
use Admin\App\Models\MemberArea\PaymentHistory;
use Admin\App\Models\MemberArea\MemberActivity;
use Admin\App\Models\MemberArea\MemberArea;
use Admin\App\Models\MemberArea\Post;
use Admin\App\Models\MemberArea\Postmeta;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Session;

class MemberAreaSummaryController extends Controller
{
    /**
     * Display the member details for the given ID.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            // Eager load member + activities
            $member = MemberAreaSummary::with(['country', 'state', 'activities'])
                ->where('members_id', $id)
                ->firstOrFail();

            $countries = CountryMaster::all();
            $states = State::all();

            $personal = $this->generatePersonalInfoHtml($member);

            $websiteDetails = MemberAreaWebsite::getWebsiteDetails($id);
            $socialMediaDetails = MemberAreaSocialMedia::getSocialMediaDetails($id);

            $paymentHistory = PaymentHistory::where('paymenthistory_member_id', $id)
                ->orderByDesc('paymenthistory_date')
                ->get();

                    // LAST LOGIN
            $lastLogin = $member->activities()
                ->orderByDesc('members_log_time')
                ->first();

            $lastLoginFormatted = $lastLogin
                ? $lastLogin->members_log_time->format('Y-m-d H:i:s')
                : '-';

            $doj = $member->members_doj
                ? $member->members_doj->format('Y-m-d')
                : '-';
            $matrixConfig = [];
            if ($member->matrix_id) {
                $matrixConfig = MatrixConfiguration::where('matrix_id', $member->matrix_id)
                    ->pluck('matrix_value', 'matrix_key')
                    ->toArray();
            }
                $currency = Session::get('site_settings.site_currency', '$');

                $cWalletBalance = Cache::remember("wallet_balance_{$id}_1", 60, function () use ($id) {
                    return $this->calculateWalletBalance($id, 1); // 1 = C-Wallet
                });

                $eWalletBalance = Cache::remember("wallet_balance_{$id}_2", 60, function () use ($id) {
                    return $this->calculateWalletBalance($id, 2); // 2 = E-Wallet
                });

            $data = [
                'sub1' => $member->members_id,
                'errval' => [
                    'members_id' => $member->members_id,
                    'members_username' => $member->members_username,
                    'members_firstname' => $member->members_firstname,
                    'members_lastname' => $member->members_lastname,
                    'members_email' => $member->members_email,
                    'members_phone' => $member->members_phone,
                    'members_ip_address' => $member->members_ip_address,
                    'members_status' => $member->members_status,
                ],
                'userdetails' => [
                    'members_type_name' => $member->members_type_name ?? 'N/A',
                    'lastlogin'         => $lastLoginFormatted,
                    'members_from'      => $member->members_from ?? 'N/A',
                ],
                'members_id' => $member->members_id,
                'members_doj' => $doj,
                'members_subdomain' => $member->members_subdomain ?? 'N/A',
                'members_email' => $member->members_email,
                'members_firstname' => $member->members_firstname,
                'members_lastname' => $member->members_lastname,
                'members_phone' => $member->members_phone,
                'members_dob' => $member->members_dob,
                'members_company_name' => $member->members_company_name ?? 'N/A',
                'members_address' => $member->members_address ?? 'N/A',
                'members_address2' => $member->members_address2 ?? 'N/A',
                'members_address3' => $member->members_address3 ?? 'N/A',
                'members_city' => $member->members_city ?? 'N/A',
                'members_state' => $member->state ? $member->state->state_id : 'N/A',
                'members_zip' => $member->members_zip ?? 'N/A',
                'members_country' => $member->country ? $member->country->country_master_id : 'N/A',
                'country' => $member->country ? $member->country->country_master_name : 'N/A',
                'members_ssn_number' => $member->members_ssn_number ?? 'N/A',
                'status' => $member->members_status == 1 ? 'Active' : 'Suspended',
                'login_ip' => $member->members_ip_address ?? 'N/A',
                'login_attempt' => $member->activities->count(),
                'language' => $member->members_lang ? $this->getLanguageName($member->members_lang) : 'N/A',
                'revenue' => $this->getRevenueData($member->members_id),
                'sales' => $this->getSalesData($member->members_id),
                'block1details' => [
                    'replicated_url' => $member->members_subdomain
                        ? "{$member->members_subdomain}"
                        : '#',
                ],
                'countries' => $countries,
                'states' => $states,
                'personal' => $personal,
                'members_image' => $member->members_thumb_image ?? 'Uploads/members/avatar.png',
                'rank' => ['rank_value' => 'N/A'],
                'members_gender' => $member->members_gender ?? 'N/A',
                'websiteDetails' => $websiteDetails,
                'socialMediaDetails' => $socialMediaDetails,
                'paymentHistory' => $paymentHistory,
                'matrixConfig' => $matrixConfig,
                'matrix_id'    => $member->matrix_id ?? null,
                'currency' => $currency,
                'cWallet'  => number_format($cWalletBalance, 2),
                'eWallet'  => number_format($eWalletBalance, 2),
            ];

            return view('admin::memberarea.showmemberarea', $data);

        } catch (\Exception $e) {
            Log::error('Error fetching member details: ' . $e->getMessage(), [
                'member_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            abort(500, 'An error occurred while fetching member details.');
        }
    }

    private function generatePersonalInfoHtml($member)
    {
        $html = '
        <div class="datatable-wrapper datatable-loading no-footer sortable fixed-columns">
            <div class="datatable-container">
                <table class="datatable-table">
                    <tbody>
                        <tr class="border-b dark:border-neutral-700">
                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                ' . __('First Name') . '
                            </th>
                            <td class="px-6 py-4 dark:text-neutral-100">' . e($member->members_firstname ?? 'N/A') . '</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-700">
                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                ' . __('Last Name') . '
                            </th>
                            <td class="px-6 py-4 dark:text-neutral-100">' . e($member->members_lastname ?? 'N/A') . '</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-700">
                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                ' . __('Date of Birth') . '
                            </th>
                            <td class="px-6 py-4 dark:text-neutral-100">' . e($member->members_dob ?? 'N/A') . '</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-700">
                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                ' . __('SSN/EIN Number') . '
                            </th>
                            <td class="px-6 py-4 dark:text-neutral-100">' . e($member->members_ssn_number ?? 'N/A') . '</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-700">
                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                ' . __('Company Name') . '
                            </th>
                            <td class="px-6 py-4 dark:text-neutral-100">' . e($member->members_company_name ?? 'N/A') . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';

        return $html;
    }

    public function updateContactDetails(Request $request)
    {
        $request->validate([
            'members_id' => 'required|exists:ihook_members_table,members_id',
            'email' => 'required|email|max:70',
            'phone' => 'nullable|string|max:30|regex:/^[0-9\-]+$/',
            'country' => 'nullable|exists:ihook_country_master_table,country_master_id',
            'city' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'address2' => 'nullable|string|max:1000',
            'state' => 'nullable|exists:ihook_state_table,state_id',
            'zip' => 'nullable|string|max:30',
        ]);

        try {
            $member = MemberAreaSummary::findOrFail($request->members_id);
            $member->update([
                'members_email' => $request->email,
                'members_phone' => $request->phone,
                'members_country' => $request->country,
                'members_city' => $request->city,
                'members_address' => $request->address,
                'members_address2' => $request->address2,
                'members_state' => $request->state,
                'members_zip' => $request->zip,
            ]);

            return redirect()->route('distributors.show', $request->members_id)
                ->with('success', 'Contact details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating contact details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update contact details.');
        }
    }
    public function updateBillingDetails(Request $request)
    {
        $request->validate([
            'members_id' => 'required|exists:ihook_members_table,members_id',
            'country' => 'nullable|exists:ihook_country_master_table,country_master_id',
            'city' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'address2' => 'nullable|string|max:1000',
            'state' => 'nullable|exists:ihook_state_table,state_id',
            'zip' => 'nullable|string|max:30',
        ]);

        try {
            $member = MemberAreaSummary::findOrFail($request->members_id);
            $member->update([
                'members_country' => $request->country,
                'members_city' => $request->city,
                'members_address' => $request->address,
                'members_address2' => $request->address2,
                'members_state' => $request->state,
                'members_zip' => $request->zip,
            ]);

            return redirect()->route('distributors.show', $request->members_id)
                ->with('success', 'Billing details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating billing details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update billing details.');
        }
    }

    public function showWebsiteDetails($id)
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized access.'], 401);
            }

            $websiteDetails = MemberAreaWebsite::getWebsiteDetails($id);

            // Generate HTML for the website details form
            $html = view('admin::memberarea.partials.website_details', [
                'user_id' => $id,
                'mobile' => $websiteDetails['mobile'] ?? '',
                'message' => $websiteDetails['message'] ?? '',
            ])->render();

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            Log::error('Error fetching website details: ' . $e->getMessage(), [
                'member_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Failed to fetch website details.'], 500);
        }
    }

    public function showSocialMediaDetails($id)
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized access.'], 401);
            }

            $socialMediaDetails = MemberAreaSocialMedia::getSocialMediaDetails($id);

            // Generate HTML for the social media details form
            $html = view('admin::memberarea.partials.social_media_details', [
                'user_id' => $id,
                'facebook' => $socialMediaDetails['facebook'] ?? '',
                'twitter' => $socialMediaDetails['twitter'] ?? '',
                'youtube' => $socialMediaDetails['youtube'] ?? '',
                'linkedin' => $socialMediaDetails['linkedin'] ?? '',
                'google' => $socialMediaDetails['google'] ?? '',
                'skype' => $socialMediaDetails['skype'] ?? '',
                'pinterest' => $socialMediaDetails['pinterest'] ?? '',
                'tumblr' => $socialMediaDetails['tumblr'] ?? '',
            ])->render();

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            Log::error('Error fetching social media details: ' . $e->getMessage(), [
                'member_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Failed to fetch social media details.'], 500);
        }
    }

public function updateWebsiteDetails(Request $request)
{
    try {
        $validated = $request->validate([
            'id' => 'required|exists:ihook_members_table,members_id',
            'mobile' => 'nullable|string|max:30|regex:/^[\+0-9\s\-]*$/',
            'message' => 'nullable|string|max:1000',
        ], [
            'mobile.regex' => 'The mobile number format is invalid. Use numbers, +, spaces, or hyphens.',
        ]);

        $data = [
            'mobile' => $request->mobile ?? '',
            'message' => $request->message ?? '',
        ];

        Log::info('Website details validation passed', [
            'user_id' => $request->id,
            'data' => $data
        ]);

        $success = MemberAreaWebsite::updateWebsiteDetails($request->id, $data);

        if ($success) {
            // SUCCESS: Redirect WITHOUT the ?tab=my-sites parameter
            return redirect()->route('distributors.show', ['id' => $request->id])
                ->with('success', 'Website details updated successfully.');
        } else {
            Log::warning('Website details update failed', ['user_id' => $request->id]);
            return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'my-sites'])
                ->with('error', 'Failed to update website details. Please try again.');
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Website details validation failed', [
            'user_id' => $request->id,
            'errors' => $e->errors()
        ]);
        return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'my-sites'])
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        Log::error('Error updating website details: ' . $e->getMessage(), [
            'user_id' => $request->id,
            'trace' => $e->getTraceAsString(),
        ]);
        return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'my-sites'])
            ->with('error', 'Failed to update website details due to a server error.');
    }
}

    public function updateSocialMediaDetails(Request $request)
    {
        // dd($request->all());

        try {
            $validated = $request->validate([
                'id' => 'required|exists:ihook_members_table,members_id',
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'google' => 'nullable|url|max:255',
                'skype' => 'nullable|string|max:255',
                'pinterest' => 'nullable|url|max:255',
                'tumblr' => 'nullable|url|max:255',
            ], [
                'facebook.url' => 'The Facebook URL is invalid.',
                'twitter.url' => 'The Twitter URL is invalid.',
                'youtube.url' => 'The YouTube URL is invalid.',
                'linkedin.url' => 'The LinkedIn URL is invalid.',
                'google.url' => 'The Google URL is invalid.',
                'pinterest.url' => 'The Pinterest URL is invalid.',
                'tumblr.url' => 'The Tumblr URL is invalid.',
            ]);

            $data = [
                'facebook' => $request->facebook ?? '',
                'twitter' => $request->twitter ?? '',
                'youtube' => $request->youtube ?? '',
                'linkedin' => $request->linkedin ?? '',
                'google' => $request->google ?? '',
                'skype' => $request->skype ?? '',
                'pinterest' => $request->pinterest ?? '',
                'tumblr' => $request->tumblr ?? '',
            ];

            Log::info('Social media details validation passed', [
                'user_id' => $request->id,
                'data' => $data
            ]);

            $success = MemberAreaSocialMedia::updateSocialMediaDetails($request->id, $data);

            if ($success) {
                return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'social-media'])
                    ->with('success', 'Social media details updated successfully.');
            } else {
                Log::warning('Social media details update failed', ['user_id' => $request->id]);
                return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'social-media'])
                    ->with('error', 'Failed to update social media details. Please try again.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Social media details validation failed', [
                'user_id' => $request->id,
                'errors' => $e->errors()
            ]);
            return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'social-media'])
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating social media details: ' . $e->getMessage(), [
                'user_id' => $request->id,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('distributors.show', ['id' => $request->id, 'tab' => 'social-media'])
                ->with('error', 'Failed to update social media details due to a server error.');
        }
    }

    private function getLanguageName($langId)
    {
        $languages = [
            1 => 'English',
            2 => 'Spanish',
        ];
        return $languages[$langId] ?? 'N/A';
    }


    private function getRevenueData($memberId)
    {
        $payments = PaymentHistory::where('paymenthistory_member_id', $memberId)
            ->select('paymenthistory_status', 'paymenthistory_amount')
            ->get();

        $paid = $unpaid = 0.0;
        foreach ($payments as $p) {
            if ($p->paymenthistory_status === 'paid') {
                $paid += (float) $p->paymenthistory_amount;
            } elseif ($p->paymenthistory_status === 'notpaid') {
                $unpaid += (float) $p->paymenthistory_amount;
            }
        }

        $shopId = MemberAreaSummary::where('members_id', $memberId)->value('members_shop_id');

        $ordersTotal = 0.0;
        if ($shopId) {
            $ordersTotal = DB::table('cart_postmeta AS pm')
                ->join('cart_posts AS p', 'p.ID', '=', 'pm.post_id')
                ->join('cart_postmeta AS cust', function ($join) use ($shopId) {
                    $join->on('cust.post_id', '=', 'pm.post_id')
                        ->where('cust.meta_key', '_customer_user')
                        ->where('cust.meta_value', $shopId);
                })
                ->where('pm.meta_key', '_order_total')   // Fixed: pm.meta_key
                ->where('p.post_type', 'shop_order')
                ->where('p.post_status', 'wc-completed') // Optional: only completed orders
                ->sum('pm.meta_value');
        }

        $currency = Session::get('site_settings.site_currency', '$');

        return view('memberarea.partials.revenue_rows', [
            'currency' => $currency,
            'paid'     => $paid,
            'unpaid'   => $unpaid,
            'orders'   => $ordersTotal,
        ])->render();
    }


    private function getSalesData($memberId)
    {

        $shopId = MemberAreaSummary::where('members_id', $memberId)
            ->value('members_shop_id');

        if (! $shopId) {
            return '<tr><td colspan="9" class="px-6 py-4 text-center text-gray-500">No sales data</td></tr>';
        }

        // -------------------------------------------------
        // 2. Pull every completed order that belongs to the shop
        // -------------------------------------------------
        $orders = DB::table('cart_postmeta AS pm')               // _order_total
            ->join('cart_posts AS p', 'p.ID', '=', 'pm.post_id')
            ->join('cart_postmeta AS cust', function ($j) use ($shopId) {
                $j->on('cust.post_id', '=', 'pm.post_id')
                ->where('cust.meta_key', '_customer_user')
                ->where('cust.meta_value', $shopId);
            })
            ->where('pm.meta_key', '_order_total')
            ->where('p.post_type', 'shop_order')
            ->where('p.post_status', 'wc-completed')
            ->select(
                'p.post_date AS order_date',
                DB::raw('CAST(pm.meta_value AS DECIMAL(12,2)) AS total')
            )
            ->get();

        if ($orders->isEmpty()) {
            return '<tr><td colspan="9" class="px-6 py-4 text-center text-gray-500">No sales data</td></tr>';
        }

        // -------------------------------------------------
        // 3. Prepare date helpers
        // -------------------------------------------------
        $now          = Carbon::now();
        $curYear      = $now->year;
        $curDateStr   = $now->format('m/d/Y');                     // today
        $ytdStart     = "01/01/{$curYear}";
        $mtdStart     = $now->copy()->startOfMonth()->format('m/d/Y');
        $l3mStart     = $now->copy()->subMonths(2)->startOfMonth()->format('m/d/Y');
        $l6mStart     = $now->copy()->subMonths(5)->startOfMonth()->format('m/d/Y');

        // -------------------------------------------------
        // 4. Accumulators
        // -------------------------------------------------
        $ytd = $mtd = $l3m = $l6m = 0.0;
        $q   = [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0];

        foreach ($orders as $o) {
            $dateStr = Carbon::parse($o->order_date)->format('m/d/Y');
            $month   = (int) Carbon::parse($o->order_date)->month;
            $amount  = (float) $o->total;

            // YTD
            if ($dateStr >= $ytdStart && $dateStr <= $curDateStr) {
                $ytd += $amount;
            }

            // MTD
            if ($dateStr >= $mtdStart && $dateStr <= $curDateStr) {
                $mtd += $amount;
            }

            // Last 3 months
            if ($dateStr >= $l3mStart && $dateStr <= $curDateStr) {
                $l3m += $amount;
            }

            // Last 6 months
            if ($dateStr >= $l6mStart && $dateStr <= $curDateStr) {
                $l6m += $amount;
            }

            // Quarterly (based on calendar month)
            if (in_array($month, [1,2,3]))   $q[1] += $amount;
            if (in_array($month, [4,5,6]))   $q[2] += $amount;
            if (in_array($month, [7,8,9]))   $q[3] += $amount;
            if (in_array($month, [10,11,12])) $q[4] += $amount;
        }

        // -------------------------------------------------
        // 5. Render the view row
        // -------------------------------------------------
        $currency = Session::get('site_settings.site_currency', '$');

        return view('memberarea.partials.yearly_sales_row', [
            'currency' => $currency,
            'year'     => $curYear,
            'ytd'      => $ytd,
            'mtd'      => $mtd,
            'l3m'      => $l3m,
            'l6m'      => $l6m,
            'q1'       => $q[1],
            'q2'       => $q[2],
            'q3'       => $q[3],
            'q4'       => $q[4],
        ])->render();
    }

    public function savePasswordDetail(Request $request)
    {
        $request->validate([
            'members_id' => 'required|exists:ihook_members_table,members_id',
            'currentpassword' => 'required|string',
            'newpassword' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'newpassword_confirmation' => 'required',
            'notify' => 'required|in:1,2',
        ]);

        try {
            $member = MemberAreaSummary::findOrFail($request->members_id);

            if (!Hash::check($request->currentpassword, $member->members_password)) {
                return back()->withErrors(['currentpassword' => 'Current password is incorrect.']);
            }

            $member->update([
                'members_password' => Hash::make($request->newpassword),
            ]);

            if ($request->notify == 1) {
                try {
                    \Mail::raw("Your password has been changed successfully.", function ($m) use ($member) {
                        $m->to($member->members_email)->subject('Password Updated');
                    });
                } catch (\Exception $e) {
                    \Log::warning('Password email failed', ['error' => $e->getMessage()]);
                }
            }

            return redirect()
                ->route('distributors.show', $member->members_id)
                ->with('success', 'Password updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Password update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to update password.');
        }
    }

    public function contactUs(Request $request, $members_id)
    {
        $request->validate([
            'members_id' => 'required|exists:ihook_members_table,members_id',
        ]);

        try {
            return redirect()->route('distributors.show', $members_id)
                ->with('success', 'Contact form submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Error processing contact form: ' . $e->getMessage(), [
                'member_id' => $members_id,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Failed to submit contact form.');
        }
    }

    public function activateMember($id)
    {
        try {
            $member = MemberAreaSummary::where('members_id', $id)->firstOrFail();
            $member->update(['members_status' => 1]);

            return redirect()->route('distributors.show', $id)
                ->with('success', 'Member activated successfully.');
        } catch (\Exception $e) {
            Log::error('Activate member failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to activate member.');
        }
    }

       public function suspendMember($id)
    {
        try {
            $member = MemberAreaSummary::where('members_id', $id)->firstOrFail();
            $member->update(['members_status' => 2]);

            return redirect()->route('distributors.show', $id)
                ->with('success', 'Member suspended successfully.');
        } catch (\Exception $e) {
            Log::error('Suspend member failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to suspend member.');
        }
    }

    public function personalPurchases($id)
    {
        $member = MemberAreaSummary::with(['personalPurchases' => function($q) {
            $q->orderByDesc('created_on');
        }])
        ->select(['members_id', 'members_email'])
        ->where('members_id', $id)
        ->firstOrFail();

        $orders = $member->personalPurchases;

        return view('memberarea.partials.personal_purchase_rows', compact('orders'));
    }

    public function commissionInvoice($memberId)
    {
        $commissions = MemberHistrory::where('history_member_id', $memberId)
            ->where('history_amount', '>', 0)
            ->orderByDesc('history_datetime')
            ->get();

        return view('admin::memberarea.partials.commission_rows', compact('commissions'))->render();
    }

    public function packageHistory($memberId)
    {
        $packages = PaymentHistory::with(['package', 'matrix'])
            ->where('paymenthistory_member_id', $memberId)
            ->where('paymenthistory_plan_id', '>', 0)
            ->orderByDesc('paymenthistory_date')
            ->get();

        return view('admin::memberarea.partials.package_rows', compact('packages'))->render();
    }

    public function commissionPdf($historyId)
    {
        $commission = MemberHistrory::findOrFail($historyId);

        $pdf = Pdf::loadView('memberarea.pdf.commission', compact('commission'));
        return $pdf->stream('commission-' . $historyId . '.pdf');
    }

    public function packagePdf($paymentId)
    {
        $package = PaymentHistory::with(['package', 'matrix', 'member'])
            ->findOrFail($paymentId);

        if (!$package->member) {
            abort(404, 'Member not found');
        }

        $pdf = Pdf::loadView('memberarea.pdf.package', compact('package'));
        return $pdf->stream('package-' . $paymentId . '.pdf');
    }

    public function showMemberParties($memberId)
    {
        $setups = PartySetup::where('setup_party_id', $memberId)
                    ->orderByDesc('id')
                    ->get();

        $html = '';
        foreach ($setups as $i => $row) {
            $html .= view('memberarea.partials.party_row', [
                'sno'   => $i + 1,
                'row'   => $row,
            ])->render();
        }

        return response($html);
    }

    public function getEditForm($id)
    {
        $member = MemberAreaSummary::with(['country', 'state'])
            ->where('members_id', $id)
            ->firstOrFail();

        $countries = CountryMaster::orderBy('country_master_name')->get();
        $states    = State::orderBy('state_name')->get();
        return view('admin::memberarea.partials.edit_user_form', compact('member', 'countries', 'states'));
    }

    public function UpdateUserForm(Request $request, $id)
    {
        // dd($request->all());
        $member = MemberAreaSummary::where('members_id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'members_username' => 'required|string|max:50|unique:ihook_members_table,members_username,' . $id . ',members_id',
            'members_email'    => 'required|email|max:70|unique:ihook_members_table,members_email,' . $id . ',members_id',
            'members_phone'    => 'nullable|string|max:30',
            'members_firstname'=> 'nullable|string|max:50',
            'members_lastname' => 'nullable|string|max:50',
            'members_dob'      => 'nullable|date',
            'members_country'  => 'nullable|exists:ihook_country_master_table,country_master_id',
            'members_state'    => 'nullable|exists:ihook_state_table,state_id',
            'members_city'     => 'nullable|string|max:50',
            'members_zip'      => 'nullable|string|max:20',
            'members_address'  => 'nullable|string|max:500',
            'members_address2' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->messages()
            ], 422);
        }

        $member->update($request->only([
            'members_username','members_email','members_phone','members_firstname','members_lastname',
            'members_dob','members_gender','members_country','members_state','members_city',
            'members_zip','members_address','members_address2'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'member'  => $member->refresh()
        ]);
    }

    public function planDetails($id)
    {
        try {
            Log::info('PlanDetails started', ['member_id' => $id]);

            $member = MemberAreaSummary::findOrFail($id);

            $packages = PaymentHistory::where('paymenthistory_member_id', $id)
                ->where('matrix_id', $id)
                ->orderByDesc('paymenthistory_date')
                ->orderByDesc('paymenthistory_id')
                ->get();

            $kv = MatrixConfiguration::where('matrix_id', $id)
                ->pluck('matrix_value', 'matrix_key')
                ->toArray();

            $get = fn($key, $default = '—') => $kv[$key] ?? $default;

            $sponsorUsername = $get('default_sponsor_name');
            $sponsor = $sponsorUsername
                ? MemberAreaSummary::where('members_username', $sponsorUsername)->first()
                : null;

            $directReferrals = MatrixConfiguration::where('matrix_key', 'default_sponsor_name')
                ->where('matrix_value', $member->members_username)
                ->count();

            $planType = $get('matrix_description', 'Unilevel Plan');
            $membershipType = $get('members_account_type') == 1 ? 'IBO' : 'Customer';
            $membershipStatus = $get('active_status') == 1 ? 'Active' : 'Inactive';

            $accountStatus = $get('active_status') == 1 ? 'Active' : 'Suspended';
            $accountStatusClass = $accountStatus === 'Active'
                ? 'bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400 border border-green-400'
                : 'bg-red-100 text-red-800 dark:bg-gray-700 dark:text-red-400 border border-red-400';

            $currentPackage = optional($packages->first())->package?->package_name ?? 'Silver';

            $subscriptionExpiry = $member->subscription_expiry
                ? Carbon::parse($member->subscription_expiry)->format('m/d/Y')
                : '02/25/2025';

            $enroller = '—';
            $dateOfJoin = $member->members_doj?->format('m/d/Y') ?? '02/21/2025';
            $currentRank = 'NA';

            $referralLink = $member->members_subdomain
                ? "{$member->members_subdomain}"
                : "https://ihookmlmsoftware.com";

            // ADD PAYMENT INFO HERE
            $firstPayment = $packages->first();

            $paymentInfo = $firstPayment ? [
                'gateway'          => $firstPayment->paymenthistory_type === 'ewalletcredits' ? 'Admin Credits' : ucfirst($firstPayment->paymenthistory_mode),
                'transaction_id'   => $firstPayment->paymenthistory_trans_id ?? '—',
                'package_name'     => $firstPayment->package?->package_name ?? '—',
                'subscription_date'=> $firstPayment->paymenthistory_date?->format('m/d/Y') ?? '—',
                'expiry_date'      => $member->subscription_expiry?->format('m/d/Y') ?? '—',
                'fee'              => '$' . number_format($firstPayment->paymenthistory_amount, 2),
                'currency'         => $firstPayment->currency_id ?? 'USD',
            ] : null;

            $data = [
                'member'             => $member,
                'kv'                 => $kv,
                'get'                => $get,
                'planType'           => $planType,
                'membershipType'     => $membershipType,
                'membershipStatus'   => $membershipStatus,
                'accountStatus'      => $accountStatus,
                'accountStatusClass' => $accountStatusClass,
                'currentPackage'     => $currentPackage,
                'subscriptionExpiry' => $subscriptionExpiry,
                'sponsor'            => $sponsor,
                'enroller'           => $enroller,
                'directReferrals'    => $directReferrals,
                'dateOfJoin'         => $dateOfJoin,
                'currentRank'        => $currentRank,
                'referralLink'       => $referralLink,
                'packages'           => $packages,
                'matrix_id'          => $id,
                'paymentInfo'        => $paymentInfo,
            ];

            $html = view('admin::memberarea.partials.plan_details', $data)->render();

            return response()->json(['html' => $html]);

        } catch (\Exception $e) {
            Log::error('Plan Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load plan details.'], 500);
        }
    }

    public function approvePendingPayment(Request $request)
    {
        $request->validate([
            'member_id'  => 'required|integer',
            'matrix_id'  => 'required|integer',
            'payment_id' => 'required|integer',
        ]);

            $updated = DB::table('ihook_paymenthistory_table')
                ->where('paymenthistory_member_id', $request->member_id)
                ->where('matrix_id', $request->matrix_id)
                ->where('paymenthistory_id', $request->payment_id)
                ->whereIn('paymenthistory_status', ['notpaid', 'pending'])
                ->update([
                    'paymenthistory_status' => 'paid'
                ]);

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found or already approved.'
                ], 400);
            }

            try {
                $columns = DB::getSchemaBuilder()->getColumnListing('ihook_matrix_members_link_table');

                $possiblePassupCols = ['passup_id', 'members_passup_direct_id', 'sponsor_id', 'parent_id', 'direct_sponsor_id'];
                $passupCol = collect($possiblePassupCols)->first(fn($col) => in_array($col, $columns));

                if ($passupCol && in_array('spillover_id', $columns)) {
                    DB::statement("UPDATE ihook_matrix_members_link_table
                                SET spillover_id = IFNULL(spillover_id, ?)
                                WHERE members_id = ? AND matrix_id = ?",
                                [$passupCol, $request->member_id, $request->matrix_id]);
                }
            } catch (\Exception $e) {
                \Log::warning('Spillover update skipped: ' . $e->getMessage());
            }

            try {
                $memberCols = DB::getSchemaBuilder()->getColumnListing('ihook_members_table');

                if (in_array('members_status', $memberCols)) {
                    DB::table('ihook_members_table')
                        ->where('members_id', $request->member_id)
                        ->update(['members_status' => 1]);  // ← This is the correct value
                }
            } catch (\Exception $e) {
                \Log::warning('Member status update failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment approved successfully!'
            ]);
    }

    public function getPaymentInfo($id)
    {
        try {
            $payment = PaymentHistory::with('package')->findOrFail($id);

            // Format dates
            $subDate = $payment->paymenthistory_date?->format('d/m/Y') ?? '—';
            $expiryDate = $payment->subscription_expiry ?? '—'; // or calculate
            if ($expiryDate !== '—') {
                $expiryDate = Carbon::parse($expiryDate)->format('d/m/Y');
            }

            return response()->json([
                'gateway'          => $payment->paymenthistory_type === 'ewalletcredits' ? 'Ewallet' : ucfirst($payment->paymenthistory_mode),
                'transaction_id'   => $payment->paymenthistory_trans_id ?? '—',
                'package_name'     => $payment->package?->package_name ?? '—',
                'subscription_date'=> $subDate,
                'expiry_date'      => $expiryDate,
                'amount'           => number_format($payment->paymenthistory_amount, 2),
                'currency'         => $payment->currency_id ?? 'USD',
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment Info Error: ' . $e->getMessage());
            return response()->json(['error' => 'Not found'], 404);
        }
    }
    public function getProcessedEarnings($memberId)
    {
        return $this->earningReport($memberId, true);
    }
    public function getCommissionReport($memberId)
    {
        return $this->earningReport($memberId, false);
    }
    private function earningReport($memberId, $onlyProcessed)
    {
        try {
            // Use correct table names from your models
            $historyTable = 'ihook_history_table';
            $historyTypeTable = 'ihook_history_type_table';
            $matrixLinkTable = 'ihook_matrix_members_link_table';
            $membersTable = 'ihook_members_table';

            $builder = DB::table("{$historyTable} AS h")
                ->leftJoin("{$matrixLinkTable} AS a", 'a.members_id', '=', 'h.history_member_id')
                ->leftJoin("{$membersTable} AS b", 'a.members_id', '=', 'b.members_id')
                ->where('h.history_member_id', $memberId)
                ->where('h.history_amount', '!=', 0);

            if ($onlyProcessed) {
                $types = DB::table($historyTypeTable)
                    ->where('history_credit_type', 1)
                    ->where('history_commission_type', 1)
                    ->pluck('history_type_name')
                    ->toArray();

                if (empty($types)) {
                    return response('<tr><td colspan="5" class="text-center">' . __('No data available') . '</td></tr>');
                }

                $builder->whereIn('h.history_type', $types);
            }

            $records = $builder->select([
                    'h.history_amount',
                    'h.history_description',
                    'h.history_datetime',
                    'h.history_type',
                ])
                ->orderByDesc('h.history_datetime')
                ->get();

            // Generate HTML (using your models)
            $output = '';
            $site_currency = '$'; // or config('site.currency')

            if ($records->count() > 0) {
                foreach ($records as $i => $record) {
                    $formatdate = Carbon::parse($record->history_datetime)->format('d M Y');
                    $sno = $i + 1;

                    if ($onlyProcessed) {
                        // Processed Earnings format
                        $output .= '<tr>
                            <td>' . $sno . '</td>
                            <td>' . htmlspecialchars($site_currency . ' ' . $record->history_amount) . '</td>
                            <td><span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Processed</span></td>
                            <td>' . htmlspecialchars($record->history_description) . '</td>
                            <td>' . htmlspecialchars($formatdate) . '</td>
                        </tr>';
                    } else {
                        // Commission Report format
                        $output .= '<tr>
                            <td>' . $sno . '</td>
                            <td>' . htmlspecialchars($site_currency . ' ' . $record->history_amount) . '</td>
                            <td>' . htmlspecialchars($record->history_description) . '</td>
                            <td>' . htmlspecialchars($formatdate) . '</td>
                        </tr>';
                    }
                }
            } else {
                $colspan = $onlyProcessed ? 5 : 4;
                $output .= '<tr><td colspan="' . $colspan . '" class="text-center">' . __('No data available') . '</td></tr>';
            }

            return response($output);

        } catch (\Exception $e) {
            \Log::error("Earning report error (processed=$onlyProcessed): " . $e->getMessage());
            return response('<tr><td colspan="5" class="text-center text-red-600">' . __('Error loading data') . '</td></tr>');
        }
    }
    private function calculateWalletBalance($memberId, $walletType)
    {
        $types = DB::table('ihook_history_type_table')
            ->get(['history_type_name', 'history_credit_type', 'history_debit_type']);

        $credit = $debit = [];

        foreach ($types as $t) {
            if ($t->history_credit_type) $credit[] = $t->history_type_name;
            if ($t->history_debit_type)  $debit[]  = $t->history_type_name;
        }

        $creditSum = $debitSum = 0;

        if ($credit) {
            $creditSum = DB::table('ihook_history_table')
                ->where('history_member_id', $memberId)
                ->where('history_wallet_type', $walletType)
                ->whereIn('history_type', $credit)
                ->sum('history_amount') ?? 0;
        }

        if ($debit) {
            $debitSum = DB::table('ihook_history_table')
                ->where('history_member_id', $memberId)
                ->where('history_wallet_type', $walletType)
                ->whereIn('history_type', $debit)
                ->sum('history_amount') ?? 0;
        }
        // dd($creditSum);

        return (float)$creditSum - (float)$debitSum;
    }
    public function updatePersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'members_id' => 'required|exists:ihook_members_table,members_id',
            'firstname'     => 'required|string|max:30',
            'lastname'      => 'required|string|max:30',
            'dob'           => 'nullable|date',
            'company_name'  => 'nullable|string|max:70',
            'ssn_number'    => 'nullable|string|max:100',
            'sub_domain'    => 'nullable'
        ]);

        $id = $validated['members_id']; // get from form

        $member = MemberAreaSummary::findOrFail($id);

        $member->update([
            'members_firstname'     => $validated['firstname'],
            'members_lastname'      => $validated['lastname'],
            'members_dob'           => $validated['dob'] ?? null,
            'members_company_name' => $validated['company_name'] ?? null,
            'members_ssn_number'   => $validated['ssn_number'] ?? null,
            'members_subdomain'    => $validated['sub_domain'] ?? null,
        ]);
        // dd($member);

        return back()->with('success', 'Personal information updated successfully!');
    }

}
