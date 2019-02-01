<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<header class="over-hide">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a href="/" class="navbar-item">
                    <img src="images/twitter.png">
                </a>

                <a href="/" role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                   data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-end">
                    @guest
                        <div class="navbar-item">
                            <div class="buttons">
                                <a href="{{ route('login') }}" class="button is-light">
                                    {{ __('Login') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="button background-color-primary has-text-white">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="navbar-item">
                            <div class="buttons">
                                <a href="#">
                                    {{ Auth::user()->name }}
                                </a>
                                <a class="button background-color-primary has-text-white"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest

                </div>
            </div>
        </div>
    </nav>
</header>
<div id="app">
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
