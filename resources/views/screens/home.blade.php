@extends('master')

@section('content')
    
    <a href="{{route('register.show')}}">Register</a>
    
    <a href="{{route('login.show')}}">Login</a>
    
    <a href="{{route('logout')}}">Logout</a>
    
    <a href="{{route('password_reset.show')}}">Reset password</a>
    
@endsection
