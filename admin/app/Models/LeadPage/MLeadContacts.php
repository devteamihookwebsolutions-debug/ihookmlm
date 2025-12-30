<?php

namespace Admin\App\Models\LeadPage;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\currencyformat;
use Admin\App\Models\Member\CurrencySetting;
use Admin\App\Display\LeadPage\DLeadContacts;
use Illuminate\Support\Facades\Session;
class MLeadContacts
{
public static function getcurrencyformat()
{
    // Fetch the first record with id = 1
    $record = currencyformat::find(1);
// dd($record);
    // Return the record
    return $record; // or return as JSON if for API: return response()->json($record);
}
public static function allcurrency($curr)
{
    // dd($curr);
    // Fetch all currencies ordered by currency_name
    $records = CurrencySetting::orderBy('currency_value', 'asc')->get()->toArray();

// dd($records);
    // Pass the collection to your helper function
    return DLeadContacts::allcurrency($records, $curr);
}

public static function insertcurrency($request)
{
    // Validate input
    $request->validate([
        'currency' => 'required|string',
        'thousands_separator' => 'required|string',
        'decimal_separator' => 'required|string',
    ]);

    $currencyValue = $request->currency;
    $thousandsSeparator = $request->thousands_separator;
    $decimalSeparator = $request->decimal_separator;

    // Get currency symbol
    $currencyRecord = DB::table('ihook_currencysettings_table')
        ->where('currency_value', $currencyValue)
        ->first();

    if (!$currencyRecord) {
        return back()->with('error_message', 'Selected currency not found.');
    }

    $currencySymbol = $currencyRecord->currency_symbol;

    // Insert/Update site currency
    DB::table('ihook_sitesettings_table')
        ->updateOrInsert(
            ['sitesettings_name' => 'site_currency'],
            ['sitesettings_value' => $currencySymbol]
        );

    // Insert/Update currency format
    DB::table('ihook_currencyformat')
        ->updateOrInsert(
            ['id' => 1],
            [
                'thousand_seperator' => $thousandsSeparator,
                'decimal_seperator' => $decimalSeparator,
                'currency' => $currencySymbol,
                'updated_date' => now(),
            ]
        );
return back()->with('success_message', 'Format added successfully!');

}

}