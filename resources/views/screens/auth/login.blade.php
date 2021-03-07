@extends('master')

@section('content')

    
    <div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <h1 class="mt-0 mb-0">Login</h1>
                </div>

                <div class="col-lg-6">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form class="login" method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input id="email" type="text" class="form-control" name="email" />
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password" />
                        </div>

                        <div class="form-checkbox">
                            <!-- Custom Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="remember_me" class="custom-control-input" name="remember_me" value="true" />
                                <label class="custom-control-label pt-0" for="remember_me">
                                    <div>Remember me</div>
                                    <small>(not recommended on public or shared computers)</small>
                                </label>
                            </div>
                        </div>

                        <input class="btn delicious-btn btn-5 mb-3" type="submit" />

                        <div>
                            <a class="link" href="{{route('forgot_password.show')}}">Forgot your password?</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
