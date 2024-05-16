<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Hub') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="icon" href="\img\random-logo.svg">

    <!-- Styles -->
    @yield('styles')
    <link href="{{ asset('css/app.css?v=' . config('app.version')) }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-custom navbar-light navbar-laravel">
            <div class="container-fluid">
                @guest
                    <a href="/" class="text-decoration-none">
                        <div class="logo">UserHub</div>
                    </a>
                @else
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-flex align-items-center">
                            <a href="/" class="text-decoration-none">
                                <div class="logo">UserHub</div>
                            </a>
                            @if(auth()->user()->is_admin)
                                <div class="ms-5">
                                    <ul class="navbar-nav mr-auto fw-semibold d-flex flex-row align-items-center gap-3">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.users.page') }}">Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.users.generate.page') }}">Users Generation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('profile') }}">Personal Details</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                            <div class="ms-5">
                                <ul class="navbar-nav mr-auto fw-semibold d-flex flex-row align-items-center gap-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile') }}">Personal Details</a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </nav>
        @yield('content')
    </div>
    <form id="logout-form" action="/logout" method="POST">
        @csrf
    </form>

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('js')
</body>

</html>