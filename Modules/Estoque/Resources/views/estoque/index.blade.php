@extends('estoque::estoque.estoqueTemplate')
@section('title', 'Estoque')
@section('body')
@if($flag==0)
<table class="table text-center ">

    <thead class="">

    <div class="col-12 text-right mb-4">
    <a class="btn btn-success btn-sm"  href="{{url('/estoque/create')}}">
    <i class="material-icons" style="vertical-align:middle; font-size:25px;">note_add</i>Adicionar
    </a>
    <a class="btn btn-danger btn-sm" href="{{url('/estoque/inativos')}}">
    <i class="material-icons" style="vertical-align:middle; font-size:25px;">delete</i>Inativos
    </a>
    </div>
    
        
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            
            <th scope="col">Categorias</th>
            <th scope="col">Tipo</th>
            <th scope="col">Quantidade</th>
            <th scope='col'>Gerenciar Estoque</th>
            <th scope="col">Editar</th>
            <th scope="col">Excluir</th>
            <th/>
        </tr>
    </thead>
    <tbody>
        @foreach($itens as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->produtos->last()->nome}}</td>
            <td>{{$item->produtos->last()->categoria->nome}}</td>
            <td>{{$item->tipoUnidade->nome}}-({{$item->tipoUnidade->quantidade_itens}} itens)</td>
            <td>{{$item->quantidade}}</td>
            <td>
                <a href="{{url('/estoque/movimentacao/alterar/' . $item->id)}}"><button class="btn btn-primary btn-sm"> <i class="material-icons">list</i></button></a>
            </td>
            <td>
                <a class="btn btn-sm btn-warning" href="{{url('estoque/'.$item->id.'/edit')}}">
                    <i class="material-icons">border_color</i>
                </a>
            </td>
            <td>
                <form method="POST" action="{{url('estoque/'.$item->id )}}">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">

                        <i class="material-icons">delete</i>
                    </button>
                </form>
            </td>
        </tr> @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="100%" class="text-center">
                <p class="text-cetner">
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="100%" class="text-center">
            </td>
        </tr>
    </tfoot>
</table>
@else

<table class="table text-center ">

    <thead class="">

    <div class="col-12 text-right mb-4">
    <a class="btn btn-warning btn-sm" href="{{url('/estoque')}}">
        <i class="material-icons" style="vertical-align:middle; font-size:25px;">keyboard_backspace</i>Voltar</a>
    </div>
        
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            
            <th scope="col">Categorias</th>
            <th scope="col">Tipo</th>
            <th scope="col">Quantidade</th>
            <th scope='col'>Restaurar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($itensInativos as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->produtos->last()->nome}}</td>
            <td>{{$item->produtos->last()->categoria->nome}}</td>
            <td>{{$item->tipoUnidade->nome}}-({{$item->tipoUnidade->quantidade_itens}} itens)</td>
            <td>{{$item->quantidade}}</td>
          
            <td>
            <form method="POST" action="{{url('estoque/'.$item->id . '/restore')}}">
                    @method('put')
                    @csrf
                    <button type="submit" class="btn btn-info"> <i class="material-icons">restore_from_trash</i></button>
                </form>
            </td>
        </tr> 
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="100%" class="text-center">
                <p class="text-cetner">
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="100%" class="text-center">
            </td>
        </tr>
    </tfoot>
</table>
@endif
@endsection