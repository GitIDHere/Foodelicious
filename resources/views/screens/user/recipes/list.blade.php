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

                                {{ Breadcrumbs::render('recipes_list') }}

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="container">

                                    <div class="row">
                                        <div class="col-12 mt-4">
                                            <a class="btn-small mb-3 right" href="{{route('user.recipes.create.view')}}">New Recipe</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="search-box">
                                                <form action="{{route('user.recipes.search.submit')}}" method="POST">
                                                    @csrf
                                                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    <input type="search" name="search_term" placeholder="Search your recipes" value="{{ isset($searchTerm) ? $searchTerm : ''}}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($recipeList->isNotEmpty())
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="recipe-list">
                                                    @foreach($recipeList as $recipe)
                                                        <div class="content-container">
                                                            <a href="{{route('user.recipes.view', ['recipe' => $recipe['id']])}}">
                                                                <img src="{{$recipe['thumbnail']}}"  class="thumbnail"  alt="{{$recipe['title']}}"/>
                                                            </a>

                                                            <div class="recipe-info">

                                                                <a href="{{route('user.recipes.view', ['recipe' => $recipe['id']])}}">
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
                                                {{ $recipeListPager->links('includes.pagination') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="row col-12">
                                            <h5 class="mx-auto mt-4 mb-4">No recipes found</h5>
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
