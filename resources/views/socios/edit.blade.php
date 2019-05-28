@extends('layouts.app')

@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <form method="POST" action="{{action('UserController@update',$socio)}}"
                          encrypte="multipart/form-data">

                        @method('PUT')

                        {{csrf_field()}}

                        <div class="row justify-content-center">
                            <div class="profile-header-container">
                                <div class="profile-header-img">
                                    <img class="rounded-circle" src=" {{asset("/storage/fotos/$socio->foto_url")}}"
                                         width=""/>
                                    <!-- badge -->
                                    <div class="row justify-content-center">
                                        <span class="label label-default rank-label">{{$socio->name}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if(Auth::user()->direcao == '1')
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <label for="name" class="col-sm-4 col-form-label"> Número Sócio: </label>
                                    <input type="text" name="num_socio" class="form-control" id="num_socio"
                                           placeholder="numero socio"
                                           value="{{old('num_socio', $socio->num_socio)}}"/>
                                </div>
                            </div>
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
                        @else
                            <div class="form-group">

                                <label for="name" class="col-sm-4 col-form-label"> Número Sócio: </label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_socio" class="form-control" id="num_socio"
                                           placeholder="numero socio"
                                           disabled value="{{old('num_socio', $socio->num_socio)}} "/>
                                </div>
                            </div>

                            <div class="form-group">

                                <label for="tipo_socio" class="col-sm-4 col-form-label"> Tipo Sócio </label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="tipo_socio" disabled>
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
                                    <select class="form-control" name="sexo" disabled>
                                        <option value="{{$socio->sexo}}" {{old('sexo', $socio->sexo) == 'F' ? 'selected' : ''}}>
                                            Feminino
                                        </option>
                                        <option value="{{$socio->sexo}}" {{old('sexo', $socio->sexo) == 'M' ? 'selected' : ''}}>
                                            Masculino
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="quota_paga" class="col-sm-4 col-form-label">Quota </label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="quota_paga" disabled>
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
                                    <select class="form-control" name="ativo" disabled>
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
                                    <select class="form-control" name="direcao" disabled>
                                        <option value="1" {{old('direcao', $socio->direcao) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="0" {{old('direcao', $socio->direcao) == '0' ? 'selected' : ''}}>
                                            Não
                                        </option>

                                    </select>
                                </div>
                            </div>
                        @endif

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


                        @if($socio->tipo_socio == 'P')



                            <div class="form-group">
                                <label for="tipo_licenca" class="col-md-4 control-label">tipo licenca</label>
                                <div class="col-sm-10">

                                    <select class="form-control" id="tipo_licenca">
                                        <option value="">Selecione o tipo licenca</option>
                                        <option value="">Tecnologias de Internet</option>
                                        <option value="Ainet" selected>Aplicações para a Internet</option>
                                        <option value="DAD">Desenvolvimento Aplicações Distribuídas</option>
                                    </select>

                                </div>
                            </div>



                            <div class="form-group">
                                <label for="instrutor" class="col-sm-4 col-form-label"> instrutor </label>
                                <div class="col-sm-10">
                                    <input type="text" name="instrutor" class="form-control" id="instrutor"
                                           placeholder="instrutor" value="{{old('instrutor', $socio->instrutor)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="validade_licenca" class="col-sm-4 col-form-label"> validade licenca </label>
                                <div class="col-sm-10">
                                    <input type="text" name="validade_licenca" class="form-control"
                                           id="validade_licenca" placeholder="validade_licenca"
                                           value="{{old('validade_licenca', $socio->validade_licenca)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="licenca_confirmada" class="col-sm-4 col-form-label"> licenca
                                    confirmada </label>
                                <div class="col-sm-10">
                                    <input type="text" name="licenca_confirmada" class="form-control"
                                           id="licenca_confirmada" placeholder="licenca_confirmada"
                                           value="{{old('licenca_confirmada', $socio->licenca_confirmada)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="num_certificado" class="col-sm-4 col-form-label"> num certificado </label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_certificado" class="form-control" id="num_certificado"
                                           placeholder="num_certificado"
                                           value="{{old('num_certificado', $socio->num_certificado)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="classe_certificado" class="col-sm-4 col-form-label"> classe
                                    certificado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="classe_certificado" class="form-control"
                                           id="classe_certificado" placeholder="classe_certificado"
                                           value="{{old('classe_certificado', $socio->classe_certificado)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="validade_certificado" class="col-sm-4 col-form-label"> validade
                                    certificado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="validade_certificado" class="form-control"
                                           id="validade_certificado" placeholder="validade_certificado"
                                           value="{{old('validade_certificado', $socio->validade_certificado)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="certificado_confirmado" class="col-sm-4 col-form-label">
                                    certificado_confirmado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="certificado_confirmado" class="form-control"
                                           id="certificado_confirmado" placeholder="certificado_confirmado"
                                           value="{{old('certificado_confirmado', $socio->certificado_confirmado)}}"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <td><a href="{{route('licenca',['piloto' => $socio])}}">licenca.pdf</a>&nbsp
                                    <a href="{{route('certificado',['piloto' => $socio])}}">certificado.pdf</a></td>
                            </div>
                            <div class="form-group">

                                <label for="upload_file" class="control-label col-sm-3">Upload File </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file" name="upload_file" id="upload_file"
                                           value="{{old('name', $socio->licenca_confirmada)}}"/>
                                </div>
                            </div>



                        @endif

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="ok" value="guardar">
                            <a class="btn btn-primary" href="{{action('UserController@index')}}">voltar</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
