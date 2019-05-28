@extends('layouts.app')

@section('content')


    @if($errors->any())
        @include('partials.errors')
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action="{{action('UserController@store')}}">

                        {{csrf_field()}}

                        <div class="form-group">

                            <label for="name" class="col-sm-4 col-form-label"> Tipo Sócio: </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tipo_socio">
                                    <option value="P" {{old('tipo_socio', $socio->tipo_socio) == 'P' ? 'selected' : ''}}>
                                        Piloto
                                    </option>
                                    <option value="NP" {{old('tipo_socio', $socio->tipo_socio) == 'NP' ? 'selected' : ''}}>
                                        Não-piloto
                                    </option>
                                    <option value="A" {{old('tipo_socio', $socio->tipo_socio) == 'A' ? 'selected' : ''}}>
                                        Aeromodelista
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sexo" class="col-sm-4 col-form-label"> Genero </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="sexo">
                                    <option value="F" {{old('sexo', $socio->sexo) == 'F' ? 'selected' : ''}}>
                                        Feminino
                                    </option>
                                    <option value="M" {{old('sexo', $socio->sexo) == 'M' ? 'selected' : ''}}>
                                        Masculino
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quota_paga" class="col-sm-4 col-form-label">Quota </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="quota_paga">
                                    <option value="1" {{old('quota_paga', $socio->quota_paga) == '1' ? 'selected' : ''}}>
                                        Sim
                                    </option>
                                    <option value="0" {{old('quota_paga', $socio->quota_paga) == '0' ? 'selected' : ''}}>
                                        Não
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ativo" class="col-sm-4 col-form-label">Sócio ativo</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="ativo">
                                    <option value="1" {{old('ativo', $socio->ativo) == '1' ? 'selected' : ''}}>
                                        Sim
                                    </option>
                                    <option value="0" {{old('ativo', $socio->ativo) == '0' ? 'selected' : ''}}>
                                        Não
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direcao" class="col-sm-4 col-form-label">Direção</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="direcao">
                                    <option value="1" {{old('direcao', $socio->direcao) == '1' ? 'selected' : ''}}>
                                        Sim
                                    </option>
                                    <option value="0" {{old('direcao', $socio->direcao) == '0' ? 'selected' : ''}}>
                                        Não
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 col-form-label"> Nome Completo </label>
                            <div class="col-sm-10">

                                <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                                       value="{{old('name', $socio->name)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nome_informal" class="col-sm-4 col-form-label"> Nome Informal </label>
                            <div class="col-sm-10">
                                <input type="text" name="nome_informal" class="form-control" id="nome_informal"
                                       placeholder="nome_informal"
                                       value="{{old('nome_informal', $socio->nome_informal)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-4 col-form-label"> Email </label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email"
                                       value="{{old('email', $socio->email)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="foto" class="col-sm-4 col-form-label">Upload Foto Perfil</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento" class="col-sm-4 col-form-label"> Data nascimento </label>
                            <div class="col-sm-10">
                                <input type="date" name="data_nascimento" class="form-control" id="data_nascimento"
                                       placeholder="data_nascimento"
                                       value="{{old('data_nascimento', $socio->data_nascimento)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nif" class="col-sm-4 col-form-label">NIF</label>
                            <div class="col-sm-10">
                                <input type="text" name="nif" class="form-control" id="nif" placeholder="nif"
                                       value="{{old('nif', $socio->nif)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefone" class="col-sm-4 col-form-label"> Telefone </label>
                            <div class="col-sm-10">
                                <input type="text" name="telefone" class="form-control" id="telefone"
                                       placeholder="telefone" value="{{old('telefone', $socio->telefone)}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endereco" class="col-sm-4 col-form-label"> Endereço </label>
                            <div class="col-sm-10">
                                <input type="text" name="endereco" class="form-control" id="endereco"
                                       placeholder="endereco" value="{{old('endereco', $socio->endereco)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-6">
                                <input type="submit" class="btn btn-success" name="ok" value="guardar">
                                <a class="btn btn-primary" href="{{action('UserController@index')}}">voltar</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
