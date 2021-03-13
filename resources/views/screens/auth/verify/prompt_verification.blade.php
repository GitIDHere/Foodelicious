@extends('master')

@section('content')

<div class="white-bk container">

    <div class="row">
        <p>Please verify your email.</p>
    </div>

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
    
</div>

    
@endsection