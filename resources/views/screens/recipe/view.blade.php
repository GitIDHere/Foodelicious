@extends('master')

@section('content')

    <div class="recipe-post-area">

        <!-- recipe Slider -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="recipe-slider owl-carousel">
                        @foreach($recipe['photos'] as $photo)
                            <img src="{{$photo}}" alt="">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- recipe Content Area -->
        <div class="recipe-content-area">
            <div class="container">

                <div class="row">

                    <div class="col-10">
                        <div class="recipe-headline my-5">
                            <span>{{date('F j, Y', strtotime($recipe['date_created']))}}</span>
                            <h2>{{$recipe['title']}}</h2>
                            <div class="recipe-duration">
                                <h6>Cook: {{$recipe['cook_time']}}</h6>
                                <h6>Yields: {{$recipe['servings']}} Servings</h6>
                            </div>
                            <div class="recipe-description">
                                {!! $recipe['description'] !!}
                            </div>
                        </div>
                    </div>

                    @if($recipe['is_published'])
                        <!-- FAVOURITING --->
                        <div class="col-2">
                            <div class="recipe-favourites text-right my-5">
                                <div class="favourites">
                                    <form>
                                        <input type="checkbox" data-recipe="{{$recipe['id']}}" id="toggle-heart" {{$recipe['is_favourited'] ? 'checked' : ''}} />
                                        <label for="toggle-heart" aria-label="favourite">❤</label>
                                    </form>
                                    <span class="favourite">{{$recipe['favourites']}}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row recipe-info-container">

                    <div class="col-12 col-lg-8 prep-directions">
                        @foreach ($recipe['cooking_steps'] as $index => $cookingStep)
                            <div class="single-preparation-step d-flex">
                                <h4>{{sprintf('%02d', $index)}}.</h4>
                                {!! $cookingStep !!}
                            </div>
                        @endforeach
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4 ingredient-list">
                        <div class="ingredients">
                            <h4>Ingredients</h4>
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
                    @if($recipe['is_published'])
                        <div class="row pb-5">

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

                        </div>
                        @endif
                @endauth
            </div>

        </div>

    </div>

    @include("theme._instagram_feed")

@endsection
