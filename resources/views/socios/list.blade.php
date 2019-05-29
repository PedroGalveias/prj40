@extends('layouts.app')

@section('content')
    <div class="container-fluid" id='bg-light-grey'>

        <form action="{{action('UserController@index')}}" method="get" class="form-inline">
            <div class="form-group">
                <label class="mr-sm-2" for="inputNumSocio">Nº Sócio</label>
                <input type="text" name="num_socio" id="inputNumSocio" placeholder="Nº Sócio"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('num_socio') }}">
                </select>
            </div>
            <div class="form-group">
                <label for="inputNomeInformal" class="mr-sm-2">Nome</label>
                <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="Nome Informal"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('nome_informal') }}">
            </div>
            <div class="form-group">
                <label for="inputName" class="mr-sm-2">E-mail</label>
                <input type="text" name="email" id="inputEmail" placeholder="E-mail"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="selectType" class="mr-sm-2">Tipo Sócio</label>
                <select name="tipo_socio" id="selectTipo" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                    <option disabled selected>Tipo</option>
                    <option value="P">Piloto</option>
                    <option value="NP">Não Piloto</option>
                    <option value="A">Aeromodelista</option>
                </select>
            </div>

            <div class="form-group">
                <label for="selectQuotaPaga" class="mr-sm-2">Quotas</label>
                <select name="quota_paga" id="selectQuotaPaga" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                    <option disabled selected>Pagas</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="form-group">
                <label for="selectSocioAtivo" class="mr-sm-2">Sócio</label>
                <select name="ativo" id="selectSocioAtivo" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                    <option disabled selected>Ativo</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="form-group">
                <label for="selectDirecao" class="mr-sm-2">Direção</label>
                <select name="direcao" id="selectDirecao"
                        class="form-control">
                    <option disabled selected>Direcao</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>
            <span style="width: 10px"></span>
            <button type="submit" class="btn btn-pr">Filtrar</button>


            <div class="container">
                <br>
                <div class="row justify-content-center">

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">Sócios</div>

                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @can('direcao')
                                    <td class="align-middle">
                                        <form action="{{ route('desativar_sem_quotas', $socios) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    style="margin-top: 10px;">desativar_sem_quotas
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                                <table class="table table-striped">

                                    <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nº Sócio</th>
                                        <th>nome</th>
                                        <th>email</th>
                                        <th>tipo</th>
                                        <th>direcao</th>
                                        <th>nº de licença</th>
                                        <th>ativo</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($socios as $socio)
                                        <tr>
                                            @if(!($socio->foto_url))
                                                <td><img class="rounded-circle"
                                                         src=" {{asset("/storage/fotos/default.jpg")}}"
                                                         width="50"/></td>
                                            @else
                                                <td><img class="rounded-circle"
                                                         src=" {{asset("/storage/fotos/$socio->foto_url")}}"
                                                         width="50"/></td>
                                            @endif
                                            <td>{{$socio->num_socio}}</td>
                                            <td>{{$socio->nome_informal}}</td>
                                            <td>{{$socio->email}}</td>
                                            <td> @if($socio->tipo_socio == 'A')
                                                    aeromodelista
                                                @elseif($socio->tipo_socio == 'P')
                                                    piloto
                                                @else
                                                    não piloto
                                                @endif </td>
                                            <td> @if($socio->direcao == '1')
                                                    Sim
                                                @else
                                                    Não
                                                @endif </td>
                                            <td> {{$socio->num_licenca}}
                                            </td>
                                            <td> @if($socio->ativo == '1')
                                                    sim
                                                @else
                                                    nao

                                                @endif
                                            </td>


                                            @can('direcao')
                                                <td class="align-middle">
                                                    <form action="{{action('UserController@sendReActivationEmail', ['socio' => $socio->id])}}"
                                                          method="POST" role="form" class="inline">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-sm btn-dark">reativar email
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{ route('quota', $socio->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        @if($socio->quota_paga == '0')
                                                            <button type="submit" class="btn btn-sm btn-warning"
                                                                    style="margin-top: 10px;">quota não-paga
                                                            </button>
                                                            <input type="hidden" name="quota_paga" value="1">
                                                        @else
                                                            <button type="submit" class="btn btn-sm btn-warning"
                                                                    style="margin-top: 10px;">quota paga
                                                            </button>
                                                            <input type="hidden" name="quota_paga" value="0">
                                                        @endif

                                                    </form>
                                                <td class="align-middle">
                                                    <form action="{{ route('ativarSocio', $socio->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        @if($socio->ativo == '0')
                                                            <button type="submit" class="btn btn-sm btn-warning"
                                                                    style="margin-top: 10px;">não-ativo
                                                            </button>
                                                            <input type="hidden" name="ativo" value="1">
                                                        @else
                                                            <button type="submit" class="btn btn-sm btn-warning"
                                                                    style="margin-top: 10px;">ativo
                                                            </button>
                                                            <input type="hidden" name="ativo" value="0">
                                                        @endif

                                                    </form>
                                                </td>
                                                <td class="align-middle">
                                                    <a class="btn btn-sm btn-primary"
                                                       href="{{action('UserController@edit', ['socio' => $socio->id])}} ">Editar</a>
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{action('UserController@destroy', ['socio' => $socio->id])}}"
                                                          method="POST" role="form" class="inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete
                                                        </button>
                                                    </form>
                                                </td>
                                        </tr>
                                        @endcan
                                    @endforeach
                                    <div class="row justify-content-center">{{ $socios->links() }} </div>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

@endsection
