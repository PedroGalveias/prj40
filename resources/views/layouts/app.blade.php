<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FlightClub') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- DropDown admin -->

            <!-- Left Side Of Navbar -->
            @can('direcao')
                <div class="btn-group">
                    <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Aeronaves
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{action('AeronaveController@index')}}">Lista</a>
                        <a class="dropdown-item" href="{{action('AeronaveController@create')}}">Adicionar</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Movimentos
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{action('MovimentoController@index')}}">Lista</a>
                        <a class="dropdown-item" href="{{action('MovimentoController@create')}}">Adicionar</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Socios
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{action('UserController@index')}}">Lista</a>
                        <a class="dropdown-item" href="{{action('UserController@create')}}">Adicionar</a>
                    </div>
                </div>
            @endcan
                <ul class="navbar-nav mr-auto"></ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="{{action('UserController@edit',['socio' => Auth::user()->id])}}">Perfil</a>
                                <a class="dropdown-item" href="{{action('HomeController@index')}}">Home</a>
                                @can('direcao', auth()->user())
                                    <a class="dropdown-item" href="{{action('AeronaveController@priceTime', ['aeronave'=> Auth::user()->id])}}">Preço-hora aeronave</a>
                                @endcan
                                <a class="dropdown-item" href="{{action('UserController@showChangePasswordForm')}}">Alterar
                                    palavra-passe</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                </ul>
        </div>

    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
