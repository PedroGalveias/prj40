@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Aeronaves</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>Matricula</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Número Lugares</th>
                                <th>Total horas</th>
                                <th>Preço hora</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($aeronaves as $aeronave)

                                <tr>
                                    <td>{{ $aeronave->matricula }}</td>
                                    <td>{{ $aeronave->marca }}</td>
                                    <td>{{ $aeronave->modelo }}</td>
                                    <td>{{ $aeronave->num_lugares }}</td>
                                    <td>{{ $aeronave->conta_horas }}</td>
                                    <td>{{ $aeronave->preco_hora }}</td>

                                    @can('direcao')
                                        <div class="row">
                                            <td class="inline">
                                                <a class="btn btn-sm btn-warning"
                                                   href="{{action('AeronaveController@listaPilotosAutorizados', ['matricula' => $aeronave->matricula])}}">lista
                                                    autorizados</a>
                                            </td>
                                            <td class="inline">
                                                <a class="btn btn-sm btn-primary"
                                                   href="{{action('AeronaveController@edit', ['matricula' => $aeronave->matricula])}}">Editar</a>
                                            </td>

                                            <td class="inline">
                                                <form action="{{action('AeronaveController@destroy',$aeronave)}}"
                                                      method="POST" role="form" class="inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </div>
                                </tr>
                            @endcan
                            @endforeach
                        </table>
                        <div class="row justify-content-center">{{ $aeronaves->links() }}   </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
