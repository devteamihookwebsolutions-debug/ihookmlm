<?php

namespace Admin\App\Http\Controllers\Bonus;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Bonus\MatchingBonus;
use Admin\App\Models\Bonus\MatchingBonusLink;
use Admin\App\Models\Factories\SiteSetting;
use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\Rank\RankSetting;
use Admin\App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MatchingBonusController extends Controller
{
    public function index()
    {
        $bonuses = MatchingBonus::with('matrix')->get();
        // Generate the table rows for $showmatch
        $showmatch = '';
         foreach ($bonuses as $index => $bonus) {
            // Determine status text and badge
            $status = $bonus->matchingbonus_status
                ? "<span class='bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400'>Active</span>"
                : "<span class='bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400'>Inactive</span>";

            $showmatch .= "
                <tr>
                    <td>" . ($index + 1) . "</td>
                    <td>" . htmlspecialchars($bonus->matrix->matrix_name ?? 'N/A') . "</td>
                    <td>" . htmlspecialchars($bonus->matchbonus_name) . "</td>
                    <td>" . ($bonus->commission_based_on == 1 ? 'Level' : 'Rank') . "</td>
                    <td>" . ($bonus->commission_sent_type == 1 ? 'Percentage' : ($bonus->commission_sent_type == 2 ? 'Fixed' : 'Other')) . "</td>
                    <td>" . $status . "</td>
                    <td class='flex items-center space-x-3'>
                        <a href='" . route('matchbonus.edit', $bonus->matchbonus_id) . "' class='text-gray-500 hover:text-gray-700' title='Edit'>
                            <svg class='w-6 h-6' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                                <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                    d='m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z'/>
                            </svg>
                        </a>
                        <a href='javascript:void(0)' onclick='confirmDelete2(" . $bonus->matchbonus_id . ")' class='text-gray-500 hover:text-gray-700' title='Delete'>
                            <svg class='w-6 h-6' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                                <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                    d='M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z'/>
                            </svg>
                        </a>
                    </td>
                </tr>";
        }

        return view('Bonus.matchbonusview', compact('showmatch'));
    }

    public function create($matrix_id = null)
    {
        $matrices = MMatrix::all()->pluck('matrix_name', 'matrix_id');
        $eligible = ''; // Implement logic for eligible data if needed
        $members_paid_account_type = 1;
        $dashboard_type = SiteSetting::where('sitesettings_name', 'dashboard_type')->value('sitesettings_value') ?? '1';

        $data = [
            'matrices' => $matrices,
            'selected' => $matrix_id,
            'attributes' => 'onchange="showMatchingBonus(this.value);"',
            'sub1' => $matrix_id,
            'eligible' => $eligible,
            'members_paid_account_type' => $members_paid_account_type,
            'dashboard_type' => $dashboard_type,
        ];

        return view('Bonus.addmatchingbonus', $data);
    }

  public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'matrix_id' => 'required|exists:ihook_matrix_table,matrix_id',
            'matchingbonus_name' => 'required|string|max:240',
            'commissionsent_type' => 'required|in:1,2,3',
            'matchbonus_status' => 'required|in:0,1',
            'levelcommissiontype' => 'required|in:0,1',
            'l_levels.*' => 'nullable|integer',
            'l_commission.*' => 'nullable|numeric|min:0',
            'l_commissionpercentage.*' => 'nullable|in:1,2',
            'l_method.*' => 'nullable|in:1',
            'l_wallet.*' => 'nullable|in:1,2',
            'r_levels.*' => 'nullable|integer',
            'r_commission.*' => 'nullable|numeric|min:0',
            'r_commissionpercentage.*' => 'nullable|in:1,2',
            'r_method.*' => 'nullable|in:1',
            'r_wallet.*' => 'nullable|in:1,2',
            'r_rank.*' => 'nullable|exists:ihook_ranksetting,rank_id',
        ]);

        if (MatchingBonus::checkNameExists($validated['matchingbonus_name'], $validated['matrix_id'])) {
            return redirect()->back()->with('error_message', 'Matching bonus name already exists for this matrix.');
        }

            $bonus = MatchingBonus::create([
            'matrix_id' => $validated['matrix_id'],
            'matchbonus_name' => $validated['matchingbonus_name'],
            'commission_based_on' => $validated['levelcommissiontype'] == 1 ? 2 : 1,
            'commission_sent_type' => $validated['commissionsent_type'],
            'matchingbonus_status' => $validated['matchbonus_status'],
            'created_by' => (int)(Auth::id() ?: 1),
            'updated_by' => (int)(Auth::id() ?: 1),
            'created_on' => now(),
            'updated_on' => now(),
        ]);

        $isRank = $validated['levelcommissiontype'] == 1;
        $levels = $isRank ? $request->input('r_levels', []) : $request->input('l_levels', []);
        $commissions = $isRank ? $request->input('r_commission', []) : $request->input('l_commission', []);
        $percentages = $isRank ? $request->input('r_commissionpercentage', []) : $request->input('l_commissionpercentage', []);
        $methods = $isRank ? $request->input('r_method', []) : $request->input('l_method', []);
        $wallets = $isRank ? $request->input('r_wallet', []) : $request->input('l_wallet', []);
        $ranks = $isRank ? $request->input('r_rank', []) : [];

        foreach ($levels as $index => $level) {
            if ($level && isset($commissions[$index]) && $commissions[$index] > 0) {
                MatchingBonusLink::create([
                    'matchbonus_id' => $bonus->matchbonus_id,
                    'levels' => $level,
                    'commission_amount' => $commissions[$index],
                    'commission_type' => $methods[$index] ?? 1,
                    'wallet_type' => $wallets[$index] ?? 2,
                    'rank_id' => $isRank ? ($ranks[$index] ?? null) : null,
                    'commission_percentage_from' => $percentages[$index] ?? 1,
                ]);
            }
        }

        Log::info('MATCHINGBONUS - Add', ['user_id' => Auth::id() ?? 1, 'matchbonus_id' => $bonus->matchbonus_id]);

return redirect()->route('matchbonus.index')->with('success', 'Matching bonus added successfully');
    } catch (\Exception $e) {
        Log::error('MATCHINGBONUS - Add Failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return redirect()->back()->with('error_message', $e->getMessage());
    }
}

    public function edit($id)
    {
        $bonus = MatchingBonus::with(['matrix', 'links.rank'])->findOrFail($id);

        $matrices = MMatrix::all()->pluck('matrix_name', 'matrix_id');

        $ranks = RankSetting::where('matrix_id', $bonus->matrix_id)
            ->where('rank_key', 'rank_title')
            ->get()
            ->pluck('rank_value', 'rank_id');

        $dashboard_type = SiteSetting::where('sitesettings_name', 'dashboard_type')
            ->value('sitesettings_value') ?? '1';

        return view('Bonus.editmatching', [
            'sub1' => $bonus,
            'match_details' => $bonus->links, // Pass collection instead of rendered HTML
            'commission' => $bonus->commission_based_on,
            'commission_sent_type' => $bonus->commission_sent_type,
            'matchbonus_name' => $bonus->matchbonus_name,
            'status' => $bonus->matchingbonus_status,
            'matchbonus_id' => $bonus->matchbonus_id,
            'matrix_id' => $bonus->matrix_id,
            'count' => $bonus->links->count(),
            'matrices' => $matrices,
            'ranks' => $ranks,
            'dashboard_type' => $dashboard_type,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'matrix_id' => 'required|exists:ihook_matrix_table,matrix_id',
                'matchingbonus_name' => 'required|string|max:240',
                'commissionsent_type' => 'required|in:1,2,3',
                'matchbonus_status' => 'required|in:0,1',
                'levelcommissiontype' => 'required|in:0,1',
                'l_levels.*' => 'nullable|integer',
                'l_commission.*' => 'nullable|numeric|min:0',
                'l_commissionpercentage.*' => 'nullable|in:1,2',
                'l_method.*' => 'nullable|in:1',
                'l_wallet.*' => 'nullable|in:1,2',
                'r_levels.*' => 'nullable|integer',
                'r_commission.*' => 'nullable|numeric|min:0',
                'r_commissionpercentage.*' => 'nullable|in:1,2',
                'r_method.*' => 'nullable|in:1',
                'r_wallet.*' => 'nullable|in:1,2',
                'r_rank.*' => 'nullable|exists:ihook_ranksetting,rank_id',
            ]);

            if (MatchingBonus::checkNameExists($validated['matchingbonus_name'], $validated['matrix_id'], $id)) {
                return redirect()->back()->with('error_message', 'Matching bonus name already exists for this matrix.');
            }

            $bonus = MatchingBonus::findOrFail($id);

            $bonus->update([
                'matrix_id' => $validated['matrix_id'],
                'matchbonus_name' => $validated['matchingbonus_name'],
                'commission_based_on' => $validated['levelcommissiontype'] == 1 ? 2 : 1,
                'commission_sent_type' => $validated['commissionsent_type'],
                'matchingbonus_status' => $validated['matchbonus_status'],
                'updated_by' => (int)(Auth::id() ?: 1),
                'updated_on' => now(),
            ]);

            $bonus->links()->delete();

            $isRank = $validated['levelcommissiontype'] == 1;
            $levels = $isRank ? $request->input('r_levels', []) : $request->input('l_levels', []);
            $commissions = $isRank ? $request->input('r_commission', []) : $request->input('l_commission', []);
            $percentages = $isRank ? $request->input('r_commissionpercentage', []) : $request->input('l_commissionpercentage', []);
            $methods = $isRank ? $request->input('r_method', []) : $request->input('l_method', []);
            $wallets = $isRank ? $request->input('r_wallet', []) : $request->input('l_wallet', []);
            $ranks = $isRank ? $request->input('r_rank', []) : [];

            foreach ($levels as $index => $level) {
                if ($level && isset($commissions[$index]) && $commissions[$index] > 0) {
                    MatchingBonusLink::create([
                        'matchbonus_id' => $bonus->matchbonus_id,
                        'levels' => $level,
                        'commission_amount' => $commissions[$index],
                        'commission_type' => $methods[$index] ?? 1,
                        'wallet_type' => $wallets[$index] ?? 2,
                        'rank_id' => $isRank ? ($ranks[$index] ?? null) : null,
                        'commission_percentage_from' => $percentages[$index] ?? 1,
                    ]);
                }
            }

            Log::info('MATCHINGBONUS - Edit', [
                'user_id' => Auth::id() ?? 1,
                'matchbonus_id' => $bonus->matchbonus_id,
                'data' => $request->except(['_token', '_method'])
            ]);

return redirect()->route('matchbonus.index')->with('success', 'Matching Bonus updated successfully');        } catch (\Exception $e) {
            Log::error('MATCHINGBONUS - Edit Failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error_message', 'Failed to update: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $bonus = MatchingBonus::findOrFail($request->id);
            $bonus->links()->delete();
            $bonus->delete();

            Log::info('MATCHINGBONUS - Delete', ['user_id' => Auth::id(), 'matchbonus_id' => $request->id]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getRankName(Request $request)
    {
        $matrix_id = $request->input('selectedValue');
        $count = $request->input('count', 1);

        $ranks = RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->get(['rank_id as id', 'rank_value as name']);

        return response()->json([
            'ranks' => $ranks,
            'count' => $count,
        ]);
    }

    public function checkMatchingBonusName(Request $request)
    {
        $name = $request->matchingbonus_name;
        $matrix_id = $request->matrix_id;
        $action = $request->action;
        $exclude_id = $action == 'checkeditmatchingbonusname' ? $request->sub1 : null;

        return response()->json([
            'valid' => !MatchingBonus::checkNameExists($name, $matrix_id, $exclude_id)
        ]);
    }

    private function getRankCryptoCurrency($id = null)
    {
        return '';
    }

}


