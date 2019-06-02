@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="table-responsive col-md-6">
                <div class="card-header">Pilotos autorizados</div>
                <table class="table table-hover table-light table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th>Nº Sócio</th>
                        <th>Nome</th>
                        <th></th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach ($pilotosAuto as $pilotoAuto)

                        <tr>
                            <td>{{$pilotoAuto->num_socio}}</td>
                            <td>{{$pilotoAuto->nome_informal}}</td>
                            <div class="row">
                                <td>
                                    <form action="{{action('AeronaveController@removePiloto', ['pilotoAuto' => $pilotoAuto,'aeronave'=>$aeronave])}}"
                                          method="POST" role="form" class="inline">

                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                             >
                                        </button>
                                    </form>
                                </td>
                            </div>
                        </tr>
                    @endforeach

                </table>
            </div>

            <div class="table-responsive col-md-6">
                <div class="card-header">Pilotos não autorizados</div>
                <table class="table table-hover table-light table-sm ">
                    <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Nº Sócio</th>
                        <th>Nome</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($pilotosNaoAuto as $pilotoNaoAuto)
                        <tr>
                            <td>
                                <form action="{{action('AeronaveController@acrescentaPiloto', ['pilotoNaoAuto' => $pilotoNaoAuto->id,'aeronave'=>$aeronave->matricula])}}"
                                      method="POST" role="form" class="inline">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <
                                    </button>
                                </form>
                            </td>
                            <td>{{$pilotoNaoAuto->num_socio}}</td>
                            <td>{{$pilotoNaoAuto->nome_informal}}</td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
