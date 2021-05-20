@extends('master')

@section('content')

<div class="pt-5 pb-5" >
    
    <div class="container">
        
        <div class="row">
            
            <div class="mx-auto col-lg-6 col-md-12">
                
                <form class="white-bk auth p-4" method="POST" action="{{route('forgot_password.submit')}}">
                    @csrf
                    
                    <h1 class="mt-0 mb-4">Password Reset</h1>

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
                        <label class="required" for="email">Email</label>
                        <input id="email" type="text" class="form-control" name="email" value="{{old('email')}}" />
                    </div>

                    <input class="btn delicious-btn btn-5 mb-3" type="submit" value="Submit" />
                    
                    <hr/>
                    
                    <div>
                        <a class="link" href="{{route('login.show')}}">Login</a>
                       <a class="link pull-right" href="{{route('register.show')}}">Register</a>
                    </div>

                </form>
                
            </div>
            
        </div>
        
    </div>
    
</div>
    
@endsection
