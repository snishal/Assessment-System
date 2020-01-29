<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}" defer></script>
    <script src="{{ asset('js/semantic.min.js') }}" defer></script>

    <!-- Styles -->
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
                    @auth
                        <a class="ui item" href="{{ url('/home') }}">Home</a>
                    @else
                        <a class="ui item" href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a class="ui item" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <div class="ui container placeholder">
        @for ($i = 1; $i < 30; $i++)
            <div class="image header">
                <div class="line"></div>
                <div class="line"></div>
            </div>
        @endfor
    </div>

</body>
@yield('scripts')
</html>
