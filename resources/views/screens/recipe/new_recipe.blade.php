@extends('master')

@section('page_scripts')
    <script src="{{asset('js/ingredient_tags.js')}}"></script>
@endsection

@section('content')
    
    <form method="POST" action="{{ route('new_recipe.submit')  }}">
        @csrf
        
        <input name='tags'
          class='some_class_name'            
          placeholder='write some tags'      
          value='css, html, javascript, css' of Objects)
          data-blacklist='.NET,PHP'>    

    </form>
    
@endsection
