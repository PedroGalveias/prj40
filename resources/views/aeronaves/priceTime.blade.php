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
                            <th>Unidade</th>
                            <th>Minutos</th>
                            <th>Preço</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($values=1 ; $values <= 10; $values++)
                            <tr>
                                <td scope>
                                    {{$values}}</td>
                                <td scope>
                                    <input
                                            name="minutos[{{$values}}]"
                                            value="{{5*round($values*6/5)}}"
                                            readonly="readonly">
                                </td>
                                <td>
                                    <input
                                            name="preco[{{$values}}]"
                                            value=" {{round((5*round($values*6/5))/60* $aeronave->preco_hora)}} "
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