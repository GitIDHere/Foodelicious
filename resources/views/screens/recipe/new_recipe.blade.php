@extends('master')

@section('page_scripts')
    <script src="{{mix('js/ingredient_tags.js')}}"></script>
@endsection

@section('content')
    
    <form method="POST" action="{{ route('new_recipe.submit')  }}">
        @csrf
        
        <input id="ingredients" name='tags' class='some_class_name' placeholder='Ingredients'>    

    </form>
    
@endsection
