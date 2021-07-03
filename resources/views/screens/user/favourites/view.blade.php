@extends('master')

@section('content')
    @auth
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-4 mb-4 pr-md-0">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-lg-9 col-md-8 pl-md-0">

                    <div class="container">

                        <div class="row">

                            <div class="pt-3 pb-3 bg-grey col-12">

                                {{ Breadcrumbs::render('favourite_recipes') }}

                                <div class="container">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="search-box">
                                                <form action="{{route('user.recipe.favourites.search.submit')}}" method="POST">
                                                    @csrf
                                                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    <input type="search" name="search_term" placeholder="Search your favourite recipes" value="{{ isset($searchTerm) ? $searchTerm : ''}}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($favouriteList->isNotEmpty())
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="recipe-list">
                                                    @foreach($favouriteList as $recipe)
                                                        <div class="content-container">
                                                            <a href="{{route('recipe.show', ['recipe' => $recipe['id'], 'recipe_title' => $recipe['title_url_formatted']])}}">
                                                                <img src="{{$recipe['thumbnail']}}"  class="thumbnail"  alt="{{$recipe['title']}}"/>
                                                            </a>

                                                            <div class="recipe-info">

                                                                <a href="{{route('recipe.show', ['recipe' => $recipe['id'], 'recipe_title' => $recipe['title_url_formatted']])}}">
                                                                    <span class="title">{{$recipe['title']}}</span>
                                                                </a>

                                                                <span class="icons">
                                                                    <span class="icon heart">
                                                                        <span class="text">{{$recipe['total_favourites']}}</span>
                                                                    </span>

                                                                    <span class="icon comment">
                                                                        <span class="text">{{$recipe['total_comments']}}</span>
                                                                    </span>
                                                                </span>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                {{ $favouriteListPager->links('includes.pagination') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="row col-12">
                                            @if (\Illuminate\Support\Str::contains(url()->current(), 'search'))
                                                <h5 class="mx-auto mt-4 mb-4">No recipes found</h5>
                                            @else
                                                <h5 class="mx-auto mt-4 mb-4">No favourites yet!</h5>
                                            @endif
                                        </div>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endauth
@endsection
