<?php

namespace FourCms\Admin\Controllers\Web;

use FourCms\Admin\Controllers\WebController;

class HomeController extends WebController
{

    public function index()
    {

        return $this->view('app');
    }
}
