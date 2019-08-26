<?php

namespace Modules\Cliente\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Entities\{Telefone, Endereco, Email, Documento};
use Modules\Cliente\Entities\{Cliente};
use Modules\Cliente\Http\Requests\CreateClienteRequest;
use DB;

class ClienteController extends Controller
{
    
    public function index()
    {
        return view('cliente::index');
    }

    
    public function create()
    {
        return view('cliente::create');
    }

    
    public function store(CreateClienteRequest $request) {
        DB::beginTransaction();
        try {

            $dados = $request->all();
            
            $endereco = Endereco::create($dados['endereco']);
            $email = Email::create(['email' => $dados['email']]);

            $tipo_documento_id = $dados['tipo_cliente_id'] == 1 ? 1 : 6;
            $documento = Documento::create([
                'numero' =>$dados['documento'],
                'tipo_documento_id' =>  $tipo_documento_id 
            ]);
              
            $cliente = Cliente::create([
                'nome' => $dados['nome'],
                'tipo_cliente_id' => $dados['tipo_cliente_id'],
                'documento_id' => $documento->id,
                'endereco_id' => $endereco->id,
                'email_id' => $email->id
            ]);

            $telefones = $dados['telefones'];
            foreach($telefones as $telefone){
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

    public function show($id)
    {
        return view('cliente::show');
    }

    public function edit($id)
    {
        return view('cliente::edit');
    }

    public function update(CreateClienteRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $dados = $request->all();
            $cliente = Cliente::findOrFail($id);
            $email = Email::findOrFail($cliente['email_id']);
            $endereco = Email::findOrFail($cliente['endereco_id']);
            $documento = Email::findOrFail($cliente['documento_id']);
            

            $endereco->update($dados['endereco']);
            $email->update(['email' => $dados['email']]);
            $tipo_documento_id = $dados['tipo_cliente_id'] == 1 ? 1 : 6;
            $documento->update([
                'numero' =>$dados['documento'],
                'tipo_documento_id' =>  $tipo_documento_id 
            ]);
            $cliente->update([
                'nome' => $dados['nome'],
                'tipo_cliente_id' => $dados['tipo_cliente_id'],
                'documento_id' => $documento->id,
                'endereco_id' => $endereco->id,
                'email_id' => $email->id
            ]);

            $telefones = $dados['telefones'];
            foreach($telefones as $telefone){
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

    public function destroy($id)
    {
        //
    }
}