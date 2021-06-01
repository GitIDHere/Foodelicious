@extends('master')

@section('content')
<div class="bg-img bg-overlay pt-5 pb-5" style="background-image: url(/img/bg-img/hero/hero3.jpg);" >
    <div class="container">
        <div class="row">
            <div class="white-box mx-auto col-lg-12 col-md-12 p-4">
                <div class="text-center">
                    <h1 class="">Your email has been verified!</h1>
                    <p>You are now able to access the full content of the website.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include("theme._instagram_feed")


@endsection
