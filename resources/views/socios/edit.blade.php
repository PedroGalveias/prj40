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
                          enctype="multipart/form-data">

                        @method('PUT')

                        {{csrf_field()}}

                        <div class="row justify-content-center">
                            <div class="profile-header-container">
                                <div class="profile-header-img">
                                    @if(!($socio->foto_url))
                                        <td><img class="rounded-circle" src=" {{asset("/storage/fotos/default.jpg")}}"
                                                 width="100"/></td>
                                    @else
                                        <td><img class="rounded-circle"
                                                 src=" {{asset("/storage/fotos/$socio->foto_url")}}" width="100"/></td>
                                @endif


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
                                <label for="sexo" class="col-sm-4 col-form-label"> Sexo </label>
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
                                <label for="ativo" class="col-sm-4 col-form-label">Ativo</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="ativo" value="{{$socio->ativo}}">
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
                                    <input type="hidden" name="tipo_socio" value="{{$socio->tipo_socio}}">
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
                                <label for="sexo" class="col-sm-4 col-form-label"> Sexo </label>
                                <input type="hidden" name="sexo" value="{{$socio->sexo}}">
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
                                    <input type="hidden" name="quota_paga" value="{{$socio->quota_paga}}">
                                    <select class="form-control" name="quota_paga" disabled>
                                        <option value="" {{old('quota_paga', $socio->quota_paga) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="" {{old('quota_paga', $socio->quota_paga) == '0' ? 'selected' : ''}}>
                                            Não
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="direcao" class="col-sm-4 col-form-label">Direção</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="direcao" value="{{$socio->direcao}}">
                                    <select class="form-control" name="direcao" disabled>
                                        <option value="" {{old('direcao', $socio->direcao) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="" {{old('direcao', $socio->direcao) == '0' ? 'selected' : ''}}>
                                            Não
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ativo" class="col-sm-4 col-form-label">Ativo</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="ativo" value="{{$socio->ativo}}">
                                    <select class="form-control" name="ativo" disabled>
                                        <option value="" {{old('ativo', $socio->ativo) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="" {{old('ativo', $socio->ativo) == '0' ? 'selected' : ''}}>
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
                            <input type="file" name="foto_file" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
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
                                <label for="licenca_confirmada" class="col-sm-4 col-form-label">Licença
                                    confirmada</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="licenca_confirmada" readonly>
                                        <option value="1" {{old('licenca_confirmada', $socio->licenca_confirmada) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="0" {{old('licenca_confirmada', $socio->licenca_confirmada) == '0' ? 'selected' : ''}}>
                                            Não
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="certificado_confirmado" class="col-sm-4 col-form-label">Certificado
                                    confirmado</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="certificado_confirmado" readonly>
                                        <option value="1" {{old('certificado_confirmado', $socio->certificado_confirmado) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="0" {{old('certificado_confirmado', $socio->certificado_confirmado) == '0' ? 'selected' : ''}}>
                                            Não
                                        </option>


                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tipo_licenca" class="col-sm-4 col-form-label">Tipo licença</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tipo_licenca">
                                        <option value="1" {{old('tipo_licenca', $socio->tipo_licenca) == 'ALUNO-PPL(A)' ? 'selected' : ''}}>
                                            Aluno - Private Pilot License Airplane
                                        </option>
                                        <option value="0" {{old('tipo_licenca', $socio->tipo_licenca) == 'ALUNO-PU' ? 'selected' : ''}}>
                                            Aluno - Piloto de Ultraleve
                                        </option>
                                        <option value="1" {{old('tipo_licenca', $socio->tipo_licenca) == 'ATPL' ? 'selected' : ''}}>
                                            Airline Transport Pilot License
                                        </option>
                                        <option value="1" {{old('tipo_licenca', $socio->tipo_licenca) == 'CPL(A)' ? 'selected' : ''}}>
                                            Comercial Pilot License Airplane
                                        </option>
                                        <option value="1" {{old('tipo_licenca', $socio->tipo_licenca) == 'PPL(A)' ? 'selected' : ''}}>
                                            Private Pilot License Airplane
                                        </option>
                                        <option value="1" {{old('tipo_licenca', $socio->tipo_licenca) == 'PU' ? 'selected' : ''}}>
                                            Piloto de Ultraleve
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="instrutor" class="col-sm-4 col-form-label">Instrutor</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="instrutor">
                                        <option value="1" {{old('instrutor', $socio->instrutor) == '1' ? 'selected' : ''}}>
                                            Sim
                                        </option>
                                        <option value="0" {{old('instrutor', $socio->instrutor) == '0' ? 'selected' : ''}}>
                                            Não
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="validade_licenca" class="col-sm-4 col-form-label"> Validade licença </label>
                                <div class="col-sm-10">
                                    <input type="date" name="validade_licenca" class="form-control"
                                           id="validade_licenca" placeholder="validade_licenca"
                                           value="{{old('validade_licenca', $socio->validade_licenca)}}"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="num_certificado" class="col-sm-4 col-form-label"> Número
                                    certificado </label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_certificado" class="form-control" id="num_certificado"
                                           placeholder="num_certificado"
                                           value="{{old('num_certificado', $socio->num_certificado)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="num_licenca" class="col-sm-4 col-form-label"> Número licença </label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_licenca" class="form-control" id="num_licenca"
                                           placeholder="num_licenca"
                                           value="{{old('num_licenca', $socio->num_licenca)}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="classe_certificado" class="col-sm-4 col-form-label"> classe
                                    certificado</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="classe_certificado">
                                        <option value="1" {{old('classe_certificado', $socio->classe_certificado) == 'Class 1' ? 'selected' : ''}}>
                                            Class 1 medical certificate
                                        </option>
                                        <option value="0" {{old('classe_certificado', $socio->classe_certificado) == 'Class 2	' ? 'selected' : ''}}>
                                            Class 2 medical certificate
                                        </option>
                                        <option value="1" {{old('classe_certificado', $socio->classe_certificado) == 'LAPL	' ? 'selected' : ''}}>
                                            Light Aircraft Pilot Licence Medical
                                        </option>


                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="validade_certificado" class="col-sm-4 col-form-label"> validade
                                    certificado</label>
                                <div class="col-sm-10">
                                    <input type="date" name="validade_certificado" class="form-control"
                                           id="validade_certificado" placeholder="validade_certificado"
                                           value="{{old('validade_certificado', $socio->validade_certificado)}}"/>
                                </div>
                            </div>
                            <div class="d-md-table-row">
                                <td><a href="{{route('licenca',['piloto' => $socio])}}">licenca.pdf</a>&nbsp
                                    <a href="{{route('certificado',['piloto' => $socio])}}">certificado.pdf</a></td>
                            </div>
                            <div class="form-group">
                                <label for="licenca" class="col-sm-4 col-form-label">Upload certificado</label>
                                <input type="file" name="licenca" id="licenca" class="form-control" accept=".pdf">
                            </div>
                            <div class="form-group">
                                <label for="certificado" class="col-sm-4 col-form-label">Upload licença</label>
                                <input type="file" name="certificado" id="certificado" class="form-control"
                                       accept=".pdf">
                            </div>
                            @can('direcao')
                                <div class="form-group">
                                    <label for="licenca_confirmada" class="col-sm-4 col-form-label">licenca
                                        confirmada</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="licenca_confirmada">
                                            <option value="1" {{old('licenca_confirmada', $socio->licenca_confirmada) == '1' ? 'selected' : ''}}>
                                                Sim
                                            </option>
                                            <option value="0" {{old('licenca_confirmada', $socio->licenca_confirmada) == '0' ? 'selected' : ''}}>
                                                Não
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="certificado_confirmado" class="col-sm-4 col-form-label">certificado
                                        confirmado</label>
                                    <div class="col-sm-10">

                                        <select class="form-control" name="certificado_confirmado">

                                            <option value="1" {{old('certificado_confirmado', $socio->certificado_confirmado) == '1' ? 'selected' : ''}}>
                                                Sim
                                            </option>
                                            <option value="0" {{old('certificado_confirmado', $socio->certificado_confirmado) == '0' ? 'selected' : ''}}>
                                                Não
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-table-row">
                                    <td><a href="{{route('licenca',['piloto' => $socio])}}">licenca.pdf</a>&nbsp
                                        <a href="{{route('certificado',['piloto' => $socio])}}">certificado.pdf</a></td>
                                </div>
                                <div class="form-group">
                                    <label for="licenca" class="col-sm-4 col-form-label">Upload certificado</label>
                                    <input type="file" name="licenca" id="licenca" class="form-control" accept=".pdf">
                                </div>
                                <div class="form-group">
                                    <label for="certificado" class="col-sm-4 col-form-label">Upload licença</label>
                                    <input type="file" name="certificado" id="certificado" class="form-control"
                                           accept=".pdf">
                                </div>
                            @endcan
                        @endif
                        <div class="form-group">
                            <input type="submit" class="btn btn-sm btn-success" name="ok" value="guardar">
                            <a class="btn btn-sm btn-primary" href="{{action('UserController@index')}}">voltar</a>

                            @can('direcao')
                                @if(Auth::user()->id != $socio->id)
                                    <form action="{{action('UserController@sendReActivationEmail', ['socio' => $socio->id])}}"
                                          method="POST" role="form" class="inline">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-dark">
                                            reenviar email
                                            ativação
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
