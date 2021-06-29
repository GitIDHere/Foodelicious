@extends('master')

@section('content')

    <div class="recipe-post-area">

        @if (isset($recipe['is_preview']) && $recipe['is_preview'])
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="preview-banner">This is a preview of your recipe</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- recipe Slider -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="recipe-slider owl-carousel">
                        @foreach($recipe['photos'] as $photo)
                            <img src="{{$photo}}" class="mx-auto" style="width: 680px;" alt="">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- recipe Content Area -->
        <div class="recipe-content-area">
            <div class="container">

                <div class="row">

                    <div class="mt-4 recipe-headline col-12">
                        <span>{{date('F j, Y', strtotime($recipe['date_created']))}}</span>
                        <h1 class="col-8 pl-0 pr-0">{{$recipe['title']}}</h1>
                    </div>

                    <div class="col-8">
                        <div class="recipe-headline my-5">
                            <div class="recipe-duration">
                                <h6>Cook: {{$recipe['cook_time']}}</h6>
                                <h6>Yields: {{$recipe['servings']}} Servings</h6>
                            </div>
                            <div class="recipe-description">
                                {!! $recipe['description'] !!}
                            </div>
                        </div>
                    </div>

                    @if((isset($recipe['is_preview']) && $recipe['is_preview']) || $recipe['is_published'])

                        <div class="col-4">

                            <div class="col-9 pr-0 pl-0 d-inline-block">
                                <div class="profile-pic">
                                    <a href="{{route('user.profile.public.recipe_list', ['username' => $recipe['user']['username']])}}">
                                        <img src="{{ $recipe['user']['profile_pic'] ?? '/img/core-img/profile_pic_default.png' }}"
                                             class=" " alt="profile picture" />
                                    </a>
                                    <a href="{{route('user.profile.public.recipe_list', ['username' => $recipe['user']['username']])}}">
                                        <span>{{$recipe['user']['username']}}</span>
                                    </a>
                                </div>
                            </div>

                            <div class="recipe-favourites col-2 pr-0 pl-0 text-right d-inline-block">
                                <div class="favourites">
                                    <form>
                                        <input type="checkbox" data-recipe="{{$recipe['id']}}" id="toggle-heart"
                                               @if ($recipe['is_favourited'])
                                                class="checked" checked=checked
                                               @endif
                                        />
                                        <label for="toggle-heart" aria-label="favourite">❤</label>
                                    </form>
                                    <span class="favourite">{{$recipe['favourites']}}</span>
                                </div>
                            </div>




                        </div>


                    @endif
                </div>

                <div class="row recipe-info-container mb-5">

                    <div class="col-12 col-lg-8 prep-directions">
                        <h2>Cooking steps</h2>
                        @foreach ($recipe['cooking_steps'] as $index => $cookingStep)
                            <div class="single-preparation-step d-flex">
                                <h3>{{sprintf('%02d', $index)}}.</h3>
                                {!! $cookingStep !!}
                            </div>
                        @endforeach
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4 ingredient-list">
                        <div class="ingredients">
                            <h2>Ingredients</h2>
                            @foreach ($recipe['ingredients'] as $index => $ingredient)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{'ingredientCB'.$index}}">
                                    <label class="custom-control-label" for="{{'ingredientCB'.$index}}">{{$ingredient}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                @auth()

                    @if ((isset($recipe['is_preview']) && $recipe['is_preview']) || ($recipe['is_published'] && $recipe['enable_comments']))

                        @include('screens.recipe._comments')

                        <div class="row pb-5">

                        @if ($comments['has_commented'] == false)

                            <div class="col-12">
                                <div class="section-heading text-left">
                                    <h3>Leave a comment</h3>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="contact-form-area">

                                    <form action="#" method="post" id="recipe-comment" data-recipe="{{$recipe['id']}}">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="comment" class="form-control" id="comment" cols="30" rows="10" placeholder="Comment"></textarea>
                                                <div class="word_counter" data-link="comment" data-char-limit="500"></div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn delicious-btn mt-30 right" type="submit">Post Comments</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        @else
                            <div class="col-12">
                                <div class="warning">
                                    <p>You have already commented</p>
                                </div>
                            </div>
                        @endif
                        </div>

                    @endif
                @endauth

                @guest
                    <div class="col-12 mb-5 clearfix">
                        <a class="btn-small" href="{{route('login.show')}}">Login to comment</a>
                    </div>
                @endguest
            </div>

        </div>

    </div>

    @include("theme._instagram_feed")

@endsection
