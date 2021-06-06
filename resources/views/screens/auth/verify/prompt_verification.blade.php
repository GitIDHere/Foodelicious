@extends('master')

@section('content')
<div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(/img/bg-img/hero/hero3.jpg);" >

    <div class="container">

        <div class="row">

            <div class="col-12">

                <div class="mx-auto white-box col-lg-6 col-md-12 pt-4 pb-4">

                    <h2 style="text-align: center;">Please verify your email</h2>

                    <form method="POST" action="{{route('verification.send')}}">
                        @csrf
                        <input type="submit" class="mx-auto d-block btn delicious-btn m-1" value="Send verification email" />
                    </form>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
