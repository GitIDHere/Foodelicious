@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row">
                    @include('screens.user.partials._side_bar')
                    
                    <div class="col-12 col-lg-8">
                        fddf
                    </div>
                    
                </div>
            </div>
        </div>
    @endauth
@endsection
