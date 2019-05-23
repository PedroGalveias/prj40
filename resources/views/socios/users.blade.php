@extends('layouts.app')

@section('content')
    <div class="container-fluid" id='bg-light-grey'>
        <h4>Filtrar Utilizador</h4>
        <form action="{{route('socios.index')}}" method="get" class="form-inline">
            <div class="form-group">
                <label class="mr-sm-2" for="inputNumSocio">Nº Sócio</label>
                <input type="text" name="num_socio" id="inputNumSocio" placeholder=" Escrever Nº Sócio"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('num_socio') }}">
                </select>
            </div>
            <div class="form-group">
                <label for="inputNomeInformal" class="mr-sm-2">Nome</label>
                <input type="text" name="nome_informal" id="inputNomeInformal" placeholder=" Escrever Nome Informal"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('nome_informal') }}">
            </div>
            <div class="form-group">
                <label for="inputName" class="mr-sm-2">E-mail</label>
                <input type="text" name="email" id="inputEmail" placeholder=" Enter E-mail"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="selectType" class="mr-sm-2">Tipo Sócio</label>
                <select name="type" id="selectTipo" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                    <option disabled selected>Escolhe Tipo</option>
                    <option value="P">Piloto</option>
                    <option value="NP">Não Piloto</option>
                </select>
            </div>

            <div class="form-group">
                <label for="selectDirecao" class="mr-sm-2">Direção</label>
                <input type="checkbox" name="direcao" id="selectDirecao"
                       class="form-control mb-2 mr-sm-2 mb-sm-0" value="{{ old('direcao') }}">
            </div>

            <button type="submit" class="btn btn-pr">Apply Filter</button>

        </form>
        </br>
    </div>
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

                        <table class="table table-striped">

                            <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nº Sócio</th>
                                <th>nome</th>
                                <th>email</th>
                                <th>tipo</th>
                                <th>direcao</th>
                                <th>quotas pagas</th>
                                <th>ativo</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($users as $user)

                                <tr>
                                    <td><img class="rounded-circle" src="{{asset("/storage/fotos/$user->foto_url")}}"/>
                                    </td>
                                    <td>{{$user->num_socio}}</td>
                                    <td>{{$user->nome_informal}}</td>
                                    <td>{{$user->email}}</td>
                                    <td> @if($user->tipo_socio == 'A')
                                            aeromodelista
                                        @elseif($user->tipo_socio == 'P')
                                            piloto
                                        @else
                                            não piloto
                                        @endif </td>


                                    <td> @if($user->direcao == '1')
                                            Sim
                                        @else
                                            Não


                                        @endif </td>
                                    <td> @if($user->quota_paga == '1')
                                            pago
                                        @else
                                            nao pago


                                        @endif </td>
                                    <td> @if($user->ativo == '1')
                                            sim
                                        @else
                                            nao


                                        @endif </td>

                                    @can('view-account',$user)
                                        <td>
                                            <a class="btn btn-primary"
                                               href="{{action('UserController@edit', ['socio' => $user->id])}} ">Editar</a>
                                            <form action="{{action('UserController@destroy', ['socio' => $user->id])}}"
                                                  method="POST" role="form" class="inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                </tr>
                            @endcan
                            @endforeach

                        </table>
                        <div class="row justify-content-center">{{ $users->links() }}   </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
