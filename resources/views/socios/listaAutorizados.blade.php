@extends('layouts.app')

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-md-9">


            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Sócios</div>
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
    </div>
@endsection
