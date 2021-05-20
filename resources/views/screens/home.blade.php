@extends('master')

@section('content')
    @auth
        <br/>
        <br/>
        <br/>
        <br/>
        <a href="{{route('user.recipes.create.view')}}">Add recipes</a>    
    @endauth
    
@endsection
