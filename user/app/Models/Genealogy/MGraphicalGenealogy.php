<?php

namespace User\App\Models\Genealogy;

use Admin\App\Models\Middleware\MBinaryMembersPosition;
use DB;

class MGraphicalGenealogy
{
  public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        // Get root member details
        $binaryParentDetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetRoot = null);

        $directId        = $binaryParentDetails['direct_id'];
        $memberName      = $binaryParentDetails['membername'];
        $memberPhone     = $binaryParentDetails['members_phone'];
        $memberEmail     = $binaryParentDetails['members_email'];
        $memberImagePath = $binaryParentDetails['members_image'] ? '/'.$binaryParentDetails['members_image'] : '/assets/img/avatar/avatar.png';
        $memberImage     = asset($memberImagePath);
        $parentRoot      = $binaryParentDetails['root'];
        $rankTitle       = $binaryParentDetails['ranktitle'] ?: 'Nil';
        $sponsorUsername = $directId > 0 ? $binaryParentDetails['sponsor_username'] : 'Nil';
        $rankIconPath    = $binaryParentDetails['rank_icon_path'] ?: '';
        $members_id      = $binaryParentDetails['members_id'];

        $targetRoot = $parentRoot + 3;

        // Get counts
        $count            = MBinaryMembersCount::getBinaryMembersCount($members_id, $matrix_id);
        $leftTotalMember  = $count['left'];
        $rightTotalMember = $count['right'];
        $downlineCount    = MMembersCount::getDownlineMembersCount($members_id, $matrix_id);

        // Initialize data array
        $data = [];

        // Build root node
        $data[] = [
            'id'               => $members_id,
            'name'             => $memberName,
            'pid'              => 0,
            'title'            => $memberName,
            'description'      => "Sponsor : {$sponsorUsername}",
            'phone'            => $memberPhone,
            'email'            => $memberEmail,
            'rank'             => "Rank : {$rankTitle}",
            'img'              => $memberImage,
            'rankimage'        => $rankIconPath,
            'leftmembercount'  => "Left total members : {$leftTotalMember}",
            'rightmembercount' => "Right total members : {$rightTotalMember}",
            'members_id'       => $members_id,
            'downlinecount'    => $downlineCount
        ];

        // Get direct left & right children
        $leftUser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
        $rightUser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

        // Recursively build the tree starting from root
        self::buildTreeRecursive($data, $members_id, $leftUser, $rightUser, $matrix_id, $targetRoot);

        // Convert to JS format
        $output = 'var data = ' . json_encode($data, JSON_PRETTY_PRINT) . ';';

        return $output;
    }

    private static function buildTreeRecursive(&$data, $parentId, $leftUser, $rightUser, $matrix_id, $targetroot)
    {
        // dd('funciton reached');
        $positions = [];
        if ($leftUser > 0)  $positions['1'] = $leftUser;
        if ($rightUser > 0) $positions['2'] = $rightUser;

        $filledCount = count($positions);
        // dd($filledCount);
        // Case 1: Both legs filled
        if ($filledCount == 2) {
            foreach (['1' => $leftUser, '2' => $rightUser] as $pos => $childId) {
                $childDetails = MBinaryLinkDetails::getBinaryLinkDetails($childId, $matrix_id, $targetroot);
                if ($childDetails['root'] <= $targetroot) {
                    $data[] = self::buildNodeArray($childDetails, $childId, $parentId);
                    $childLeft  = MBinaryMembersPosition::getBinaryMembersPosition($childId, $matrix_id, '1');
                    $childRight = MBinaryMembersPosition::getBinaryMembersPosition($childId, $matrix_id, '2');
                    self::buildTreeRecursive($data, $childId, $childLeft, $childRight, $matrix_id, $targetroot);
                }
            }
        }
        // Case 2: Only one leg filled
        elseif ($filledCount == 1) {
            $filledPos = key($positions);
            $childId = $positions[$filledPos];

            $childDetails = MBinaryLinkDetails::getBinaryLinkDetails($childId, $matrix_id, $targetroot);
            if ($childDetails['root'] <= $targetroot) {
                $data[] = self::buildNodeArray($childDetails, $childId, $parentId);
                $childLeft  = MBinaryMembersPosition::getBinaryMembersPosition($childId, $matrix_id, '1');
                $childRight = MBinaryMembersPosition::getBinaryMembersPosition($childId, $matrix_id, '2');
                self::buildTreeRecursive($data, $childId, $childLeft, $childRight, $matrix_id, $targetroot);
            }

            // Add empty node for missing leg
        }

    }

    private static function buildNodeArray($details, $memberId, $pid)
    {
        $username = $details['membername'] ?? 'Unknown';
        $sponsor  = $details['direct_id'] > 0 ? ($details['sponsor_username'] ?? 'Nil') : 'Nil';
        $rank     = empty($details['ranktitle']) ? 'Nil' : $details['ranktitle'];
        $image    = asset($details['members_image'] ?? 'uploads/members/avatar.png');
        // dd($image);
        $rankImg  = $details['rank_icon_path'] ?? '';

        $count = MBinaryMembersCount::getBinaryMemberscount($memberId, $details['matrix_id'] ?? 1);
        $downline = MMembersCount::getDownlineMemberscount($memberId, $details['matrix_id'] ?? 1);
        // dd($downline);

        return [
            'id'               => (string)$memberId,
            'pid'              => (string)$pid,
            'name'             => $username,
            'title'            => $username,
            'description'      => "Sponsor: $sponsor",
            'phone'            => $details['members_phone'] ?? '',
            'email'            => $details['members_email'] ?? '',
            'rank'             => "Rank: $rank",
            'img'              => $image,
            'rankimage'        => $rankImg,
            'leftmembercount'  => "Left total members: " . ($count['left'] ?? 0),
            'rightmembercount' => "Right total members: " . ($count['right'] ?? 0),
            'members_id'       => (string)$memberId,
            'downlinecount'    => (string)$downline
        ];
    }
}
