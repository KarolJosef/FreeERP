<?php

namespace Modules\Assistencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Assistencia\Entities\ClienteAssistenciaModel;
use Modules\Assistencia\Http\Requests\StoreClienteRequest;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index()
    {

      return view('assistencia::paginas.clientes');
    }

    public function cadastrar()
    {

      return view('assistencia::paginas.clientes.cadastroCliente');
    }

    public function localizar()
    {
      $clientes = ClienteAssistenciaModel::all();


      return view('assistencia::paginas.clientes.localizarCliente',compact('clientes'));
    }

    public function salvar(StoreClienteRequest $req){
      $dados  = $req->all();
      ClienteAssistenciaModel::create($dados);
      return redirect()->route('cliente.localizar')->with('success','Cliente cadastrado com sucesso!');
    }

    public function editar($id)
    {
      $cliente = ClienteAssistenciaModel::find($id);


      return view('assistencia::paginas.clientes.editarCliente',compact('cliente'));
    }

    public function atualizar(Request $req, $id)
    {
      $dados  = $req->all();
      ClienteAssistenciaModel::find($id)->update($dados);
      return redirect()->route('cliente.localizar');
    }

    public function deletar($id)
    {
      ClienteAssistenciaModel::find($id)->delete();
      return redirect()->route('cliente.localizar');
    }

    public function buscar(Request $req)
    {
      $clientes = ClienteAssistenciaModel::busca($req->busca);


      return view('assistencia::paginas.clientes.localizarCliente',compact('clientes'));

    }


}