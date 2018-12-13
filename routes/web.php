<?php


Auth::routes();

Route::any('user/{id}/update', [ 'as' => 'user.update', 'uses' => 'UserController@update']);
Route::any('user/create', [ 'as' => 'user.create', 'uses' => 'UserController@create']);
Route::any('user/store', [ 'as' => 'user.store', 'uses' => 'UserController@store']);
Route::any('user/{id}/destroy', [ 'as' => 'user.destroy', 'uses' => 'UserController@destroy']);
Route::any('users/', [ 'as' => 'users.index', 'uses' => 'UserController@index']);

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::get('/', 'UserController@index');
        Route::get('/users/create/', 'UserController@create');
        Route::get('/users/{user}/', 'UserController@edit');
    });

    Route::get('/users', 'UserController@index');


    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
});





