@extends('master')

@section('content')
    
    <h1>Forgot password</h1>
    
    <form method="POST" action="{{route('forgot_password.submit')}}">
        @csrf
        
        @if(session()->has('status'))
            <div class="alert alert-success">
                {{ session()->get('status') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <label for="email">Email</label>
        <input id="email" name="email" type="text" />
        <br/><br/>
        
        <input type="submit" />
        
    </form>
    
@endsection
