<?php

namespace User\App\Http\Controllers\Genealogy;

use User\App\Models\Genealogy\MTabularGenealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use Exception;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TabularGenealogyController extends Controller
{
    public function view($encrypted)
    {
        Log::info(' TabularGenealogyController view', ['encrypted' => $encrypted]);

        try {
            // Decrypt
            [$memberId, $matrixId] = MURLCrypt::decode($encrypted);
            Log::info('Decrypted values', ['memberId' => $memberId, 'matrixId' => $matrixId]);

            if (!$memberId || !$matrixId) {
                Log::warning('Invalid encrypted string - decryption failed', ['encrypted' => $encrypted]);
                abort(404, 'Invalid encrypted link');
            }

            // Auth check
            $loggedInMemberId = Auth::user()->members_id ?? session('default.customer_id');

            if ($memberId != $loggedInMemberId) {
                abort(403);
            }

            $prefix = config('ihook.prefix', 'ihook');
            // Fetch Member
            $member = DB::table("{$prefix}_members_table")
                ->where('members_id', $memberId)
                ->first();
            // Fetch Matrix
            $matrix = DB::table("{$prefix}_matrix_table")
                ->where('matrix_id', $matrixId)
                ->first();

            if (!$member || !$matrix) {
                Log::error('Member or Matrix not found!', [
                    'member_found' => !!$member,
                    'matrix_found' => !!$matrix
                ]);
                abort(404);
            }

            $viewData = [
                'encrypted'        => $encrypted,
                'memberId'         => $memberId,
                'members_username' => $member->members_username ?? 'User',
                'members_email'    => $member->members_email ?? '',
                'matrix_name'      => ucfirst($matrix->matrix_name ?? 'Matrix'),
            ];

            Log::info('Final View Data Prepared', $viewData);

            return view('user::genealogy.tabular', $viewData);

        } catch (Exception $e) {
            abort(500, 'Server Error');
        }
    }

    public function getTabularGenealogyDetails($encrypted, Request $request)
    {
        try {
            [$memberId, $matrixId] = MURLCrypt::decode($encrypted);

            $loggedInId = Auth::user()->members_id ?? session('default.customer_id');

            if ((int)$memberId !== (int)$loggedInId) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }

            return MTabularGenealogy::getTabularGenealogyDetails($encrypted, $request);

        } catch (Exception $e) {
            Log::error('Tabular Genealogy Controller Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load genealogy data'], 500);
        }
    }
}
