@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="row justify-content-center">

                        <div class="profile-header-container">
                            <div class="profile-header-img">
                                <img class="rounded-circle" src=asset("/storage/fotos/{{ $user->foto_url}});"/>
                                <!-- badge -->
                                <div class="rank-label-container">
                                    <span class="label label-default rank-label">{{$user->name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav class="navbar navbar-expand-lg navbar-light bg-light ">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <li>
                                    <a class="nav-link"
                                       href="{{action('UserController@edit',['user' => Auth::user()->id])}}"><strong>Alterar
                                            perfil</strong></a>
                                </li>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <li>
                                    <a class="nav-link"
                                       href="{{action('UserController@showChangePasswordForm')}}"><strong>Mudar
                                            Palavra-passe</strong></a>
                                </li>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <li>
                                    <a class="nav-link" href="{{action('HomeController@index')}}"><strong>home</strong></a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{action('UserController@tabelaAeronavePreço')}}"><strong>Tabela
                                            Preços/Hora Aeronave</strong></a>
                                </li>

                            </ul>
                        </div>

                    </nav>
                </div>
                <div class="row justify-content-center">
                    <table class="table table-striped">
                        <thead>
                        <tr>

                            <th>Nº Sócio</th>
                            <th>tipo Sócio</th>

                            <th>Nome Completo</th>
                            <th>sexo</th>
                            <th>data Nascimento</th>
                            <th>email</th>
                            <th>nif</th>
                            <th>telefone</th>
                            <th>endereço</th>
                            <th>quota</th>
                            <th>ativo</th>
                        </tr>
                        </thead>
                        <thead>

                        <tr>

                            <td>{{Auth::user()->num_socio}}</td>

                            <td> @if(Auth::user()->tipo_socio == 'A')
                                    aeromodelista
                                @elseif(Auth::user()->tipo_socio == 'P')
                                    piloto
                                @else
                                    não piloto
                                @endif </td>


                            <td>{{Auth::user()->name}}</td>
                            <td> @if(Auth::user()->sexo == 'F')
                                    feminino
                                @else
                                    masculino


                                @endif </td>

                            <td>{{Auth::user()->data_nascimento}}</td>
                            <td>{{Auth::user()->email}}</td>

                            <td>{{Auth::user()->nif}}</td>
                            <td>{{Auth::user()->telefone}}</td>
                            <td>{{Auth::user()->endereco}}</td>
                            <td> @if(Auth::user()->quota_paga == '1')
                                    pago
                                @else
                                    nao pago


                                @endif </td>
                            <td> @if(Auth::user()->ativo == '1')
                                    sim
                                @else
                                    nao


                                @endif </td>


                        </tr>
                        </thead>

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
