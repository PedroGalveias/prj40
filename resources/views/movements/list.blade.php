@extends('layouts.app')

@section('content')
    <div class="container-fluid" id='bg-light-grey'>
        <h4>Filtrar Utilizador</h4>
        <form action="{{route('movimentos.index')}}" method="get" class="form-inline">
            <div class="form-group">
                <label class="mr-sm-2" for="inputNumMovimento">Nº de Movimento</label>
                <input type="text" name="id" id="inputNumMovimento" placeholder=" Escrever Nº Movimento"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('id') }}">
                </select>
            </div>
            <div class="form-group">
                <label for="inputAeronave" class="mr-sm-2">Aeronave</label>
                <input type="text" name="aeronave" id="inputAeronave" placeholder=" Escrever Matrícula da Aeronave"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('aeronave') }}">
            </div>
            <div class="form-group">
                <label for="inputPiloto_id" class="mr-sm-2">Piloto</label>
                <input type="text" name="piloto_id" id="inputPiloto_id" placeholder=" Enter ID Piloto"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('piloto_id') }}">
            </div>
            <div class="form-group">
                <label for="inputInstrutor_id" class="mr-sm-2">Instrutor</label>
                <input type="text" name="instrutor_id" id="inputInstrutor_id" placeholder=" Enter ID Instrutor"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('instrutor_id') }}">
            </div>
            <!-- DATA -->
            <div class="form-group">
                <label for="inputDataInicio" class="mr-sm-2">Data Inicio</label>
                <input type="date" name="dataInicio" id="data" placeholder=" Enter Data Inicio"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('data') }}">
            </div>
            <div class="form-group">
                <label for="inputDataFinal" class="mr-sm-2">Data Final</label>
                <input type="date" name="dataFinal" id="data" placeholder=" Enter Data Final"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('data') }}">
            </div>
            <div class="form-group">
                <label for="selectType" class="mr-sm-2">Natureza</label>
                <select name="natureza" id="selectNatureza" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                    <option disabled selected>Escolhe Natureza do Voo</option>
                    <option value="T">Treino</option>
                    <option value="I">Instrução</option>
                    <option value="E">Especial</option>
                </select>
            </div>
            <div class="form-group">
                <label for="selectConfirmado" class="mr-sm-2">Confirmado</label>
                <select name="confirmado" id="selectConfirmado"
                        class="form-control">
                    <option disabled selected>Escolhe</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>


            <button type="submit" class="btn btn-pr">Apply Filter</button>

        </form>
        </br>
    </div>

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
                                    @can('view-account',$movimento)
                                        <td>
                                            <a class="btn btn-primary"
                                               href="{{action('MovementController@edit',['id'=>$movimento->id])}}">Editar</a>
                                            <form action="{{action('MovementController@destroy', ['id'=>$movimento->id])}}"
                                                  method="POST" role="form" class="inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    @endcan
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
                                    <td>{{$movimento->num_pessoas}}</td>
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