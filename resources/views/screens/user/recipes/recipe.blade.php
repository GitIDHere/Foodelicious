@extends('master')

@section('page_scripts')
    <script src="{{mix('js/recipe_tags.js')}}"></script>
    <script src="{{mix('js/recipe_cooking_steps.js')}}"></script>
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
                @if(isset($data))
                    @foreach($data['cooking_steps'] as $index => $cookingStep)
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
        
        <input id="recipe-cook_time" type="text" name="cook_time" placeholder="Cook time" value="{{ ($data['cook_time'] ?? '') }}" />
        <br/><br/>
        
        <input id="recipe-servings" type="text" name="servings" placeholder="Servings" value="{{ ($data['servings'] ?? '') }}" />
        <br/><br/>

        <input id="recipe-utensils" type="text" name="utensils" placeholder="Utensils" value="{{ ($data['utensils'] ?? '') }}" />
        <br/><br/>

        <input id="recipe-prep" type="text" name="prep_directions" placeholder="Preparations" value="{{ ($data['preparations'] ?? '') }}" />
        <br/><br/>
        
        <input id="recipe-ingredients" name="ingredients" class="some_class_name" placeholder="Ingredients" value="{{ ($data['ingredients'] ?? '') }}">
        <br/><br/>
        
        <input id="recipe-photos" type="file" name="photos[]" multiple="multiple" accept=".jpg,.png,.jpeg"/>
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
        
        <pre>{"1": "Expedita explicabo consectetur rerum iure consectetur expedita cumque.", "2": "Dolorem dolorem vero quo aut perspiciatis.", "3": "Suscipit mollitia quo sed porro perspiciatis earum.", "4": "Consequatur est consequatur cupiditate architecto expedita.", "5": "Magni ea libero sint beatae."}</pre>
        
        <input type="submit" />
        
    </form>
    
@endsection
