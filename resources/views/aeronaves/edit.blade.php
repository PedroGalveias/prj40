@extends('layouts.app')
@section('content')
    @if($errors->any())
        @include('partials.errors')
    @endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action="{{ action('AeronaveController@update',$aeronave)}}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Marca </label>
                            <div class="col-sm-10">
                                <input type="text" name="marca" class="form-control" id="marca" placeholder="Marca"
                                       value="{{old('marca', $aeronave->marca)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="matricula" class="col-sm-4 col-form-label"> Matricula </label>
                            <div class="col-sm-10">
                                <input type="text" name="matricula" class="form-control" id="matricula"
                                       placeholder="Matricula" disabled value="{{old('matricula', $aeronave->matricula)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modelo" class="col-sm-4 col-form-label"> Modelo </label>
                            <div class="col-sm-10">
                                <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo"
                                       value="{{old('modelo', $aeronave->modelo)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="num_lugares" class="col-sm-4 col-form-label"> Num lugares </label>
                            <div class="col-sm-10">
                                <input type="number" min="1" name="num_lugares" class="form-control" id="num_lugares"
                                       placeholder="Num_lugares"
                                       value="{{old('num_lugares', $aeronave->num_lugares)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="conta_horas" class="col-sm-4 col-form-label"> Conta horas </label>
                            <div class="col-sm-10">
                                <input type="number" min="0" name="conta_horas" class="form-control" id="conta_horas"
                                       placeholder="Conta_horas"
                                       value="{{old('conta_horas', $aeronave->conta_horas)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="preco_hora" class="col-sm-4 col-form-label"> Preço hora </label>
                            <div class="col-sm-10">
                                <input type="number" min="0" name="preco_hora" class="form-control" id="preco_hora"
                                       placeholder="Preco_hora" value="{{old('preco_hora', $aeronave->preco_hora)}}"/>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-12" role="main">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th scope="row">Unidade</th>
                                            <th scope="row">Minutos</th>
                                            <th scope="row">Preço</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($values=1 ; $values <= 10; $values++)
                                            <tr>
                                                <td>
                                                    {{$values}}</td>
                                                <td>
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
                        
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-6">
                                <input type="submit" class="btn btn-success" name="ok" value="guardar">
                                <a class="btn btn-primary" href="{{action('AeronaveController@index')}}">voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
