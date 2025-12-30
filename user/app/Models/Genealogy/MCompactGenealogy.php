<?php

namespace User\App\Models\Genealogy;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MURLCrypt;

class MCompactGenealogy
{
    public static function getCompactGenealogytree($members_id, $matrix_id)
    {
        $prefix = config('ihook.prefix', 'ihook');
        $table_link = "{$prefix}_matrix_members_link_table";
        $table_members = "{$prefix}_members_table";

        // Root member details
        $root = DB::table("{$table_link} as l")
            ->join("{$table_members} as m", 'l.members_id', '=', 'm.members_id')
            ->where('l.members_id', $members_id)
            ->where('l.matrix_id', $matrix_id)
            ->select('m.members_username', 'm.members_image')
            ->first();

        $root_username = $root->members_username ?? 'Unknown';
        $root_image = $root->members_image
            ? asset('' . ltrim($root->members_image, '/'))
            : asset('/img/compact_emptyavatar.png');

        $crypturl = MURLCrypt::getEncryptURL($matrix_id, $members_id);

        $output = '
        <section class="bg-gray-800 flex justify-center flex-col py-12 relative">
            <div class="relative w-full flex items-center justify-center">
                <div class="flex flex-col m-auto">
                    <div class="mb-12 relative flex justify-center text-center
                        before:content-[\'\'\] before:absolute before:top-[115%] before:left-14 before:right-14
                        before:h-[2px] before:bg-white/70">

                        <div class="relative text-center
                            after:content-[\'\'\] after:absolute after:w-[2px] after:h-[25px]
                            after:bottom-0 after:left-1/2 after:bg-white/70
                            after:transform after:translate-y-[100%]">

                            <a href="' . url('/user/network/view/' . $crypturl) . '">
                                <img src="' . $root_image . '" alt="' . htmlspecialchars($root_username) . '"
                                     class="w-28 h-28 border-4 border-indigo-600 rounded-full overflow-hidden object-cover bg-white mx-auto">
                            </a>

                            <p class="bg-white py-1 px-3 rounded text-teal-800 font-medium m-0 mt-2
                                before:content-[\'\'\] before:absolute before:w-[2px] before:h-[8px]
                                before:bg-white before:left-1/2 before:top-0 before:transform before:-translate-y-full">
                                ' . htmlspecialchars($root_username) . '
                            </p>
                        </div>
                    </div>

                    <div class="relative w-full flex items-center justify-center space-x-32">
                        ' . self::renderLeg($members_id, $matrix_id, 'left') . '
                        ' . self::renderLeg($members_id, $matrix_id, 'right') . '
                    </div>
                </div>
            </div>
        </section>';

        return $output;
    }

    private static function renderLeg($parent_id, $matrix_id, $side)
    {
        $prefix = config('ihook.prefix', 'ihook');
        $position = ($side === 'left') ? 1 : 2;

        $child = DB::table("{$prefix}_matrix_members_link_table as l")
            ->join("{$prefix}_members_table as m", 'l.members_id', '=', 'm.members_id')
            ->whereRaw("FIND_IN_SET(?, l.members_parents)", [$parent_id])
            ->where('l.matrix_id', $matrix_id)
            ->where('l.position', $position)
            ->select('l.members_id', 'm.members_username', 'm.members_image')
            ->first();

        if (!$child) {
            // Empty slot
            return '
            <div class="flex flex-col">
                <div class="mb-12 relative flex justify-center text-center
                    before:content-[\'\'\] before:absolute before:w-[2px] before:h-[25px]
                    before:bg-white before:left-1/2 before:top-0 before:transform before:-translate-y-full">
                    <div class="relative text-center">
                        <img src="' . asset('/img/compact_emptyavatar.png') . '" alt="empty"
                             class="w-28 h-28 border-4 border-dashed border-gray-500 rounded-full overflow-hidden bg-gray-200 mx-auto">
                        <p class="bg-white py-1 px-3 rounded text-gray-600 m-0 mt-2">empty</p>
                    </div>
                </div>
            </div>';
        }

        $crypt = MURLCrypt::getEncryptURL($matrix_id, $child->members_id);
        $img = $child->members_image
            ? asset('' . ltrim($child->members_image, '/'))
            : asset('/img/compact_emptyavatar.png');

        return '
        <div class="flex flex-col">
            <div class="mb-12 relative flex justify-center text-center
                before:content-[\'\'\] before:absolute before:w-[2px] before:h-[25px]
                before:bg-white before:left-1/2 before:top-0 before:transform before:-translate-y-full">
                <div class="relative text-center">
                    <a href="' . url('/user/network/view/' . $crypt) . '">
                        <img src="' . $img . '" alt="' . htmlspecialchars($child->members_username) . '"
                             class="w-28 h-28 border-4 border-indigo-600 rounded-full overflow-hidden object-cover bg-white mx-auto">
                    </a>
                    <p class="bg-white py-1 px-3 rounded text-teal-800 font-medium m-0 mt-2">
                        ' . htmlspecialchars($child->members_username) . '
                    </p>
                </div>
            </div>
        </div>';
    }
}
