@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Aeronaves Valores</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>ID</th>
                                <th>Matricula</th>
                                <th>Unidade Conta Horas</th>
                                <th>Minutos</th>
                                <th>Preço</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($records as $records)

                                <tr>
                                    <td>{{ $records->id }}</td>
                                    <td>{{ $records->matricula }}</td>
                                    <td>{{ $records->unidade_conta_horas }}</td>
                                    <td>{{ $records->minutos }}</td>
                                    <td>{{ $records->preco }}</td>

                                    <td>
                                        <a class="btn btn-primary"
                                           href="{{action('AeronaveController@edit', ['matricula' => $aeronave->matricula])}}">Editar</a>
                                        <form action="{{action('AeronaveController@destroy', ['matricula' => $aeronave->matricula])}}"
                                              method="POST" role="form" class="inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>

                                </tr>

                            @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection