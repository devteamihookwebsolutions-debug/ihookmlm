<?php

/**
 * This class contains public functions related to MWalletType
 *
 * @package         MWalletType
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\WalletType;
use Illuminate\Http\Request;
use Admin\App\Display\Middleware\DWalletType;

class MWalletType
{

    public static function getWalletType($name, $id, $editable)
    {
        $records = WalletType::where('wallet_status', 'Active')->get();

        // return DWalletType::getWalletType($records, $name, $id, $editable);
    }
    public function getWalletTypeEarnings($name, $id, $editable)
    {
        return WalletType::where('wallet_status', 'Active')->get();
    }

}
?>
