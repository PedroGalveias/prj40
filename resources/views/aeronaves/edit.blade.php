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
                                <input type="text" name="num_lugares" class="form-control" id="num_lugares"
                                       placeholder="Num_lugares"
                                       value="{{old('num_lugares', $aeronave->num_lugares)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="conta_horas" class="col-sm-4 col-form-label"> Conta horas </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas" class="form-control" id="conta_horas"
                                       placeholder="Conta_horas"
                                       value="{{old('conta_horas', $aeronave->conta_horas)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="preco_hora" class="col-sm-4 col-form-label"> Preço hora </label>
                            <div class="col-sm-10">
                                <input type="text" name="preco_hora" class="form-control" id="preco_hora"
                                       placeholder="Preco_hora" value="{{old('preco_hora', $aeronave->preco_hora)}}"/>
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
