<?php
namespace Admin\App\Models\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class MBinaryBottomUser
{


     public static function getBottomUser($members_id, $matrix_id)
{
    $positionLeft = '1';
    $positionRight = '2';


    // 1. Find the maximum root for the member in the matrix
    $regRoot = MemberLinks::where('matrix_id', $matrix_id)
        ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
        ->max('root');

        

    // Initialize output
    $leftUser = $members_id;
    $rightUser = $members_id;

    // 2. Get the leftmost user (position = 1)
    if ($positionLeft === '1') {
        // Find all left descendants of this member
        $leftDescendants = MemberLinks::where('matrix_id', $matrix_id)
            ->where('position', '1')
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
            ->pluck('members_id')
            ->toArray();

        if (!empty($leftDescendants)) {
            // Find the deepest leftmost descendant (no further children in position 1)
            foreach ($leftDescendants as $descendantId) {
                $hasChild = MemberLinks::where('matrix_id', $matrix_id)
                    ->where('position', '1')
                    ->whereRaw("FIND_IN_SET(?, members_parents)", [$descendantId])
                    ->exists();

                if (!$hasChild) {
                    $leftUser = $descendantId;
                    break; // stop at the deepest leftmost descendant
                }
            }
        }

        // Update left_most_members_id
        MemberLinks::where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->update(['left_most_members_id' => $leftUser]);
    }

    // 3. Get the rightmost user (position = 2)
    if ($positionRight === '2') {
        // Find all right descendants of this member
        $rightDescendants = MemberLinks::where('matrix_id', $matrix_id)
            ->where('position', '2')
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
            ->pluck('members_id')
            ->toArray();

        if (!empty($rightDescendants)) {
            // Find the deepest rightmost descendant (no further children in position 2)
            foreach ($rightDescendants as $descendantId) {
                $hasChild = MemberLinks::where('matrix_id', $matrix_id)
                    ->where('position', '2')
                    ->whereRaw("FIND_IN_SET(?, members_parents)", [$descendantId])
                    ->exists();

                if (!$hasChild) {
                    $rightUser = $descendantId;
                    break; // stop at the deepest rightmost descendant
                }
            }
        }

        // Update right_most_members_id
        MemberLinks::where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->update(['right_most_members_id' => $rightUser]);
    }


    return ['leftuser' => $leftUser, 'rightuser' => $rightUser];
}
    

}