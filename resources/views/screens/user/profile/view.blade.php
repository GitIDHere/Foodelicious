@extends('master')

@section('content')
    @auth
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-4 mb-4 pr-md-0">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-lg-9 col-md-8 pl-md-0">

                    <div class="container">

                        <div class="row">

                            <div class="pt-3 pb-3 bg-grey col-12">

                                {{ Breadcrumbs::render('my_profile') }}

                                <div class="row display-profile-info">

                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <img
                                            class="d-sm-block d-xs-block mx-sm-auto mx-xs-auto {{$profile['img'] ?: 'green-circle' }}"
                                            id="profile_pic" src="{{$profile['img'] ?: '/img/core-img/profile_pic_default.png'}}" alt="profile picture" />
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

                                    <div class="container">

                                        <h3>Account security</h3>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <a class="btn btn-tile ml-0" href="{{route('user.security.email.view')}}">
                                            <i class="fa fa-envelope"></i>
                                            <span>Change email</span>
                                        </a>

                                        <a class="btn btn-tile" href="{{route('user.security.password.view')}}">
                                            <i class="fa fa-ellipsis-h"></i>
                                            <span>Change password</span>
                                        </a>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    @endauth
@endsection
