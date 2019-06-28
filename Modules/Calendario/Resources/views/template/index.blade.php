<?php

$moduleInfo = [
    'icon' => 'today',
    'name' => config('calendario.name')
];

$menu = [
    ['icon' => 'add_box', 'tool' => 'Criar Agenda', 'route' => route('agendas.criar')],
];

?>

@extends('template')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{Module::asset(config('calendario.id').':css/app.css')}}">
@endsection

@section('js')
    <script src="{{Module::asset(config('calendario.id').':js/app.js')}}"></script>
@endsection