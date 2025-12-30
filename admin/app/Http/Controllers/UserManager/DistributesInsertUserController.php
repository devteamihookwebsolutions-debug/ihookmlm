<?php

namespace Admin\App\Http\Controllers\UserManager;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Session;
use Illuminate\Support\Facades\Validator;
use Admin\App\Models\UserManager\MInsertUser;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\Country;
use Admin\App\Models\Member\State;
use Admin\App\Models\Member\Plan;
use Admin\App\Http\Controllers\Controller;

class DistributesInsertUserController extends Controller
{

public function index(){
    return view('admin::distributors.distributors');
}
public function fetch(Request $request)
{
    // IMPORTANT: Tell Laravel to parse JSON input
    $input = $request->json()->all();

    $take = $input['take'] ?? 10;
    $skip = $input['skip'] ?? 0;
    $requiresCounts = $input['requiresCounts'] ?? false;

    // Build base query
    $query = Member::leftJoin(
            'ihook_matrix_members_link_table',
            'ihook_matrix_members_link_table.members_id',
            '=',
            'ihook_members_table.members_id'
        )
        ->leftJoin(
            'ihook_members_table as directid',
            'directid.members_id',
            '=',
            'ihook_matrix_members_link_table.direct_id'
        )
        ->select(
            'ihook_members_table.*',
            'ihook_matrix_members_link_table.link_id',
            'ihook_matrix_members_link_table.members_parents',
            'directid.members_username as directid_username'
        );



if (!empty($input['search']) && isset($input['search'][0]['key'])) {

    $searchKey = $input['search'][0]['key'];

    $query->where(function ($q) use ($searchKey) {
        $q->where('ihook_members_table.members_username', 'LIKE', "%{$searchKey}%")
          ->orWhere('ihook_members_table.members_email', 'LIKE', "%{$searchKey}%")
          ->orWhere('ihook_members_table.members_firstname', 'LIKE', "%{$searchKey}%")
          ->orWhere('ihook_members_table.members_lastname', 'LIKE', "%{$searchKey}%")
          ->orWhere('directid.members_username', 'LIKE', "%{$searchKey}%");
    });
}

    if (!empty($input['where'])) {
        
    }

    if (!empty($input['sorted'])) {
        foreach ($input['sorted'] as $sort) {

            // Column name from grid
            $column = $sort['name'];

            // Direction fix
            $direction = strtolower($sort['direction']) === 'ascending' ? 'asc' : 'desc';

            //  Map grid fields to DB columns (IMPORTANT)
            $columnMap = [
                'members_id'         => 'ihook_members_table.members_id',
                'members_username'   => 'ihook_members_table.members_username',
                'members_email'      => 'ihook_members_table.members_email',
                'members_firstname'  => 'ihook_members_table.members_firstname',
                'members_lastname'   => 'ihook_members_table.members_lastname',
                'directid_username'  => 'directid.members_username',
                'members_status'     => 'ihook_members_table.members_status',
                'account_status'     => 'ihook_members_table.account_status',
            ];

            // Apply sorting only if column is allowed
            if (isset($columnMap[$column])) {
                $query->orderBy($columnMap[$column], $direction);
            }
        }
    } else {
        // Default sorting
        $query->orderByDesc('ihook_members_table.members_id');
    }


    // Get total count before pagination
    $totalRecords = $query->count();

    //  dd($totalRecords);
    // Apply pagination
    $members = $query->skip($skip)->take($take)->get();

    // Add country & state names
    foreach ($members as $member) {
        $member->country_name = getCountryByCode($member->members_country)->country_master_name ?? '-';
        $member->state_name   = getStatesWithId($member->members_state)->state_name ?? '-';

          //  Status conversion (NUMBER → TEXT)
    if ($member->members_status == 1) {
        $member->members_status_text = 'Active';
    } else {
        $member->members_status_text = 'Pending';
    }
    }

    // dd($members);
    // This is the EXACT format Syncfusion expects when requiresCounts: true
    return response()->json([
        "result" => $members,
        "count"  => $totalRecords
    ]);
}

public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $exists = Member::where('members_email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
        ]);

        $username = $request->input('username');
        $exists = Member::where('members_username', $username)->exists();

        return response()->json(['exists' => $exists]);
    }

public function fetchState(Request $request)
    {
        $states = getStatesByCountryCode($request->sortname);
        return response()->json(['states' => $states]);
    }
public function adddistrbutors()
  {
      return view('admin::distributors.add_distributors');
  }

    public function insertUser(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'email' => 'required|email|unique:ihook_members_table,members_email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8',
            'repassword' => 'required|min:8|same:password',
            'address' => 'required',
            'phone' =>  ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'matrix_id' => 'required',
            'zipcode' => 'required',
            'sponsor_id'=>'required',
            'package'=>'required'
        ]);

        $data = $request->all();
        // echo "<pre>";
        // print_r($data);exit;

     try {
        $userInserter = new MInsertUser();
        // dd($userInserter);
        $success = $userInserter->insertUser($request);
        // dd($success);
        //   $userInserter = new MInsertUser();
        //    $success = $userInserter->insertUser($request);
        //    dd($success);exit;
        if ($success) {
            //  show success message
            return redirect()->route('admin.distributors.index')->with('success', 'Member has been successfully registered!');
        } else {
            return redirect()->back()->with('error', 'Member registration failed.');
        }


    } catch (\Exception $e) {
        // Log or debug
        // Log::error($e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
}
?>
