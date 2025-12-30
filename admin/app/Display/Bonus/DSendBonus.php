<?php
namespace Admin\App\Display\Bonus;



class DSendBonus
{
     public static function showUser($records)
    {
        if ($records->isEmpty()) {
            return '';
        }

        $output = '<select aria-label="label"
            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
            dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800
            dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
            multiple data-actions-box="true" id="user_list" name="user_list[]" required>';

        foreach ($records as $member) {
            $output .= sprintf(
                '<option value="%s">%s</option>',
                e($member->members_id),
                e($member->members_username)
            );
        }

        $output .= '</select>';

// dd($output);
        // dd($output);
        return $output;
    }
}
