<?php


namespace Admin\App\Display\Middleware;

use Illuminate\Http\Request;

class DMatrixTypes
{

    /**
     * Generate the matrix type select dropdown.
     *
     * @param array $recordSet
     * @param int $matrix_type_id
     * @return string
     */
  public static function getMatrixTypes($recordSet, $count, $matrix_type_id)
{

$output = '';
$selectedMatrixTypeId = intval($matrix_type_id); // current selected value

// Determine if the select should be read-only
$isReadonly = !empty($selectedMatrixTypeId);

// Start select tag (classes kept intact)
$output = '<select id="matrix_type_id" aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="matrix_type_id" required aria-describedby="matrixtypeid-error" ' . ($isReadonly ? 'disabled' : '') . '>';
$output .= '<option value="">' . __('Select') . '</option>';

// Loop through recordSet
foreach ($recordSet as $record) {
    $selected = ($record['matrix_type_id'] == $selectedMatrixTypeId) ? ' selected="selected"' : '';
    $output .= '<option value="' . intval($record['matrix_type_id']) . '"' . $selected . '>' . ucfirst($record['matrix_type_name']) . '</option>';
}

$output .= '</select>';

// If readonly, add hidden input to submit the value
if ($isReadonly) {
    $output .= '<input type="hidden" name="matrix_type_id" value="' . intval($selectedMatrixTypeId) . '">';
}

return $output;
}


}
