@extends('layouts.app')

@section('content')


    @if($errors->any())
        @include('partials.errors')
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action="{{action('UserController@store',['id'=>$user->id])}}">

                        {{csrf_field()}}


                        <div class="form-group">
                            <label for="name" class="col-sm-4 col-form-label"> Nome Completo </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="num_socio" class="col-sm-4 col-form-label"> Num socio </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_socio" class="form-control" id="num_socio" placeholder="Num socio" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nome_informal" class="col-sm-4 col-form-label"> Nome Informal </label>
                            <div class="col-sm-10">
                                <input type="text" name="nome_informal" class="form-control" id="nome_informal" placeholder="nome_informal" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endereco" class="col-sm-4 col-form-label"> Endereço </label>
                            <div class="col-sm-10">
                                <input type="text" name="endereco" class="form-control" id="endereco" placeholder="endereco"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefone" class="col-sm-4 col-form-label"> Telefone </label>
                            <div class="col-sm-10">
                                <input type="text" name="telefone" class="form-control" id="telefone" placeholder="telefone"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento" class="col-sm-4 col-form-label"> Data nascimento </label>
                            <div class="col-sm-10">
                                <input type="text" name="data_nascimento" class="form-control" id="data_nascimento" placeholder="data_nascimento"  />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-4 col-form-label"> Email </label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="foto" class="col-sm-4 col-form-label">Upload Foto Perfil</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
                        </div>

                        <div class="form-group">
                            <label for="nif" class="col-sm-4 col-form-label">NIF</label>
                            <div class="col-sm-10">
                                <input type="text" name="nif" class="form-control" id="nif" placeholder="nif"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-6">
                                <input type="submit" class="btn btn-success" name="ok" href="{{route('socios.create', ['id'=>$user->id])}}" value="guardar">
                                <a class="btn btn-primary" href="{{action('UserController@index')}}">voltar</a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
