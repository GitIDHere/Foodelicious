@extends('master')

@section('page_scripts')
    <script src="{{mix('js/recipe_tags.js')}}"></script>
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
    
    <form method="POST" action="{{ route('user.recipe.new.submit') }}" enctype="multipart/form-data">
        @csrf
        
        <input id="recipe-title" type="text" name="title" placeholder="Title" value="First recipe" />
        <br/><br/>
        
        <label for="recipe-desc">Description</label>
        <textarea id="recipe-desc" name="description">This is a recipe that I want to save</textarea>
        <br/><br/>

        <input id="recipe-directions" type="text" name="directions" placeholder="Direction (JSON)" value="" />
        <br/><br/>
        
        <input id="recipe-cook_time" type="text" name="cook_time" placeholder="Cook time" value="01:33" />
        <br/><br/>
        
        <input id="recipe-servings" type="text" name="servings" placeholder="Servings" value="2" />
        <br/><br/>

        <input id="recipe-utensils" type="text" name="utensils" placeholder="Utensils" value="spoon,{{old('utensils')}}" />
        <br/><br/>

        <input id="recipe-prep" type="text" name="prep_directions" placeholder="Preperations" value="boil water. Cut carrots into cubes" />
        <br/><br/>
        
        <input id="recipe-ingredients" name='ingredients' class='some_class_name' value="chocolate,{{old('ingredients')}}" placeholder='Ingredients'>
        <br/><br/>
        
        <input id="recipe-photos" type="file" name="photos[]" multiple="multiple" accept=".jpg,.png,.jpeg"/>
        <br/><br/>
        
        <pre>{"1": "Expedita explicabo consectetur rerum iure consectetur expedita cumque.", "2": "Dolorem dolorem vero quo aut perspiciatis.", "3": "Suscipit mollitia quo sed porro perspiciatis earum.", "4": "Consequatur est consequatur cupiditate architecto expedita.", "5": "Magni ea libero sint beatae."}</pre>
        
        <input type="submit" />
        
    </form>
    
@endsection
