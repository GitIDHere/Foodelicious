@extends('emails.master_email')

@section('content')
    
    <p>Password request has been requested. Please click the button below to reset your password</p>
    
    <a href="{{ $passwordResetURL  }}" class="email-btn">Reset password</a>
    
    <p>This link will expire at {{ $expirationDateTime }}</p>
    
    <p>Thank you,</p>
    <p>{{ $signOff }}</p>
@endsection
