@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{Auth::user()->nome_informal}}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>

                        @endif

                        <nav class="navbar navbar-expand-lg navbar-light bg-light ">

                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarNav" aria-controls="navbarNav"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarNav">

                                <ul class="navbar-nav">

                                    <li>
                                        <a class="nav-link"
                                           href="{{action('UserController@index')}}"><strong>Ver
                                                sócios</strong></a>

                                    </li>
                                    <li>
                                        <a class="nav-link"
                                           href="{{action('AeronaveController@index')}}"><strong>Lista
                                                de aeronaves</strong></a>
                                    </li>
                                    <li>
                                        <a class="nav-link"
                                           href="{{action('MovimentoController@index')}}"><strong>Lista
                                                de movimentos</strong></a>
                                    </li>
                                    @can('piloto')
                                        <li>
                                            <a class="nav-link"
                                               href="{{action('MovimentoController@create')}}"><strong>adicionar
                                                    movimento</strong></a>
                                        </li>
                                    @endcan
                                </ul>

                            </div>
                        </nav>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
