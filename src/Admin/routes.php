<?php

Route::group(['middleware' => 'admin.api', 'namespace' => '\FourCms\Admin\Controllers\Api'], function () {

    Route::group(['prefix' => 'api'], function () {
        Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
            // Authentication routes...
            Route::post('login', 'AuthController@postLogin');
            Route::get('login', 'AuthController@postLogin');
            Route::get('logout', 'AuthController@getLogout');
            Route::get('user', 'AuthController@getUser');
            Route::get('avatar', 'AuthController@getAvatar');
        });

        Route::group(['middleware' => 'admin.auth'], function () {
            // Dashboard
            Route::get('dashboard', 'DashboardController@index');

            Route::get('user/statuses', 'UserController@getStatuses');
            Route::put('user/{id}/restore', 'UserController@putRestore');
            Route::put('user/{id}/status', 'UserController@putStatus');
            Route::get('user/loginas/{id}', 'UserController@loginAs');
            Route::get('user/logoutas', 'UserController@logoutAs');
            Route::resource('user', 'UserController', ['except' => ['create']]);

            Route::resource('role', 'RoleController', ['except' => ['create']]);

            Route::get('text', 'TextController@index');
            Route::put('text', 'TextController@update');
            Route::post('text/autosave', 'TextController@autosave');
        });

        Route::get('text/translations', 'TextController@getTranslations');

        Route::get('{all?}', 'HomeController@error404')->where('all', '.*');
    });

    Route::group([], function () {
        // test page
        Route::get('test', 'HomeController@test');

        // Application entry point
        Route::get('{all?}', 'HomeController@index')->where('all', '.*');
    });
});
