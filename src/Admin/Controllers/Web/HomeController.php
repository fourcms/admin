<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Controllers\Web;

use FourCms\Admin\Controllers\WebController;

class HomeController extends WebController
{

    public function index()
    {

        return $this->view('app');
    }
}
