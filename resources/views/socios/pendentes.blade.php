@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="table-responsive col-md-6">
                <div class="card-header">Pilotos não confirmados</div>
                <table class="table table-hover table-light table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th>Nº Sócio</th>
                        <th>Nome</th>
                        <th>Licenca confirmada</th>
                        <th>Certificado confirmado</th>
                        <th></th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach ($pilotos as $piloto)

                        <tr>
                            <td>{{$piloto->num_socio}}</td>
                            <td>{{$piloto->nome_informal}}</td>
                            <td> @if($piloto->licenca_confirmada == '1')
                                    Sim
                                @else
                                    Não

                                @endif
                            </td>
                            <td> @if($piloto->certificado_confirmado == '1')
                                    Sim
                                @else
                                    Não

                                @endif
                            </td>
                            <td>
                                <form action="{{action('UserController@edit', ['piloto' => $piloto])}}"
                                      method="GET" role="form" class="inline">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Editar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>

            <div class="table-responsive col-md-6">
                <div class="card-header">Movimentos não confirmados</div>
                <table class="table table-hover table-light table-sm ">
                    <thead class="thead-light">
                    <tr>

                        <th>Aeronave</th>
                        <th>Nº licença piloto</th>
                        <th>Confirmado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($movimentos as $movimento)
                        <tr>

                            <td>{{$movimento->aeronave}}</td>
                            <td>{{$movimento->num_licenca_piloto}}</td>
                            <td> @if($movimento->confirmado == '1')
                                    Sim
                                @else
                                    Não

                                @endif
                            </td>
                            <td>
                                <form action="{{action('MovimentoController@edit', ['movimento' => $movimento->id])}}"
                                      method="GET" role="form" class="inline">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Editar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
