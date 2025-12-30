<?php

namespace Admin\App\Models\Middleware;
use User\App\Models\Matrix;
use DateTime;

class MMatrixList
{

    public static function getMatrixList()
    {
        return Matrix::where('matrix_status', '1')->get();
    }

    public static function showMatrixList($selectedId, $name, $onchangeScript)
    {
        $matrices = Matrix::where('matrix_status', '1')->get();

        $html = "<select name='{$name}' onchange=\"{$onchangeScript}\">";

        foreach ($matrices as $matrix) {
            $selected = ($matrix->id == $selectedId) ? 'selected' : '';
            $html .= "<option value='{$matrix->id}' {$selected}>{$matrix->name}</option>";
        }

        $html .= "</select>";

        return $html;
    }

}
