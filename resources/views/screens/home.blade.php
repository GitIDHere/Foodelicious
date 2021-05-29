@extends('master')

@section('content')
    @auth
        <a href="{{route('user.recipes.create.view')}}">Add recipes</a>
    @endauth

    <!-- Most recent -->

    <!-- Most favourited this week -->

    <!-- Most commented today -->

    @include("theme._instagram_feed")

@endsection
