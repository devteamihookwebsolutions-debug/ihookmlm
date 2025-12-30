<?php

namespace User\App\Models\Rank;

use Admin\App\Models\Middleware\MGroupSalesTargetAmount;
use Admin\App\Models\Middleware\MTargetSalesAmount;
use Admin\App\Models\Middleware\MTotalGPV;
use Admin\App\Models\Middleware\MTotalPV;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use User\App\Models\Scheduler\Rank\MDirectReferal;
use User\App\Models\Scheduler\Rank\MGetLevel;
use User\App\Models\Scheduler\Rank\MGroupReferal;
use User\App\Models\Scheduler\Rank\MProduct;
use User\App\Models\Scheduler\Rank\MTarget;

class MDashboardRankProgress
{
    protected $prefix;

    public function __construct()
    {
        $this->prefix = config('services.ihook.prefix', '');
    }

    public function getRankProgress()
    {
        $user = Auth::user();
        $memberId = $user->members_id;

        // Matrix link data
        $matrixLinks = DB::table("{$this->prefix}_matrix_members_link_table")
            ->where('members_id', $memberId)
            ->get();

        if ($matrixLinks->isEmpty()) {
            return $this->fallbackRankData();
        }

        // Find valid matrix with ranks
        $matrix_id = null;
        $rank_id = 1;
        $highrankid = 0;
        $rank_achieved_date = null;

        foreach ($matrixLinks as $link) {
            $temp_matrix_id = $link->matrix_id;
            $totalRanks = DB::table("{$this->prefix}_ranksetting")
                ->where('matrix_id', $temp_matrix_id)
                ->distinct('rank_id')
                ->count();

            if ($totalRanks > 0) {
                $matrix_id = $temp_matrix_id;
                $rank_id = $link->rankid ?? 1;
                $highrankid = $link->higher_rank ?? 0;
                $rank_achieved_date = $link->rank_achieved_date;
                break;
            }
        }

        if (!$matrix_id) {
            return $this->fallbackRankData();
        }

        // Member info
        $member = DB::table("{$this->prefix}_members_table")
            ->where('members_id', $memberId)
            ->first();

        $username = $member->members_username ?? '';

        // Current rank details
        $currentRank = $this->getRankDetails($matrix_id, $rank_id);
        $current_rank_name = $currentRank['ranktitle'] ?? 'Starter';
        $current_rank_image = config('services.ihook.cdnexturl', '') . '/' . ($currentRank['rankimg'] ?? '');

        // Conditions
        $condition = $this->rankCondition($memberId, $matrix_id, $rank_id);
        if ($rank_id == 0) {
            $condition = $this->rankCondition($memberId, $matrix_id, 1);
        }

        // Next rank
        $next_rank_id = $rank_id + 1;
        $nextRank = $this->getRankDetails($matrix_id, $next_rank_id);
        $next_condition = !empty($nextRank) ? $this->rankCondition($memberId, $matrix_id, $next_rank_id) : [];
        $nextcondition_status = !empty($nextRank) ? '1' : '0';
        $next_rank_name = $nextRank['ranktitle'] ?? '';
        $next_rank_image = !empty($nextRank['rankimg']) ? config('services.ihook.cdnexturl', '') . '/' . $nextRank['rankimg'] : '';

        // Previous rank
        if ($rank_id > 1) {
            $prev = $this->getRankDetails($matrix_id, $rank_id - 1);
            $last_rank_name = $prev['ranktitle'] ?? 'No Rank';
            $last_rank_img = !empty($prev['rankimg'])
                ? config('services.ihook.cdnexturl', '') . '/' . $prev['rankimg']
                : config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png';
        } else {
            $last_rank_name = 'No Rank';
            $last_rank_img = config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png';
        }

        // Higher rank
        if ($highrankid > 0) {
            $higher = $this->getRankDetails($matrix_id, $highrankid);
            $higher_rank_name = $higher['ranktitle'] ?? 'No Higher Rank';
            $higher_rank_img = !empty($higher['rankimg'])
                ? config('services.ihook.cdnexturl', '') . '/' . $higher['rankimg']
                : config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png';
        } else {
            $higher_rank_name = 'No Higher Rank';
            $higher_rank_img = config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png';
        }

        $first_achieved = $rank_achieved_date ? Carbon::parse($rank_achieved_date)->format('F Y') : 'Nil';

        return [
            'user_name'               => $username,
            'rank_id'                 => $rank_id,
            'current_rank_name'       => $current_rank_name,
            'current_rank_image'      => $current_rank_image,
            'next_rank_name'          => $next_rank_name,
            'next_rank_image'         => $next_rank_image,
            'next_condition'          => $next_condition,
            'nextcondition_status'    => $nextcondition_status,
            'condition'               => $condition,
            'last_rank_name'          => $last_rank_name,
            'last_rank_img'           => $last_rank_img,
            'higher_rank_name'        => $higher_rank_name,
            'higher_rank_img'         => $higher_rank_img,
            'first_achieved'          => $first_achieved,
            'last_achieved'           => $first_achieved,
            'matrix_id'               => $matrix_id,
        ];
    }

    private function getRankDetails($matrix_id, $rankid)
    {
        $records = DB::table("{$this->prefix}_ranksetting")
            ->where('matrix_id', $matrix_id)
            ->where('rank_id', $rankid)
            ->whereNotNull('rank_value')
            ->where(function ($q) {
                $q->whereRaw("rank_key REGEXP '^[0-9]+$'")
                  ->orWhereIn('rank_key', ['rank_icon_path', 'rank_title', 'commission', 'bonus', 'rank_color']);
            })
            ->get();

        $data = ['rankimg' => '', 'ranktitle' => '', 'commission' => 0, 'bonus' => 0, 'color' => '#E3A008'];

        foreach ($records as $rec) {
            match ($rec->rank_key) {
                'rank_icon_path' => $data['rankimg'] = $rec->rank_value,
                'rank_title'     => $data['ranktitle'] = $rec->rank_value,
                'commission'     => $data['commission'] = $rec->rank_value,
                'bonus'          => $data['bonus'] = $rec->rank_value,
                'rank_color'     => $data['color'] = $rec->rank_value,
                default          => null,
            };
        }

        return $data;
    }

    public function rankCondition($member_id, $matrix_id, $rankid)
    {
        $records = $this->totCondition($matrix_id, $rankid);

        $return = [];

        foreach ($records as $i => $record) {

            $key = (int) $record->rank_key;
            $required = (float) $record->rank_value;  // renamed for clarity

            $current = 0;
            $name = 'Condition ' . $key;

            switch ($key) {
                case 1:
                    $current = MDirectReferal::directReferal($member_id, $matrix_id);
                    $name = 'Number of Direct Referral';
                    break;

                case 2:
                    $current = MGroupReferal::groupReferal($member_id, $matrix_id);
                    $name = 'Number of Group Referral';
                    break;

                case 3:
                    $current = MProduct::product($member_id, $matrix_id);
                    $name = 'Number of Sales';
                    break;

                case 4:
                    $current = MProduct::productSold($member_id, $matrix_id);
                    $name = 'Number of Product Sold';
                    break;

                case 5:
                    $current = MTarget::target($member_id, $matrix_id);
                    $name = 'Target Achieved';
                    break;

                case 6:
                    $current = MGetLevel::getLevel($member_id, $matrix_id, $required);
                    $name = 'Level Completion';
                    break;

                case 7:
                    $current = MTotalPV::getTotalPV($member_id, $matrix_id);
                    $name = 'Personal PV Points';
                    break;

                case 8:
                    $current = MTotalGPV::getTotalGPV($member_id, $matrix_id);
                    $name = 'Group PV Points (GPV)';
                    break;

                case 9:
                    $current = MTargetSalesAmount::salesTargetByAmount($member_id, $matrix_id);
                    $name = 'Sales Target Amount';
                    break;

                case 10:
                    $current = MGroupSalesTargetAmount::groupSalesTarget($member_id, $matrix_id);
                    $name = 'Group Sales Target Amount';
                    break;

                case 11:
                    $current = MTotalPV::getTotalPV($member_id, $matrix_id);
                    $name = 'Online Sales PV';
                    break;

                default:
                    $name = "Unknown Condition ($key)";
                    break;
            }

            // Progress bar calculation
            $bar = 0;
            if ($required > 0) {
                if ($current >= $required) {
                    $bar = 100;
                } else {
                    $bar = round(($current / $required) * 100, 2);
                }
            } else {
                $bar = 100; // No requirement = completed
            }

            // Use exact keys expected by JavaScript
            $return[] = [
                'name'     => $name,
                'current'  => $current,
                'required' => $required,
                'bar'      => $bar,
            ];
        }

        return $return;
    }


    public function totCondition($matrix_id, $rankid)
    {
        $excluded = ['rank_title', 'bonus', 'wallet_type', 'commission', 'directbonus', 'networkbonus', 'maxbonus', 'rank_icon_path', 'rank_color', 'cryptocurrency'];

        return DB::table("{$this->prefix}_ranksetting")
            ->where('rank_id', $rankid)
            ->where('matrix_id', $matrix_id)
            ->whereRaw("rank_key REGEXP '^[0-9]+$'")
            ->whereNotIn('rank_key', $excluded)
            ->orderByDesc('id')
            ->get();
    }
public function getPreviousRank($memberId, $matrix_id, $current_rank_id)
{
    $achievedRanks = $this->getAchievedRanks($memberId, $matrix_id);

    $previousAchieved = array_filter($achievedRanks, fn($id) => $id != $current_rank_id);

    if (empty($previousAchieved)) {
        return [];
    }
    rsort($previousAchieved);

    $previousRanksList = [];

    foreach ($previousAchieved as $prev_rank_id) {
        $prevRank = $this->getRankDetails($matrix_id, $prev_rank_id);

        $rank_title = $prevRank['ranktitle'] ?? 'Unknown Rank';
        $rank_image = !empty($prevRank['rankimg'])
            ? config('services.ihook.cdnexturl', '') . '/' . $prevRank['rankimg']
            : config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png';

        // Get achieved date from matrix_members_link_table
        $link = DB::table("{$this->prefix}_matrix_members_link_table")
            ->where('members_id', $memberId)
            ->where('matrix_id', $matrix_id)
            ->where('rankid', $prev_rank_id)
            ->first();

        $achieved_date = 'N/A';
        if ($link && $link->rank_achieved_date) {
            $achieved_date = Carbon::parse($link->rank_achieved_date)->format('d M Y');
        }

        $previousRanksList[] = [
            'rank_id'       => $prev_rank_id,
            'rank_title'    => $rank_title,
            'rank_image'    => $rank_image,
            'achieved_date' => $achieved_date,
        ];
    }

    return $previousRanksList; // Array of all previous achieved ranks
}

    private function getAchievedRanks($memberId, $matrix_id)
    {
        $rankIds = DB::table("{$this->prefix}_ranksetting")
            ->where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->whereNotNull('rank_value')
            ->distinct()
            ->pluck('rank_id');

        $achieved = [];
        foreach ($rankIds as $rId) {
            $conditions = $this->rankCondition($memberId, $matrix_id, $rId);
            $totalBars = array_sum(array_column($conditions, 'bar'));
            $progress = count($conditions) > 0 ? $totalBars / count($conditions) : 100;
            if ($progress >= 100) {
                $achieved[] = $rId;
            }
        }
        return $achieved;
    }

    private function fallbackRankData()
    {
        return [
            'user_name' => Auth::user()->members_username ?? '',
            'rank_id' => 1,
            'current_rank_name' => 'Starter',
            'current_rank_image' => '',
            'next_rank_name' => '',
            'next_rank_image' => '',
            'next_condition' => [],
            'nextcondition_status' => '0',
            'condition' => [],
            'last_rank_name' => 'No Rank',
            'last_rank_img' => config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png',
            'higher_rank_name' => 'No Higher Rank',
            'higher_rank_img' => config('services.ihook.ui_asset_url', '') . '/assets/img/dashboard_horizontal/no-rank.png',
            'first_achieved' => 'Nil',
            'last_achieved' => 'Nil',
            'matrix_id' => 1,
        ];
    }
}
