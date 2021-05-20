@extends('master')

@section('content')
    <h1>404 Not found</h1>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
@endsection