@extends('master')

@section('content')
    
    <a href="{{route('register.show')}}">Register</a>
    
    <a href="{{route('login.show')}}">Login</a>
    
    <a href="{{route('logout')}}">Logout</a>
    
@endsection
