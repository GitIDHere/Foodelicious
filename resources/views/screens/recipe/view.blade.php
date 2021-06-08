@extends('master')

@section('page_scripts')

@endsection

@section('content')

    <div class="recipe-post-area section-padding-0-80">

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

                    <div class="col-12 col-md-8">
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

                    <!-- RATING --->
                    <div class="col-12 col-md-4">
                        <div class="recipe-ratings text-right my-5">
                            <div class="ratings">
                                <i class="fa fa-heart" aria-hidden="true"> {{$recipe['ratings']}}</i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        @foreach ($recipe['cooking_steps'] as $index => $cookingStep)
                            <div class="single-preparation-step d-flex">
                                <h4>{{sprintf('%02d', $index)}}.</h4>
                                {!! $cookingStep !!}
                            </div>
                        @endforeach
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4">
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

                <div class="row">
                    <div class="col-12">
                        <div class="section-heading text-left">
                            <h3>Leave a comment</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="contact-form-area">
                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="email" class="form-control" id="email" placeholder="E-mail">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn delicious-btn mt-30" type="submit">Post Comments</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    @include("theme._instagram_feed")

@endsection
