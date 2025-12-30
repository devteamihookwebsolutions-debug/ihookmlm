<?php

namespace Display\Middleware;
namespace Admin\App\Display\Middleware;
class DAutoSearchMembers
{

//         // dd($recordsmembers);
//   public static function getMembers(Collection $recordsmembers, $do = null)
//     {
//         // dd($recordsmembers);
//         $clickLabel = ($do === 'sponsorlist') ? 'getvaluesponsor' : 'getvalue';

//         $output = '<div class="bg-neutral-100 p-2 shadow-md rounded-lg cursor-pointer m-scrollable" data-scrollable="true" data-height="120" data-mobile-height="450">';

//         if ($recordsmembers->count() > 0) {
//             foreach ($recordsmembers as $member) {
//                 $username = e($member->members_username); // escape for safety
//                 $output .= '<div class="search-suggestion search-selectable" id="' . $username . '" onclick="' . $clickLabel . '(this.id)">' . $username . '</div>';
//             }
//         } else {
//             $output .= '<div class="search-suggestion search-selectable text-gray-500">' . __('No data available') . '</div>';
//         }

//         $output .= '</div>';

//         dd($output);
//         return $output;
//     }
    
public static function getAllMembersNew($recordsmembers)
{
    $output = '';

    // Ensure $recordsmembers is iterable
    if ($recordsmembers && $recordsmembers->count() > 0) {
        foreach ($recordsmembers as $member) {
            $output .= '<div class="cursor-pointer py-2 px-4 text-sm text-black hover:bg-neutral-100" 
                        data-value="' . e($member->members_username) . '" 
                        onclick="selectSuggestion(\'' . e($member->members_username) . '\')">'
                        . e($member->members_username) .
                        '</div>';
        }
    }
// dd($output);
    return $output;
}
 
public static function getAllMembers($recordsmembers)
{
    $output = '';

    if ($recordsmembers && $recordsmembers->count() > 0) {
        foreach ($recordsmembers as $member) {

            $id = e($member->members_id);
            $username = e($member->members_username);

            $output .= '
                <div class="cursor-pointer py-2 px-4 text-sm text-black hover:bg-neutral-100"
                     data-id="' . $id . '"
                     data-username="' . $username . '"
                     onclick="selectSuggestion(this)">
                     ' . $username . '
                </div>';
        }
    }

    return $output;
}


// public static function getMembers($recordsmembers)
// {
//     $output = '<div class="bg-neutral-100 p-2 shadow-md rounded-lg cursor-pointer m-scrollable" 
//                 data-scrollable="true" data-height="120" data-mobile-height="450">';

//     // Use Laravel safe getter
//     $do = request()->query('do');
//     $clicklabel = ($do === 'sponsorlist') ? 'getvaluesponsor' : 'getvalue';
//     dd($clickLabel);

//     if (!empty($recordsmembers) && count($recordsmembers) > 0) {
//         foreach ($recordsmembers as $member) {
//             $output .= '<div class="search-suggestion search-selectable" 
//                         id="' . e($member->members_id) . '" 
//                         onclick="'.$clicklabel.'(this.id)">' 
//                         . e($member->members_username) . 
//                         '</div>';
//         }
//     } else {
//         $output .= '<div class="search-suggestion search-selectable">' 
//                     . __('No data available') . 
//                     '</div>';
//     }

//     $output .= '</div>';
//     // dd($output);
//  return $output;
// }

}