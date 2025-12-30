<?php

namespace Display\Middleware;
namespace Admin\App\Http\Display\Middleware;
class DCryptoCurrency
{

    public static function getCryptoCurrency($records, $editable = null)
{
    if ($records->isEmpty()) {
        return '<select id="cryptocurrency" name="cryptocurrency" 
                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                <option value="">-- No active currency found --</option>
            </select>';
    }

    $output = '<select id="cryptocurrency" name="cryptocurrency" 
                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">';
    $output .= '<option value="">-- Select currency --</option>';

    foreach ($records as $record) {
        $selected = ($editable == trim($record->crypto_currency_id)) ? 'selected' : '';
        $output .= '<option value="' . $record->crypto_currency_id . '" ' . $selected . '>' 
                    . strtoupper(e($record->crypto_name)) . '</option>';
    }

    $output .= '</select>';

    return $output;
}

}