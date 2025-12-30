<?php
namespace Admin\App\Display\LeadPage;

class DLeadContacts
{
public static function allcurrency($records, $curr)
{
    $output = ''; // Initialize the variable first
// dd($curr);
    if (count((array)$records) > 0) {
        for ($i = 0; $i < count((array)$records); $i++) {
            $selected = ($curr == $records[$i]['currency_symbol']) ? 'selected=selected' : '';
            $output .= '<option value="' . $records[$i]['currency_value'] . '" ' . $selected . '>' 
                        . $records[$i]['currency_name'] . ' (' . $records[$i]['currency_symbol'] . ')</option>';
        }
    }

    // dd($output); // Optional: use this for debugging
    return $output;
}


}