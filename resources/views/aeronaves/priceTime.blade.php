@extends('layouts.app')
@section('content')



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Lista Aeronave Preço/Hora</div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Unidade</th>
                            <th scope="col">Minutos</th>
                            <th scope="col">Preço</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($unidades=1 ; $unidades <= 10; $unidades++)
                            <tr>
                                <td scope="row">
                                    {{$unidades}}</td>
                                <td scope="row">
                                    <input
                                            style='width:auto'
                                            name="minutos[{{$unidades}}]"
                                            value="{{5*round($unidades*6/5)}}"
                                            readonly="readonly">
                                </td>
                                <td scope="row">
                                    <input
                                            style='width:auto'
                                            name="preco[{{$unidades}}]"
                                            value=" {{round((5*round($unidades*6/5))/60* $aeronave->preco_hora)}} "
                                            readonly="readonly">
                                </td>
                            </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection