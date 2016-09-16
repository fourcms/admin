<?php
/*
 * This file is part of the FourCms Admin Platfourm package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Controllers;

use Longman\Platfourm\Http\Controllers\AdminController as BaseController;

abstract class Controller extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        // Set scope namespace
        $admin_prefix         = config('fourcms.admin_prefix', 'admin');
        $this->scopeNamespace = $admin_prefix;
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function view($view, $data = [], $mergeData = [])
    {
        $packagePrefiux = 'fourcms/admin::';

        if (view()->exists($packagePrefiux . $view)) {
            return view($packagePrefiux . $view, $data, $mergeData);
        }

        $viewMask = [];
        if ($this->scopeNamespace) {
            $viewMask[] = $this->scopeNamespace;
        }
        if ($this->viewNamespace) {
            $viewMask[] = $this->viewNamespace;
        }
        $viewMask[] = $view;

        return view(implode('.', $viewMask), $data, $mergeData);
    }

}
