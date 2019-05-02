<?php

namespace Modules\Assistencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Assistencia\Entities\{ConsertoAssistenciaModel, PecaAssistenciaModel, ServicoAssistenciaModel, ClienteAssistenciaModel};
use DB;

class ConsertoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function index()
     {

       return view('assistencia::paginas.conserto');
     }
     public function retirarPeca()
     {

     }
     public function cadastrar(){
       $busca = ' ';

       $pecas = PecaAssistenciaModel::busca($busca);
       $servicos = ServicoAssistenciaModel::busca($busca);
       $ordens = ConsertoAssistenciaModel::all();
       if ($ordens == null):
         /*ATENÇÃO, TALVEZ ESTE IF NÃO SEJA NECESSARIO, APÓS FINALIZAR O FORM, TESTAR SEM A PARTE DE CIMA*/
         $id = 1;
         return view('assistencia::paginas.consertos.cadastrarconserto');
       else:

         $id = ConsertoAssistenciaModel::max();
         $id = $id + 1;
         return view('assistencia::paginas.consertos.cadastrarconserto',compact('id','pecas','servicos'));
      endif;

     }
     public function buscarPeca(Request $req)
     {
       $pecas = PecaAssistenciaModel::busca($req->busca);

       return view('assistencia::paginas.consertos.cadastrarconserto',compact('id','pecas','servicos'));

     }
     public function buscarServico(Request $req)
     {
       $servicos = PecaAssistenciaModel::busca($req->busca);

       return view('assistencia::paginas.consertos.cadastrarconserto',compact('id','pecas','servicos'));

     }

     public function nomeClientes(Request $req){
       return ClienteAssistenciaModel::where('nome','LIKE', "%".$req->input('nome')."%")->select(DB::raw("CONCAT(nome,'|',cpf) AS nomecpf"))->get()->pluck('nomecpf');
     }

     public function dadosCliente(Request $req){
       [$nome, $cpf] = explode('|',$req->input('nome'));
       return ClienteAssistenciaModel::where('nome',$nome)->where('cpf',$cpf)->select('id','nome','email','cpf','celnumero')->first();
     }

}
