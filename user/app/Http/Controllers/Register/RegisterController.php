<?php

namespace User\App\Http\Controllers\Register;

use Admin\App\Models\Factories\MPaymentSettings;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use User\App\Http\Controllers\AuthorizeNet\AuthorizeNetController;
use Admin\App\Models\UserManager\MInsertUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use User\App\Http\Controllers\Paypal\PayPalController;
use User\App\Http\Controllers\Stripe\StripeController;
use User\App\Models\BankWire\BankWire;
use User\App\Models\Register\MRegister;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use User\App\Models\Register\Middleware\MEmailExists;
use User\App\Models\Register\Middleware\MNameExists;
use Illuminate\Support\Facades\Auth;
use User\App\Models\Register\Middleware\MRegisterMembersInsert;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
   public function index(): View
    {
        return view('user::auth.login');
    }

    public function postLogin(Request $request): RedirectResponse
    {

    $request->validate([
        'members_email' => 'required|email',
        'members_password' => 'required',
    ], [
        'members_email.required' => 'Email field is required.',
        'members_password.required' => 'Password field is required.',
    ]);

    // Find the user by email
    $member = Member::where('members_email', $request->members_email)->first();
    if (!$member) {
        // Email not found
        return back()->withErrors(['members_email' => 'Email not found']);
    }
    if (!Hash::check($request->members_password, $member->members_password)) {
        // Password incorrect
        return back()->withErrors(['members_password' => 'Password is incorrect']);
    }
    if ($member && Hash::check($request->members_password, $member->members_password)) {
        // Log in the user manually
        auth()->login($member);
        return redirect()->route('user.dashboard');
    }
    return back()->withErrors(['members_email' => 'Invalid credentials']);
    }
public function registration(): View
{
    $member = Member::first();
    $sponsorId = $member->members_id;

    Session::put('register', ['default_sponser' => $sponsorId ]);

    $paymentSettingsList = MPaymentSettings::showPaymentSettingsList();
    $bankwireGateway = $paymentSettingsList->firstWhere('paymentsettings_id', 2);
    $bankwireSpecific = MPaymentSettings::getBankwirePaymentSettings();

    $bankwire_details = [
        'paymentsettings_accname'   => $bankwireGateway->paymentsettings_accname ?? '',
        'paymentsettings_accnum'    => $bankwireGateway->paymentsettings_accnum ?? '',
        'bankwire_address'         => $bankwireSpecific['bankwire_address'] ?? '',
        'bankwire_swift_code'      => $bankwireSpecific['bankwire_swift_code'] ?? '',
        'bankwire_route'           => $bankwireSpecific['bankwire_route'] ?? '',
    ];

    return view('user::auth.registration', compact('member', 'sponsorId', 'bankwire_details'));
}


    public function postRegistration(Request $request)
    {
        $paymentMethod = $request->input('payment');
        // Store everything in session early
        Session::put('register', $request->all());
        Log::info('Session data stored', ['register_data' => $request->except(['card_number', 'cvv', 'expiry'])]);

        // PayPal (ID: 17)
        if ($request->filled('payment') && $paymentMethod == 17) {
            Log::info('Redirecting to PayPal payment', ['payment_method' => 1]);
            $paypalController = new PayPalController();
            return $paypalController->pay($request);
        }

        // Stripe (ID: 21)
        if ($request->filled('payment') && $paymentMethod == 21) {
            Log::info('Redirecting to Stripe Checkout', ['payment_method' => 21]);
            $stripeController = new StripeController();
            return $stripeController->pay($request);
        }

        // Authorize.Net (ID: 16)
        if ($request->filled('payment') && $paymentMethod == 16) {
            Log::info('Processing Authorize.Net payment - Raw input check', [
                'payment_method' => 16,
                'has_card_number' => $request->has('card_number'),
                'has_expiry' => $request->has('expiry'),
                'has_cvv' => $request->has('cvv'),
                'card_holder' => $request->input('card_holder_name'),
                'email' => $request->input('email')
            ]);

            // First check if required fields exist at all
            $cardNumber = $request->input('card_number');
            $expiry = $request->input('expiry');
            $cvv = $request->input('cvv');
            $holderName = $request->input('card_holder_name');

            if (!$cardNumber || !$expiry || !$cvv || !$holderName) {
                Log::warning('Authorize.Net: Missing card fields', [
                    'card_number_present' => !empty($cardNumber),
                    'expiry_present' => !empty($expiry),
                    'cvv_present' => !empty($cvv),
                    'holder_present' => !empty($holderName)
                ]);

                return redirect()->back()
                    ->withErrors([
                        'card_number' => !$cardNumber ? 'Card number is required.' : null,
                        'expiry'      => !$expiry ? 'Expiry date is required.' : null,
                        'cvv'         => !$cvv ? 'CVV is required.' : null,
                        'card_holder_name' => !$holderName ? 'Card holder name is required.' : null,
                    ])
                    ->withInput()
                    ->with('error', 'Please fill all card details correctly.');
            }

            $validator = Validator::make($request->all(), [
                'card_holder_name' => 'required|string|max:100',
                'card_number'      => 'required',
                'expiry'           => ['required', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'],
                'cvv'              => 'required|digits_between:3,4',
            ]);

            // Manual card number validation - allows spaces
            $cleanCardNumber = preg_replace('/\D/', '', $request->input('card_number'));
            if (strlen($cleanCardNumber) < 13 || strlen($cleanCardNumber) > 19) {
                $validator->errors()->add('card_number', 'Card number must be between 13 and 19 digits.');
            }

            if ($validator->fails()) {
                Log::warning('Authorize.Net validation failed', [
                    'errors' => $validator->errors()->all(),
                    'submitted_card' => $request->input('card_number'),
                    'clean_digits' => $cleanCardNumber,
                    'digit_count' => strlen($cleanCardNumber)
                ]);

                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Please correct the card details.');
            }

            Log::info('Authorize.Net card validation passed');

            // Safe explode
            if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $expiry, $matches)) {
                return back()->withErrors(['expiry' => 'Invalid expiry format'])->withInput();
            }

            $expMonth = (int) $matches[1];
            $expYearShort = (int) $matches[2];
            $expYear = 2000 + $expYearShort;

            $expiryDate = \Carbon\Carbon::createFromDate($expYear, $expMonth, 1)->endOfMonth();

            if ($expiryDate->isPast()) {
                Log::warning('Authorize.Net: Card expired', ['expiry' => $expiry]);
                return back()
                    ->withErrors(['expiry' => 'The card has already expired.'])
                    ->withInput();
            }

            Log::info('Card expiry valid', ['expires' => "$expMonth/$expYear"]);

            $request->merge([
                'exp_month' => str_pad($expMonth, 2, '0', STR_PAD_LEFT),
                'exp_year'  => $expYear,
            ]);

            Session::put('register', $request->all());

            Log::info('Calling AuthorizeNetController@pay - All checks passed');
            $authorizeController = new AuthorizeNetController();
            return $authorizeController->pay($request);
        }

        $success = MRegister::redirectMembers($request);

        if ($success) {
            Log::info('Free registration successful', ['session_cleared' => true]);
            Session::forget('register');
            Session::flash('success_message', 'Your registration was successful');
            return redirect()->route('user.thankyou');
        }

        Log::error('Registration failed in MRegister::redirectMembers');
        return back()->with('error', 'Registration failed. Please try again.');
    }

    public function dashboard()
    {
         return view('user::auth.dashboard');
    }

     public function thankyou()
    {
         return view('user::auth.thankyou');

    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    public function checkEmail(Request $request)
    {
            $request->validate([
            'email' => 'required|email',
        ]);
         $email = $request->input('email');

         $checker = new MEmailExists();
        $exists = $checker->checkRegisterEmailExists($email);

        return response()->json(['exists' => $exists]);
    }

    public function checkUsername(Request $request)
    {

        $username = $request->input('username');
        $checker = new MNameExists();
        $exists = $checker->checkUserNameExists($username);
        return response()->json(['exists' => $exists]);

    }

        public function getState(Request $request)
    {
        $countryCode = $request->input('country');
        $states = getStatesByCountryCode($countryCode);
        return response()->json($states);
    }

        public function fetchState(Request $request)
    {
        $countryCode = $request->input('sortname'); // from JS
        $states = getStatesByCountryCode($countryCode);
        return response()->json(['states' => $states]);
    }

    public function setSponsorDetails(Request $request)
    {

        try {
            $sponsorUsername = $request->input('reg_sponsor_id');

            if (empty($sponsorUsername)) {
                return response()->json(['error' => 'Sponsor ID is required.'], 400);
            }

            // Example lookup
            $sponsor = Member::select(
                'members_id',
                'members_username',
                'members_firstname',
                'members_lastname',
                'members_email',
                'members_phone'
            )->where('members_username', $sponsorUsername)->first();

            if (!$sponsor) {
                return response()->json(['error' => 'This sponsor ID does not exist. Please choose another.'], 404);
            }

            $isActiveSponsor = MemberLinks::where('members_id', $sponsor->members_id)
                ->where('members_account_status', 1)
                ->where('members_status', 1)
                ->exists();

            if (!$isActiveSponsor) {
                return response()->json(['error' => 'Sponsor is inactive.'], 404);
            }

            return response()->json([
                'sponsor_id'       => $sponsor->members_id,
                'sponsor_username' => $sponsor->members_username,
                'sponsor_email'    => $sponsor->members_email,
                'sponsor_phone'    => $sponsor->members_phone,
            ]);

        } catch (\Throwable $e) {
            \Log::error('setSponsorDetails error', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }

    }

    public function verifyEpin(Request $request)
    {
        $request->validate([
            'epin_code' => 'required|string|max:20'
        ]);

        $epinCode = trim($request->epin_code);

        $epin = DB::table('ihook_epin_table')
            ->where('epin_code', $epinCode)
            ->first();

        if (!$epin) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired E-pin code.'
            ]);
        }

        if ($epin->epin_status == 1) {
            return response()->json([
                'success' => false,
                'message' => 'This E-pin has already been used by another user.'
            ]);
        }

        if ($epin->epin_status == 0) {
            return response()->json([
                'success' => true,
                'message' => 'Valid E-pin!',
                'amount' => $epin->epin_amount,
                'package_id' => $epin->epin_package ?? null
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'This E-pin is not available for use.'
        ]);
    }

  public function completeRegistrationAfterPayment(Request $request, $paymentId = null, $amount = null)
{
    Log::info('completeRegistrationAfterPayment() called', [
        'payment_id' => $paymentId,
        'amount'     => $amount,
        'request'    => $request->all()
    ]);

    $sessionData = Session::get('register', []);

    Log::info('Session data retrieved', $sessionData);

    $request->merge($sessionData);

    $success = MRegister::redirectMembers($request);

    if (!$success) {
        Log::error('MRegister::redirectMembers failed after payment');
        return false;
    }

    $username = $request->input('user_name') ?? $request->input('members_username');
    $member = Member::where('members_username', $username)->first();

    if (!$member) {
        Log::error('Could not find newly registered member by username');
        return false;
    }

    $members_id = $member->members_id;

    Log::info('Registration completed successfully', ['members_id' => $members_id]);

    Session::forget('register');

    return $members_id;
}

}
