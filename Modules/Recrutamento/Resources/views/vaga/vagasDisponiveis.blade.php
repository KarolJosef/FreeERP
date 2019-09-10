@extends('template')
@section('content')
    
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ativos" role="tabpanel" aria-labelledby="ativos-tab">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cargo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data['vaga'] as $vaga)
                    <tr>
                        <td>{{$vaga->id}}</td>
                        <td>{{$vaga->cargo}}</td>
                        <td>
                            <a class="btn btn-info" href='{{ url("recrutamento/vaga/".$vaga->id) }}'>Visualizar Vaga</a> 
                            <a class="btn btn-info" href='{{ url("recrutamento/candidato/create") }}'>Candidatar-se</a> 
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection