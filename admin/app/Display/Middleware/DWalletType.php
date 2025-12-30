<?php


namespace Admin\App\Display\Middleware;

use Illuminate\Http\Request;

class DWalletType
{

public static function getWalletType($records, string $name, string $id, $editable = null): string
{
    // Get the CSS class from the query parameter or use default
    $class = request()->query('classname', 'bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500');

    $output = '';

    // Check if $records is countable (array or Collection)
    if (is_countable($records) && count($records) > 0) {
        $output .= '<select aria-label="label" id="' . e($id) . '" class="' . e($class) . ' wallet" name="' . e($name) . '" required aria-describedby="wallet-error">';
        $output .= '<option value="">' . __('Select') . '</option>';

        foreach ($records as $record) {
            // Support both array or object (including Eloquent Model)
            $wallet_type_id = is_array($record) ? ($record['wallet_type_id'] ?? '') : ($record->wallet_type_id ?? '');
            $wallet_name = is_array($record) ? ($record['wallet_name'] ?? '') : ($record->wallet_name ?? '');

            $selected = ($editable !== null && trim($editable) == $wallet_type_id) ? 'selected="selected"' : '';

            $output .= '<option value="' . e($wallet_type_id) . '" ' . $selected . '>' . __($wallet_name) . '</option>';
        }

        $output .= '</select>';
    }


    return $output;


    }




}
?>