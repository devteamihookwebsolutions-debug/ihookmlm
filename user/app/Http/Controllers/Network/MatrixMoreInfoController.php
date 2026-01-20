<?php

/**
 * This class contains public functions related to MatrixMoreInfoController
 *
 * @package         MatrixMoreInfoController
 * @category        Controller
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

namespace User\App\Http\Controllers\Network;

use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Model\Genealogy\MBinaryCollapseGenealogy;
use Admin\App\Model\Genealogy\MCollapseGenealogy;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Network\MMatrixMoreInfo; // Reference to model

class MatrixMoreInfoController extends Controller
{
    /**
     * This public function is used to constructor of this class
     */
    public function __construct() {
        $output = array();
        if (request()->query('action') != 'matrixmoreinfo') {
            if (empty(session('default.customer_id'))) {
                return redirect(env('FCPATH') . "/login");
            } parent::getSiteDetails();
        }
    }

    /**
     * This public function is used to show the user matrix more information details
     * @return HTML data
     */
    public function showMatrixMoreInformation()
    {
        try {
            return MMatrixMoreInfo::showMatrixMoreInformation();
        }
        catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/network");
        }
    }
}
