@extends('layouts.app')

@section('content')

<div class="ui container">
    <div class="ui raised centered card">
        <div class="content">
            <div class="header">
                <h3 class="ui block center aligned header">
                    LogIn to Continue
                </h3>
            </div>
            <div class="description">
                <form class="ui form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label>Email</label>
                        <input type="text" name="email" placeholder="eg: johndoe@gmail.com">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password">
                    </div>
                    <div class="field">
                        <div class="ui checkbox">
                          <input type="checkbox" name="remember" tabindex="0" class="hidden">
                          <label>Remember Me</label>
                        </div>
                    </div>
                    <button class="ui positive button" type="submit">Login</button>
                    <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
