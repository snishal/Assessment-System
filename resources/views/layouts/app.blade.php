<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/semantic.min.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <div class="ui secondary huge pointing menu">
        <div class="ui container">
            <a class="header item" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            @if (Route::has('login'))
                <div class="right menu">
                    @guest
                        <a class="ui item" href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a class="ui item" href="{{ route('register') }}">Register</a>
                        @endif
                    @else
                        <div class="header">
                            {{ Auth::user()->name }}
                        </div>
                        <a class="ui item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            @endif
        </div>
    </div>

    @yield('content')

</body>
</html>
