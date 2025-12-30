<?php

namespace Admin\App\Http\Controllers\UserManager;
use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Validator;
// use App\Models\UserManager\InsertUser; // Assumes you have this model
// use App\Models\Middleware\AdminActivityLog; // Assumes you have this model

class InsertUserController extends Controller
{
    public function __construct()
    {
        // You can use Laravel middleware for auth instead of manual session check
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin.id')) {
        //         return redirect()->to(env('BCPATH') . '/adminlogin');
        //     }
        //     return $next($request);
        // });
    }

    /**
     * Handle the request to insert a user
     */
    public function insert(Request $request)
    {
        // dd($request->all());
        try {
            // Validate the request inputs (custom validation logic if needed)
            $this->validateInsertUser($request);

            // Log admin activity
            // AdminActivityLog::log('Usermanager - Add User');

            // Insert the user (make sure your model handles the logic)
            InsertUser::insertNewUser($request->all());

            return redirect()->back()->with('success_message', 'User added successfully.');

        } catch (\Exception $e) {
            Log::error('Error inserting user: ' . $e->getMessage());
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }

    /**
     * Validate user input (You can extract this to FormRequest if needed)
     */
    protected function validateInsertUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:ihook_members_table,members_email',
            'user_name' => 'required|unique:ihook_members_table,members_username',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ]);
    }
}
