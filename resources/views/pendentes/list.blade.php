@extends('layouts.app')
@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="table-responsive col-md-6">
                <h1>Assuntos Sócios Pendentes</h1>
                <table class="table table-hover table-light table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th>Nome</th>
                        <th>Número de Sócio</th>
                        <th>Tipo de Sócio</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach ($socios as $socio)
                        <tr>
                            <td>{{$socio->name}}</td>
                            <td>{{$socio->num_socio}}</td>
                            <td>{{$socio->tipo_socio}}</td>
                        </tr>
                    @endforeach
                    <div class="row justify-content-center">{{ $movimentos->links() }}   </div>
                </table>
            </div>
        </div>
    </div>

    <br>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="table-responsive col-md-6">
                <h1>Assuntos Movimentos Pendentes</h1>
                <table class="table table-hover table-light table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th>ID Movimento</th>
                        <th>Data</th>
                        <th>ID do Piloto</th>
                        <th>Natureza</th>
                        <th>Aerodromo Partida</th>
                        <th>Aerodromo Chegada</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($movimentos as $movimento)
                        <tr>
                            <td>{{$movimento->id}}</td>
                            <td>{{$movimento->data}}</td>
                            <td>{{$movimento->piloto_id}}</td>
                            <td>{{$movimento->natureza}}</td>
                            <td>{{$movimento->aerodromo_partida}}</td>
                            <td>{{$movimento->aerodromo_chegada}}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="row justify-content-center">{{ $movimentos->links() }}   </div>
            </div>
        </div>
    </div>

@endsection