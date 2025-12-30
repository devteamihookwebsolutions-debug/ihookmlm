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
