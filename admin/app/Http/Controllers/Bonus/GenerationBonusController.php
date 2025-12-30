<?php

namespace Admin\App\Http\Controllers\Bonus;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Bonus\GenerationBonusLinkTable;
use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\Rank\RankSetting;
use Admin\App\Models\Wallet;
use Illuminate\Http\Request;

class GenerationBonusController extends Controller
{
    /**
     * Display a listing of the generation bonuses
     */
    public function index()
    {
        $bonuses = GenerationBonusLinkTable::select('matrix_id')
            ->groupBy('matrix_id')
            ->get()
            ->map(function ($bonus) {
                $data = GenerationBonusLinkTable::getKeyValuePairs($bonus->matrix_id);
                $data['matrix_id'] = $bonus->matrix_id;
                $data['plan_name'] = MMatrix::find($bonus->matrix_id)->matrix_name ?? 'Unknown';
                return $data;
            });

        $showmatch = $this->formatTableData($bonuses);

        return view('Bonus.generationbonusview', compact('showmatch'));
    }

    /**
     * Show the form for creating a new generation bonus
     */
    public function create($matrix_id = null)
    {
        \Log::info('GenerationBonusController::create called', ['matrix_id' => $matrix_id]);

        $plans = MMatrix::all();
        \Log::info('Plans fetched', ['plans' => $plans->toArray()]);

        $addshowmatch = $this->generatePlanOptions($plans, $matrix_id, false);
        $dashboardtype = 2;
        $rankdetail = $this->getRankDetails();

        // Fetch ranks with raw query logging
        $ranksQuery = RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->orderBy('rank_id');
        \Log::info('Ranks SQL Query', ['query' => $ranksQuery->toSql(), 'bindings' => $ranksQuery->getBindings()]);

        $ranks = $matrix_id ? $ranksQuery->get() : collect([]);
        \Log::info('Ranks fetched for matrix_id ' . $matrix_id, [
            'count' => $ranks->count(),
            'ranks' => $ranks->toArray(),
        ]);

        if ($ranks->isEmpty() && $matrix_id) {
            \Log::warning('No ranks found for matrix_id ' . $matrix_id);
            session()->flash('warning', 'No ranks defined for the selected plan. Please add ranks first.');
        }

        $gen_details = $this->getGenDetails($matrix_id);
        $sub1 = $matrix_id && MMatrix::find($matrix_id) ? 'true' : '';
        \Log::info('MMatrix check', ['matrix_id' => $matrix_id, 'sub1' => $sub1]);

        $wallets = Wallet::all();
        $selected_wallet = $matrix_id ? (GenerationBonusLinkTable::getKeyValuePairs($matrix_id)['wallet'] ?? '') : '';

        $data = $matrix_id ? GenerationBonusLinkTable::getKeyValuePairs($matrix_id) : [];
        \Log::info('GenerationBonusLinkTable data', ['matrix_id' => $matrix_id, 'data' => $data]);

        $generationalbonus_name = $data['generationalbonus_name'] ?? '';
        $commission_percentage = $data['commission_percentage'] ?? 2;
        $generationalbonus_status = $data['generationalbonus_status'] ?? 0;
        $levelcount = count($ranks);

        return view('Bonus.addgenerationbonus', compact(
            'addshowmatch',
            'dashboardtype',
            'rankdetail',
            'gen_details',
            'ranks',
            'matrix_id',
            'sub1',
            'generationalbonus_name',
            'commission_percentage',
            'wallets',
            'selected_wallet',
            'generationalbonus_status',
            'levelcount'
        ));
    }

    /**
     * Store a newly created generation bonus
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'matrix_id' => 'required|integer|exists:ihook_matrix_table,matrix_id',
            'generationalbonus_name' => 'required|string|max:255',
            'commission_percentage' => 'required|in:1,2',
            'wallet' => 'required|integer|exists:ihook_wallettype,wallet_type_id',
            'generationalbonus_status' => 'nullable|in:0,1',
            'r_rank.*' => 'required|integer|exists:ihook_ranksetting,rank_id',
            'r_own.*' => 'required|numeric|min:0',
            'r_admin.*' => 'required|numeric|min:0',
            'r_method.*' => 'required|in:1,2',
        ]);

        $matrix_id = $request->input('matrix_id');
        $ranks = RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->get();

        // Dynamically validate rank-specific fields
        foreach ($ranks as $rank) {
            $request->validate([
                "r_rank_{$rank->rank_id}.*" => 'required|numeric|min:0',
            ]);
        }

        // Ensure unique rank selections
        $rank_ids = $request->input('r_rank', []);
        if (count($rank_ids) !== count(array_unique($rank_ids))) {
            return back()->withErrors(['r_rank' => 'Each rank must be unique.'])->withInput();
        }

        // Flatten arrays into key-value pairs
        $keyValuePairs = [
            'generationalbonus_name' => $request->input('generationalbonus_name'),
            'commission_percentage' => $request->input('commission_percentage'),
            'wallet' => $request->input('wallet'),
            'generationalbonus_status' => $request->input('generationalbonus_status', 0),
        ];

        // Process rank-based data
        if ($request->has('r_rank')) {
            foreach ($request->input('r_rank') as $index => $rank_id) {
                $level = $index + 1;
                $keyValuePairs["rank_{$level}_rank"] = $rank_id;
                $keyValuePairs["rank_{$level}_own"] = $request->input('r_own')[$index] ?? 0;
                $keyValuePairs["rank_{$level}_admin"] = $request->input('r_admin')[$index] ?? 0;
                foreach ($ranks as $subRank) {
                    $keyValuePairs["rank_{$level}_rank{$subRank->rank_id}"] = $request->input("r_rank_{$subRank->rank_id}")[$index] ?? 0;
                }
                $keyValuePairs["rank_{$level}_method"] = $request->input('r_method')[$index] ?? 2;
            }
        }

        // Store in database
        GenerationBonusLinkTable::storeKeyValuePairs($keyValuePairs, $matrix_id);

        return redirect()->route('generationbonus.index')->with('success', 'Generation Bonus created successfully.');
    }

    /**
     * Show the form for editing a generation bonus
     */
    public function edit($matrix_id)
    {
        \Log::info('GenerationBonusController::edit called', ['matrix_id' => $matrix_id]);

        $data = GenerationBonusLinkTable::getKeyValuePairs($matrix_id);
        $plans = MMatrix::all();
        $addshowmatch = $this->generatePlanOptions($plans, $matrix_id, true);
        $dashboardtype = 2;
        $rankdetail = $this->getRankDetails();
        $ranks = RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->orderBy('rank_id')
            ->get();
        \Log::info('Ranks fetched for matrix_id ' . $matrix_id, [
            'count' => $ranks->count(),
            'ranks' => $ranks->toArray(),
        ]);

        if ($ranks->isEmpty()) {
            \Log::warning('No ranks found for matrix_id ' . $matrix_id);
            session()->flash('warning', 'No ranks defined for the selected plan. Please add ranks first.');
        }

        $gen_details = $this->getGenDetails($matrix_id);
        $sub1 = $matrix_id && MMatrix::find($matrix_id) ? 'true' : '';
        $wallets = Wallet::all();
        $selected_wallet = $data['wallet'] ?? '';

        $generationalbonus_name = $data['generationalbonus_name'] ?? '';
        $commission_percentage = $data['commission_percentage'] ?? 2;
        $generationalbonus_status = $data['generationalbonus_status'] ?? 0;
        $levelcount = count($ranks);

        return view('Bonus.addgenerationbonus', compact(
            'addshowmatch',
            'dashboardtype',
            'rankdetail',
            'gen_details',
            'ranks',
            'matrix_id',
            'sub1',
            'generationalbonus_name',
            'commission_percentage',
            'wallets',
            'selected_wallet',
            'generationalbonus_status',
            'levelcount'
        ));
    }

    /**
     * Update the specified generation bonus
     */
    public function update(Request $request, $matrix_id)
    {
        // Validate input, excluding r_rank since it's read-only
        $request->validate([
            'matrix_id' => 'required|integer|exists:ihook_matrix_table,matrix_id',
            'generationalbonus_name' => 'required|string|max:255',
            'commission_percentage' => 'required|in:1,2',
            'wallet' => 'required|integer|exists:ihook_wallettype,wallet_type_id',
            'generationalbonus_status' => 'nullable|in:0,1',
            'r_own.*' => 'required|numeric|min:0',
            'r_admin.*' => 'required|numeric|min:0',
            'r_method.*' => 'required|in:1,2',
        ]);

        $ranks = RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->get();

        // Dynamically validate rank-specific fields
        foreach ($ranks as $rank) {
            $request->validate([
                "r_rank_{$rank->rank_id}.*" => 'required|numeric|min:0',
            ]);
        }

        // Validate r_rank[] to ensure they exist in the database
        $rank_ids = $request->input('r_rank', []);
        foreach ($rank_ids as $rank_id) {
            if ($rank_id && !$ranks->contains('rank_id', $rank_id)) {
                return back()->withErrors(['r_rank' => 'Invalid rank selected.'])->withInput();
            }
        }

        // Ensure unique rank selections
        if (count($rank_ids) !== count(array_unique($rank_ids))) {
            return back()->withErrors(['r_rank' => 'Each rank must be unique.'])->withInput();
        }

        // Flatten arrays into key-value pairs
        $keyValuePairs = [
            'generationalbonus_name' => $request->input('generationalbonus_name'),
            'commission_percentage' => $request->input('commission_percentage'),
            'wallet' => $request->input('wallet'),
            'generationalbonus_status' => $request->input('generationalbonus_status', 0),
        ];

        // Process rank-based data
        if ($request->has('r_rank')) {
            foreach ($request->input('r_rank') as $index => $rank_id) {
                $level = $index + 1;
                $keyValuePairs["rank_{$level}_rank"] = $rank_id;
                $keyValuePairs["rank_{$level}_own"] = $request->input('r_own')[$index] ?? 0;
                $keyValuePairs["rank_{$level}_admin"] = $request->input('r_admin')[$index] ?? 0;
                foreach ($ranks as $subRank) {
                    $keyValuePairs["rank_{$level}_rank{$subRank->rank_id}"] = $request->input("r_rank_{$subRank->rank_id}")[$index] ?? 0;
                }
                $keyValuePairs["rank_{$level}_method"] = $request->input('r_method')[$index] ?? 2;
            }
        }

        // Update in database
        GenerationBonusLinkTable::updateKeyValuePairs($keyValuePairs, $matrix_id);

        return redirect()->route('generationbonus.index')->with('success', 'Generation Bonus updated successfully.');
    }

    /**
     * Delete the specified generation bonus
     */
  public function destroy($id) // Change: accept $id directly from route
{
    if (!$id) {
        return response()->json(['message' => 'Invalid ID'], 400);
    }

    GenerationBonusLinkTable::deleteByMatrixId($id);

    // If it's an AJAX request (from JS), return JSON
    if (request()->ajax() || request()->wantsJson()) {
        return response()->json(['message' => 'Generation Bonus deleted successfully']);
    }

    // Otherwise, redirect back with success
    return redirect()->route('generationbonus.index')
                     ->with('success', 'Generation Bonus deleted successfully');
}

    /**
     * Get ranks for a given matrix_id
     */
    public function getRanks(Request $request)
    {
        $matrix_id = $request->input('selectedValue');
        $ranks = RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->orderBy('rank_id')
            ->get();
        $options = '<option value="">Select Rank</option>';
        foreach ($ranks as $rank) {
            $options .= "<option value='{$rank->rank_id}'>{$rank->rank_value}</option>";
        }
        return $options;
    }

    /**
     * Helper to format table data for index view
     */
    private function formatTableData($bonuses)
    {
        $html = '';
        foreach ($bonuses as $index => $bonus) {
            $html .= "<tr>";
            $html .= "<td>" . ($index + 1) . "</td>";
            $html .= "<td>{$bonus['plan_name']}</td>";
            $html .= "<td>{$bonus['generationalbonus_name']}</td>";
            $html .= "<td>" . (Wallet::find($bonus['wallet'])->wallet_name ?? 'Unknown') . "</td>";

            // Status badge (Active / Inactive)
            if ($bonus['generationalbonus_status'] == 1) {
                $statusBadge = "<span class='bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded
                    dark:bg-gray-700 dark:text-green-400 border border-green-400'>Active</span>";
            } else {
                $statusBadge = "<span class='bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded
                    dark:bg-gray-700 dark:text-red-400 border border-red-400'>Inactive</span>";
            }

            $html .= "<td>{$statusBadge}</td>";

            // Action icons
            $html .= "<td class='flex items-center space-x-3'>
                <a href='" . route('generationbonus.edit', $bonus['matrix_id']) . "'
                class='text-gray-500 hover:text-gray-700' title='Edit'>
                    <svg class='w-6 h-6' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                            d='m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z'/>
                    </svg>
                </a>

                <a href='#' onclick='confirmDelete2({$bonus['matrix_id']})'
                class='text-gray-500 hover:text-gray-700' title='Delete'>
                    <svg class='w-6 h-6' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                            d='M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z'/>
                    </svg>
                </a>
            </td>";

            $html .= "</tr>";
        }
        return $html;
    }

    /**
     * Helper to generate plan options for dropdown
     */
    private function generatePlanOptions($plans, $selected_id = null, $isEdit = false)
{
    // If edit mode, disable the dropdown
    $disabled = $isEdit ? 'disabled' : '';

    $options = "<div>";
    $options .= "<select id='matrix_id' name='matrix_id'
        class='bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300'
        required {$disabled}>";

    $options .= '<option value="">Select Plan</option>';

    foreach ($plans as $plan) {
        $selected = $plan->matrix_id == $selected_id ? 'selected' : '';
        $options .= "<option value='{$plan->matrix_id}' {$selected}>{$plan->matrix_name}</option>";
    }

    $options .= "</select>";

    // Add helper text + hidden field in edit mode
    if ($isEdit) {
        $options .= "<p class='text-xs text-gray-500 mt-1'>
            Plan cannot be changed after creation.
        </p>";

        // Hidden input ensures matrix_id is still submitted
        if ($selected_id) {
            $options .= "<input type='hidden' name='matrix_id' value='{$selected_id}'>";
        }
    }

    $options .= "</div>";

    return $options;
}


    /**
     * Helper to get rank details for table headers
     */
    private function getRankDetails()
    {
        return '<th scope="col" class="px-6 py-3">Rank</th>';
    }

    /**
     * Helper to get generation details for table body
     */
    private function getGenDetails($matrix_id)
    {
        $data = $matrix_id ? GenerationBonusLinkTable::getKeyValuePairs($matrix_id) : [];
        $ranks = $matrix_id ? RankSetting::where('matrix_id', $matrix_id)
            ->where('rank_key', 'rank_title')
            ->orderBy('rank_id')
            ->get() : collect([]);
        $gen_details = [];

        // Initialize rows for each rank
        foreach ($ranks as $index => $rank) {
            $level = $index + 1;
            $row = [
                'rank' => $data["rank_{$level}_rank"] ?? '',
                'own' => $data["rank_{$level}_own"] ?? '',
                'admin' => $data["rank_{$level}_admin"] ?? '',
                'method' => $data["rank_{$level}_method"] ?? 2,
            ];
            // Add rank-specific columns
            foreach ($ranks as $subRank) {
                $row["rank{$subRank->rank_id}"] = $data["rank_{$level}_rank{$subRank->rank_id}"] ?? '';
            }
            $gen_details[] = $row;
        }

        return $gen_details;
    }
}
