<?php

namespace User\App\Http\Controllers\Profile;

use Admin\App\Models\Member\Country;
use Admin\App\Models\Member\Member;
use Auth;
use Log;
use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use User\App\Models\MemberArea\MemberAreaSocialMedia;
use User\App\Models\MemberArea\MemberAreaSummary;
use User\App\Models\MemberArea\MemberAreaWebsite;

class ProfileController extends Controller
{
public function show()
{
    $member = Auth::user();
    $memberId = $member->members_id;

    // CRITICAL: Reload fresh member with the column we need
    $memberFresh = Member::select('*') // or just needed columns
        ->findOrFail($memberId);

    // Use fresh data for transaction password check
    $hasTransactionPassword = !empty($memberFresh->members_transaction_password);

    // Now load full relationships for other data
    $memberModel = Member::with(['card', 'social', 'site', 'notification'])
        ->findOrFail($memberId);

    $member_details = $memberModel->toArray();

    // Fix regform (you had syntax error)
    $regform = [
        'members_firstname'    => true,
        'members_lastname'     => true,
        'members_email'        => true,
        'members_phone'        => true,
        'members_address'      => true,
        'members_city'         => true,
        'members_state'        => true,
        'members_zip'          => true,
        'members_country'      => true,
        'members_company_name' => true,
        'members_ssn_number'   => true,
        'members_ein_number'   => true,
        'members_dob'          => true,
    ];

    // Pass both
    return view('user::profile.myprofile', [
        'member_details'          => $member_details,
        'has_transaction_password'=> $hasTransactionPassword,
        'regform'                 => $regform,

        'totalorders'       => $this->getTotalOrders($member),
        'todayearnings'     => $this->getTodayEarnings($member),
        'userlog'           => $this->getActivityLogs($member),
        'new_notification'  => $this->getNewNotifications($member),
        'directsales'       => $this->getDownlineSales($member),

        'qrCodeUrl' => $this->get2FAQr(),
        '2fa'       => ($member_details['members_two_fact'] ?? 0) == 2,
    ]);
}

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'members_firstname' => 'required|string|max:255',
            'members_email' => 'required|email',
        ]);

        $member = Member::findOrFail(session('default.customer_id'));
        $member->update([
            'members_firstname' => $request->members_firstname,
            'members_lastname' => $request->members_lastname,
            'members_company_name' => $request->members_company_name,
            'members_phone' => $request->members_phone,
            'members_email' => $request->members_email,
            'members_alternate_email' => $request->members_email2,
            'members_subdomain' => $request->members_subdomain,
        ]);


        session()->flash('success_message', 'Personal info updated successfully!');
        return redirect()->route('user::profile.myprofile');
    }

    public function updateContact(Request $request)
    {
        $member = Member::findOrFail(session('default.customer_id'));
        $member->update($request->only([
            'members_address', 'members_address2', 'members_city',
            'members_state', 'members_zip', 'members_country'
        ]));

        session()->flash('success_message', 'Contact info updated!');
        return redirect()->route('user::profile.myprofile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|min:8|confirmed',
        ]);

        $member = Member::findOrFail(session('default.customer_id'));
        $member->members_password = Hash::make($request->newpassword);
        $member->save();

        session()->flash('success_message', 'Password updated successfully!');
        return redirect()->route('user.profile.myprofile');
    }


public function updateTransactionPassword(Request $request)
{
    Log::info('Transaction Password Update Started', [
        'member_id' => Auth::user()?->members_id
    ]);

    $member = Auth::user();

    // Validation
    $request->validate([
        'transactionpassword' => 'required|min:6|confirmed',
        'transactionpassword_confirmation' => 'required',
    ]);

    // If already has transaction password → require current one
    if (!empty($member->members_transaction_password)) {
        $request->validate([
            'currenttransactionpassword' => 'required'
        ]);

        if (!Hash::check($request->currenttransactionpassword, $member->members_transaction_password)) {
            return back()
                ->withErrors(['currenttransactionpassword' => 'Current transaction password is incorrect!'])
                ->withInput();
        }
    }

    // Update password
    $member->members_transaction_password = Hash::make($request->transactionpassword);
    $saved = $member->save();

    if ($saved) {
        // SUCCESS → Use Laravel "with" so your info_message shows it
        return redirect()->route('user::profile.myprofile')
            ->with('success_message', 'Transaction password updated successfully!');
    } else {
        return back()->withErrors(['error' => 'Failed to update transaction password. Please try again.']);
    }
}

    public function checkTransactionPassword(Request $request)
    {
        $member = Member::findOrFail(session('default.customer_id'));
        $valid = Hash::check($request->currenttransactionpassword, $member->members_transaction_password);

        return response()->json(['valid' => $valid]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'members_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'members_image_cropped' => 'nullable|string',
        ]);

        $member = Member::findOrFail(session('default.customer_id'));
        $imagePath = $member->members_image;

        if ($request->has('members_image_cropped') && $request->members_image_cropped) {
            $image = str_replace('data:image/png;base64,', '', $request->members_image_cropped);
            $image = str_replace(' ', '+', $image);
            $data = base64_decode($image);
            $fileName = 'members/' . Str::random(20) . '.png';
            Storage::disk('s3')->put($fileName, $data);
            $imagePath = Storage::disk('s3')->url($fileName);
        } elseif ($request->hasFile('members_image')) {
            $fileName = 'members/' . Str::random(20) . '.' . $request->members_image->extension();
            $path = $request->file('members_image')->storeAs('members', $fileName, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $imagePath = Storage::disk('s3')->url($path);
        }

        if ($imagePath) {
            $member->members_image = $imagePath;
            $member->members_thumb_image = $imagePath;
            $member->save();
            session(['members_image' => $imagePath]);
            session()->flash('success_message', 'Avatar updated successfully!');
        }

        return redirect()->route('user::profile.myprofile');
    }

    public function toggle2FA(Request $request)
    {
        $member = Member::findOrFail(session('default.customer_id'));
        $set = $request->set == '2' ? '2' : '1';
        $verify = $set == '2' ? 1 : 0;

        $member->update([
            'members_two_fact' => $set,
            'members_login_verification' => $verify,
            'members_password_verification' => $verify,
            'gauth_codes' => 0
        ]);

        return response()->json(['status' => 'success']);
    }

    // Helper functions (you can move to service class later)
    private function getTotalOrders($member) { /* your logic */ return 10; }
    private function getTodayEarnings($member) { return 250.00; }
    private function getActivityLogs($member) { return collect(); }
    private function getNewNotifications($member) { return collect(); }
    private function getDownlineSales($member) { return collect(); }
    private function get2FAQr() { return null; }
}
