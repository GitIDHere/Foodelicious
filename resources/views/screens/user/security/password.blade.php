@extends('master')

@section('content')
    @auth

        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-4 mb-4">
                    @include('screens.user.partials._side_bar')
                </div>

                <div class="col-lg-9 col-md-8">

                    {{ Breadcrumbs::render('update_password')}}

                    <h2>Update password</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <form class="" method="POST" action="{{route('user.security.password.submit')}}">
                        @csrf

                        <div class="input-container">
                            <label for="password" class="required">Current password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                            />
                        </div>

                        <div class="input-container">
                            <label for="new_password" class="required">New password</label>
                            <input
                                id="new_password"
                                type="password"
                                name="new_password"
                                class="form-control"
                            />
                        </div>

                        <div class="input-container">
                            <label for="new_password_confirmation" class="required">Confirm new password</label>
                            <input
                                id="new_password_confirmation"
                                type="password"
                                name="new_password_confirmation"
                                class="form-control"
                            />
                        </div>

                        <div class="input-container">
                            <input type="submit" value="Update" class="btn delicious-btn right" />
                        </div>

                    </form>

                </div>

            </div>
        </div>

    @endauth
@endsection
