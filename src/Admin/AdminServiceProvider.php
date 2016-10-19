<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Publish files
        /*$this->publishes(
            [
                __DIR__ . '/../config/config.php' => config_path('fourcms/admin.php'),
                __DIR__ . '/../resources/views'   => base_path('resources/views/vendor/fourcms/admin'),
            ]
        );*/

        // Append the missing package settings
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'fourcms.admin'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'fourcms/admin');
    }

    public function register()
    {
        $this->app->singleton('fourcms.admin', function () {
            $admin = new Admin();
            return $admin;
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Admin', '\FourCms\Admin\Facades\Admin');

        $this->appendPathToSwagger();
    }

    public function appendPathToSwagger()
    {
        $current = config('l5-swagger.paths.annotations');
        if (empty($current)) {
            return false;
        }

        if (! is_array($current)) {
            $current = (array) $current;
        }

        $path      = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Controllers';
        $current[] = $path;

        // Append to config
        config(['l5-swagger.paths.annotations' => $current]);

        $currentBase = config('l5-swagger.paths.base');
        if ($currentBase) {
            return;
        }

        $defaultLocale = $this->app->getDefaultLocale();
        if ($defaultLocale) {
            config(['l5-swagger.paths.base' => '/' . $defaultLocale]);
        }
    }
}
