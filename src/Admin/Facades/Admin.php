<?php

namespace FourCms\Admin\Facades;

class Admin extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'itdc.admin';
    }
}
