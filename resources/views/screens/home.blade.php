@extends('master')

@section('content')
    
    <a href="{{route('register.show')}}">Register</a>
    
    <a href="{{route('login.show')}}">Login</a>
    
    <a href="{{route('logout')}}">Logout</a>
    
    <a href="{{route('forgot_password.show')}}">Forgot password</a>
    
    @auth
        <br/>
        <br/>
        <br/>
        <br/>
        <a href="{{route('user.recipe.new')}}">Add recipes</a>    
        <a href="{{route('user.recipe.list')}}">My recipes</a>    
    @endauth
    
@endsection
