<?php

namespace Modules\Calendario\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Calendario\Entities\Agenda;

class CalendarioController extends Controller
{
    public function index()
    {
        //TODO Get agendas do funcinário logado
        $agendas = Agenda::where('funcionario_id', 1)->orderBy('titulo')->get();
        return view('calendario::index', ['agendas' => $agendas]);
    }

    public function agendas()
    {
        $agendas = Agenda::withTrashed('funcionario_id', 1)->orderByRaw('deleted_at DESC, created_at DESC')->get();
        $lixeira = Agenda::onlyTrashed()->where('funcionario_id', 1)->count();
        return view('calendario::agendas.index', ['agendas' => $agendas, 'lixeira' => $lixeira]);
    }

    public function compartilhamentos(){
        $agendas = Agenda::all();
        $solicitacoes['pendentes'] = [];
        $solicitacoes['aprovadas'] = [];
        foreach ($agendas as $agenda){
            foreach ($agenda->compartilhamentos as $compartilhamento){
                if(!$compartilhamento->aprovacao){
                    array_push($solicitacoes['pendentes'], $compartilhamento);
                }
                else{
                    array_push($solicitacoes['aprovadas'], $compartilhamento);
                }
            }
        }
        return view('calendario::agendas.compartilhamentos', ['solicitacoes' => $solicitacoes]);
    }

    public function convites(){
        return redirect()->back();
    }

    public function eventos()
    {
        $eventos = [];
        $agendas = Agenda::where('funcionario_id', 1)->get();
        foreach ($agendas as $agenda) {
            $eventos = array_merge($eventos, $agenda->eventos_json);
        }
        return $eventos;
    }
}
