@extends('master')

@section('content')
    @auth
        <a href="{{route('user.recipes.create.view')}}">Add recipes</a>
    @endauth

    <div class="container-fluid p-0">

        <div class="row m-0">

            <div class="home-hero p-0 col-12">

                <div class="titles-container my-auto">
                    <h1>Foodelicious</h1>
                    <h2>World of taste</h2>
                </div>

                <video autoplay loop muted preload="auto" class="">
                    <source src="/vid/banner/home_hero.mp4" type="video/mp4">
                    <source src="/vid/banner/home_hero.webm" type="video/mp4">
                    <p>Your browser doesn't support HTML5 video. Here is a <a href="/vid/banner/home_hero.mp4">link to the video</a> instead.</p>
                </video>

            </div>

        </div>

    </div>

    <!-- Most recent -->

    <!-- Most favourited this week -->

    <!-- Most commented today -->

    @include("theme._instagram_feed")

@endsection
