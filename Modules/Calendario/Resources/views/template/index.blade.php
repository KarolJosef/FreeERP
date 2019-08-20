<?php

$moduleInfo = [
    'icon' => 'today',
    'name' => config('calendario.name')
];

$menu = [
    ['icon' => 'calendar_view_day', 'tool' => 'Visão Geral', 'route' => route('calendario.index')],
    ['icon' => 'calendar_today', 'tool' => 'Agendas', 'route' => route('agendas.index')]
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{Module::asset(config('calendario.id').':css/app.css')}}">
    <style type="text/css">
        #sidebar a.active {
            background-color: #f3f6f7;
            color: #5f6368;
        }
        .trashed {
            background-color: #f9d6d5 !important;
            display: none;
        }

        .controles {
            margin-bottom: 10px;
            color: #ffffff;
        }

        .acoes button {
            float: right;
            margin-left: 5px;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{Module::asset(config('calendario.id').':bootbox.all.min.js')}}"></script>
    <script src="{{Module::asset(config('calendario.id').':js/app.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $.when(
                $('#sidebar a.nav-link span').each(function () {
                    switch ($(this).text().trim()) {
                        case 'Visão Geral':
                            $(this).parent('a').addClass('visao-geral');
                            break;
                        case 'Agendas':
                            $(this).parent('a').addClass('agendas');
                            break;
                    }
                }))
                .done(function () {
                    switch ('{{ \Illuminate\Support\Facades\Route::currentRouteName() }}'.trim()) {
                        case 'calendario.index':
                            $('.visao-geral').addClass('active');
                            break;
                        case 'agendas.index':
                        case 'agendas.editar':
                        case 'agendas.eventos.index':
                            $('.agendas').addClass('active');
                            break;
                    }
                });
        });
    </script>
@endsection
