<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('webservices')->group(function() {
    Route::get('/', 'WebservicesController@index');


    Route::resource('webServices', 'WebservicesController');
});
