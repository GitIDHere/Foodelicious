@extends('master')

@section('content')
    
    <h1>Reset password</h1>
    
    <form method="POST" action="{{route('password_reset.submit')}}">
        @csrf

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
