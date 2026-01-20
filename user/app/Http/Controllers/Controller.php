<?php

/**
 * This class contains public functions related to Controller
 *
 * @package         Controller
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

namespace User\App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $baseData;

    public function __construct()
    {
        // Set the base data you want to share across all controllers
        $this->baseData = [
            'appName' => config('app.name'),
            'version' => '1.0',
            // other common details
        ];

        // If you want to share this data with all views automatically:
        view()->share('baseData', $this->baseData);
    }

     protected function renderView(string $view, array $data = [])
    {
        // Merge your layout data with any data passed to the view
        $data = array_merge($data, ['layout' => 'layouts.admin.admin_default']);
        return view($view, $data);
    }
}
