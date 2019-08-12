@extends('ordemservico::layouts.informacoes')
@section('content')
<div class="card " style="margin:auto; max-width: 40rem;">
  <div class="card-header bg-dark text-white">ID : </div>
  <div class="card-body">
    <p class="card-text">Solicitante : {{ $data['model']->solicitante}}</p>

    <a href="{{ url('ordemservico/os') }}" class="btn btn-primary">Voltar</a>
  </div>
</div>
@endsection