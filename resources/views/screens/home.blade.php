@extends('master')

@section('content')

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

    <div class="container pt-5 pb-5">

        <div class="row">

            <section class="recipe-list-block col-4">
                <h2>Recent</h2>
                <ul>
                    @foreach($homeData['recent_recipes'] as $recentRecipes)
                        <li class="recipe-block">
                            <a href="{{route('recipe.show', ['recipe' => $recentRecipes['recipe_id'], 'recipe_title' => $recentRecipes['title']])}}">
                                <img src="{{$recentRecipes['thumbnail']}}" alt="{{$recentRecipes['title']}}" /></a><div class="info-block">
                                <a href="{{route('recipe.show', ['recipe' => $recentRecipes['recipe_id'], 'recipe_title' => $recentRecipes['title']])}}">
                                    <h3 class="mt-0">{{$recentRecipes['title']}}</h3>
                                </a>
                                <p>{{$recentRecipes['username']}}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="recipe-list-block col-4">
                <h2>Top commented</h2>
                <ul>
                    @foreach($homeData['most_commented'] as $mostCommented)
                        <li class="recipe-block">
                            <a href="{{route('recipe.show', ['recipe' => $mostCommented['recipe_id'], 'recipe_title' => $mostCommented['title']])}}">
                                <img src="{{$mostCommented['thumbnail']}}" alt="{{$mostCommented['title']}}" /></a><div class="info-block">
                                <a href="{{route('recipe.show', ['recipe' => $mostCommented['recipe_id'], 'recipe_title' => $mostCommented['title']])}}">
                                    <h3 class="mt-0">{{$mostCommented['title']}}</h3>
                                </a>
                                <p>{{$mostCommented['username']}}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>


            <section class="recipe-list-block col-4">
                <h2>Top favourited</h2>
                <ul>
                    @foreach($homeData['most_favourited'] as $mostFavourited)
                        <li class="recipe-block">
                            <a href="{{route('recipe.show', ['recipe' => $mostFavourited['recipe_id'], 'recipe_title' => $mostFavourited['title']])}}">
                                <img src="{{$mostFavourited['thumbnail']}}" alt="{{$mostFavourited['title']}}" /></a><div class="info-block">
                                <a href="{{route('recipe.show', ['recipe' => $mostFavourited['recipe_id'], 'recipe_title' => $mostFavourited['title']])}}">
                                    <h3 class="mt-0">{{$mostFavourited['title']}}</h3>
                                </a>
                                <p>{{$mostFavourited['username']}}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>

        </div>

    </div>
    <!-- Most recent -->

    <!-- Most favourited this week -->

    <!-- Most commented today -->

    @include("theme._instagram_feed")

@endsection
