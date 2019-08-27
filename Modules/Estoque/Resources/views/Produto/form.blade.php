@extends('estoque::template')
@section('title', 'Cadastro de Produto')

@section('content')

    
    <div class="container" style="justify-content: center">
    <div class="card">
        <div class="card-header">
        Cadastro
        </div>
        <div class="card-body">
        <form action="{{isset($produto) ?  url('/estoque/produto/' . $produto->id) : url('/estoque/produto')}}" method="POST">
        @csrf
        @if(isset($produto))
            @method('put')
        @endif
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input required type="text" name="nome" class="form-control" value="{{isset($produto) ? $produto->nome : ''}}">
                    {{$errors->first('nome')}}
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="categoria_id">Categoria</label>
                    <select required class="form-control" name="categoria_id">
                        @if(isset($produto))
                            @foreach($categorias as $categoria)
                                @if($categoria->id == $produto->categoria_id)
                                    <option value="{{$categoria->id}}" selected>{{$categoria->nome}}</option>
                                @else
                                    <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                            @endforeach
                        @endif
                    </select>
                    {{$errors->first('categoria_id')}}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="categoria_id">Unidade de Medida</label>
                    <select required class="form-control" name="unidade_id">
                        @if(isset($produto))
                            @foreach($unidades as $unidade)
                                @if($unidade->id == $produto->unidade_id)
                                    <option value="{{$unidade->id}}" selected>{{$unidade->tipo}}</option>
                                @else
                                    <option value="{{$unidade->id}}">{{$unidade->tipo}}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($unidades as $unidade)
                                <option value="{{$unidade->id}}">{{$unidade->tipo}}</option>
                            @endforeach
                        @endif
                    </select>
                    {{$errors->first('categoria_id')}}
                </div>
            </div>
        </div>
            <div class="row" style="align-items: flex-start;">
                <div class="form-group col-5">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" rows="3" required>{{isset($produto) ? $produto->descricao : ''}}</textarea>
                    {{$errors->first('descricao')}}
                </div>
                <div class="col-3">
                <div class="form-group">
                    <label for="preco_venda">Preço de Venda</label>
                    <input type="text" name="preco_venda" placeholder="R$" onkeyUp="moeda(this);" class="form-control" value="{{isset($produto) ? $produto->preco_venda : ''}}" required>
                    {{$errors->first('preco_venda')}}
                </div>
            </div>
            </div>
            <div class="row col-8" style="justify-content: flex-end;">
                <button type="submit" class="btn btn-success">{{isset($produto) ? 'Salvar' : 'Cadastrar'}}</button>
            </div>

        </form>  
        </div>
    </div>
    </div>  

@endsection
<script>
    function moeda(i) {
        var v = i.value.replace(/\D/g,'');
        v = (v/100).toFixed(2) + '';
        v = v.replace(",", ".");
        v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1$2$3.");
        v = v.replace(/(\d)(\d{3}),/g, "$1$2.");
        i.value = v;
    }
    </script>