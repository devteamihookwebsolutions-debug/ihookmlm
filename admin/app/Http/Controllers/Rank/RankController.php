<?php

namespace Admin\App\Http\Controllers\Rank;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\Rank\AvatarGallery;
use Admin\App\Models\Rank\RankLevelCommission;
use Admin\App\Models\Rank\RankSetting;
use Admin\App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;

class RankController extends Controller
{
    public function index()
    {
        // Get unique rank_ids
        $rankIds = RankSetting::select('rank_id')->distinct()->pluck('rank_id');

        $ranks = [];
        foreach ($rankIds as $rankId) {
            $settings = RankSetting::where('rank_id', $rankId)->pluck('rank_value', 'rank_key')->toArray();
            $ranks[] = [
                'rank_id' => $rankId,
                'matrix_id' => $settings['matrix_id'] ?? '',
                'plan_name' => MMatrix::find($settings['matrix_id'] ?? 0)?->matrix_name ?? 'Unknown',
                'rank_title' => $settings['rank_title'] ?? '',
                'wallet' => Wallet::find($settings['wallet'] ?? 0)?->wallet_name ?? 'Unknown', // Changed 'name' to 'wallet_name'
            ];
        }

        // Generate $showrank HTML
        $showrank = '';
        foreach ($ranks as $rank) {
            $showrank .= '<tr>';
            $showrank .= '<td>' . $rank['plan_name'] . '</td>';
            $showrank .= '<td>' . $rank['rank_title'] . '</td>';
            $showrank .= '<td>' . $rank['wallet'] . '</td>';
            $showrank .= '<td>';
            $showrank .= '<a href="' . route('ranksetting.edit', $rank['rank_id']) . '">
                    <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                    </svg>
                </a>';
            $showrank .= '</td>';
            $showrank .= '</tr>';
        }

        return view('rank.ranksettings', compact('showrank'));
    }

     public function create()
    {
        $matrices = MMatrix::all();
        $wallets = Wallet::all();
        $rank_icon = '';

        // Log for debugging
        Log::info('Wallets fetched', ['count' => $wallets->count(), 'wallets' => $wallets->toArray()]);

        return view('rank.addranksettings', compact('matrices', 'wallets', 'rank_icon'));
    }

    public function store(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Store method called', $request->all());

        // Validate request
        $validated = $request->validate([
            'matrixid' => 'required|exists:ihook_matrix_table,matrix_id',
            'rank_title' => 'required|string|max:255',
            'rank_color' => 'required|string',
            'rank_icon' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'rank_icon_id' => 'nullable|string',
            'bonus' => 'nullable|numeric|min:0',
            'wallet' => 'required|exists:ihook_wallettype,wallet_type_id',
            'directbonus' => 'nullable|numeric|min:0',
            'networkbonus' => 'nullable|numeric|min:0',
            'maxbonus' => 'nullable|numeric|min:0',
            'rankcount' => 'nullable|integer|min:0',
            'totallevel' => 'nullable|integer|min:0',
            'condn*' => 'nullable|string',
            'value*' => 'nullable|string',
            'lvl*' => 'nullable|numeric|min:0',
        ]);

        // Generate new rank_id
        $rank_id = RankSetting::max('rank_id') + 1 ?: 1;
        Log::info('Generated rank_id', ['rank_id' => $rank_id]);

            // Handle rank_icon
        $icon_path = '';
        if ($request->hasFile('rank_icon')) {
            $path = $request->file('rank_icon')->store('uploads/members', 'public');
            $icon_path = 'uploads/members/' . basename($path); // Clean path
            Log::info('Rank icon uploaded', ['icon_path' => $icon_path]);
        } elseif ($request->filled('rank_icon_id')) {
            // Use static avatar from public folder
            $icon_path = 'rank-avatars/' . $request->rank_icon_id . '.png';
            Log::info('Static rank icon selected', ['icon_path' => $icon_path]);
        }
        // Store single keys in RankSetting
        $matrix_id = $request->matrixid;
        $keys = [
            'matrix_id' => $matrix_id,
            'rank_title' => $request->rank_title,
            'rank_color' => $request->rank_color,
            'rank_icon' => $icon_path,
            'bonus' => $request->bonus ?? 0,
            'wallet' => $request->wallet,
            'directbonus' => $request->directbonus ?? 0,
            'networkbonus' => $request->networkbonus ?? 0,
            'maxbonus' => $request->maxbonus ?? 0,
        ];

        foreach ($keys as $key => $value) {
            if ($value !== null && $value !== '') {
                RankSetting::create([
                    'rank_id' => $rank_id,
                    'matrix_id' => $matrix_id,
                    'rank_key' => $key,
                    'rank_value' => $value,
                ]);
                Log::info('RankSetting created', ['key' => $key, 'value' => $value]);
            }
        }

        // Store conditions in RankSetting
        $rankcount = $request->rankcount ?? 0;
        for ($i = 0; $i < $rankcount; $i++) {
            $condn = $request->input("condn$i");
            $value = $request->input("value$i");
            if ($condn !== null && $condn !== '') {
                RankSetting::create([
                    'rank_id' => $rank_id,
                    'matrix_id' => $matrix_id,
                    'rank_key' => $condn,
                    'rank_value' => $value ?? '',
                ]);
                Log::info('Condition created', ['rank_key' => $condn, 'rank_value' => $value]);
            }
        }

        // Store levels in RankLevelCommission
        $totallevel = $request->totallevel ?? 0;
        for ($i = 1; $i <= $totallevel; $i++) {
            $comm = $request->input("lvl$i") ?? 0;
            if ($comm > 0) {
                RankLevelCommission::create([
                    'rank_id' => $rank_id,
                    'matrix_id' => $matrix_id,
                    'level' => $i,
                    'commission' => $comm,
                ]);
                Log::info('Level commission stored in RankLevelCommission', ['level' => $i, 'commission' => $comm]);
            }
        }

        return redirect()->route('ranksetting')->with('success', 'Rank added successfully');
    }

    public function edit($rank_id)
    {
        // Fetch settings as key-value pairs
        $settings = RankSetting::where('rank_id', $rank_id)
            ->pluck('rank_value', 'rank_key')
            ->toArray();

        // Fetch related data
        $matrices = MMatrix::all();
        $wallets = Wallet::all();

        // Extract settings with defaults
        $matrixid = $settings['matrix_id'] ?? '';
        $ranktitle = $settings['rank_title'] ?? '';
        $rankcolor = $settings['rank_color'] ?? '#6b7280';
        $rank_icon = $settings['rank_icon'] ?? '';
        $rankbonus = $settings['bonus'] ?? 0;
        $wallet = $settings['wallet'] ?? '';
        $directbonus = $settings['directbonus'] ?? 0;
        $networkbonus = $settings['networkbonus'] ?? 0;
        $maxbonus = $settings['maxbonus'] ?? 0;

    // Generate Matrix dropdown (disabled in edit mode)
        $matrix = "<div>";
        $matrix .= '<select id="matrixid" name="matrixid" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required disabled>';
        $matrix .= '<option value="">' . __('Select Plan') . '</option>';

        foreach ($matrices as $m) {
            $selected = old('matrixid', $matrixid) == $m->matrix_id ? 'selected' : '';
            $matrix .= "<option value='{$m->matrix_id}' {$selected}>" . htmlspecialchars($m->matrix_name) . "</option>";
        }

        $matrix .= '</select>';

        // Add helper text and hidden input so matrix_id is still submitted
        if (!empty($matrixid)) {
            $matrix .= "<p class='text-xs text-gray-500 mt-1'>" . __('Plan cannot be changed after creation.') . "</p>";
            $matrix .= "<input type='hidden' name='matrixid' value='{$matrixid}'>";
        }

        $matrix .= "</div>";


        // Define condition options
        $options = [
            '1' => __('Direct Referral'),
            '2' => __('Group Referral'),
            '3' => __('Number of Sales'),
            '4' => __('Product Sold'),
            '5' => __('Target Achieved'),
            '6' => __('Level Condition'),
            '7' => __('PV Points'),
            '8' => __('GPV Points'),
            '9' => __('Sales Target'),
            '10' => __('Group Sales Target'),
            '11' => __('Online Sales PV'),
        ];

        // Generate Rank Conditions
        $count = 0;
        $rankdetails = '';
        $conditions = RankSetting::where('rank_id', $rank_id)
            ->whereIn('rank_key', array_keys($options))
            ->get();

        foreach ($conditions as $index => $condition) {
            $rankdetails .= '<div class="mb-5">';
            $rankdetails .= '<label for="condn' . $index . '" class="block mb-3 mt-3 text-xs text-gray-600 dark:text-gray-300">' . __('Condition') . '</label>';
            $rankdetails .= '<select id="condn' . $index . '" name="condn' . $index . '" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required>';
            $rankdetails .= '<option value="">' . __('Select') . '</option>';
            foreach ($options as $value => $label) {
                $rankdetails .= '<option value="' . $value . '" ' . ($condition->rank_key == $value ? 'selected' : '') . '>' . htmlspecialchars($label) . '</option>';
            }
            $rankdetails .= '</select>';
            $rankdetails .= '<label for="value' . $index . '" class="block mb-3 mt-3 text-xs text-gray-600 dark:text-gray-300">' . __('Value') . '</label>';
            $rankdetails .= '<input type="text" id="value' . $index . '" name="value' . $index . '" value="' . htmlspecialchars($condition->rank_value) . '" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required>';
            $rankdetails .= '<p class="mt-2 text-sm text-red-600 dark:text-red-500 hidden">' . __('Please enter a valid value.') . '</p>';
            $rankdetails .= '</div>';
            $count = $index + 1;
        }

        // Generate Level Commission records
        $levelcommcnt = RankLevelCommission::where('rank_id', $rank_id)->count();
        $levelcommrecord = '';
        $levelCommissions = RankLevelCommission::where('rank_id', $rank_id)->orderBy('level')->get();

        foreach ($levelCommissions as $level) {
            $levelcommrecord .= '<div class="mb-5">';
            $levelcommrecord .= '<label for="lvl' . $level->level . '" class="block mb-3 mt-3 text-xs text-gray-600 dark:text-gray-300">' . __('Level') . ' ' . $level->level . ' (%)</label>';
            $levelcommrecord .= '<input type="number" id="lvl' . $level->level . '" name="lvl' . $level->level . '" value="' . htmlspecialchars($level->commission) . '" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required>';
            $levelcommrecord .= '<p class="mt-2 text-sm text-red-600 dark:text-red-500 hidden">' . __('Please enter a valid level.') . '</p>';
            $levelcommrecord .= '</div>';
        }

        // Return View with all variables
        return view('rank.editranksettings', compact(
            'matrixid', 'rank_id', 'ranktitle', 'rankcolor', 'rank_icon', 'rankbonus',
            'wallet', 'directbonus', 'networkbonus', 'maxbonus',
            'matrix', 'rankdetails', 'count', 'levelcommcnt', 'levelcommrecord', 'wallets'
        ));
    }

    public function update(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'rank_id' => 'required|integer|exists:ihook_ranksetting,rank_id',
            'matrixid' => 'required|exists:ihook_matrix_table,matrix_id',
            'rank_title' => 'required|string|max:255',
            'rank_color' => 'required|string',
            'rank_icon' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'rank_icon_id' => 'nullable|string',
            'bonus' => 'nullable|numeric|min:0',
           'wallet' => 'required|exists:ihook_wallettype,wallet_type_id',
            'directbonus' => 'nullable|numeric|min:0',
            'networkbonus' => 'nullable|numeric|min:0',
            'maxbonus' => 'nullable|numeric|min:0',
            'rankcount' => 'nullable|integer|min:0',
            'totallevel' => 'nullable|integer|min:0',
            'condn*' => 'nullable|string|in:1,2,3,4,5,6,7,8,9,10,11',
            'value*' => 'nullable|string',
            'lvl*' => 'nullable|numeric|min:0',
        ]);

        $rank_id = $request->rank_id;

        // Delete existing records
        RankSetting::where('rank_id', $rank_id)->delete();
        RankLevelCommission::where('rank_id', $rank_id)->delete();

        // Handle rank_icon
        $icon_path = $request->input('rank_icon_id') ? 'assets/img/avatar/' . $request->rank_icon_id . '.png' : '';
        if ($request->hasFile('rank_icon')) {
            // Delete old icon if exists
            $old_icon = RankSetting::where('rank_id', $rank_id)->where('rank_key', 'rank_icon')->first();
            if ($old_icon && Storage::exists('public/' . $old_icon->rank_value)) {
                Storage::delete('public/' . $old_icon->rank_value);
            }
            $icon_path = str_replace('public/', '', $request->file('rank_icon')->store('public/uploads/members'));
            Log::info('Rank icon updated', ['icon_path' => $icon_path]);
        }

        // Store single keys in RankSetting
        $matrix_id = $request->matrixid;
        $keys = [
            'matrix_id' => $matrix_id,
            'rank_title' => $request->rank_title,
            'rank_color' => $request->rank_color,
            'rank_icon' => $icon_path,
            'bonus' => $request->bonus ?? 0,
            'wallet' => $request->wallet,
            'directbonus' => $request->directbonus ?? 0,
            'networkbonus' => $request->networkbonus ?? 0,
            'maxbonus' => $request->maxbonus ?? 0,
        ];

        foreach ($keys as $key => $value) {
            if ($value !== null && $value !== '') {
                RankSetting::create([
                    'rank_id' => $rank_id,
                    'matrix_id' => $matrix_id,
                    'rank_key' => $key,
                    'rank_value' => $value,
                ]);
                Log::info('RankSetting updated', ['key' => $key, 'value' => $value]);
            }
        }

        // Store conditions in RankSetting
        $rankcount = $request->rankcount ?? 0;
        for ($i = 0; $i < $rankcount; $i++) {
            $condn = $request->input("condn$i");
            $value = $request->input("value$i");
            if ($condn !== null && $condn !== '') {
                RankSetting::create([
                    'rank_id' => $rank_id,
                    'matrix_id' => $matrix_id,
                    'rank_key' => $condn,
                    'rank_value' => $value ?? '',
                ]);
                Log::info('Condition updated', ['rank_key' => $condn, 'rank_value' => $value]);
            }
        }

        // Store levels in RankLevelCommission
        $totallevel = $request->totallevel ?? 0;
        for ($i = 1; $i <= $totallevel; $i++) {
            $comm = $request->input("lvl$i") ?? 0;
            if ($comm > 0) {
                RankLevelCommission::create([
                    'rank_id' => $rank_id,
                    'matrix_id' => $matrix_id,
                    'level' => $i,
                    'commission' => $comm,
                ]);
                Log::info('Level commission updated', ['level' => $i, 'commission' => $comm]);
            }
        }

        return redirect()->route('ranksetting')->with('success', 'Rank updated successfully');
    }
}
