@extends('master')

@section('content')
    @auth
        <div class="container">
            <div class="row white-bk pt-4 pb-4">

                @include('screens.user.partials._side_bar')
                
                <div class="col-12 col-lg-9 pl-3">
                    
                    <h1 class="mt-0">Account Security</h1>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <a class="new-rec btn btn-md mb-3" href="{{route('user.security.email.view')}}">
                        Change email
                    </a>
                    
                </div>
                
            </div>
        </div>
    @endauth
@endsection