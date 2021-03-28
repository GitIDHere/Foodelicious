@extends('master')

@section('content')
    @auth
        <div class="profile-area">
            <div class="container">
                <div class="row white-bk pt-4 pb-4">
                    @include('screens.user.partials._side_bar')

                    <div class="container">
                        <div class="row white-bk pt-4 pb-4">
                            <div class="col-12 col-lg-9 pl-3">
                                <h2>Change email</h2>
                                <form class="" action="{{route('user.profile.change_username')}}" method="POST">
                                    @csrf

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

                                    <div class="input-container">
                                        <label for="email" class="required">Current email</label>
                                        <input type="text" name="email" id="email" class="form-control" value="{{"sd"}}"/>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    @endauth
@endsection
