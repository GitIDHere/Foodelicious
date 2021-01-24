@extends('master')

@section('content')
    
    <h1>Reset password</h1>
    
    <form method="POST" action="{{ route('password_reset.submit') }}">
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
        
        <label for="password">New password</label>
        <input id="password" name="password" type="password" />
        <br/><br/>

        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" />
        <br/><br/>

        <input id="email" name="email" type="hidden" value="{{$email}}"/>
        <input id="token" name="token" type="hidden" value="{{$token}}"/>
        
        <input type="submit" />
        
    </form>
    
@endsection
