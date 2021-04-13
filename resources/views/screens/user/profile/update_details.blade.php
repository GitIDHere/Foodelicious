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
                            
                            <div class="profile-pic-container">
                                <img id="profile_pic" class="{{ $profile['profile_pic_path'] ?? 'hidden' }}" src="{{ $profile['profile_pic_path'] ?? ''}}" alt="Profile picture" />
                            </div>
                            
                            <label class="btn btn-primary btn-upload" for="inputImage" title="Upload new picture">
                                <input id="pic_file" name="profile_pic" type="file" accept="image/*">
                                <input id="img-x" name="img-x" type="hidden" />
                                <input id="img-y" name="img-y" type="hidden" />
                                <input id="img-w" name="img-w" type="hidden" />
                                <input id="img-h" name="img-h" type="hidden" />
                            </label>
                                                    
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
