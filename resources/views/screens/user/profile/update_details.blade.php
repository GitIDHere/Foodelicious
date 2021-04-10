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
                        
                        <form id="profile-form"
                              method="POST"
                              action="{{ (route('user.profile.details.update') ) }}"
                              enctype="multipart/form-data">
                            
                            @csrf
                            
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
