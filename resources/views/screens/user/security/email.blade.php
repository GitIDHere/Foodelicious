@extends('master')

@section('content')
    @auth
        <div class="container">
            <div class="row white-bk pt-4 pb-4">

                @include('screens.user.partials._side_bar')
                
                <div class="col-12 col-lg-9 pl-3">
                    
                    <h1 class="mt-0">Update email</h1>
                    
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
                    
                    <form class="" method="POST" action="{{route('user.security.email.submit')}}">
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
                            <label for="new_email" class="required">New email</label>
                            <input
                                    id="new_email"
                                    type="email"
                                    name="new_email"
                                    class="form-control"
                                    value="{{ old('new_email')  }}"
                            />
                        </div>

                        <div class="input-container">
                            <label for="new_email_confirmation" class="required">Confirm new email</label>
                            <input
                                    id="new_email_confirmation"
                                    type="email"
                                    name="new_email_confirmation"
                                    class="form-control"
                                    value="{{ old('new_email_confirmation')  }}"
                            />
                        </div>
                        
                        
                        <div class="input-container">
                            <input type="submit" value="Update" class="btn btn-md pull-right" />
                        </div>
                        
                    </form>
                    
                </div>
                
            </div>
        </div>
    @endauth
@endsection