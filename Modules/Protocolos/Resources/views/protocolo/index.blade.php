@extends('protocolos::template')

@section('title','Lista de Protocolos')

@section('body')
    <div class="row">
        <div class="col-md-8">
            <form id="form">
                <div class="form-group">
                    <div class="input-group">
                        <input id="search-input" class="form-control" type="text" name="pesquisa" />
                        <i id="search-button" class="btn btn-info material-icons ml-2">search</i>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="text-right">
                <a class="btn btn-success" href="{{ url('protocolos/protocolos/create') }}">
                    <i class="material-icons add_circle_outline" style="vertical-align:middle; font-size:25px; margin-right:5px;">add_circle_outline</i>Novo Protocolo
                </a>
            </div>
        </div>
    </div>
    
    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="ativos-tab" data-toggle="tab" href="#ativos" role="tab" aria-controls="ativos" aria-selected="true">Caixa de entrada</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="meus-protocolos-tab" data-toggle="tab" href="#meus-protocolos" role="tab" aria-controls="meus-protocolos" aria-selected="true">Meus protocolos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="inativos-tab" data-toggle="tab" href="#inativos" role="tab" aria-controls="inativos" aria-selected="false">Inativos</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ativos" role="tabpanel"></div>
        <div class="tab-pane fade" id="meus-protocolos" role="tabpanel"></div>
        <div class="tab-pane fade" id="inativos" role="tabpanel"></div>
    </div>
    
@endsection

@section('script')
    <script>
     search = (url, target) => {
        setLoading(target)
        $.ajax({
            type: "GET",
            url: url,
            data: $("#form").serialize(),
            success: function (data) {
                target.html(data)
            },
            error: function (jqXHR, exception) {
                $("#results").html("<div class='alert alert-danger'>Desculpe, ocorreu um erro. <br> Recarregue a página e tente novamente</div>")
            },
        })
    }
    ativosInativos = (url) => {
        search(`${url}/ativos`, $("#ativos"))
        search(`${url}/inativos`, $("#inativos"))
        search(`${url}/meus-protocolos`, $("#meus-protocolos"))
        $("#ativos").on('click', 'ul.pagination a', function(e){
            e.preventDefault()
            search($(this).attr('href'), $("#ativos"))
        })
        $("#meus-protocolos").on('click', 'ul.pagination a', function(e){
            e.preventDefault()
            search($(this).attr('href'), $("#meus-protocolos"))
        })
        $("#inativos").on('click', 'ul.pagination a', function(e){
            e.preventDefault()
            search($(this).attr('href'), $("#inativos"))
        })
        
    }
    $(document).on("click", "#search-button", function() {
        ativosInativos(`${main_url}/protocolos/protocolos/list`)
    })
    $(document).ready(function(){
        ativosInativos(`${main_url}/protocolos/protocolos/list`)
        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                e.preventDefault()
                ativosInativos(`${main_url}/protocolos/protocolos/list`)
            }
        });
    })
    </script>
@endsection