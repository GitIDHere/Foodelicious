@extends('master')

@section('page_scripts')
    <script src="{{mix('js/recipe.js')}}"></script>
{{--    <script src="{{mix('js/recipe_tags.js')}}"></script>--}}
{{--    <script src="{{mix('js/recipe_cooking_steps.js')}}"></script>--}}
{{--    <script src="{{mix('js/recipe_cook_times.js')}}"></script>--}}
{{--    <script src="{{mix('js/recipe_photos.js')}}"></script>--}}
@endsection

@section('content')
    
    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ (isset($data) ? route('user.recipes.save.submit', ['recipe' => $recipe]) : route('user.recipes.create.submit') ) }}" enctype="multipart/form-data">
        @csrf
        
        <input id="recipe-title" type="text" name="title" placeholder="Title" value="{{ ($data['title'] ?? '')  }}" />
        <br/><br/>
        
        <label for="recipe-desc">Description</label>
        <textarea id="recipe-desc" name="description">{{ ($data['description'] ?? '')  }}</textarea>
        <br/><br/>
                
        <div class="cooking-steps-container">
            <div class="cooking-steps-list">
                @if(isset($data) || !empty(old('cooking_steps')))
                    @php
                    $cookingSteps = !empty(old('cooking_steps')) ? old('cooking_steps') : $data['cooking_steps'];
                    @endphp
                    @foreach($cookingSteps as $index => $cookingStep)
                        <div data-cooking-step="{{$index+1}}" class="cooking-step-container">
                            <textarea name="cooking_steps[]">{{ $cookingStep }}</textarea>
                            <div class="button-container">
                                <a data-cooking-step="{{$index+1}}" href="#" class="delete-cooking-step btn btn-delete">Delete step</a>
                                <a href="#" class="btn-move-up btn">Move up</a>
                                <a href="#" class="btn-move-down btn">Move down</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <a href="#" class="cooking-steps-new-btn" role="button">Add a step</a>
        </div>
        <br/><br/>

        <input type="number" name="cook_time_hours" class="cook-time-hours" placeholder="HH" min="0" max="15" value="{{ ($data['cook_time_hours'] ?? '') }}" />
        <input type="number" name="cook_time_minutes" class="cook-time-minutes"  placeholder="MM" min="1" max="59" value="{{ ($data['cook_time_minutes'] ?? '') }}" />
        
        <br/><br/>
        
        <input id="recipe-servings" type="text" name="servings" placeholder="Servings" value="{{ ($data['servings'] ?? '') }}" />
        <br/><br/>

        @php 
            $utensils = old('utensils');
            if (empty(old('utensils')) && isset($data)) {
                $utensils = $data['utensils'];
            }
        @endphp
        <input id="recipe-utensils" type="text" name="utensils" placeholder="Utensils" value="{{ ($utensils ?? '') }}" />
        <br/><br/>

{{--        <input id="recipe-prep" type="text" name="prep_directions" placeholder="Preparations" value="{{ ($data['preparations'] ?? '') }}" />--}}
        <textarea id="recipe-prep" name="prep_directions" placeholder="Prep">{{ ($data['preparations'] ?? '') }}</textarea>
        <br/><br/>
        
        @php
            $ingredients = old('ingredients');
            if (empty(old('ingredients')) && isset($data)) {
                $ingredients = $data['ingredients'];
            }
        @endphp
        <input id="recipe-ingredients" name="ingredients" class="some_class_name" placeholder="Ingredients" value="{{ ($ingredients ?? '') }}">
        <br/><br/>
        <br/><br/>
        
        @if (isset($data))
            <ul>
            @foreach($data['photos'] as $photo)
                <li>
                    <img alt="{{ $photo['alt']  }}" src="{{ $photo['uri'] }}" />
                    <a href="#" class="photo-delete" data-photo="{{$photo['id']}}" >Delete</a>
                </li>
            @endforeach
            </ul>
        @endif
        
        <input id="recipe-photos" type="file" name="photos[]" multiple="multiple" accept=".jpg,.png,.jpeg"/>
        
        <div class="deleted-photos"></div>
        
        <br/><br/>
        
        <label for="visibility">Recipe visibility</label>
        <select name="visibility">
            @if(isset($data))
                <option {{ ($data['visibility'] == 'public' ? 'selected' : '') }} value="public">Public</option>
                <option  {{ ($data['visibility'] == 'private' ? 'selected' : '') }} value="private">Private</option>
            @else
                <option value="public">Public</option>
                <option value="private">Private</option>
            @endif
        </select>
        <br/><br/>
        
        <input type="submit" value="Submit" />
        
    </form>
    
@endsection
