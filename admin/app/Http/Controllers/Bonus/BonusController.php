<?php
namespace Admin\App\Http\Controllers\Bonus;

use Admin\App\Http\Controllers\Controller;

use Admin\App\Models\Bonus\Bonus;
use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\Wallet;
use Admin\App\Models\Rank\RankSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonusController extends Controller
{
    /**
     * Display the bonus list.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
            $bonuses = Bonus::with(['matrix', 'wallet'])->get();
        return view( 'Bonus.bonusmanagementview', compact('bonuses'));
    }

    /**
     * Show the form for adding a new bonus.
     *
     * @return \Illuminate\View\View
     */
    public function add()
    {
        // Fetch matrices for the plan dropdown
        $matrices = MMatrix::all()->map(function ($matrix) {
            return '<option value="' . $matrix->matrix_id . '">' . htmlspecialchars($matrix->matrix_name) . '</option>';
        })->implode('');

        // Fetch wallet types for the account type dropdown
        $accountTypes = Wallet::all()->map(function ($wallet) {
            return '<option value="' . $wallet->wallet_type_id . '">' . htmlspecialchars($wallet->wallet_name) . '</option>';
        })->implode('');

        return view('Bonus.addbonusmanagement', [
            'matrix' => $matrices,
            'accountype' => $accountTypes,
        ]);
    }

    /**
     * Store a new bonus in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
public function store(Request $request)
{
    // dd($request->all());
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'matrix_id' => 'required|exists:ihook_matrix_table,matrix_id',
        'periodstatus' => 'nullable|boolean',
        'bonus_to' => 'required|in:0,1',
        'Bonus_Type' => 'required|in:1,2',
        'Bonus_Period' => 'nullable|in:1,2,3,4,5,6',
        'giftname' => 'nullable|string|max:255',
        'amount' => 'nullable|numeric|min:0',
        'maximumlimit' => 'nullable|numeric|min:0',
        'admin_approve_bonus' => 'nullable|boolean',
        'workson' => 'required|string|in:Registration,Recruit New User,Upgrade Network,Package Upgrade,Auto',
        'accountype' => 'required|exists:ihook_wallettype,wallet_type_id',
        'crypto_currency' => 'nullable|string|max:255',
        'crypto_currency_id' => 'nullable|string|max:45',
        'bonusday' => 'nullable|integer|between:1,31',
        'bonusmonth' => 'nullable|integer|between:1,12',
        'bonus_status' => 'nullable|in:1,0,active,inactive',
    ]);

    $user = Auth::user();
    $userId = $user?->id ?? 1;

    $isGift = $request->boolean('bonusreward', false);

    $bonus = new Bonus();
    $bonus->bonus_name = $validated['title'];
    $bonus->matrix_id = $validated['matrix_id'];
    $bonus->periodstatus = $validated['periodstatus'] ?? 0;
    $bonus->reward = $isGift ? 1 : 0;
    $bonus->amount = $isGift ? null : ($validated['amount'] ?? 0);
    $bonus->giftname = $isGift ? ($validated['giftname'] ?? null) : null;
    $bonus->bonustype = $validated['Bonus_Type'];

    $bonus->period = $validated['Bonus_Period'] ?? 0;

    $bonus->workson = $validated['workson'];
    $bonus->bonus_to = $validated['bonus_to'];
    $bonus->maximumlimit = $validated['maximumlimit'] ?? null;
    $bonus->admin_approve_bonus = $validated['admin_approve_bonus'] ?? 0;
    $bonus->accountype = $validated['accountype'];
    $bonus->crypto_currency = $validated['crypto_currency'] ?? null;
    $bonus->crypto_currency_id = $validated['crypto_currency_id'] ?? null;
    $bonus->bonusday = $validated['bonusday'] ?? null;
    $bonus->bonusmonth = $validated['bonusmonth'] ?? null;

    $status = $validated['bonus_status'] ?? 'active';
    $bonus->bonus_status = in_array($status, ['1', 'active']) ? 1 : 0;

    $bonus->createdby = $userId;
    $bonus->updatedby = $userId;
    $bonus->createdon = now();
    $bonus->updatedon = now();

    $bonus->save();

    return redirect()
        ->route('bonus.list')
        ->with('success', 'Bonus added successfully.');
}
/**
 * Display a specific bonus details.
 *
 * @param int $id
 * @return \Illuminate\View\View
 */
public function show($id)
{
    // Load the bonus with its relations
    $bonus = Bonus::with(['matrix', 'wallet'])->findOrFail($id);

    // Pass the whole model to the view – the view will read the fields directly
    return view('Bonus.bonusmanagementdetail', compact('bonus'));
}
/**
 * Get ranks for a specific matrix (AJAX dropdown)
 */
public function getRanks($matrix_id)
    {
        $ranks = RankSetting::where('matrix_id', $matrix_id)
            ->orderBy('rank_key')
            ->get(['rank_id', 'rank_key']);   // <-- use the real columns

        $html = '<option value="">-- Select Rank --</option>';
        foreach ($ranks as $rank) {
            $html .= '<option value="' . $rank->rank_id . '">'
                   . htmlspecialchars($rank->rank_key) . '</option>';
        }

        return $html;
    }
/**
 * Get packages for a specific matrix (AJAX dropdown)
 */
public function getPackages($id)
{

    $packages = MMatrix::where('matrix_id', $id)
        ->orderBy('package_name')
        ->get(['package_id', 'package_name']);

    $options = '<option value="">-- Select Package --</option>';
    foreach ($packages as $package) {
        $options .= '<option value="' . $package->package_id . '">'
            . htmlspecialchars($package->package_name) . '</option>';
    }

    return $options;
}
}
