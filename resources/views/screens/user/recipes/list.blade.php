@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk pt-4 pb-4">

                    @include('screens.user.partials._side_bar')
                    
                    <div class="col-12 col-lg-8">
                        <h1 class="mt-0">My Recipes</h1>
                        
                        <!-- TODO Quick search -->
                        
                        <ul class="recipe-list">
                            @foreach($recipes as $recipe)
                                <li>
                                    <a href="{{$recipe['id']}}">
                                        <div class="thumbnail"></div>
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
                    </div>
                    
                </div>
            </div>
        </div>
    @endauth
@endsection