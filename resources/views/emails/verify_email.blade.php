@extends('emails.master_email')

@section('content')

    <p>Click the button below to verify your email address.</p>

    <a href="{{$verification_url}}" class="email-btn">Verify email</a>

    <p>Thank you,</p>
    <p>{{ $signOff }}</p>

@endsection
