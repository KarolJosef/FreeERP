@extends('ordemservico::layouts.form')

@section('formulario')
@if(isset($data['model']))
{{ Form::model($data['model'], array('route' => array('modulo.gerente.update', $data['model']->id), 'method' => 'put')) }}
@endif

<div class="form-group">
    <div class="form-row">
        {{Form::label('Nome')}}
        {{Form::text('nome',$value=null,array('class' => 'form-control','placeholder'=>'Nome'))}}
    </div>
</div>
@endsection