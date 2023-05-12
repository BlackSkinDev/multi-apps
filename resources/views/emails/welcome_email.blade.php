@extends('emails.layout.master')
@section('content')
    <p style="margin-top: 15px"> Welcome to {{ config('app.name') }}! We're thrilled to have you onboard and can't wait to see what you create.<p>

    <p style="margin-top: 15px">As a registered user, you can now create, manage, and track your projects and tasks with ease. Whether you're working on a team or as an individual, {{ config('app.name') }} has everything you need to stay organized and productive.</p>

    <p style="margin-top: 15px"> If you have any questions or need help getting started, our support team is always here to assist you.</p>

    <p style="margin-top: 15px"> Thanks again for joining us, and we hope you enjoy using {{ config('app.name') }}!</p>
@endsection
