@extends('master')

@section('content')
    
    <ul>
    @foreach($recipes as $recipe)
        <li>
            <a href="{{$recipe->id}}">{{$recipe->title}}</a>
        </li>
    @endforeach
    </ul>
@endsection