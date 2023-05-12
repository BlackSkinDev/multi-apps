@extends('emails.layout.master')
@section('content')

    <p style="margin-top: 15px">
        Thank you for signing up for {{config('app.name')}}! Before you can start using our platform, we need to verify your email address.
    <p>

    <p style="margin-top: 15px">
        Please click <a href="{{$link}}" target="_blank" style="text-decoration: none">here</a> to confirm your email address. Link expires in {{$duration}} minutes.
    </p>

    <p style="margin-top: 15px">
        If the above link doesn't work, please copy and paste this URL into your browser: <a href="{{$link}}" class="disabled-link">{{$link}}</a>
    </p>


    <p style="margin-top: 15px"> Thank you for choosing our service!.</p>

@endsection


