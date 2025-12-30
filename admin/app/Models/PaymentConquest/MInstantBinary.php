<?php
namespace Admin\App\Models\PaymentConquest;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\BinaryRatio;
use Admin\App\Models\Member\CarryOver;
use Admin\App\Models\Member\History;
use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MMatrixConfiguration;


class MInstantbinary
{
      public static function binarySplitFun($membersAncestors, $memberId, $matrixId, $paymenthistory_amount, $memberName)
    {


        // Check instant binary status
        $historyMembersRefId = $memberId;
        $instantStatus = MatrixConfiguration::where('matrix_key', 'instantbinary_commission_status')
            ->where('matrix_id', $matrixId)
            ->value('matrix_value');

        if ($instantStatus == '1') {
            // Get binary ratio
            $matrix = MatrixConfiguration::where('matrix_key', 'instantbinary_sales_volume')
            ->where('matrix_id', $matrixId)
            ->first();


            if (!$matrix) {
                return null;
            }

            $binary = BinaryRatio::where('binaryratio_id', $matrix->matrix_value)->first();

            if (!$binary) {
                return null;
            }


        $firstpartbinarybaseratio = explode('or', $binary->binaryratio);


        if (!empty($firstpartbinarybaseratio[0])) {
            // Split "1:1" (or similar) into two parts
            $ratioParts = explode(':', $firstpartbinarybaseratio[0]);

            $firstpartbinaryratio  = $ratioParts[0] ?? ''; // left side
            $secondpartbinaryratio = $ratioParts[1] ?? ''; // right side
        } else {
            $firstpartbinaryratio  = '';
            $secondpartbinaryratio = '';
        }

            // Get carryover setting
          $carryoverKey = Carryover::where('carryover_id',
            MatrixConfiguration::where('matrix_key', 'instantbinary_carryover')
                ->where('matrix_id', $matrixId)
                ->value('matrix_value')
                 )->value('carryoverkey');

            // 2. Get binary commission
            $binaryCommission = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'instantbinary_commission')[0]['matrix_value'] ?? 0;

            // 3. Get wallet type
            $walletTypeValue = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'instantbinary_commission_wallet_type')[0]['matrix_value'] ?? '2';
            $binaryCommissionWalletType = ($walletTypeValue == '1') ? '1' : '2';

            // 4. Get binary commission type
            $binaryCommissionType = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'instantbinary_commission_type')[0]['matrix_value'] ?? null;

            // 5. Commission amount
            $commissionAmount = $binaryCommission;


        }

        $upLineMembers = explode(',', $membersAncestors . ',' . $memberId);


        foreach ($upLineMembers as $key => $member) {
            $nextMember = $upLineMembers[$key + 1] ?? null;
            $downMember = $member;

            if ($nextMember) {
                $leftUser  = MBinaryMembersPosition::getBinaryMembersPosition($member, $matrixId, '1');
                $rightUser = MBinaryMembersPosition::getBinaryMembersPosition($member, $matrixId, '2');

                $amount = (float) $paymenthistory_amount;

                if ($nextMember == trim($leftUser)) {
                    $leftlink = MemberLinks::where('members_id', $downMember)
                        ->where('matrix_id', $matrixId)
                        ->first();

                    if ($leftlink) {
                        $leftlink->daily_left_sales_volume   = ((float)($leftlink->daily_left_sales_volume ?? 0))   + $amount;
                        $leftlink->daily_total_left_members  = ((int)  ($leftlink->daily_total_left_members ?? 0))  + 1;
                        $leftlink->weekly_left_sales_volume  = ((float)($leftlink->weekly_left_sales_volume ?? 0))  + $amount;
                        $leftlink->weekly_total_left_members = ((int)  ($leftlink->weekly_total_left_members ?? 0)) + 1;
                        $leftlink->monthly_left_sales_volume = ((float)($leftlink->monthly_left_sales_volume ?? 0)) + $amount;
                        $leftlink->monthly_total_left_members= ((int)  ($leftlink->monthly_total_left_members ?? 0))+ 1;
                        $leftlink->instant_left_sales_volume = ((float)($leftlink->instant_left_sales_volume ?? 0)) + $amount;
                        $leftlink->save();
                    }
                }

                if ($nextMember == trim($rightUser)) {
                    $rightlink = MemberLinks::where('members_id', $downMember)
                        ->where('matrix_id', $matrixId)
                        ->first();

                    if ($rightlink) {
                        $rightlink->daily_right_sales_volume   = ((float)($rightlink->daily_right_sales_volume ?? 0))   + $amount;
                        $rightlink->daily_total_right_members  = ((int)  ($rightlink->daily_total_right_members ?? 0))  + 1;
                        $rightlink->weekly_right_sales_volume  = ((float)($rightlink->weekly_right_sales_volume ?? 0))  + $amount;
                        $rightlink->weekly_total_right_members = ((int)  ($rightlink->weekly_total_right_members ?? 0)) + 1;
                        $rightlink->monthly_right_sales_volume = ((float)($rightlink->monthly_right_sales_volume ?? 0)) + $amount;
                        $rightlink->monthly_total_right_members= ((int)  ($rightlink->monthly_total_right_members ?? 0))+ 1;
                        $rightlink->instant_right_sales_volume = ((float)($rightlink->instant_right_sales_volume ?? 0)) + $amount;
                        $rightlink->save();
                    }
                }


                // Send binary commission
               if (!empty($firstpartbinaryratio)) {
                    self::sendBinaryCommission(
                        $downMember,
                        $matrixId,
                        $historyMembersRefId,
                        $paymenthistory_amount,
                        $memberName,
                        $firstpartbinaryratio,
                        $secondpartbinaryratio,
                        $carryoverKey,
                        $binaryCommissionWalletType,
                        $commissionAmount,
                        $binaryCommissionType
                    );
                }
            }
        }
    }

     public static function sendBinaryCommission($memberId, $matrixId, $historyMemberRefId, $paymenthistory_amount, $memberName, $firstpartbinaryratio, $secondRatio, $carryover, $binaryCommissionWalletType, $commissionAmount, $binaryCommissionType)
    {


        $link = MemberLinks::where('members_id', $memberId)
            ->where('matrix_id', $matrixId)
            ->first();


        $leftVolume  = $link->instant_left_sales_volume;
        $rightVolume = $link->instant_right_sales_volume;



        // Handle first ratio
        if (is_string($firstpartbinaryratio)) {
            $firstParts = explode(':', $firstpartbinaryratio);
        } else {
            $firstParts = (array) $firstpartbinaryratio;
        }


        // Ensure both indexes exist
        $firstParts[0] = $firstParts[0] ?? 1;
        $firstParts[1] = $firstParts[1] ?? 1;

        // Handle second ratio safely
        if ($secondRatio != '1') {
            if (is_string($secondRatio)) {
                $secondParts = explode(':', $secondRatio);
            } else {
                $secondParts = (array) $secondRatio;
            }
        } else {
            // Fall back to second part of first ratio, defaulting to 1
            $secondParts = [$firstParts[1] ?? 1];
        }

        // Ensure second ratio parts exist
        $secondParts[0] = $secondParts[0] ?? 1;
        $secondParts[1] = $secondParts[1] ?? 1;


        $largerRatio = max($firstParts[0], $secondParts[0]);

        $flag = 0;


        if ($leftVolume > 0 && $rightVolume > 0) {
            if ($leftVolume < $rightVolume) {
                $targetRight = $leftVolume * $largerRatio;
                $lesserVolume = $leftVolume;
            } elseif ($leftVolume > $rightVolume) {
                $targetLeft = $rightVolume * $largerRatio;
                $lesserVolume = $rightVolume;
            } else {
                $lesserVolume = $leftVolume;
            }

            if ($binaryCommissionType == '%') {
                $commissionAmount = $lesserVolume * ($commissionAmount / 100);
            }

            if ($flag == 1 && $commissionAmount > 0) {
                $description = "Instant Binary Commission has been earned through $memberName";

                // Get cryptocurrency conversion
                // $cryptoId = MatrixConfiguration::getMatrixValue($matrixId, 'instantbinary_cryptocurrency');
                // $cryptoName = CryptoCurrency::find($cryptoId)->crypto_default_name;
                // $cryptoBalance = MCryptoConverter::cryptoConverter($cryptoName);
                // $cryptoQty = $cryptoBalance != 0 ? number_format($commissionAmount / $cryptoBalance, 6) : 0;

                $history = new History();
                $history->history_member_id = $members_id;
                $history->history_amount = $format_commission_amount;
                $history->history_type = 'binarycommission';
                $history->history_description = $dec;
                $history->history_datetime = now();
                $history->history_payment = 0;
                $history->history_wallet_type = $history_wallet_type;
                $history->history_matrix_id = $matrix_id;
                $history->history_members_ref_id = $history_members_ref_id;
                $history->history_binary_commission_type = $history_binary_commission_type;
                $history->history_transaction_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
                // $history->crypto_qty = $crypto_qty;
                // $history->currency_id = $cryptocurrency1;


                $history->save();
            }

            // Update remaining volume
            $link->update([
                'instant_left_sales_volume' => $updateLeftVolume ?? 0,
                'instant_right_sales_volume' => $updateRightVolume ?? 0,
            ]);
        }
    }
}
