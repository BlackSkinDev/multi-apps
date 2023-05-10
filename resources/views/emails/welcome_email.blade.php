<html>
<head>
<style>
    .paragraph{
        color: blue;
    }
</style>
</head>
<body style="margin:0px; padding:0px;" bgcolor="#ffffff">
<p class="paragraph">

    Hello {{$name}},

    Welcome to {{ config('app.name') }}! We are thrilled to have you onboard and can't wait to see what you create.

    As a registered user, you can now create,manage, and track your projects and tasks with ease.

    Whether you'are working on a team or as an individual, {{ config('app.name') }} has everything you

    need to stay organized and productive. If you have any questions or need help getting started, our support team is always here

    to assist you. Just reply to this email, and we'll be happy to help.

    Thanks again for joining us, and we hope you enjoy using {{ config('app.name') }}!

</p>

Best regards,<br>
The {{ config('app.name') }} team
</body>
</html>

