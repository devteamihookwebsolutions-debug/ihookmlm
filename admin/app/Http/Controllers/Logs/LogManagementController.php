<?php

/**
 * This class contains public functions related to LogManagementController
 *
 * @package         LogManagementController
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

namespace Admin\App\Http\Controllers\Logs;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Logs\MLogManagement;
use Illuminate\Http\Request;

class LogManagementController extends Controller
{
      public  function showUserLogs()
        {
            // dd('kjasdf');
              $output['userlog'] = MLogManagement::showUserLogs();
              // dd($output);
              return view('logs/user_logs',$output);
        }
         public  function showAdminLogs()
        {
            // dd('kjasdf');
              $output['adminlog'] = MLogManagement::showAdminLogs();
              // dd($output);
              return view('logs/admin_logs', $output);
        }
}
