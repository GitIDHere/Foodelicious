@extends('master')

@section('content')

    <h1>Please verify your email.</h1>

    <form method="POST" action="{{route('verification.send')}}">
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

        <input type="submit" value="Re-send verification email" />

    </form>
    
@endsection