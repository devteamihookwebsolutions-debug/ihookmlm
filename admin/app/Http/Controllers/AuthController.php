<?php

namespace Admin\App\Http\Controllers;
use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Admin\App\Models\Member\Admin;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class AuthController extends Controller
{

     public function index(): View
    {
        return view('admin::auth.login');
    }  

 
    /**
     * Write code on Method
     *
     * @return response()
     */


    public function postLogin(Request $request): RedirectResponse
    {
        // Step 1: Validate input
    $request->validate([
        'admin_email' => 'required|email',
        'admin_password' => 'required',

    ], [
        'admin_email.required' => 'Email field is required.',
        'admin_password.required' => 'Password field is required.',
    ]);

    // Step 2: Find member by email
    $member = Admin::where('admin_email', $request->admin_email)->first();

    if (!$member) {
            // Email not found
            return back()->withErrors(['admin_email' => 'Email not found']);
        }

        if (!Hash::check($request->admin_password, $member->admin_password)) {
            // Password incorrect
            return back()->withErrors(['admin_password' => 'Password is incorrect']);
        }

    // Step 3: Verify password
    if ($member && Hash::check($request->admin_password, $member->admin_password)) {
        // Step 4: Manually store member info in session
        Session::put('admin_id', $member->admin_id);
        Session::put('admin_email', $member->admin_email); // Optional: store more info

        // Step 5: Redirect to dashboard
        return redirect()->route('admin.dashboard');
    }

    // Step 6: On failure, return with error
    return back()->withErrors([
        'admin_email' => 'Invalid email or password.',
    ])->withInput($request->except('admin_password'));
    }
        
     public function dashboard()
    {
           $adminId = Session::get('admin_id');

    if (!$adminId) {
        // If no admin is logged in, redirect to login page
        return redirect()->route('admin.login');
    }

    // Fetch admin data by ID (optional, but useful)
    $admin = Admin::find($adminId);


    // Pass admin data to the view
    return view('admin::auth.dashboard', compact('admin'));
        
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(Request $request)
{
    // Step 1: Remove admin session data
    Session::forget('admin_id');
    Session::forget('admin_email');

    // Optionally, clear all session data
    // Session::flush();

    // Step 2: Redirect to login page (or homepage)
    return redirect()->route('admin.login')->with('status', 'You have been logged out.');
}

   
}
