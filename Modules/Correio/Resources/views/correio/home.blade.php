@extends('template')
@section('content')
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="ativos" role="tabpanel" aria-labelledby="ativos-tab">
  <div class="res">{{$data['title']}}</div>  
 
  <div class="result" id="content">
   
    
    
  	<table class="table table-striped" id="tab">    
		  <thead> 
		    <tr>

			   	<th class="align-middle text-center">Objetos Rastreados</th>
          <th class="align-middle text-center">Descrição</th>
          <th class="align-middle text-center">Ultima Atualização</th>
          <th class="align-middle text-center"><img 
        src="GMail_icon-icons.com_76886.png"
      /></th>
          <th class="align-middle text-center"><img 
        src="twitter.png"
      /> </th>
          <th></th>

        </tr>              
      </thead>               
      @foreach($correio as $c)
        <tr>
          <td style="text-align:center">
            <form class="group-form" action="rastrear">
              <a href="correio/correio/create?codigo={{$c->objeto}}">{{$c->objeto}}</a>
            </form> 
          </td>
             
          <td style="text-align:center">{{$c->descricao}}</td>
          <td style="text-align:center"> {{$c->ultimaAtualizacao}}</td>
          <td>
            <div style="text-align:center">               
                
              <form id="check-form" class="group-form" action="store">                  
                  @if($c->isToNotify)
                    <input class="notification" type="checkbox" name="isToNotify" value="1" checked disabled="" >
                  @else
                    <input class="notification" type="checkbox" name="isToNotify" value="1" disabled="" >
                  @endif    
              </form>
            </div>
          </td>
           <td>
            <div style="text-align:center">               
                
              <form id="check-form" class="group-form" action="store">                  
                  @if($c->isToNotifyTw)
                    <input class="notification" type="checkbox" name="isToNotifyTw" value="1" checked disabled="" >
                  @else
                    <input class="notification" type="checkbox" name="isToNotifyTw" value="1" disabled="" >
                  @endif    
              </form>
            </div>
          </td>
          <td style="text-align:left;">
            <form class="group-form" action="{{url('correio/correio',[$c->id])}}" method="POST">
              {{method_field('DELETE')}}
              {{ csrf_field() }}
              <input type="submit" class="btn btn-danger" value="Deletar"/>
            </form>
          </td>
          <td>
            
             <button data-toggle="modal" data-target="#modal{{$c->id}}" class="btn btn-info" href='{{ url("correio/create/{$c->id}/edit") }}'>Editar</button>

          </td>  

        </tr>  

<!-------------------------------Inicio do Modal----------------------------------------------------->      

              <div class="modal fade" id="modal{{$c->id}}" tabindex="-1" role="dialog" aria-labelledby="exemplo">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h8 class="modal-title">Objeto:{{$c->objeto}}</h8>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel"></h4>

                        </div>
                        <div class="modal-body">
                            <form  action="{{url('correio/correio',$c->id)}}" method="PUT"   >
                                 {{ csrf_field() }}
                                @if($data['model'])
                                  @method('PUT')
                                @endif
                                <div class="form-group">
                                        <input type="hidden" name="id" value="{{$c->id}}" >             </div>                                        
                                <div class="form-group">
                                    <label for="message-text" class="control-label" >Descrição:</label>
                                    <textarea name="descricao" class="form-control">{{$c->descricao}}</textarea>
                                </div>
                                
                                <div style="text-align:right;"class="checkbox">                             
                                    <label>Notificar mudanças por:<br>Email @if($c->isToNotify)</label>
                                   <input class="notification" type="checkbox" name="isToNotify" value="1" checked >

                                    <label>Twitter
                                      <input class="notification"name="isToNotifyTw" type="checkbox" value="1" checked>
                                    </label>     
                                @else
                                    <input class="notification" type="checkbox" name="isToNotify" value="1" >

                                     <input class="notification"name="isToNotifyTw" type="checkbox" value="1">                                
                                @endif 
                                                   
                                </div>    
                                                   
                                <div class="modal-footer">
                                    <button type="submit" id="update" class="btn btn-success">Salvar</button>
                                </div>


                            </form>

                      </div>

                    </div>

                </div>

              </div>


         @endforeach

		</table>     
                     
  <a class="btn btn-success" href="{{ url('correio/correio/create') }}">Rastrear Novo Objeto</a>   


  </div> 
    
     
  </div>  


</div>

@endsection





