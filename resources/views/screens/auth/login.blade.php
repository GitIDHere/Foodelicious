@extends('master')

@section('content')
    <h1>Login</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('login.submit')  }}">
        @csrf
        
        <label for="email">Email</label>
        <input id="email" type="text" name="email" />
        <br/><br/>
        
        <label for="password">Password</label>
        <input id="password" type="password" name="password" />
        <br/><br/>
        
        <label for="remember_me">Remember me</label>
        <input id="remember_me" type="checkbox" name="remember_me" value="true" />
        <br/><br/>
        
        <input type="submit" />
        
    </form>
    
@endsection
