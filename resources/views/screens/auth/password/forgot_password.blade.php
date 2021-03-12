@extends('master')

@section('content')

<div class="pt-5 pb-5 center-confirm">
    <div class="container">

        <div class="row">
            <h1 class="green font-lg mb-0">Password reset</h1>
        </div>
        
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

    </div>
</div>
    
@endsection
