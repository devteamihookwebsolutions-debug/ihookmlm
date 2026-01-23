<?php

/**
 * This class contains public functions related to MGraphicalGenealogyColors
 *
 * @package         MGraphicalGenealogyColors
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Genealogy;

use Admin\App\Models\Member\RankSetting;


class MGraphicalGenealogyColors
{


public static function getRankColors($matrixId)
{
    // dd($matrixId);
    $rankGroups = RankSetting::where('matrix_id', $matrixId)
        ->whereIn('rank_key', ['rank_title', 'rank_color'])
        ->orderBy('rank_id')
        ->get()
        ->groupBy('rank_id');

        // dd($rankGroups);
    $output = '';

    foreach ($rankGroups as $settings) {
        $title = $settings->firstWhere('rank_key', 'rank_title')?->rank_value;
        $color = $settings->firstWhere('rank_key', 'rank_color')?->rank_value ?? '#cccccc';

        if (!$title) continue;

        $output .= '<li class="mx-5 mt-2 flex items-center gap-3">
                        <span class="inline-block w-8 h-8 rounded-full" style="background: ' . e($color) . '"></span>
                        <p class="mb-0">' . e($title) . '</p>
                    </li>';
    }
// dd($output);
    return $output;
}
}
