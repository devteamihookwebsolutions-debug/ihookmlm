<?php
namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\PaymentHistory;
use Admin\App\Models\Member\PackageLevelCommission;
use Admin\App\Models\Member\Package;

use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\History;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Support\Str;



class MSentPackageLevelCommissionSuccess
{


     public static function sentPackageLevelCommission(
        $membersId,
        $matrixId,
        $spilloverId,
        $memberName,
        $packageId,
        $level,
        $maxLevel,
        $dynamicCompressionStatus,
        $directCheck
    ) {
        if ($spilloverId > 0 && $level <= $maxLevel) {

            // Fetch spillover member matrix link
            $matrixMemberLink = MemberLinks::where('members_id', $spilloverId)
                ->where('matrix_id', $matrixId)
                ->first([$directCheck, 'members_account_status']);

// dd('dfsf');

            if ($matrixMemberLink) {
                $nextSpilloverId = $matrixMemberLink->$directCheck;
                $membersAccountStatus = $matrixMemberLink->members_account_status;

                // Fetch package level commission
                $levelDetails = PackageLevelCommission::where('packagelevelcommission_package_id', $packageId)
                    ->where('matrix_id', $matrixId)
                    ->where('levels', $level)
                    ->first();

                if (!$levelDetails) {
                    return; // No commission defined for this level
                }

                $walletType = $levelDetails->packagelevelcommission_wallet_type;
                $historyWalletType = $walletType == '1' ? '1' : '2';

                // Fetch package details
                $packageDetails = Package::where('package_id', $packageId)
                    ->where('matrix_id', $matrixId)
                    ->first(['package_price', 'package_name']);

                $packagePrice = $packageDetails->package_price;
                $packageName = $packageDetails->package_name;

                // Calculate commission
                if ($levelDetails->packagelevelcommission_method == '%') {
                    $commissionAmt = ($packagePrice * $levelDetails->packagelevelcommission_amount) / 100;
                } else {
                    $commissionAmt = $levelDetails->packagelevelcommission_amount;
                }

                $description = "{$packageName} {$levelDetails->packagelevelcommission_name} Commission has been earned through referring {$memberName}";

                if ($commissionAmt > 0 && $membersAccountStatus == '1') {
                    // $format_comm_amt = MFormatNumber::formatingNumberCurrency($commission_amt);
                    $currency = $levelDetails->currency;

                    // $crypto = CryptoCurrency::where('crypto_name', $currency)->first();
                    // $cryptocurrency = $crypto->crypto_default_name;
                    // $cryptoCurrencyId = $crypto->crypto_currency_id;

                    // // Convert commission to crypto quantity
                    // $btcCryptoBalance = MCryptoConverter::cryptoConverter($cryptocurrency);
                    // $cryptoValue = str_replace(',', '', $btcCryptoBalance);

                    // $cryptoQty = $cryptoValue != '0' ? $formattedCommissionAmt / $cryptoValue : $cryptoValue;
                    // $cryptoQty = number_format($cryptoQty, 6, '.', '');

                    // Insert commission into history using new History() format
                    $history = new History();
                    $history->history_member_id = $spilloverId;
                    $history->history_amount = $commissionAmt;
                    $history->history_type = 'packagelevelcommission';
                    $history->history_description = $description;
                    $history->history_datetime = now();
                    $history->history_payment = 0;
                    $history->history_plan_id = $packageId;
                    $history->history_wallet_type = $historyWalletType;
                    $history->history_matrix_id = $matrixId;
                    $history->history_members_ref_id = $membersId;
                    $history->history_transaction_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
                    // $history->crypto_qty = $cryptoQty;
                    // $history->currency_id = $cryptoCurrencyId;
                    $history->save();
                }

                // Increment level based on dynamic compression
                $level = $dynamicCompressionStatus == '1' && $membersAccountStatus == '1' ? $level + 1 : $level + 1;

                // Recursive call
                self::sentPackageLevelCommission(
                    $membersId,
                    $matrixId,
                    $nextSpilloverId,
                    $memberName,
                    $packageId,
                    $level,
                    $maxLevel,
                    $dynamicCompressionStatus,
                    $directCheck
                );
            }
        }
    }
}

