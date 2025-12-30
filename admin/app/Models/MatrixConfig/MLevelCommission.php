<?php
namespace Admin\App\Models\MatrixConfig;

// use Admin\App\Models\Middleware\MMatrixDetails;
// use Admin\App\Display\MatrixConfig\DMatrixPackage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Admin\App\Models\Member\LevelCommission;
use Admin\App\Models\Member\MatrixConfiguration;

class MLevelCommission
{


   public static function showLevelCommission($matrix_id) {


       $records = LevelCommission::where('matrix_id', $matrix_id)
            ->orderBy('levelcommission_id', 'asc')
            ->get();

        return  $records;

    }

        public static function insertLevelCommission($levels) {

            // dd('dsfsdf');
            $levelCommissionName = $levels['name'];
            $levelCommissionAmount = $levels['commission'];
            $method = $levels['method'];
            $matrixId = $levels['matrixid'];
            $pid = $levels['pid'];
            $wallet = $levels['wallet'];
            // $cryptocurrency =  $levels['commission'];

            // Determine method type
            $levelCommissionMethod = ($method === 'Flat') ? 'flat' : '%';

            // Determine wallet type
            $levelCommissionWalletType = ($wallet === 'C-Wallet') ? 1 : 2;
            // dd($levelCommissionWalletType);
            $levelRecord = LevelCommission::where('levels', $levels)
                ->where('matrix_id', $matrixId)
                ->first();

              if ($levelRecord) {
                LevelCommission::where('levelcommission_id', $levelRecord->levelcommission_id)->update([
                    'levelcommission_name' => $levelCommissionName,
                    'levelcommission_amount' => $levelCommissionAmount,
                    'levelcommission_method' => $levelCommissionMethod,
                    'levelcommission_wallet_type' => $levelCommissionWalletType,
                    // 'currency' => $cryptocurrency, // uncomment if needed
                ]);

            } else {
                // Count existing levels for this matrix
                $existingLevels = LevelCommission::where('matrix_id', $matrixId)->count();
                $newLevel = $existingLevels + 1;

                // Create new level commission record
                $levelRecord = new LevelCommission();
                $levelRecord->levelcommission_name = $levelCommissionName;
                $levelRecord->levelcommission_amount = $levelCommissionAmount;
                $levelRecord->levelcommission_method = $levelCommissionMethod;
                $levelRecord->matrix_id = $matrixId;
                $levelRecord->levelcommission_wallet_type = $levelCommissionWalletType;
                $levelRecord->levels = $newLevel;
                // $levelRecord->currency = $cryptocurrency;
                $levelRecord->save();
            }

            // Update matrix configuration
            $matrixConfig = MatrixConfiguration::where('matrix_id', $matrixId)
                ->where('matrix_key', 'level_commisison_status')
                ->first();

            if ($matrixConfig) {
                $matrixConfig->matrix_value = 1;
                $matrixConfig->save();
            }

            return response()->json(['success' => true]);

        }

        public function deleteLevelCommission(Request $request)
        {
            LevelCommission::where('levels', $request->id)
                ->where('matrix_id', $request->matrix_id)
                ->delete();

            return response()->json(['success' => true]);
        }

}
