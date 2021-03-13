@extends('master')

@section('content')
    
<div class="pt-5 pb-5" >
    <div class="container">
        
        <div class="row">
            
            <div class="mx-auto col-lg-6 col-md-12">
                
                <form class="white-bk auth p-4" method="POST" action="{{route('password_reset.submit')}}">
                    @csrf

                    <input id="email" name="email" type="hidden" value="{{$email}}"/>
                    <input id="token" name="token" type="hidden" value="{{$token}}"/>
                    
                    <h1 class="mt-0 mb-4">Reset Password</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="password" class="required">New password</label>
                        <input id="password" name="password" type="password" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation">Confirm new password</label>
                        <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" />
                    </div>
                    
                    <input class="btn delicious-btn btn-5 mb-3" type="submit" />
                    
                    <hr/>
                    
                    <div>
                        <a class="link" href="{{route('login.show')}}">Login?</a>
                       <a class="link pull-right" href="{{route('register.show')}}">Register</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
