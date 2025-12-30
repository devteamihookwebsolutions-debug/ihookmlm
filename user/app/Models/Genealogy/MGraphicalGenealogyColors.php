<?php

namespace User\App\Models\Genealogy;

use Illuminate\Support\Facades\DB;

class MGraphicalGenealogyColors
{
    public static function getRankcolors($matrix_id)
    {
        $prefix = config('ihook.prefix', 'ihook'); // Laravel way

        // Step 1: Get all rank titles
        $ranks = DB::table("{$prefix}_ranksetting")
            ->where('rank_key', 'rank_title')
            ->where('matrix_id', $matrix_id)
            ->orderBy('rank_id', 'ASC')
            ->get();

        if ($ranks->isEmpty()) {
            return '<li class="text-gray-500">No ranks configured</li>';
        }

        $output = '';

        foreach ($ranks as $rank) {
            $rankId   = $rank->rank_id;
            $rankName = $rank->rank_value ?? 'Unknown Rank';

            // Step 2: Get color for this rank
            $colorRow = DB::table("{$prefix}_ranksetting")
                ->where('rank_key', 'rank_color')
                ->where('rank_id', $rankId)
                ->where('matrix_id', $matrix_id)
                ->first();

            $rankColor = $colorRow->rank_value ?? '#cccccc'; // fallback gray

            $output .= '<li class="mx-5 mt-2 flex items-center gap-3">
                          <span style="background: ' . $rankColor . '; padding: 12px; border-radius: 50px; display: inline-block; width: 20px; height: 20px;"></span>
                          <p class="mb-0">' . htmlspecialchars($rankName) . '</p>
                        </li>';
        }

        return $output;
    }
}
