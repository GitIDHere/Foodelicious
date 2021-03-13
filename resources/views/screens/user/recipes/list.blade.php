@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk">

                    @include('screens.user.partials._side_bar')
                    
                    <div class="col-12 col-lg-8">
                        <h1>My Recipes</h1>
                        
                        <ul class="recipe-list">
                            @foreach($recipes as $recipe)
                                <li>
                                    <a href="{{$recipe->id}}">{{$recipe->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    @endauth
@endsection