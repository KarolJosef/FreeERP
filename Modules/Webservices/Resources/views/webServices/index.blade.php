@extends('template')

@section('content')
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="ativos" role="tabpanel" aria-labelledby="ativos-tab">
  	<table class="table table-striped">	
		<thead>
			<tr>
				<th>Objeto</th>
				<th>Emails Notificados</th>
			</tr>
		</thead>
   @foreach($data['web_service'] as $ws)
   		<tr>
   			<td>{{$ws->codigo}}</td><br>
   			
   		</tr>
   @endforeach		
	</table>	   
  </div>
</div>

@endsection