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