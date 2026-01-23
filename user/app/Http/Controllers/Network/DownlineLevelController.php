<?php

/**
 * This class contains public functions related to DownlineLevelController
 *
 * @package         DownlineLevelController
 * @category        Controller
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

namespace User\App\Http\Controllers\Network;

use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Model\Genealogy\MBinaryCollapseGenealogy;
use Admin\App\Model\Genealogy\MCollapseGenealogy;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Network\MDownlineLevel; // Reference to model

class DownlineLevelController extends Controller
{
    /**
     * This public function is used to constructor of this class
     */
    public function __construct()
    {
        $output = array();
        if (empty(session('default.customer_id'))) {
            return redirect(env('FCPATH') . "/login");
        }  parent::getSiteDetails();
    }

    /**
     * This public function is used to show in downline level
     * @return HTML data
     */
    public function downlineLevel()
    {
        try{
            $id              = session('default.customer_id');
            $output['level'] = MDownlineLevel::getLevel($id);

            return view('network/downlinelevel', $output);
            session()->forget('success_message');
            session()->forget('error_message');
        }catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/network");
        }
    }

    /**
     * This public function is used to get in downline level
     * @return HTML data
     */
    public function getDownlineLevel()
    {
        try{
            $id = session('default.customer_id');
            MDownlineLevel::getLevelUsers($id);
        }catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/network");
        }
    }
}
