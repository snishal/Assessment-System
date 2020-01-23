<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/semantic.min.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">

    <title>@section('title', 'Admin')</title>
</head>
<body>

    <div class="ui secondary huge pointing menu">
        <a class="item {{ Request::is('admin') ? 'active' : '' }}" href="/admin">
            Home
        </a>
        <a class="item {{ Request::is('admin/tests*') ? 'active' : '' }}" href="/admin/tests">
            Tests
        </a>
        <a class="item {{ Request::is('admin/mcqs*') ? 'active' : '' }}" href="/admin/mcqs">
            MCQs'
        </a>
        <div class="right menu">
            <div class="item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="ui button" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    @yield('main')

</body>
</html>
