@extends('layouts.app')
@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST"
                          action="{{action('AeronaveController@store')}}">

                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Marca </label>
                            <div class="col-sm-10">
                                <input type="text" name="marca" class="form-control" id="marca" placeholder="Marca"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Modelo </label>
                            <div class="col-sm-10">
                                <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Num lugares </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_lugares" class="form-control" id="num_lugares"
                                       placeholder="Num_lugares"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Conta horas </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas" class="form-control" id="conta_horas"
                                       placeholder="Conta_horas"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Preço hora </label>
                            <div class="col-sm-10">
                                <input type="text" name="preco_hora" class="form-control" id="preco_hora"
                                       placeholder="Preco_hora"/>
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
