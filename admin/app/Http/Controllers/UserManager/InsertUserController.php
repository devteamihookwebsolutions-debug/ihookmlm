<?php

/**
 * This class contains public functions related to InsertUserController
 *
 * @package         InsertUserController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
