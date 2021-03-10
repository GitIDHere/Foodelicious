@extends('master')

@section('content')

    
<div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(/img/bg-img/breadcumb3.jpg);">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-0 mb-0 mb-4 mb-lg-0">Login</h1>
            </div>
        </div>
        
        <div class="row">
            
            <div class="col-lg-6 col-md-12"><<!-- TODO ---></div>
            
            <div class="col-lg-6 col-md-12">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form class="white-bk p-4" method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input id="email" type="text" class="form-control" name="email" value="{{old('email')}}" />
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" />
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
