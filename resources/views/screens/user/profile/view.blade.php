@extends('master')

@section('content')
    @auth
        <div class="container">

            <div class="row">

                <div class="col-md-3">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-md-9">

                    {{ Breadcrumbs::render('my_profile') }}

                    <div class="row display-profile-info">

                        <div class="col-md-3">
                            <img id="profile_pic" src="{{$data['img'] ?? '/img/core-img/profile_pic_default.png'}}" alt="profile picture" />
                        </div>

                        <div class="col-md-9">
                            <p>
                                {{ $data['description'] ?? '' }}
                            </p>

                            <a class="btn-small mb-3" href="{{route('user.profile.details')}}">
                                Update profile
                            </a>
                        </div>

                    </div>

{{--                    <div class="row">--}}
{{--                        @include('screens.user.partials._recipe_list')--}}
{{--                    </div>--}}

                </div>

            </div>

        </div>
    @endauth
@endsection
