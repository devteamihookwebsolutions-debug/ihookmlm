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
