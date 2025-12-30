<?php
/**
 * This class contains public static functions related to e pin
 *
 * @package         CEpinHistory
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php

namespace User\App\Http\Controllers\Epin;

use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use User\App\Models\Epin\MEpinHistory;

class EpinHistoryController extends Controller
{
    public static function showEpinHistory()
    {
            $output['epinrecords']     = MEpinHistory::epinRecordsUnused();

            $output['epinusedrecords'] = MEpinHistory::epinRecordsUsed();

           return view('user::epin.epinhistory', $output);

    }
}

