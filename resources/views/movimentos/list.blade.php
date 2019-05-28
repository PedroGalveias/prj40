@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Movimentos</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th> </th>
                                <th>Matrícula da Aeronave</th>
                                <th>Num licenca piloto</th>
                                <th>Data do Voo</th>
                                <th>Hora descolagem</th>
                                <th>Hora aterragem</th>
                                <th>Tempo do Voo</th>
                                <th>Natureza do Voo</th>
                                <th>Piloto</th>
                                <th>Código do Aeródromo de Partida</th>
                                <th>Código do Aeródromo de Chegada</th>
                                <th>Nº Aterragens</th>
                                <th>Nº Descolagens</th>
                                <th>Nº Diário</th>
                                <th>Nº Serviço</th>
                                <th>Conta-horas Inicial</th>
                                <th>Conta-horas Final</th>
                                <th>Nº pessoas a bordo</th>
                                <th>Tipo de instrução</th>
                                <th>Instrutor</th>
                                <th>Confirmado</th>
                                <th>Observações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($movimentos as $movimento)

                                <tr>
                                    <td>
                                        <a class="btn btn-primary"
                                           href="{{action('MovimentoController@edit',['id'=>$movimento->id])}}">Editar</a>
                                        <form action="{{action('MovimentoController@destroy', ['id'=>$movimento->id])}}"
                                              method="POST" role="form" class="inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>


                                    <td>{{$movimento->aeronave}}</td>
                                    <td>{{$movimento->num_licenca_piloto}}</td>
                                    <td>{{$movimento->data}}</td>
                                    <td>{{$movimento->hora_descolagem}}</td>
                                    <td>{{$movimento->hora_aterragem}}</td>
                                    <td>{{$movimento->tempo_voo}}</td>
                                    <td>{{$movimento->natureza}}</td>
                                    <td>{{$movimento->piloto_id}}</td>
                                    <td>{{$movimento->aerodromo_partida}}</td>
                                    <td>{{$movimento->aerodromo_chegada}}</td>
                                    <td>{{$movimento->num_aterragens}}</td>
                                    <td>{{$movimento->num_descolagens}}</td>
                                    <td>{{$movimento->num_diario}}</td>
                                    <td>{{$movimento->num_servico}}</td>
                                    <td>{{$movimento->conta_horas_inicio}}</td>
                                    <td>{{$movimento->conta_horas_fim}}</td>
                                    <td>{{$movimento->num_pessoas}}</td>
                                    <td>{{$movimento->tipo_instrucao}}</td>
                                    <td>{{$movimento->instrutor_id}}</td>
                                    <td>{{$movimento->confirmado}}</td>
                                    <td>{{$movimento->observacoes}}</td>


                                </tr>
                            @endforeach
                            <div class="row justify-content-center">{{ $movimentos->links() }}   </div>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection