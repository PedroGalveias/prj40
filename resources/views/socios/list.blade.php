@extends('layouts.app')

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-md-9">
            <form action="{{action('UserController@index')}}" method="get" class="form-inline">
                <div class="form-group">
                    <label class="mr-sm-0" for="inputNumSocio">Nº Sócio</label>
                    <input type="text" name="num_socio" id="inputNumSocio" placeholder="Nº Sócio"
                           class="form-control form-control-sm" value="{{ old('num_socio') }}">
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputNomeInformal" class="mr-sm-2">Nome</label>
                    <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="Nome Informal"
                           class="form-control form-control-sm" value="{{ old('nome_informal') }}">
                </div>
                <div class="form-group">
                    <label for="inputName" class="mr-sm-2">E-mail</label>
                    <input type="text" name="email" id="inputEmail" placeholder="E-mail"
                           class="form-control form-control-sm" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="selectType" class="mr-sm-2">Tipo Sócio</label>
                    <select name="tipo_socio" id="selectTipo"
                            class="custom-select custom-select-sm mb-2 mr-sm-2 mb-sm-0">
                        <option disabled selected>Tipo</option>
                        <option value="P">Piloto</option>
                        <option value="NP">Não Piloto</option>
                        <option value="A">Aeromodelista</option>
                    </select>
                </div>
                @can('direcao')
                    <div class="form-group">
                        <label for="selectQuotaPaga" class="mr-sm-2">Quotas</label>
                        <select name="quota_paga" id="selectQuotaPaga"
                                class="custom-select custom-select-sm mb-2 mr-sm-2 mb-sm-0">
                            <option disabled selected>Pagas</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="selectSocioAtivo" class="mr-sm-2">Sócio</label>
                        <select name="ativo" id="selectSocioAtivo"
                                class="custom-select custom-select-sm mb-2 mr-sm-2 mb-sm-0">
                            <option disabled selected>Ativo</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                @endcan
                <div class="form-group">
                    <label for="selectDirecao" class="mr-sm-2">Direção</label>
                    <select name="direcao" id="selectDirecao"
                            class="custom-select custom-select-sm mb-2 mr-sm-2 mb-sm-0">
                        <option disabled selected>Direcao</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-sm btn-primary"
                        style="margin-top: 2px;">Filtrar
                </button>

            </form>
        </div>

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Sócios</div>
                        @can('direcao')

                            <div class="row justify-content-center">
                                <form action="{{action('UserController@desativarSemQuotas')}}" method="POST"
                                      class="inline">
                                    {{ method_field('PATCH') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-light mr-1 mb-5"
                                            style="margin-top: 10px;">
                                        desativar socios c/ quotas não pagas
                                    </button>
                                </form>
                                <form action="{{action('UserController@resetQuota')}}" method="POST"
                                      class="inline">
                                    @method('patch')
                                    @csrf
                                    <button type="submit" class="btn btn-light mb-5"
                                            style="margin-top: 10px;">
                                        resetar quotas
                                    </button>
                                </form>

                                @endcan
                            </div>
                            <div class="card-body">

                                <table class="table table-striped">
                                    <div class="col-md-9">
                                        <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nº Sócio</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Tipo Sócio</th>
                                            <th>Direção</th>
                                            <th>nº de licença</th>
                                            <th>Ativo</th>
                                            @can('direcao')
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            @endcan
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
                                                             width="50"/>
                                                    </td>
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
                                                        Sim
                                                    @else
                                                        Não

                                                    @endif
                                                </td>


                                                @can('direcao')

                                                    <div class="row">
                                                        <td class="align-middle">
                                                            <form action="{{ route('quota', $socio->id) }}"
                                                                  method="POST">
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
                                                        </td>
                                                        <td class="align-middle">
                                                            <form action="{{ route('ativarSocio', $socio->id) }}"
                                                                  method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('PATCH') }}
                                                                @if($socio->ativo == '0')
                                                                    <button type="submit" class="btn btn-sm btn-warning"
                                                                            style="margin-top: 10px;">inativo
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
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </div>
                                            </tr>
                                            @endcan
                                        @endforeach

                                        <div class="row justify-content-center">{{ $socios->links() }} </div>

                                    </div>
                                </table>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
