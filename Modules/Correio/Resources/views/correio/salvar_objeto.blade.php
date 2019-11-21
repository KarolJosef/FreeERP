@extends('template')
@section('content')
<table class="table table-striped"> 
      <thead>      
        <tr>
          <th>Objetos Rastreados</th>
          <th>Descrição</th>
          <th>Receber notificações por email</th>
        </tr>
      </thead>  
      <tr>       
         
          <td><div class="checkbox">
               <label><input type="checkbox" value=""></label>
              </div>
          </td>

@endsection         





@section('js')
    <script>
        $(document).ready(function(){
            $("#adicionar").on("click", function(){

         }
      }      
    </script>          



@endsection
