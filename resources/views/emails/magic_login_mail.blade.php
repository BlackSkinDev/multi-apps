@extends('emails.layout.master')
@section('content')
    <p style="margin-top: 15px">
        Welcome back to {{config('app.name')}}, we are delighted to see you again!
    <p>

    <p style="margin-top: 15px">
        Click <a href="{{$link}}" target="_blank" style="text-decoration: none">here</a> to log into your account. Link expires in {{$duration}} minutes.
    </p>

    <p style="margin-top: 15px">
        If the above link doesn't work, please copy and paste this URL into your browser: <a href="{{$link}}" >{{$link}}</a>
    </p>

@endsection


