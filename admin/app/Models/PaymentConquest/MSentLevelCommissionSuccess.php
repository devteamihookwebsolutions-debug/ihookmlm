<?php

namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\History;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\LevelCommission;
use Illuminate\Support\Str;

class MSentLevelCommissionSuccess
{
    public static function sentLevelCommission(
        $memberId,
        $matrixId,
        $spilloverId,
        $memberName,
        $paymentAmount,
        $level,
        $maxLevel,
        $dynamicCompression,
        $directCheck
    ) {
        // Stop if no sponsor or level exceeded
        if ($spilloverId <= 0 || $level > $maxLevel) {
            return;
        }

        $spillover = MemberLinks::select($directCheck, 'members_account_status')
            ->where('members_id', $spilloverId)
            ->where('matrix_id', $matrixId)
            ->first();

        if (!$spillover) {
            return;
        }

        $nextSpilloverId = $spillover->{$directCheck};
        $accountStatus = $spillover->members_account_status;

        $levelDetails = LevelCommission::where('matrix_id', $matrixId)
            ->where('levels', $level)
            ->first();

        if (!$levelDetails) {
            return;
        }

        // Wallet type
        $historyWalletType = ($levelDetails->levelcommission_wallet_type == '1') ? '1' : '2';

        // Calculate commission
        if (in_array(trim($levelDetails->levelcommission_method), ['1', '%', 'percentage'])) {
            $commissionAmount = ($paymentAmount * $levelDetails->levelcommission_amount) / 100;
        } else {
            $commissionAmount = (float) $levelDetails->levelcommission_amount;
        }

        $description = "Level {$level} Commission has been earned through referring {$memberName}";

        // Only credit if amount > 0 and member is active
        if ($commissionAmount > 0 && $accountStatus == '1') {

            // FIX: Define crypto variables safely (even if crypto is disabled)
            $cryptoQty = 0;
            $cryptoCurrencyId = null;

            // If you enable crypto later, just uncomment below
            /*
            $currency = $levelDetails->currency;
            $crypto = CryptoCurrency::where('crypto_name', $currency)->first();
            if ($crypto) {
                $cryptoCurrencyId = $crypto->crypto_currency_id;
                $cryptoBalance = MCryptoConverter::cryptoConverter($crypto->crypto_default_name);
                $cryptoValue = str_replace(',', '', $cryptoBalance);
                $formattedCommission = MFormatNumber::formatingNumberCurrency($commissionAmount);
                $cryptoQty = $cryptoValue != 0 ? $formattedCommission / $cryptoValue : 0;
                $cryptoQty = number_format($cryptoQty, 6, '.', '');
            }
            */

            $history = new History();
            $history->history_member_id = $spilloverId;
            $history->history_amount = $commissionAmount;
            $history->history_type = 'levelcommission';
            $history->history_description = $description;
            $history->history_datetime = now();
            $history->history_payment = 0;
            $history->history_wallet_type = $historyWalletType;
            $history->history_matrix_id = $matrixId;
            $history->history_members_ref_id = $memberId;
            $history->history_transaction_id = '#' . Str::random(9);
            $history->crypto_qty = $cryptoQty;
            $history->currency_id = $cryptoCurrencyId;
            $history->save();
        }

        // Dynamic Compression Logic
        if ($dynamicCompression == '1') {
            if ($accountStatus == '1') {
                $level += 1;
            }
        } else {
            $level += 1;
        }

        // Recurse to next level
        self::sentLevelCommission(
            $memberId,
            $matrixId,
            $nextSpilloverId,
            $memberName,
            $paymentAmount,
            $level,
            $maxLevel,
            $dynamicCompression,
            $directCheck
        );
    }
}
