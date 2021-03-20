@extends('master')

@section('page_scripts')
    <script src="{{mix('js/recipe.js')}}"></script>
    {{--    <script src="{{mix('js/recipe_tags.js')}}"></script>--}}
    {{--    <script src="{{mix('js/recipe_cooking_steps.js')}}"></script>--}}
    {{--    <script src="{{mix('js/recipe_cook_times.js')}}"></script>--}}
    {{--    <script src="{{mix('js/recipe_photos.js')}}"></script>--}}
@endsection

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk pt-4 pb-4">

                    @include('screens.user.partials._side_bar')
                    
                    <div class="col-12 col-lg-9 pl-3">
                        <h1 class="mt-0">New Recipe</h1>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form 
                                method="POST" 
                                action="{{ (isset($data) ? route('user.recipes.save.submit', ['recipe' => $recipe]) : route('user.recipes.create.submit') ) }}" 
                                enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="recipe-title" class="required">Title</label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    class="form-control" 
                                    id="recipe-title" 
                                    value="{{ ($data['title'] ?? '')  }}" 
                                />
                            </div>
                            
                            <div class="mb-3">
                                <label for="recipe-desc" class="required">Description</label>
                                <textarea
                                        name="description"
                                        id="recipe-desc"
                                        class="form-control txt-area">{{ ($data['description'] ?? '')  }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="">Cook time</label>
                                <div class="container">
                                    <div class="row">
                                        <div>
                                            <label for="cook_time_hours" class="required">Hours</label>
                                            <input
                                                type="number"
                                                name="cook_time_hours"
                                                id="cook_time_hours"
                                                class="form-control mr-3 num-counter cook-time-hours"
                                                placeholder="HH"
                                                min="0" max="15"
                                                value="{{ ($data['cook_time_hours'] ?? '') }}"
                                            />    
                                        </div>
                                        <div>
                                            <label for="cook_time_minutes" class="required">Minutes</label>
                                            <input
                                                type="number"
                                                id="cook_time_minutes"
                                                name="cook_time_minutes"
                                                class="form-control num-counter cook-time-minutes"
                                                placeholder="MM"
                                                min="0" max="59"
                                                value="{{ ($data['cook_time_minutes'] ?? '') }}"
                                            />
                                        </div>
                                </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="recipe-servings" class="required">Servings</label>
                                <input
                                    type="number"
                                    id="recipe-servings"
                                    name="servings"
                                    class="form-control num-counter"
                                    min="1" max="60"
                                    value="{{ ($data['servings'] ?? '1') }}"
                                />                                
                            </div>

                            <div class="mb-3">
                                <label for="recipe-prep" class="required">Preparation</label>
                                <textarea  name="prep_directions"  id="recipe-prep"  class="form-control txt-area">{{ ($data['preparations'] ?? '')  }}</textarea>
                            </div>

                            
                            COOKING STEPS - ACORDIAN


                            @php
                                $utensils = old('utensils');
                                if (empty(old('utensils')) && isset($data)) {
                                    $utensils = $data['utensils'];
                                }
                            @endphp
                            <div class="mb-3">
                                <label for="recipe-utensils" class="required">Utensils</label>
                                <input
                                    type="text"
                                    name="utensils"
                                    id="recipe-utensils"
                                    class="form-control tagify--outside tags-container"
                                    value="{{ ($utensils ?? 'Spoon,Bowl') }}" 
                                />
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        </form>
                        

                    </div>
                    
                </div>
            </div>
        </div>
    @endauth
@endsection