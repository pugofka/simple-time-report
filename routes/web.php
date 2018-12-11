<?php


Auth::routes();



Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::get('/', function (){
            return view('admin.index');
        });


    });

//    Route::middleware('role:client')->group(function () {
//        Route::get('/', function (){
//            return view('admin.index');
//        });
//    });

});



Route::get('/home', 'HomeController@index')->name('home');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
