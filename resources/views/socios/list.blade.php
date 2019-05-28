@extends('layouts.app')

@section('content')

    <div class="container">

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
                                        <td><img class="rounded-circle" src=" {{asset("/storage/fotos/default.jpg")}}"
                                                 width="50"/></td>
                                    @else
                                        <td><img class="rounded-circle"
                                                 src=" {{asset("/storage/fotos/$socio->foto_url")}}" width="50"/></td>
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
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
