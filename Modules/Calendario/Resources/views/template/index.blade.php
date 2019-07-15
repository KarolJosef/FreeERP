<?php

$moduleInfo = [
    'icon' => 'calendar_today',
    'name' => config('calendario.name')
];

$menu = [
    ['icon' => 'today', 'tool' => 'Visão Geral', 'route' => route('calendario.index')],
    ['icon' => 'add_box', 'tool' => 'Criar Agenda', 'route' => route('agendas.criar')]
];

?>

@extends('template')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{Module::asset(config('calendario.id').':css/app.css')}}">
@endsection

@section('js')
    @parent
    <script src="{{Module::asset(config('calendario.id').':js/app.js')}}"></script>
@endsection