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
                            <th scope="col">Matricula</th>
                            <th scope="col">Unidade</th>
                            <th scope="col">Minutos</th>
                            <th scope="col">Preço</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $records)
                            <tr>
                                <td>{{ $records->matricula }}</td>
                                <td>{{ $records->unidade_conta_horas }}</td>
                                <td>{{ $records->minutos }}</td>
                                <td>{{ $records->preco }}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection