@extends('template')
@section('content')
        <!--@if($data['model'])
            @method('PUT')
        @endif-->
               
        <div class="form-group">            
            <label for="nome_produto" class="control-label">Digite aqui o código do objeto a ser rastreado</label>

            <form id="form">        	     
                <input  type="text" name="codigo" class="form-control" size="13" onblur="javascript: this.value=this.value.toUpperCase();"id="codigo"	placeholder="Código Ex: PE123456789BR"><br>			
           
            <div class="form-group">
        	   <button type="submit" id="rastrear" class="btn btn-success"> {{ $data['button'] }} </button> 
            </div>
            </form>
        </div>

            

        <div class="result">
            @if($data['dadosCorreio'])
             <strong><h4 class="mt-3 mb-3">Histórico do objeto: {{$data['codigo']}}</h4></strong>
              <a href="" data-toggle="modal" data-target="#myModalcad">Salvar esse objeto para futuras consultas</a>

              <div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h8 class="modal-title">Objeto:{{$data['codigo']}}</h8>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel"></h4>
                        </div>
                        <div class="modal-body">
                            <form  action="{{url('correio/correio')}}" method="POST"  >
                                 {{ csrf_field() }}
                                @if($data['model'])
                                  @method('PUT')
                                @endif
                                <div class="form-group">
                                        <input type="hidden" name="objeto" value="{{$data['codigo']}}" >
                                </div>                                        
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Descrição:</label>
                                    <textarea name="descricao" class="form-control"></textarea>
                                </div>
                                <div style="text-align:right;"class="checkbox">                                                       
                                    <label>Notificar mudanças por email <input name="isToNotify" type="checkbox" value="1"></label>               
                                </div>    
                                                   
                                <div class="modal-footer">
                                    <button type="submit" id="store" class="btn btn-success">Salvar</button>
                                </div>
                            </form> 
                      </div>  
                    </div>
                </div>
            </div>


            
             <table class="table table-striped">
                <thead>
                    <tr>                       
                    </tr>
                </thead>
                <tbody>

                  @foreach($data['dadosCorreio'] as $tr)
                    <tr>
                        <td>{{$tr[0]}}</td>                        
                        <td>{{$tr[1]}}</td>
                    </tr>
                  @endforeach
                </tbody>  
             </table>  
            
                    
            @endif
            



        </div>

@endsection
