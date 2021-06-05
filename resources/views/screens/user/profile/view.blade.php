@extends('master')

@section('content')
    @auth
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-4 mb-4">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-lg-9 col-md-8">

                    {{ Breadcrumbs::render('my_profile') }}

                    <div class="row display-profile-info">

                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <img class="d-sm-block d-xs-block mx-sm-auto mx-xs-auto" id="profile_pic" src="{{$profile['img'] ?? '/img/core-img/profile_pic_default.png'}}" alt="profile picture" />
                        </div>

                        <div class="col-lg-9 col-md-8">
                            <p class="desc-long d-none d-lg-block">{{ $profile['description'] ?? '' }}</p>

                            <p class="desc-short d-none d-lg-none d-md-block">Short {{ $profile['short_description'] ?? '' }}</p>

                            <a class="btn-small mb-3" href="{{route('user.profile.details')}}">
                                Update profile
                            </a>
                        </div>

                    </div>

                    <div class="row">
                        @include('screens.user.partials._recipe_list')
                    </div>

                </div>

            </div>

        </div>
    @endauth
@endsection
