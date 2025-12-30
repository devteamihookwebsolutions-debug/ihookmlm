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