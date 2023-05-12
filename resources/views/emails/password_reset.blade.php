@extends('emails.layout.master')
@section('content')
    <p style="margin-top: 15px">
        We received a request to reset the password associated with this email address. If you didn't make this request, you can ignore this email.
    <p>

    <p style="margin-top: 15px">
        To reset your password, please click <a href="{{$link}}" target="_blank" style="text-decoration: none">here</a>. Link expires in {{$duration}} minutes.
    </p>

    <p style="margin-top: 15px">
        If the above link doesn't work, please copy and paste this URL into your browser: <a href="{{$link}}">{{$link}}</a>
    </p>

@endsection

