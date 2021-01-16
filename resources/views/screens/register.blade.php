@extends('master')

@section('content')
    
    <form method="POST" action="/register">
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
{{--        value="{{ old('email') }}"--}}
        
        <label for="email">Email</label>
        <input id="email" name="email" type="text" class="@error('email') is-invalid @enderror"  value="s@S.s">
        <br/><br/>
        
        <label for="password">Password</label>
        <input id="password" name="password" type="password" class="@error('password') is-invalid @enderror">
        <br/><br/>
        
        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="@error('password_confirmation ') is-invalid @enderror">
        <br/><br/>
        
        <input type="submit" />
        
    </form>
    
@endsection


