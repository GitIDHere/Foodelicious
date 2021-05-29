@extends('master')

@section('content')

<div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(/img/bg-img/hero/hero3.jpg);" >
    <div class="container">

        <div class="row">

            <div class="white-box mx-auto col-lg-6 col-md-12">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="white-bk auth p-4" method="POST" action="{{ route('register.submit') }}">
                    @csrf

                    <h1 class="mt-0 mb-4">Register</h1>

                    <div class="mb-3">
                        <label for="username" class="required">Username</label>
                        <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ randUsername() }}" >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="required">Email</label>
                        <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" value="{{ randEmail() }}" >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="required">Password</label>
                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="required">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation ') is-invalid @enderror">
                    </div>

                    <div class="form-checkbox">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="remember_me" class="custom-control-input" name="remember_me" value="1" />
                            <label class="custom-control-label pt-0" for="remember_me">
                                <span class="d-block">Remember me</span>
                                <small>(not recommended on public or shared computers)</small>
                            </label>
                        </div>
                    </div>

                    <input class="btn delicious-btn btn-5 mb-3 right" type="submit" value="Submit" />
                    <div class="clear"></div>

                    <hr/>

                    <div>
                        <a class="link" href="{{route('forgot_password.show')}}">Forgot your password?</a>
                        <a class="link pull-right" href="{{route('login.show')}}">Login</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>











@endsection


