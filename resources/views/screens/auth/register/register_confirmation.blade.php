@extends('master')

@section('content')
<div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(/img/bg-img/hero/hero3.jpg);" >
    <div class="white-box mx-auto col-lg-6 col-md-12 pt-4 pb-4">

        <div class="row">
            <h2 class="mx-auto">Thank you for registering!</h2>
            <h3 class="mx-auto">Please check your email to verify your account</h3>
        </div>

        <div class="row">
            <a class="mx-auto mt-3 btn delicious-btn m-1 d-block" href="{{route('home')}}">Back home</a>
        </div>

    </div>
</div>
@endsection
