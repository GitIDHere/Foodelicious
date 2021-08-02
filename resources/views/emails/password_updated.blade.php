@extends('emails.master_email')

@section('content')

    <p>Your password has been successfully updated. If this wasn't you, then please reset your password immediately</p>

    <a href="{{route('forgot_password.show')}}" class="email-btn">Reset password</a>

    <p>Thank you,</p>
    <p>{{ $signOff }}</p>

@endsection
