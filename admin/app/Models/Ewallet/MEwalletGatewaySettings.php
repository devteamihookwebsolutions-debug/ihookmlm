<?php

namespace Admin\App\Models\Ewallet;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;


class MEwalletGatewaySettings
{

    public static function getContent($name)
{
    // Build table name with prefix
    $table = 'ihook_sitesettings_table';

    // Fetch the value of the column
    $value = DB::table($table)
               ->where('sitesettings_name', $name)
               ->value('sitesettings_value');
// dd($value);
    return $value;
}
 public static function updateSettings($request)
    {
        // 1. Collect input
        $apiusername = $request->input('apiusername');
        $apipassword = $request->input('apipassword');
        $status = $request->input('ewallet-gateway_status') == '1' ? 1 : 0;



        // 2. Update or insert each setting
        $settings = [
            'ewallet-apiusername'   => $apiusername,
            'ewallet-apipassword'   => $apipassword,
            'ewallet-gateway_status'=> $status,
        ];

        foreach ($settings as $name => $value) {
            DB::table('ihook_sitesettings_table')
                ->updateOrInsert(
                    ['sitesettings_name' => $name],
                    ['sitesettings_value' => $value]
                );
        }

        // 3. Flash success message
        Session::flash('success', __('Ewallet gateway updated successfully'));
    }

    /**
     * Generate a random 32-character key
     */
    public static function generateKey(): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle(str_repeat($characters, 32)), 0, 32);
    }
}