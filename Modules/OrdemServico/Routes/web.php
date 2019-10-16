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

//Módulo de Ordem de servico
Route::prefix('ordemservico')->name('modulo.')->group(function() {
	Route::get('pdf/{id}', 'OrdemServicoController@pdf')->name('os.pdf');
	Route::get('cidades/showJson/{idEstado}','CidadeController@showJson');	
	Route::get('status/create','StatusController@create');
	Route::post('status/store','StatusController@store');
	Route::get('os/{id}/editStatus','OrdemServicoController@editStatus')->name('os.edit.status');
	Route::post('os/{id}/updateStatus','OrdemServicoController@updateStatus')->name('os.update.status');
	
	Route::get('painel/{id}/ordensDisponiveis','PainelTecnicoController@ordensDisponiveis')->name('tecnico.painel.ordens_disponiveis');
	Route::get('painel/{id}', 'PainelTecnicoController@index')->name('tecnico.painel.index');
	Route::get('painel/{id}/minhasOs', 'PainelTecnicoController@ordensAtivas')->name('tecnico.painel.minhasOs');
	Route::get('painel/{id}/{idOs}/pegarResponsabilidade', 'PainelTecnicoController@pegarResponsabilidade')->name('tecnico.painel.pegarResponsabilidade');

	Route::resource('os', 'OrdemServicoController');
	Route::resource('tecnico', 'TecnicoController');
	Route::resource('solicitante', 'SolicitanteController');

	
});
