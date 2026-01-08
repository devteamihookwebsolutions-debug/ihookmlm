<?php
namespace Admin\App\Http\Controllers\LeadPage;

use Admin\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Admin\App\Models\LeadPage\MLeadContacts;
use Exception;

class  LeadContactsController extends Controller
{


public function currencysetting()
{
    // Get currency settings from model
    $currencySettings = MLeadContacts::getcurrencyformat();
  // dd($currencySettings);

 // $currencySeparator=$currencySettings->thousand_seperator;

 // dd($currencySeparator);
    // Get active currency from DB
    $getcurrencyformat = DB::table('ihook_currencyformat')
        ->where('id', 1)
        ->first();

 // GET CURRENCY SYMBOL
$currencySymbol=$getcurrencyformat->currency;

//dd($currencySymbol);


// GET CURRENCY DETAILS
$currencyDetails = DB::table('ihook_currencysettings_table')
    ->where('currency_symbol', $currencySymbol)
    ->first();

     // dd($currencyDetails);



    // If no active currency is found, provide default values
    if (!$getcurrencyformat) {
      //  dd("insideloop");
        $getcurrencyformat = (object)[
            'currency' => 'USD',           // default currency
            'thousand_seperator' => '10',  // default thousand separator
            'decimal_seperator' => '2',    // default decimal separator
        ];
    }

    // Get the currency code
    $curr = $getcurrencyformat->currency;



    // Get all currencies
    $allCurrency = MLeadContacts::allcurrency($curr);
//dd($allCurrency);
    // Return Blade view with data


    // return view('bulkuserupload.currencysetting', [
    //     'currency_settings' => $currencySettings,
    //     'allcurrency' => $allCurrency,
    //     'getcurrencyformat' => $getcurrencyformat, // pass to Blade safely
    //     'success' => session('success'),
    //     'error_message' => session('error_message'),
    // ]);

      return view('bulkuserupload.currencysetting', [
        'currency_settings' => $currencySettings,
        'allcurrency' => $allCurrency,
        'getcurrencyformat' => $currencyDetails, // pass to Blade safely
        'success' => session('success'),
        'error_message' => session('error_message'),
    ]);


//currencyDetails

}
public function insertcurrency(Request $request) // inject Request


{
    // Call model function with request
    return MLeadContacts::insertcurrency($request);
}
}
