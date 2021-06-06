@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 bg-grey">
            <h1 class="txt-center">404 Not found</h1>

            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
