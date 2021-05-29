@extends('master')

@section('content')
<div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(/img/bg-img/hero/hero3.jpg);" >
    <div class="white-box mx-auto col-lg-6 col-md-12 pt-4 pb-4">

        <div class="row">
            <h2 class="mx-auto">Please verify your email</h2>
        </div>

        <div class="mt-5">
            <form method="POST" action="{{route('verification.send')}}">
                @csrf
                <input type="submit" class="mx-auto d-block btn delicious-btn m-1" value="Send verification email" />
            </form>
        </div>

    </div>
</div>
@endsection
