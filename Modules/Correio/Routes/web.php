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

Route::prefix('correio')->group(function() {
    Route::get('/', 'CorreioController@index');
   // Route::get('rastrear','CorreioController@rastrear');
   Route::get('verifica','CorreioController@ultimaAtualizacao');
   //Route::put('update/{$id}', 'CorreioController@update');
   Route::get('atualiza','CorreioController@atualizar');
   Route::get('twitter','CorreioController@toTwitter');

    // localhost:8000/correio/rastrear

    Route::resource('correio', 'CorreioController');

});
