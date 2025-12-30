<?php

namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\PaymentConquest\MSentDirectCommissionSuccess;
use Admin\App\Models\PaymentConquest\MSentLevelCommissionSuccess;
use Admin\App\Models\PaymentConquest\MSentPVSuccess;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\LevelCommission;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Illuminate\Support\Facades\Log;

class MOneTimeRegisterSuccess
{
    public static function oneTimeRegisterSuccess(
        $membersId,
        $directId,
        $matrixId,
        $entryCriteria,
        $paymentAmtExclusive,
        $memberName,
        $matrixTypeId
    ) {
        Log::info('[OneTimeRegister] STARTED - FREE REGISTRATION COMMISSION', [
            'member_id' => $membersId,
            'payment_amount' => $paymentAmtExclusive
        ]);

        // Get sponsor (spillover)
        $spilloverId = MemberLinks::where('members_id', $membersId)
            ->where('matrix_id', $matrixId)
            ->value('spillover_id') ?: $directId;

        $registrationFee = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'registration_fee');
        $registrationFee = is_array($registrationFee) ? ($registrationFee[0]['matrix_value'] ?? '0') : $registrationFee;
        $registrationFee = (float) trim($registrationFee);

        Log::info('[OneTimeRegister] Registration Fee from Config', ['fee' => $registrationFee]);

           // === 1. DIRECT COMMISSION ===
$directStatus = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'direct_referrel_commission_status');
$directStatus = is_array($directStatus) ? ($directStatus[0]['matrix_value'] ?? '0') : $directStatus;

if ($directStatus === '1') {
    Log::info('[OneTimeRegister] Direct Commission Enabled - Sending to processor', [
        'registration_fee' => $registrationFee
    ]);


    MSentDirectCommissionSuccess::sentDirectCommission(
        $membersId,
        $directId,
        $matrixId,
        '1',
        $registrationFee,
        0,
        0,
        $memberName
    );
}
        // === 2. LEVEL COMMISSION ===
        $levelStatus = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'level_commisison_status');
        $levelStatus = is_array($levelStatus) ? ($levelStatus[0]['matrix_value'] ?? '0') : $levelStatus;

        if ($levelStatus === '1') {
            $maxLevel = LevelCommission::where('matrix_id', $matrixId)->max('levels') ?: 10;
            $dynamicComp = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'dynamic_compression_status');
            $dynamicComp = is_array($dynamicComp) ? ($dynamicComp[0]['matrix_value'] ?? '0') : $dynamicComp;
            $checkField = ($matrixTypeId == 3 && $dynamicComp !== '1') ? 'direct_id' : 'spillover_id';

            $levelBaseAmount = $registrationFee;

            Log::info('[OneTimeRegister] LEVEL COMMISSION - FREE MODE', [
                'registration_fee_as_base' => $levelBaseAmount,
                'max_levels' => $maxLevel
            ]);

            MSentLevelCommissionSuccess::sentLevelCommission(
                $membersId,
                $matrixId,
                $spilloverId,
                $memberName,
                $levelBaseAmount,
                1,
                $maxLevel,
                $dynamicComp,
                $checkField
            );
        }

        $pvValue = MMatrixConfiguration::getMatrixConfigurationDetails($matrixId, 'registration_pv');
        $pvValue = is_array($pvValue) ? ($pvValue[0]['matrix_value'] ?? '0') : $pvValue;
        $pvValue = (float) trim($pvValue);

        if ($pvValue > 0) {
            MSentPVSuccess::sentPV($membersId, $pvValue, $matrixId, 0, $spilloverId);
            Log::info('[OneTimeRegister] PV Distributed', ['pv' => $pvValue, 'to' => $spilloverId]);
        }

        Log::info('[OneTimeRegisterSuccess] FREE REGISTRATION COMMISSIONS COMPLETED!', [
            'member_id' => $membersId,
            'registration_fee_used' => $registrationFee,
            'direct_commission' => ($directStatus === '1') ? 'YES' : 'NO',
            'level_commission' => ($levelStatus === '1') ? 'YES' : 'NO',
            'pv' => $pvValue
        ]);
    }
}
