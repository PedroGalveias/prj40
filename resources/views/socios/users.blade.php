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
            <td><img class="rounded-circle" src="{{asset("/storage/fotos/$user->foto_url")}}" /></td>
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
                <a class="btn btn-primary" href="{{action('UserController@edit', ['socio' => $user->id])}} ">Editar</a>
                <form action="{{action('UserController@destroy', ['socio' => $user->id])}}" method="POST" role="form" class="inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endcan
    @endforeach
      <div class="row justify-content-center">{{ $users->links() }}   </div>
    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
