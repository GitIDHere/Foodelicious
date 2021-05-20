@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk pt-4 pb-4">

                    @include('screens.user.partials._side_bar')

                    <div class="col-12 col-lg-8">

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
                                Profile Photo
                                <span class="hint">
                                    <i class="fa fa-info-circle">
                                        <span
                                                class="hint-tooltip"
                                                data-balloon-length="large"
                                                aria-label="Click on the image below to select an image. Use the cropper to crop the image."
                                                data-balloon-pos="right"></span>
                                    </i>
                                </span>
                            </label>
                            <div class="profile-pic-container">
                                <img id="profile_pic" src="{{ $details['profile_pic_path'] ?? '/img/core-img/profile_pic_default.png'}}" alt="Profile picture" />
                            </div>

                            <div class="hidden">
                                <input id="pic_file" name="profile_pic" type="file" accept="image/*">
                                <input id="img-x" name="img-x" type="hidden" />
                                <input id="img-y" name="img-y" type="hidden" />
                                <input id="img-w" name="img-w" type="hidden" />
                                <input id="img-h" name="img-h" type="hidden" />
                            </div>

                            <div class="input-container">
                                <label for="profile-desc" class="required">Description</label>
                                <textarea
                                        name="description"
                                        id="profile-desc"
                                        class="form-control txt-area">{{ ($details['description'] ?? old('description'))  }}</textarea>
                            </div>


                            <div class="input-container">
                                <input type="submit" value="Update" class="btn btn-md pull-right" />
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection
