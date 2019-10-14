@extends('assistencia::layouts.master')


@section('content')
<div class="card text-center">
    <div class="card-header">
        <h3>Cadastrar Serviço</h3>
    </div>
    <div class="card-body">
        <div class="row ">
            <div class="col-md-11 text-left">
                <a href="{{url('/assistencia')}}"><i class="material-icons mr-2">home</i></button></a>
                <a href="{{route('servicos.localizar')}}"><i class="material-icons mr-2">arrow_back</i></button></a>
            </div>
        </div>
        <div class="row justify-content-center">
            <form class="col-md-4" action="{{route('servicos.salvar')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('assistencia::paginas.estoque._form_serv')
                <button class="btn btn-success">Cadastrar serviço padrão</button>
            </form>
        </div>
    </div>
</div>

@stop
@section('js')
<script>
$(document).ready(function() {
    $('#money2').inputmask('decimal', {
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 2,
                'radixPoint': ",",
                'digitsOptional': false,
                'allowMinus': false,
                'prefix': 'R$ ',
                'placeholder': '',
                'rightAlign':false,
                // 'removeMaskOnSubmit':true
    });
})
</script>
@stop