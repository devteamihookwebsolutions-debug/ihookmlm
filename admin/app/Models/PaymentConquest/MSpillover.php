<?php
namespace Admin\App\Models\PaymentConquest;

// use Query\Bin_Query;
// use Model\Middleware\MMembersDetails;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;

// use Model\Middleware\MFormatNumber;
// use Model\Middleware\MCryptoExchange;
// use Model\Middleware\MPackageDetails;

class MSpillover
{

    public static function setSpillover($members_id, $direct_id, $matrix_id, $matrix_type_id)
{
    if ($direct_id > 0) {
        // Get deep
        $level_deep = MatrixConfiguration::where('matrix_id', $matrix_id)
            ->where('matrix_key', 'level_deep')
            ->value('matrix_value');

        // Get width
        $level_width = MatrixConfiguration::where('matrix_id', $matrix_id)
            ->where('matrix_key', 'level_width')
            ->value('matrix_value');

        if ($matrix_type_id == '1') { // binary matrix
            $width = 2;
            $deep = 9999;
        } else {
            $width = $level_width == 0 ? 9999 : $level_width;
            $deep = $level_deep == 0 ? 9999 : $level_deep;
        }

        if ($matrix_type_id == '5') { // xup matrix
            $passupRecord = MemberLinks::where('members_id', $members_id)
                ->where('matrix_id', $matrix_id)
                ->where('members_status', '1')
                ->first();

            if ($passupRecord && $passupRecord->members_passup_id > 0) {
                $direct_id = $passupRecord->members_passup_id;
            }
        }

        // Get direct member's parents
        $directMember = MemberLinks::where('members_id', $direct_id)
            ->where('matrix_id', $matrix_id)
            ->first();

        $members_parents = $directMember->members_parents;
        $root = $directMember->root;
        $childroot = $root + 1;
        $position = 0;

        // Check spillover children count
        $children = MemberLinks::where('spillover_id', $direct_id)
            ->where('matrix_id', $matrix_id)
            ->get();

        if ($children->count() < $width) {
            $childrenmembers_parents = $members_parents ? $members_parents . ',' . $direct_id : $direct_id;

            if ($matrix_type_id == '1') {
                $position = $children->count() == 0 ? 1 : 2;
            }

            MemberLinks::where('members_id', $members_id)
                ->where('matrix_id', $matrix_id)
                ->update([
                    'spillover_id' => $direct_id,
                    'members_parents' => $childrenmembers_parents,
                    'root' => $childroot,
                    'position' => $position
                ]);

            // MongoDB update
            $where = ['members_id' => (int)$members_id, 'matrix_id' => $matrix_id];
            $update = [
                'matrix.spillover_id' => (string)$direct_id,
                'matrix.members_parents' => $childrenmembers_parents,
                'matrix.root' => (string)$childroot
            ];
          
        } else {
            // Find next spillover child
            $child = MemberLinks::where('matrix_id', $matrix_id)
                ->where('members_filled_status', 0)
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$direct_id])
                ->orderBy('root', 'ASC')
                ->orderBy('link_id', 'ASC')
                ->first();

            $members_parents = $child->members_parents;
            $childrenspilloverid = $child->members_id;
            $root = $child->root;
            $childrenmembers_parents = $members_parents . ',' . $childrenspilloverid;

            // Check spillover count
            $spillovercounttot = MemberLinks::where('spillover_id', $childrenspilloverid)
                ->where('matrix_id', $matrix_id)
                ->count();

            if ($matrix_type_id == '1') {
                $position = $spillovercounttot == 0 ? 1 : 2;
            }

            $childroot = $root + 1;
            $members_filled_status = $spillovercounttot >= $width ? 1 : 0;

            MemberLinks::where('members_id', $members_id)
                ->where('matrix_id', $matrix_id)
                ->update([
                    'spillover_id' => $childrenspilloverid,
                    'members_parents' => $childrenmembers_parents,
                    'root' => $childroot,
                    'position' => $position
                ]);

            // MongoDB update
            $where = ['members_id' => (int)$members_id, 'matrix_id' => $matrix_id];
            $update = [
                'matrix.spillover_id' => (string)$childrenspilloverid,
                'matrix.members_parents' => $childrenmembers_parents,
                'matrix.root' => (string)$childroot
            ];
           
        }

        // Update members_filled_status if full
        $iTotal = MemberLinks::where('spillover_id', $direct_id)
            ->where('matrix_id', $matrix_id)
            ->distinct('members_id')
            ->count('members_id');

        if ($iTotal >= $width) {
            MemberLinks::where('members_id', $direct_id)
                ->where('matrix_id', $matrix_id)
                ->update(['members_filled_status' => 1]);
        }
    }

    return true;
}

public static function setSpilloverByLeg($membersId, $directId, $matrixId, $matrixTypeId, $position, $width)
{
    if ($directId <= 0) return false;

    // Check if the position is already filled
    $legCount = MemberLinks::where('spillover_id', $directId)
        ->where('position', $position)
        ->orderBy('members_id', 'asc')
        ->first();

    if (!$legCount) {
        // Get the direct member
        $direct = MemberLinks::where('members_id', $directId)->first();
        if (!$direct) return false;

        $newRoot = $direct->root + 1;
        $childrenParents = $direct->members_parents ? $direct->members_parents . "," . $directId : $directId;

        // Update the current member
        $member = MemberLinks::where('members_id', $membersId)
            ->where('matrix_id', $matrixId)
            ->first();

        $member->update([
            'spillover_id' => $directId,
            'root' => $newRoot,
            'members_parents' => $childrenParents,
            'position' => $position
        ]);

       
        $spilloverId = $directId;
    } else {
        $nextSpillover = $legCount->members_id;

        // Recursive helper to get new spillover
        self::getNewSpillover($nextSpillover, $position, $membersId);

        $updatedMember = MemberLinks::where('members_id', $membersId)->first();
        $nwSpillover = $updatedMember->spillover_id;

        $direct = MemberLinks::where('members_id', $nwSpillover)->first();
        $newRoot = $direct->root + 1;
        $childrenParents = $direct->members_parents ? $direct->members_parents . "," . $nwSpillover : $nwSpillover;

        $updatedMember->update([
            'spillover_id' => $nwSpillover,
            'root' => $newRoot,
            'members_parents' => $childrenParents,
            'position' => $position
        ]);

        // Update MongoDB
   

        $spilloverId = $nwSpillover;
    }

    // Update filled status if required
    $total = MemberLinks::where('spillover_id', $spilloverId)
        ->where('matrix_id', $matrixId)
        ->distinct('members_id')
        ->count('members_id');

    if ($total >= $width) {
        MemberLinks::where('members_id', $spilloverId)
            ->where('matrix_id', $matrixId)
            ->update(['members_filled_status' => 1]);
    }

    return true;
}

public static function getNewSpillover($spilloverId, $position, $membersId)
{
    // Check if the spillover position already has members
    $nextMember = MemberLinks::where('spillover_id', $spilloverId)
        ->where('position', $position)
        ->orderBy('members_id', 'asc')
        ->first();

    if ($nextMember) {
        // Recursive call if there is already a member in this position
        self::getNewSpillover($nextMember->members_id, $position, $membersId);
    } else {
        // Update the member with the new spillover
        MemberLinks::where('members_id', $membersId)
            ->update(['spillover_id' => $spilloverId]);
    }

    return true;
}



}