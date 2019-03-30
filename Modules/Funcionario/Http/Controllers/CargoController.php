<?php
namespace Modules\Funcionario\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Funcionario\Entities\{Cargo};
use DB;

class CargoController extends Controller{

    public function index(Request $request){
        $data = [
			'cargos'	=> Cargo::all(),
			'title'		=> "Lista de cargos",
		]; 

	    return view('funcionario::cargo.index', compact('data'));
    }
    
	public function create(Request $request){
		$data = [
			"url" 	 	=> url('funcionario/cargo'),
			"button" 	=> "Salvar",
			"model"		=> null,
			'title'		=> "Cadastrar cargo"
		];

		$moduleInfo = [
            'icon' => 'android',
            'name' => 'Vendas',
        ];

        $menu = [
            ['icon' => 'add_box', 'tool' => 'Cadastrar', 'route' => '/'],
            ['icon' => 'search', 'tool' => 'Buscar', 'route' => '#'],
            ['icon' => 'edit', 'tool' => 'Editar', 'route' => '#'],
            ['icon' => 'delete', 'tool' => 'Remover', 'route' => '#'],
		];
		
	    return view('funcionario::cargo.form', compact('data', 'moduleInfo', 'menu'));
	}

	public function store(Request $request){
		DB::beginTransaction();
		try{
			$cargo = Cargo::Create($request->all());
			DB::commit();
			return redirect('/cargo');
		}catch(Exception $e){
			DB::rollback();
			return back();
		}
    }
    
	public function edit(Request $request, $id){
		$data = [
			"url" 	 	=> url("funcionario/cargo/$id"),
			"button" 	=> "Atualizar",
			"model"		=> Cargo::findOrFail($id),
			'title'		=> "Atualizar cargo"
		];
	    return view('funcionario::cargo.form', compact('data'));
	}
	
	public function update(Request $request, $id) {
		DB::beginTransaction();
		try{
			$cargo = Cargo::findOrFail($id);
			$cargo->update($request->all());
			DB::commit();
			return redirect('funcionario/cargo');
		}catch(Exception $e){
			DB::rollback();
			return back();
		}
    }
    
	public function show(Request $request, $id){
		$cargo = Cargo::findOrFail($id);
	    return view('funcionario::cargo.show', [
            'model' => $cargo	    
        ]);
    }
    
	public function destroy(Request $request, $id) {
		$cargo = Cargo::findOrFail($id);
		$cargo->delete();
		return back();    
	}
	
}