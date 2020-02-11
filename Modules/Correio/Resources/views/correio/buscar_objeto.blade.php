@extends('template')
@section('content')
        <!--@if($data['model'])
            @method('PUT')
        @endif-->

           
        <div class="form-group">            
            <label for="nome_produto" class="control-label">Digite aqui o código do objeto a ser rastreado</label>

            <form id="form">  
                         	     
              <input  type="text" name="codigo" class="form-control"  onblur="javascript: this.value=this.value.toUpperCase();"id="codigo" placeholder="Código Ex: PE123456789BR" pattern="^[A-Z]{2}[1-9]{9}[A-Z]{2}|([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$"  required><br>		

              <input type="hidden" name="linhas" value="{{$linhas}}">
           
              <div class="form-group">
        	      <button type="submit" id="rastrear" class="btn btn-success"> {{ $data['button'] }} 
                </button> 
              </div>
            </form>
        </div>

          @if($aux1)
           <a  target="_blank" href="{{$link}}"> A consulta por CPF ou CNPJ deve ser realizada diretamentre nos sites dos Correio clique aqui para ser redirecionado. </a>


          @endif

          @if($aux && !$aux1)

            
             
             <strong><h4 class="mt-3 mb-3">Histórico do objeto: {{$data['codigo']}}</h4></strong>
              <a href="" data-toggle="modal" data-target="#myModalcad">Salvar esse objeto para futuras consultas</a>

              <div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h8 class="modal-title">Objeto:{{$data['codigo']}}</h8>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><spanv aria-hidden="true">X</span></button>
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

                                        <input type="hidden" name="ultimaAtualizacao" value="{{$lastUpdate[0]}}  {{$lastUpdate[1]}}">                 
                                </div>                                        
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Descrição:</label>
                                    <textarea name="descricao" class="form-control"></textarea>
                                </div>
                                <div style="text-align:right;"class="checkbox">                                                       
                                    <label>Notificar mudanças:<br>Email
                                     <input name="isToNotify" type="checkbox" value="1"></label>
                                    


                                    <label>Twitter
                                      <input name="isToNotifyTw" type="checkbox" value="1">
                                    </label>               
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

                  

                  @foreach($dadosCorreio as $tr)
                    <tr>
                        <td>{{$tr[0]}}</td>                      
                        <td>{{$tr[1]}}</td>
                    </tr>
                  @endforeach
                  
                </tbody>  
             </table>                        
            
             
            

        </div>
        @elseif(!$aux1)
     <div  class="alert alert-danger" role="alert" id="p" type="">
                Objeto: {{$data['codigo']}} não encontrado
                </div> 
        @endif  
       
                        

        
@endsection

@section('js') 

<!--
<script type="text/javascript">
    $('#p').hide();
  $(document).load(function(){
    
    $('#form').on('submit', (e) => {
      if ($.trim($('#result').is(':empty'))) {  
      $('#p').show();
      }   

    })
  });

</script>-->
@endsection 

