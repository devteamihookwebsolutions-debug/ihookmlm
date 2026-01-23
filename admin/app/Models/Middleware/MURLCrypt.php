<?php

/**
 * This class contains public functions related to MURLCrypt
 *
 * @package         MURLCrypt
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Middleware;

use Hashids\Hashids;
use Illuminate\Support\Facades\Crypt;

class MURLCrypt
{
    protected static $hashids;

    protected static function hashids(): Hashids
    {
        if (!self::$hashids) {
            $salt = config('app.key');
            self::$hashids = new Hashids($salt, 100);
        }
        return self::$hashids;
    }

    /**
     * Encode → short, unique, reversible token
     */
    public static function encode(int $members_id, ?int $matrix_id): string
    {
        $nonce = random_int(100000, 999999); // 6-digit random
        return self::hashids()->encode($members_id, $matrix_id ?? 0, $nonce);
    }

    /**
     * Decode → [members_id, matrix_id] (nonce ignored)
     */
    public static function decode(string $token): ?array
    {
        $ids = self::hashids()->decode($token);
        if (count($ids) < 2) return null;

        $members_id = $ids[0];
        $matrix_id  = $ids[1] ?? null;
        // $nonce = $ids[2] ?? null; // ignore

        return [$members_id, $matrix_id === 0 ? null : $matrix_id];
    }

    // Keep your old Crypt methods (optional)
    public static function getEncryptURL($members_id, $matrix_id): string
    {
        return Crypt::encrypt([$members_id, $matrix_id]);
    }

    public static function getDecryptURL($encrypted): ?array
    {
        try {
            $decrypted = Crypt::decrypt($encrypted);
            return is_array($decrypted) && count($decrypted) === 2 ? $decrypted : null;
        } catch (\Exception $e) {
            \Log::warning('Decrypt failed', ['encrypted' => $encrypted]);
            return null;
        }
    }
}
