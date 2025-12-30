<?php

namespace User\App\Http\Controllers\Genealogy;
use User\App\Http\Controllers\Controller;
use Admin\AppModel\Genealogy\MGenealogySidebar;

class GenealogySidebarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sidebar()
    {
        return MGenealogySidebar::getGenealogySidebar();
    }
}
