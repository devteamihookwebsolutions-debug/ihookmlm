<?php

namespace User\App\Models\Genealogy;

use Admin\App\Models\Middleware\MURLCrypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MTabularGenealogy
{
    public static function getTabularGenealogyDetails($encrypted, Request $request)
    {
        try {
            // Decrypt
            [$memberId, $matrixId] = MURLCrypt::decode($encrypted);

            // Auth Check
            $loggedInMemberId = Auth::user()->members_id ?? session('default.customer_id');
            if ($memberId != $loggedInMemberId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $prefix       = config('ihook.prefix', 'ihook');
            $rootMemberId = $memberId;
            $matrix_id    = $matrixId;

            $parentParam   = $request->query('parent');
            $isRootRequest = in_array($parentParam, ['#', 'root', null, ''], true);

            Log::info('Tabular Tree Request', [
                'parent_param'    => $parentParam,
                'is_root_request' => $isRootRequest,
                'root_member_id'  => $rootMemberId
            ]);

            $data = [];

            // ========================================
            // 1. ROOT NODE (First time load)
            // ========================================
            if ($isRootRequest) {
                Log::info('LOADING ROOT NODE (You)');

                $user = DB::table("{$prefix}_members_table")
                    ->where('members_id', $rootMemberId)
                    ->select('members_username', 'members_firstname', 'members_lastname')
                    ->first();

                $hasDownline = DB::table("{$prefix}_matrix_members_link_table")
                    ->where('spillover_id', $rootMemberId)
                    ->where('matrix_id', $matrix_id)
                    ->exists();

                $data[] = [
                    "id"        => $rootMemberId,
                    "text"      => ($user->members_username ?? 'You') . " (You)",
                    "icon"      => "fa fa-user-circle fa-3x text-primary",
                    "children"  => $hasDownline,
                    "state"     => ["opened" => true],
                    "type"      => "root"
                ];

                return response()->json($data);
            }

            // ========================================
            // 2. CHILDREN OF ANY NODE (Expand)
            // ========================================
            else {
                $parentId = (int)$parentParam;

                Log::info('LOADING CHILDREN FOR PARENT ID: ' . $parentId);

                $children = DB::table("{$prefix}_matrix_members_link_table AS link")
                    ->join("{$prefix}_members_table AS m", 'link.members_id', '=', 'm.members_id')
                    ->select(
                        'link.members_id',
                        'link.position',
                        'm.members_username',
                        'm.members_firstname',
                        'm.members_lastname',
                        'm.members_email'
                    )
                    ->where('link.spillover_id', $parentId)
                    ->where('link.matrix_id', $matrix_id)
                    ->orderBy('link.position', 'ASC')
                    ->get();

                Log::info('Found ' . $children->count() . ' downlines for parent ' . $parentId);

                foreach ($children as $child) {
                    $hasKids = DB::table("{$prefix}_matrix_members_link_table")
                        ->where('spillover_id', $child->members_id)
                        ->where('matrix_id', $matrix_id)
                        ->exists();

                    $fullName = trim($child->members_firstname . ' ' . $child->members_lastname);
                    $displayName = $child->members_username ;
                    $legText = $child->position == 1 ;
                    $legColor = $child->position == 1 ? "success" : "danger";

                    $data[] = [
                        "id"       => $child->members_id,
                        "text"     => $displayName . $legText,
                        "icon"     => "fa fa-user fa-2x text-$legColor",
                        "children" => $hasKids,
                        "a_attr"   => ["title" => $child->members_email ?? 'No email']
                    ];
                }

                return response()->json($data);
            }

        } catch (\Exception $e) {
            Log::error('Tabular Genealogy Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to load genealogy data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
