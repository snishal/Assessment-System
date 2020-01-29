<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/semantic.min.js') }}" defer></script>
    <script src="{{ asset('js/user.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title', 'Dashboard')</title>
</head>
<body>

    <div class="ui secondary huge pointing menu">
        <div class="ui container">
            <div class="item header">
                {{ config('app.name', 'Laravel')}}
            </div>
            <a class="item {{ Request::is('user') ? 'active' : '' }}" href="/user">
                Home
            </a>
            <div class="right menu">
                <a class="ui item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    @yield('content')

</body>
@yield('scripts')
</html>
