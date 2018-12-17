<?php

Auth::routes();


Route::get('reports/all', [ 'as' => 'reports.all', 'uses' => 'ReportController@all']);

Route::middleware('auth')->group(function () {

    Route::get('/', 'HomeController@index');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', 'UserController');
        Route::resource('statistics', 'StatisticsController');
    });

    Route::middleware('role:user')->group(function () {
        Route::resource('reports', 'ReportController');
    });

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

});





