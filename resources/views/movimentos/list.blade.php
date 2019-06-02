@extends('layouts.app')

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-md-10">
            <form action="{{action('MovimentoController@index')}}" method="get" class="form-inline">
                <div class="form-group">
                    <label class="mr-sm-2" for="inputNumMovimento">Nº de Movimento</label>
                    <input type="text" name="id" id="inputNumMovimento" placeholder="Nº Movimento"
                           class="form-control form-control-sm" value="{{ old('id') }}">
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputAeronave" class="mr-sm-2">Aeronave</label>
                    <input type="text" name="aeronave" id="inputAeronave" placeholder="Matrícula da Aeronave"
                           class="form-control form-control-sm" value="{{ old('aeronave') }}">
                </div>
                <div class="form-group">
                    <label for="inputPiloto_id" class="mr-sm-2">Piloto</label>
                    <input type="text" name="piloto_id" id="inputPiloto_id" placeholder="ID Piloto"
                           class="form-control form-control-sm" value="{{ old('piloto_id') }}">
                </div>
                <div class="form-group">
                    <label for="inputInstrutor_id" class="mr-sm-2">Instrutor</label>
                    <input type="text" name="instrutor_id" id="inputInstrutor_id" placeholder=" ID Instrutor"
                           class="form-control form-control-sm" value="{{ old('instrutor_id') }}">
                </div>
                <!-- DATA -->
                <div class="form-group">
                    <label for="inputDataInicio" class="mr-sm-2">Data Inicio</label>
                    <input type="date" name="dataInicio" id="data" placeholder=" Data Inicio"
                           class="form-control form-control-sm" value="{{ old('data') }}">
                </div>
                <div class="form-group">
                    <label for="inputDataFinal" class="mr-sm-2">Data Final</label>
                    <input type="date" name="dataFinal" id="data" placeholder="Data Final"
                           class="form-control form-control-sm" value="{{ old('data') }}">
                </div>
                <div class="form-group">
                    <label for="selectType" class="mr-sm-2">Natureza</label>
                    <select name="natureza" id="selectNatureza"
                            class="custom-select custom-select-sm mb-2 mr-sm-2 mb-sm-0">
                        <option disabled selected>Escolhe Natureza do Voo</option>
                        <option value="T">Treino</option>
                        <option value="I">Instrução</option>
                        <option value="E">Especial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectConfirmado" class="mr-sm-2">Confirmado</label>
                    <select name="confirmado" id="selectConfirmado"
                            class="custom-select custom-select-sm mb-2 mr-sm-2 mb-sm-0">
                        <option disabled selected>Escolhe</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-sm btn-primary"
                        style="margin-top: 2px;">Filtrar
                </button>

            </form>
            </br>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
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
                                <th></th>
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

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($movimentos as $movimento)
                                <tr>
                                    @if((\Illuminate\Support\Facades\Auth::id() == $movimento->piloto_id && $movimento->confirmado==0)
                                    || (\Illuminate\Support\Facades\Auth::id() == $movimento->instrutor_id && $movimento->confirmado==0))


                                        <td>

                                            <a class="btn btn-sm btn-primary"
                                               href="{{action('MovimentoController@edit',['id'=>$movimento->id])}}">Editar</a>

                                            <form action="{{action('MovimentoController@destroy', ['id'=>$movimento->id])}}"
                                                  method="POST" role="form" class="inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>

                                        </td>

                                    @endif

                                    @can('direcao')
                                        @if($movimento->confirmado==0)
                                        <td>

                                            <a class="btn btn-sm btn-primary"
                                               href="{{action('MovimentoController@edit',['id'=>$movimento->id])}}">Editar</a>

                                            <form action="{{action('MovimentoController@destroy', ['id'=>$movimento->id])}}"
                                                  method="POST" role="form" class="inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>

                                        </td>
                                            @endif
                                    @endcan
                                    <td></td>
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