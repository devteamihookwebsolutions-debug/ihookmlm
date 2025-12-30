<?php
/**
 * This class contains public static functions related to user network page
 *
 * @package         CNetwork
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php

namespace User\App\Http\Controllers\Network;

use Admin\App\Models\Middleware\MURLCrypt;
use Exception;
use Illuminate\Http\Request;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use User\App\Models\Genealogy\MBinaryCompactGenealogy;
use User\App\Models\Network\MNetwork;

class NetworkController extends Controller
{
public function showNetwork(Request $request, $token = null, $member_id = null, $matrix_id = null)
{
    // try {
        session()->forget(['recruit', 'network', 'package', 'register', 'success_message', 'error_message']);

        $output['show_my_network_inactive_details'] = MNetwork::getInactiveNetworkDetails();
        $output['show_my_network_active_list']      = MNetwork::getActiveNetworkList();

        $auth_user_id = Auth::user()->members_id;

        if ($member_id && is_numeric($member_id)) {
            $current_member_id = (int)$member_id;
        } elseif ($token) {
            $decoded = MURLCrypt::decode($token);
            $current_member_id = $decoded[0] ?? $auth_user_id;
            $matrix_id = $decoded[1] ?? $matrix_id;
        } else {
            $current_member_id = $auth_user_id;
        }

        if (!$matrix_id) {
            $prefix = config('ihook.prefix', 'ihook');
            $matrix_id = \DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_id', $current_member_id)
                ->orderBy('link_id')
                ->value('matrix_id') ?? 1;
        }

        // Save original member only if not already saved (first load)
        if (!session()->has('original_network_member_id')) {
            session([
                'original_network_member_id' => $current_member_id,
                'original_network_matrix_id' => $matrix_id
            ]);
        }

        // Generate tree for current viewed member
        $tree = MBinaryCompactGenealogy::getCompactGenealogytree($token, $current_member_id, $matrix_id);

        $output['genealogytree'] = $tree;
        $output['referralurl']   = config('app.url') . '/';
        $output['allgenealogy']  = MNetwork::getAllGenealogyList($auth_user_id, $matrix_id);

        return view('user::genealogy.mynetwork', $output);

    // } catch (Exception $e) {
    //     \Log::error('Network Error: ' . $e->getMessage());
    //     session()->flash('error_message', 'Something went wrong.');
    //     return redirect()->route('user.network');
    // }
}

    public function showPlanNetwork(Request $request)
    {
        // dd($request->all());
        try {
            session()->forget(['recruit', 'network', 'package', 'register', 'success_message', 'error_message']);

            $output['show_my_network_inactive_details'] = MNetwork::getInactiveNetworkDetails();
            $output['show_my_network_active_list']      = MNetwork::getActiveNetworkList();

            $members_id = Auth::user()->members_id;
            $matrix_id  = null;

            if ($request->has('sub1') && $request->filled('sub1')) {
                if ($request->query('sub1') === 'matrix') {
                    $members_id = $request->query('sub2');
                    $matrix_id  = $request->query('sub3');
                } else {
                    $members_id = $request->query('sub1');
                    $matrix_id  = $request->query('sub2');
                }
            }

            if (empty($matrix_id)) {
                $first = DB::table('ihook_matrix_members_link_table')
                    ->where('members_id', $members_id)
                    ->orderBy('link_id')
                    ->first();
                $matrix_id = $first?->matrix_id ?? null;
            }

            $output['allgenealogy'] = MNetwork::getAllGenealogy($members_id, $matrix_id);
            $output['show_my_network_active_details'] = MNetwork::getActiveNetworkDetails($matrix_id);

            $output['activeplan']   = ucwords(__('Active')) . ' ' . __('Plan');
            $output['inactiveplan'] = ucwords(__('InActive')) . ' ' . __('Plan');

            return view('network.myplan', $output);

        } catch (Exception $e) {
            \Log::error('Plan Network Error: ' . $e->getMessage());
            session()->flash('error_message', 'Failed to load plan.');
            return redirect()->route('user.network');
        }
    }
}
