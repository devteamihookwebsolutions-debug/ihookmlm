<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\WalletType;
use Illuminate\Http\Request;


class MWalletDetails
{
    
        public static function getWalletDetails($wallet_type_id)
    {
         return WalletType::where('wallet_type_id', $wallet_type_id)->get();
    }
}