<?php

namespace Modules\Protocolos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Protocolos\Entities\{TipoProtocolo, TipoAcesso, Interessado, Protocolo, Setor};

use DB;

class ProtocolosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title' => 'Lista de Protocolos',
            'protocolos' => Protocolo::paginate(10)
        ];

        return view('protocolos::protocolo.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'url'               => url("protocolos/protocolos"),
            'model'             => '',
            'tipo_protocolo'    => TipoProtocolo::all(),
            'tipo_acesso'       => TipoAcesso::all(),
            'interessado'       => Interessado::all(),
            'setor'             => Setor::all(),
            'title'             => 'Cadastro de Protocolo',
            'button'            => 'Salvar',
        ];
        return view('protocolos::protocolo.form', compact('data'));
    }

    public function list(Request $request, $status) {
        $protocolo = new Protocolo;
       
        $protocolo = $protocolo->paginate(10);
        return view('protocolos::protocolo.table', compact('protocolos', 'status'));
    }

    public function fetch(Request $request){

        $query = $request->get('query'); 
        $data = DB::table('interessado')->where('nome', 'LIKE', '%'.$query.'%')
            ->pluck('nome');

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateProtocolo $request){

        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
   

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('protocolos::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
