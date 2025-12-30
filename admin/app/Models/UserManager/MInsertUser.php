<?php

namespace Admin\App\Models\UserManager;
use Admin\App\Models\UserManager\MInsertUserDetails;
use Admin\App\Models\UserManager\MInsertUserMatrixLinkDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MFormatNumber;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\UserManager\MBinaryPositionSpillover;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\Matrix;
use User\App\Models\PaymentHistory;
use Admin\App\Models\PaymentConquest\MInsertPaymentHistory;


class MInsertUser
{

//   public function insertUser(Request $request)
    public function insertUser(Request $request)

    {

       $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:ihook_members_table,members_email',
            'user_name' => 'required|unique:ihook_members_table,members_username',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ]);


        if ($validator->fails()) {
        // dd($validator->errors()); //stop and see errors
    }

    $data = $request->all();
    //  echo "<pre>";
    //  print_r($data);exit;
    $date = $data['date'] ?? null;
    $month = $data['month'] ?? null;
    $year = $data['year'] ?? null;
    $fullDate = DateTime::createFromFormat('d-m-Y', "$date-$month-$year");
    $formattedDate = $fullDate ? $fullDate->format('Y-m-d') : null;
    $transactionId = implode('', array_map(fn () => rand(0, 9), range(1, 10))) ?? null;
    $members_username = $data['user_name'];
    $members_firstname = $data['first_name'];
    $members_lastname = $data['last_name'];
    $members_email = $data['email'];
    $members_password = Hash::make($data['password']);
    $members_dob = $formattedDate;
    $members_address = $data['address'] ?? '';
    $members_country = $data['country'] ?? '';
    $members_state = $data['state'] ?? '';
    $members_city = $data['city'] ?? '';
    $members_zip = $data['zipcode'] ?? '';
    $members_phone = $data['phone'] ?? '';
    $members_plans = $data['plans'] ?? '';
    $members_payment_id = $data['payment'] ?? null;
    $members_subscription_plan = $data['Package'];
    $members_package = $data['Package'] ?? '';
    // dd($members_subscription_plan);
    $direct_id = $data['sponsor_id'] ?? null;

    $members_group_id = '1';
    $members_from = '1';
    $members_status = '1';
        //  member insert start
        $insertUserDetails = new MInsertUserDetails();
        $members_id = $insertUserDetails->insertUserDetails(
                        $members_username, $members_password, $members_email,
                        $members_firstname, $members_lastname, $members_state, $members_city,
                        $members_address, $members_phone, $members_zip, $members_country,
                        $members_from, $members_dob,$members_payment_id,null
        );


        //end: insert in userdetails

        //start: insert in payment history

if ($members_id > 0) {
//    dd('funcrion reached or not');
    $where = 'WHERE paymentsettings_default_name="admin_credits"';
    $paymentgatewaydetails = MPaymentGatewayDetails::getPaymentGatewayDetailss($where);
    //  dd($paymentgatewaydetails);
   $paymenthistory_mode = $paymentgatewaydetails->paymentsettings_id;
    // dd($paymenthistory_mode);
    $preferred_payment_method = $paymentgatewaydetails->paymentsettings_id;
    // dd($preferred_payment_method);
    $paymenthistory_trans_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
    $paymenthistory_type = 'upgrade';
    $paymenthistory_status = 'notpaid';

    $matrix_id = 1;

    $matrix_config = MMatrixConfiguration::getMatrixConfigurationDetail($matrix_id, 'members_account_type');
    $members_account_values = array_column($matrix_config->toArray(), 'matrix_value');

    // default values
    $paymenthistory_amount = 0;
    $members_subscription_plan = $members_subscription_plan ?? 0;
    $members_subscription_status = 0;
    $package_name = '';

    // ACCOUNT TYPE: 1 → FREE
    if (in_array('1', $members_account_values)) {

        $paymenthistory_amount = 0;
        $members_subscription_status = 0;

    }
    // ACCOUNT TYPE: 3 → PAID
    elseif (in_array('3', $members_account_values)) {

        $members_paid_account_type =
            MMatrixConfiguration::getMatrixConfigurationDetail($matrix_id, 'members_paid_account_type');

        $paid_account_value = $members_paid_account_type->pluck('matrix_value')->first();

        if ($paid_account_value == '1') {

            $members_subscription_status = -1;

            $purchasepackagedetails = MPackageDetails::getParamPackageDetails(
                'package_price,package_name',
                $members_subscription_plan
            );

            $paymenthistory_amount = $purchasepackagedetails->package_price;
            $package_name = $purchasepackagedetails->package_name;

        } else {

            $matrixdetails = MMatrixConfiguration::getMatrixConfigurationDetail($matrix_id, 'registration_fee');

            $paymenthistory_amount = $matrixdetails->matrix_value ?? 0;
            $members_subscription_plan = 0;
            $members_subscription_status = 0;

        }

    }
    // ACCOUNT TYPE: 2 → PACKAGE BASED
    elseif (in_array('2', $members_account_values)) {

        if (!empty($members_subscription_plan)) {

            $purchasepackagedetails = MPackageDetails::getParamPackageDetails(
                'package_price,package_name',
                $members_subscription_plan
            );

            if ($purchasepackagedetails) {
                $paymenthistory_amount = $purchasepackagedetails->package_price;
                $package_name = $purchasepackagedetails->package_name;
            }

        } else {

            $matrixdetails = MMatrixConfiguration::getMatrixConfigurationDetail($matrix_id, 'registration_fee');

            $paymenthistory_amount = $matrixdetails->matrix_value ?? 0;
            $members_subscription_plan = 0;
            $members_subscription_status = 0;
        }
    }
$raw_amount = floatval($paymenthistory_amount);  // RAW NUMBER for DB
$format_paymenthistory_amount = MFormatNumber::formatingNumberCurrency($paymenthistory_amount); // DISPLAY ONLY

$result = PaymentHistory::create([
    'paymenthistory_member_id' => $members_id,
    'paymenthistory_amount' => $raw_amount,           // No comma, no formatting
    'payment_amt_exclusive' => $raw_amount,           // No comma, no formatting
    'paymenthistory_mode' => $paymenthistory_mode,
    'paymenthistory_trans_id' => $paymenthistory_trans_id,
    'paymenthistory_date' => now(),
    'paymenthistory_type' => $paymenthistory_type,
    'paymenthistory_status' => $paymenthistory_status,
    'matrix_id' => $matrix_id,
    'paymenthistory_plan_id' => $members_subscription_plan,
]);
     //end: insert  in payment history

// dd($result);

// Fetch sponsor details
$sponsor = Member::where('members_id', $direct_id)->first();
// dd($sponsor);
if ($sponsor) {
    $position_direct_id = $sponsor->members_id;
    // dd($position_direct_id);
    $sponsor_id = $sponsor->members_id;
    // dd($sponsor_id);
    $sponsor_username = $sponsor->members_username;
    // dd($sponsor_username);
} else {
    // Handle the case where sponsor is not found
    $position_direct_id = null;
    $sponsor_username = null;
}

// Fetch matrix details
$matrix = Matrix::find($matrix_id);
// dd($matrix);
if ($matrix) {
    $matrixname = $matrix->matrix_name;
    // dd($matrixname);
    $matrix_type_id = $matrix->matrix_type_id;
    // dd($matrix_type_id);
} else {
    // Handle the case where matrix is not found
    $matrixname = null;
    $matrix_type_id = null;
}
// ----------------------------------------
// CORRECT AUTO POSITION LOGIC (Left → Right → Spillover)
// ----------------------------------------

$leftExists = MemberLinks::where('direct_id', $position_direct_id)
    ->where('matrix_id', $matrix_id)
    ->where('position', 1)
    ->exists();

$rightExists = MemberLinks::where('direct_id', $position_direct_id)
    ->where('matrix_id', $matrix_id)
    ->where('position', 2)
    ->exists();

if (!$leftExists) {
    $position = 1;


} elseif (!$rightExists) {
    $position = 2;

} else {
   
}

//get member parent start
if ($position > 0 && $matrix_type_id == '1') {
    // dd('condition reached or not');
    // Get spillover ID from position
    $spillover_id = MBinaryPositionSpillover::getSpilloverFromPosition($matrix_id, $position, $position_direct_id);
    // dd($spillover_id);

    // Fetch matrix link details
    $matrixLink = MemberLinks::where('members_id', $spillover_id)
                                  ->where('matrix_id', $matrix_id)
                                  ->first();
// dd($matrixLink);
    if ($matrixLink) {
        // dd('funciron reached or not');
        $parentroot = $matrixLink->root;
        // dd($parentroot);
        $sponsor_members_parents = $matrixLink->members_parents;
// dd($sponsor_members_parents);
        $root = $parentroot + 1;
        // dd($root);
        $members_parents = $sponsor_members_parents . ',' . $spillover_id;
        // dd($members_parents);
    } else {
        $root = 0;
        $members_parents = '0';
    }
} else {
    $root = 0;
    $members_parents = '0';
}
 // end member parents 
            $entry_criteria = 'admin';
            $usertype = 'admin';
            // tempmode logic: if account type 2 use offline else freeplan (you used members_account_type earlier)
            $tempmode = (in_array('2', $members_account_values)) ? 'offline' : 'freeplan';
            // dd($tempmode);
            $stripe_cusid = '';
            $stripe_subid = '';
            $chargebee_subid = '';
            $members_subscription_expirydate = '0000-00-00';
        $result = MinsertUserMatrixLinksDetails::insertUserMatrixLinkDetails(
            $members_id,
            $sponsor_id,
            $matrix_id,
            $members_subscription_plan,
            $entry_criteria,
            $paymenthistory_mode,
            $spillover_id,
            $position,
            'admin_register',
            $usertype,
            $sponsor_username,
            $root,
            $members_parents,
            $tempmode,
            $matrix_type_id,
            $stripe_cusid,
            $stripe_subid,
            $chargebee_subid,
            $members_subscription_expirydate
        );


               return redirect()->route('admin.distributors.index')->with('success', __('Member has been successfully registered'));
            } else {
                return redirect()->route('admin.distributors.index')->with('error', __('Member has not been registered'));
            }
}
 //start: insert in martix members link
        

  
}

