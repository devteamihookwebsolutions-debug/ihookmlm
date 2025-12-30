<?php

namespace User\App\Http\Controllers\Autologin;

use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use User\App\Models\Member;
use User\App\Models\MemberArea\MemberActivity;
use Illuminate\Http\RedirectResponse;

class MemberAutoLoginController extends Controller
{
    /**
     * POST /admin/autologin/opt
     * Returns an encrypted token that contains the member_id.
     */
    public function generateToken(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'member_id' => 'required|exists:ihook_members_table,members_id'
        ]);

        $token = encrypt($request->member_id);

        return response()->json(['token' => $token]);
    }

    /**
     * GET /admin/autologin/auto/{token}/{member_id}
     * Decrypts the token, loads the member, logs the auto-login and redirects.
     */
    public function autoLogin(Request $request, $token, $member_id): RedirectResponse
    {
        try {
            $decryptedId = decrypt($token);
        } catch (\Exception $e) {
            abort(403, 'Invalid token');
        }

        if ($decryptedId != $member_id) {
            abort(403, 'Token mismatch');
        }

        $member = Member::where('members_id', $member_id)->firstOrFail();

        MemberActivity::create([
            'members_log_members_id' => $member->members_id,
            'members_log_ip_used'    => $request->ip(),
            'log'                    => "Member {$member->members_id} logged in successfully via auto-login",
            // Route name (e.g. admin.autologin.auto) – always < 240 chars
            'doname'                 => $this->shortDoname(),
            'members_log_time'       => now(),
            'created_at'             => now(),
            'created_by'             => $member->members_id,
        ]);

        if (Hash::needsRehash($member->members_password)) {
            $member->members_password = Hash::make($member->members_password);
            $member->save();
        }

        Auth::guard('web')->login($member);

        return redirect()->route('user.dashboard');
    }

    private function shortDoname(): string
    {
        $memberId = request()->route('member_id'); 
        $cleanUrl = URL::to("/admin/autologin/{$memberId}");
        return strlen($cleanUrl) > 240 ? substr($cleanUrl, 0, 237) . '...' : $cleanUrl;
    }
}