@extends('master')

@section('content')
    
    
    <form method="POST" action="{{ route('recipe.new.submit')  }}">
        @csrf
        
        
        
        
        
    </form>
    
@endsection
