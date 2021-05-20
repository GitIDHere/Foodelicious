@extends('emails.master_email')

@section('content')

    <p>Someone requested to update your email. If this wasn't you then please contact support.</p>
        
    <p>Thank you,</p>
    <p>{{ $signOff }}</p>

@endsection
