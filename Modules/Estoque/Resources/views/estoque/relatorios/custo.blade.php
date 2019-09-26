@extends('estoque::estoque.estoqueTemplate')
@section('title', 'Relatório de Custos')
@section('body')

<table class="table">
                <form method="POST" action="" id="form">
                    @csrf

                    <div class="row">
                        <div class="form-group col-12">
                            <label for="nome">Nome do Produto</label>
                            <input id="search-input" placeholder="Insira o nome do produto" maxlength="45" class="form-control" type="text" name="nome">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="categoria">Categoria</label>
                            <select required class="form-control" name="categoria">
                                <option value="-1" selected>Todas Categorias</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="dataInicial">Data Inicial</label>
                            <input type="date" name="dataInicial" class="form-control" required>
                        </div>
                        <div class="form-group col-3">
                            <label for="dataFinal">Data Final</label>
                            <input type="date" name="dataFinal" class="form-control" required>
                        </div>
                    </div>
                    <div class="row float-right">
                        <div class="form-group col-12">
                            <button type="submit" name="btn" class="btn btn-sm btn-secondary" style="font-size:18px;"><i class="btn btn-sm btn-secondary material-icons" style="font-size:18px;" id="search-button">search</i></button>
                        </div>
                    </div>
                        
                    </div>
                </form>

<div class="row mt-5 mb-5">
    <div class="col-6">
        <canvas id="myChart"></canvas>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var teste = ['teste', '2', '3'];
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: teste,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>

@endsection