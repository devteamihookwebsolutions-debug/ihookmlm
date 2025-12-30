<?php

namespace Admin\App\Display\MatrixConfig;
use Illuminate\Http\Request;


class DMatrixBinary
{

    public static function getBinaryRatio($records, $name, $id, $editable)
    {
        // Use request()->query() to get 'classname' from the URL query string
        $class = request()->query('classname', 'form-control select2');

        $output = '';  // Initialize output

        if (count($records) > 0) {
            $output .= '<select aria-label="label" id="' . e($id) . '" class="' . e($class) . '" name="' . e($name) . '">';
            
            foreach ($records as $record) {
                $selected = ($editable == trim($record['binaryratio_id'])) ? 'selected="selected"' : '';
                $output .= '<option value="' . e($record['binaryratio_id']) . '" ' . $selected . '>' . e($record['binaryratio']) . '</option>';
            }

            $output .= '</select>';
        }

        return $output;
    }

    public static function getCarryOver($records, $name, $id, $editable)
    {
        // Get class from request or fallback
        $class = request()->query('classname', 'form-control select2');

        $output = '';

        if (count($records) > 0) {
            $output .= '<select aria-label="label" id="' . e($id) . '" class="' . e($class) . '" name="' . e($name) . '">';
            foreach ($records as $record) {
                $selected = ($editable == trim($record['carryover_id'])) ? 'selected="selected"' : '';
                $output .= '<option value="' . e($record['carryover_id']) . '" ' . $selected . '>' . e($record['carryover']) . '</option>';
            }
            $output .= '</select>';
        }

        return $output;
    }



}