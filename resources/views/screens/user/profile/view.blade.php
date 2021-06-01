@extends('master')

@section('content')
    @auth
        <div class="container">

            <div class="row">

                <div class="col-md-2">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-md-10">

                    {{ Breadcrumbs::render('my_profile') }}

                    <img class="profile_pic" src="{{$data['img'] ?? '/img/core-img/profile_pic_default.png'}}" alt="profile picture" />
                    {!! $data['description'] ?? '' !!}
                    <a class="new-rec btn btn-md mb-3" href="{{route('user.profile.details')}}">
                        Update profile
                    </a>
                </div>

            </div>

        </div>
    @endauth
@endsection
