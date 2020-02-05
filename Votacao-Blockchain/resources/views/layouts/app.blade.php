<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/personalizacao.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ URL::asset('/img/iconeUrna.png') }}" type="image/x-icon" />

</head>

<body>
    <div class="d-flex" id="wrapper">
        @auth
        <!-- Sidebar -->
        <div class="bg-info" id="sidebar-wrapper">
            <div class="sidebar-heading text-center">{{ config('app.name', 'Laravel') }}</div>
            <div class="list-group list-group-flush">

                @if (Auth::user()->eleitor == 1)
                <a href="{{ route('votacao') }}" class="list-group-item list-group-item-action bg-info text-white"><i class="fas fa-user-check"></i> Votação</a>
                @endif
                @if (Auth::user()->administrador == 1)
                <a href="{{ route('candidatos') }}" class="list-group-item list-group-item-action bg-info text-white"><i class="fas fa-address-card"></i> Candidatos</a>
                <a href="{{ route('usuarios') }}" class="list-group-item list-group-item-action bg-info text-white"><i class="fas fa-users"></i> Usuários</a>
                @endif
                <a href="{{ route('resultado') }}" class="list-group-item list-group-item-action bg-info text-white"><i class="fas fa-chart-bar"></i> Resultado</a>

            </div>
        </div>
        @endauth
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-success">
                @auth
                <button class="btn btn-light" id="menu-toggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endauth
                <button class="navbar-toggler bg-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <i class="fas fa-user"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Sair') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>