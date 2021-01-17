@extends('master')

@section('content')
    
    <h1>Reset password</h1>
    
    <form method="POST" action="{{route('password_reset.submit')}}">
        @csrf
        
        <label for="email">Email</label>
        <input id="email" name="email" type="text" />
        <br/><br/>
        
        <input type="submit" />
        
    </form>
    
    
@endsection
