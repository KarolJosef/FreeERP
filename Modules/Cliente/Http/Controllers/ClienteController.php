<?php

namespace Modules\Cliente\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Entities\{Telefone, Endereco, Email, Documento, TipoTelefone, Estado};
use Modules\Cliente\Entities\{Cliente, TipoCliente};
use Modules\Cliente\Http\Requests\CreateClienteRequest;
use DB;

class ClienteController extends Controller
{
    
    public function index(Request $request) {
        if($request->busca){
            $clientes = Cliente::where('nome', 'LIKE', '%'.$request->busca.'%')->paginate(10);
            $clientesDeletados = Cliente::onlyTrashed()->where('nome', 'LIKE', '%'.$request->busca.'%')->paginate(10);
        }else {
            $clientes = Cliente::paginate(10);
            $clientesDeletados = Cliente::onlyTrashed()->paginate(10);
        }

        return view('cliente::cliente.index', compact('clientes','clientesDeletados'));
        
    }

    
    public function create() {
        $tipo_cliente = TipoCliente::all();
        $tipo_telefone = TipoTelefone::all();
        $estados = Estado::all();
        return view('cliente::cliente.form', compact('tipo_cliente', 'tipo_telefone', 'estados'));
    }


    public function store(CreateClienteRequest $request) {
        DB::beginTransaction();
        try {
            $dados = $request->all();

            $dados['documento']['documento'] = preg_replace('/\D/', '', $dados['documento']['documento']);

            $endereco = Endereco::create($dados['endereco']);

            $email = Email::create($dados['email']);

            $tipo_documento_id = $dados['cliente']['tipo_cliente_id'] == 1 ? 1 : 6;
            $documento = Documento::create([
                'numero' =>$dados['documento']['documento'],
                'tipo_documento_id' =>  $tipo_documento_id 
            ]);
              
            $cliente = Cliente::create([
                'nome_fantasia' => $dados['cliente']['tipo_cliente_id'] == 2 ? $dados['cliente']['nome_fantasia'] : null, 
                'nome' => $dados['cliente']['nome'],
                'tipo_cliente_id' => $dados['cliente']['tipo_cliente_id'],
                'documento_id' => $documento->id,
                'endereco_id' => $endereco->id,
                'email_id' => $email->id
            ]);

            $telefones = $dados['telefones'];            
            foreach($telefones as $telefone){
                $telefone['numero'] = preg_replace('/\D/', '', $telefone['numero']);
                $tel = Telefone::create($telefone);
                $cliente->telefones()->attach($tel);
            }
            
            DB::commit();
            return redirect('/cliente')->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Exception $e){
            DB::rollback();
            return back()->with('error', 'Ops! Ocorreu um erro.');
        }
        

        
    }

    // public function show($id)
    // {
    //     return view('cliente::show');
    // }

    public function edit($id)
    {
        return 'view do editar';
    }

    public function update(CreateClienteRequest $request, $id){
            $dados = $request->all();

      
            $cliente = Cliente::findOrFail($id);

            $dados['documento']['documento'] = preg_replace('/\D/', '', $dados['documento']['documento']);      

            $tipo_documento_id = $dados['cliente']['tipo_cliente_id'] == 1 ? 1 : 6;
            
            $cliente->endereco->update($dados['endereco']);

            $cliente->email->update($dados['email']);

            $cliente->documento->update([
                'numero' =>$dados['documento']['documento'],
                'tipo_documento_id' =>  $tipo_documento_id 
            ]);
            $cliente->update([
                'nome' => $dados['cliente']['nome'],
                'nome_fantasia' => $dados['cliente']['tipo_cliente_id'] == 2 ? $dados['cliente']['nome_fantasia'] : null, 
                'tipo_cliente_id' => $dados['cliente']['tipo_cliente_id']
            ]);

            $naoExcluir = [];
            foreach($dados['telefones'] as $i => $telefone){
                $telefone['numero'] = preg_replace('/\D/', '', $telefone['numero']);
                if (isset($telefone['id'])){                  
                    $tel = Telefone::findOrFail($telefone['id']);                   
                    $tel->update($telefone);
                    
                }else{
                    $tel = Telefone::create($telefone);                    
                    $cliente->telefones()->attach($tel);
                }
                $naoExcluir[] = $tel->id;
            }

            $cliente->telefones()->whereNotIn('id', $naoExcluir)->delete();
                       
            return redirect('/cliente/cliente')->with('success', 'Cliente cadastrado com sucesso!');
       
    }

    public function destroy($id) {
        $cliente = Cliente::withTrashed()->findOrFail($id);
        if($cliente->trashed()){
            $cliente->restore();
            return back()->with('success','Cliente restaurado com sucesso!');
        } else {
            $cliente->delete();
            return back()->with('success','Cliente deletado com sucesso!');
        }
    }
}