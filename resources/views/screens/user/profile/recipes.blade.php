@extends('master')

@section('content')
    <div class="container">

        <div class="row">

            <div class="col-lg-12 col-md-8 pl-md-0">

                <div class="container">

                    <div class="row">

                        <div class="pt-3 pb-3 bg-grey col-12">

                            {{ Breadcrumbs::render('user_public_recipes', $username)}}




                            <div class="row display-profile-info">

                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <img
                                        class="d-sm-block d-xs-block mx-sm-auto mx-xs-auto {{$profile['img'] ?: 'green-circle' }}"
                                        id="profile_pic" src="{{$profile['img'] ?: '/img/core-img/profile_pic_default.png'}}" alt="profile picture" />
                                </div>

                                <div class="col-lg-9 col-md-8">
                                    <p class="desc-long d-none d-lg-block">{{ $profile['description'] ?? '' }}</p>
                                    <p class="desc-short d-none d-lg-none d-md-block">Short {{ $profile['short_description'] ?? '' }}</p>
                                </div>

                            </div>


                            <div class="container">

                                @if ($recipeList->isNotEmpty())
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="recipe-list">
                                                @foreach($recipeList as $recipe)
                                                    <li>
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
                                                    </li>
                                                @endforeach
                                            </ul>
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
@endsection
