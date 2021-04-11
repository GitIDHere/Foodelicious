@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk pt-4 pb-4">
                    
                    @include('screens.user.partials._side_bar')
                    
                    <div class="col-12 col-lg-8">
                    
                        {{ Breadcrumbs::render('my_profile') }}
                        
                        <div class="row">
                            <div class="col-sm-3 pic_container">
                                <img class="profile_pic" src="/img/bg-img/r3.jpg" alt="profile picture" />
                            </div>

                            <div class="col-sm-9">
                                {!! $profile->description ?? ''  !!}
                            </div>

                            <a class="new-rec btn btn-md mb-3" href="{{route('user.profile.details')}}">
                                Update profile
                            </a>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection
