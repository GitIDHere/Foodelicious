@extends('master')

@section('content')
    @auth
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-4 pr-md-0">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-lg-9 col-md-8 pl-md-0">

                    <div class="container">

                        <div class="row">

                            <div class="pt-3 pb-3 bg-grey col-12">

                                {{ Breadcrumbs::render('profile_details') }}

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="profile-details-form"
                                      method="POST"
                                      action="{{ (route('user.profile.details.update') ) }}"
                                      enctype="multipart/form-data">

                                    @csrf

                                    <label>
                                        Profile pic
                                        <span class="hint">
                                    <i class="fa fa-info-circle">
                                        <span
                                            class="hint-tooltip"
                                            data-balloon-length="large"
                                            aria-label="Click on the image below to select an image. Use the cropping tool to crop the image."
                                            data-balloon-pos="right"></span>
                                    </i>
                                </span>
                                    </label>
                                    <div id="profile_pic_container">
                                        <img id="profile_pic"
                                             class="{{$details['profile_pic_path'] ?? 'green-circle' }}"
                                             src="{{ $details['profile_pic_path'] ?? '/img/core-img/profile_pic_default.png'}}" alt="Profile picture" />
                                    </div>


                                    <div class="hidden">
                                        <input id="pic_file" name="profile_pic" type="file" accept="image/*">
                                        <input id="img-x" name="img-x" type="hidden" />
                                        <input id="img-y" name="img-y" type="hidden" />
                                        <input id="img-w" name="img-w" type="hidden" />
                                        <input id="img-h" name="img-h" type="hidden" />
                                    </div>

                                    <label for="profile-desc" class="required">A little bit about yourself</label>
                                    <textarea name="description" id="profile-desc" class="form-control txt-area">{{ ($details['description'] ?? old('description'))  }}</textarea>
                                    <div class="word_counter" data-link="profile-desc" data-char-limit="500"></div>

                                    <input type="submit" value="Save" class="btn delicious-btn btn-5 mb-3 mt-4 right" />

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endauth
@endsection
