<?php

namespace User\App\Models\Epin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MWalletBalance;
use User\App\Display\Epin\DEpinHistory;

class MEpinHistory
{

    public static function epinRecordsUnused()
    {
            $user = Auth::user();
            $user_id = $user->members_id;

        if (!$user_id) {
            return DEpinHistory::epinRecordsUnused(collect(), 0);
        }

        $records = DB::table(env('IHOOK_PREFIX') . '_epin_table')
            ->where('epin_member_id', $user_id)
            ->where(function ($query) {
                $query->where('epin_status', 0)
                    ->orWhereNull('epin_status');
            })
            ->orderBy('epin_id', 'desc')
            ->get();

        return DEpinHistory::epinRecordsUnused($records, $records->count());
    }

    public static function epinRecordsUsed()
    {
        $user = Auth::user();
        $user_id = $user->members_id;

        if (!$user_id) {
            return DEpinHistory::epinRecordsUsed(collect(), 0);
        }

        $records = DB::table(env('IHOOK_PREFIX') . '_epin_table')
            ->where('epin_member_id', $user_id)
            ->where('epin_status', 1)
            ->orderBy('epin_id', 'desc')
            ->get();

        return DEpinHistory::epinRecordsUsed($records, $records->count());
    }

    public static function validateEpinPass()
    {
        if (!request()->has('transaction_password')) {
            return response()->json('false');
        }

        $user = Auth::user();
        $postedPass = request('transaction_password');

        $hashed = $user->members_transaction_password ?? '';

        if ($hashed && sodium_crypto_pwhash_str_verify($hashed, $postedPass)) {
            return response()->json('true');
        }

        return response()->json('false');
    }

    public static function getAvailableBalance()
    {
        $user_id = Auth::id();
        $history_wallet_type = '2';

        return MWalletBalance::getWalletCurrentBalance($user_id, $history_wallet_type);
    }

    public static function getEpinType($err = '')
    {
        $prefix = env('IHOOK_PREFIX');
        $member = Auth::user();

        if (!$member) {
            return '<select name="epin_type"><option>Please login</option></select>';
        }

        $memberMatrixId = DB::table($prefix . '_matrix_members_link_table')
            ->where('members_id', $member->members_id)
            ->value('matrix_id');

        if (!$memberMatrixId) {
            return '<select name="epin_type"><option>No matrix assigned</option></select>';
        }

        // Step 2: Get only packages from member's matrix
        $packages = DB::table($prefix . '_package_table as p')
            ->join($prefix . '_matrix_table as m', 'p.matrix_id', '=', 'm.matrix_id')
            ->where('p.matrix_id', $memberMatrixId)
            ->where('m.matrix_status', 1)
            ->select(
                'p.package_id',
                'p.package_name',
                'p.package_price',
                'm.matrix_id',
                'm.matrix_name',
                'm.matrix_type_id'
            )
            ->get();

        // Optional: Get matrix config if needed
        $matrixConfig = DB::table($prefix . '_matrix_configuration_table')
            ->where('matrix_id', $memberMatrixId)
            ->where('matrix_key', 'registration_fee')
            ->first();

        return self::showEpinType($packages, $matrixConfig, $err);
    }
    public static function showEpinType($records, $recordsmatrix, $err)
    {
        $oldValue = is_array($err) && isset($err['epin_type']) ? trim($err['epin_type']) : '';

        $output = '<select name="epin_type" id="epin_type" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800" onchange="showPackageAmount(this.value);">
            <option value="">' . __('Select Package') . '</option>';

        // Group by matrix name (optional: if same matrix has multiple packages)
        $grouped = [];
        foreach ($records as $package) {
            $matrixName = ucfirst($package->matrix_name ?? 'Unknown');
            $grouped[$matrixName][] = $package;
        }

        foreach ($grouped as $matrixName => $packages) {
            foreach ($packages as $package) {
                $value    = $package->package_id . ',' . $package->matrix_type_id;
                $display  = $matrixName . ' - ' . $package->package_name; // This is what you wanted
                $selected = ($value === $oldValue) ? 'selected' : '';

                $output .= '<option value="' . $value . '" ' . $selected . '>' . $display . '</option>';
            }
        }

        $ewalletValue = '100000000000001,1';
        $selected     = ($ewalletValue === $oldValue) ? 'selected' : '';
        $output      .= '<option value="' . $ewalletValue . '" ' . $selected . '>' . __('E-Wallet') . '</option>';

        $output .= '</select>';

        return $output;
    }

}
