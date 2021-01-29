@extends('master')

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
