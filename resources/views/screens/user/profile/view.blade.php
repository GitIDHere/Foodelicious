@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk pt-4 pb-4">
                    @include('screens.user.partials._side_bar')
                    <div class="col-12 col-lg-8">
                        
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="container pl-0 pr-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="new-rec btn btn-md mb-3" href="{{route('user.recipes.create.view')}}">
                                            New Recipe
                                            <i class="fa fa-plus" ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="search-box container pl-0 pr-0">
                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{route('user.recipes.search.submit')}}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            <input type="search" name="search_term" placeholder="Search your recipes" value="{{ isset($searchTerm) ? $searchTerm : ''}}">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if ($recipes->isNotEmpty())
                                <ul class="recipe-list">
                                    @foreach($recipes as $recipe)
                                        <li>
                                            <a href="{{route('user.recipes.view', ['recipe' => $recipe['id']])}}">
                                                <img src="{{$recipe['thumbnail']}}"  class="thumbnail" />
                                                <span class="title">{{$recipe['title']}}</span>

                                                <span class="icon-list">
                                            <span class="icon-container">
                                                <span class="icon">&nbsp;</span>
                                                <span class="text">{{$recipe['total_favourites']}}</span>
                                            </span>
                                        </span>

                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{ $pager->links('includes.pagination') }}
                            @else
                                <div class="container">
                                    <div class="row">
                                        <h5 class="mx-auto mt-4 mb-4">No recipes found. <a href="{{route('user.recipes.create.view')}}">Add new recipes!</a></h5>
                                    </div>
                                </div>
                            @endif
                        </div>

                </div>
            </div>
        </div>
    @endauth
@endsection
