<?php

namespace FourCms\Admin;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton('itdc.admin', function () {
            $admin = new Admin();
            return $admin;
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Admin', '\FourCms\Admin\Facades\Admin');
    }
}
