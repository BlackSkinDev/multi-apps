<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{config('app.name')}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

    <style>
        /* Reset default browser styles */
        body, h1, h2, h3, p, ul, ol {
            margin: 0;
            padding: 0;
            font-size: 100%;
            font-weight: normal;
            line-height: 1.5;
            font-family: 'Poppins', sans-serif;
        }

        /* Set the body background color */
        body {
            background-color: #F0F0F0 !important;
            padding:10px !important;
        }



        /* Set the header background color and logo */
        .template-top {
            text-align: center;
            padding: 20px;
        }

        .template-bottom {
            background-color: #1d4ed8;
            text-align: center;
            padding: 20px;
            height: 70px !important;
            margin-top: 30px !important;
            color: white;
        }



        .template-top img {
            max-width: 100%;
            max-height: 50px;
        }

        /* Add a section for the main body text */
        .body-text {
            background-color: #ffffff;
            margin: 20px;
            flex: 1;
        }

        /* Add a section for the email signature */
        .signature {
            margin-top: 30px !important;
            text-align: left !important;
        }

        /* Add a section for the body content */
        .body-content{
            padding:20px !important;

        }




        /* Add styles for screens with a max width of 600px */
        @media (max-width: 600px) {
            /* Reset the body padding to 0 */
            body {
                padding: 0 !important;
            }


            /* Add padding to the header to give it some breathing room */
            .template-top {
                padding: 10px !important;
            }

            .template-bottom {
                padding: 10px !important;
            }


            /* Reduce the font size of the body text */
            .body-text p {
                font-size: 14px !important;
            }

            /* Reduce the padding of the body content */
            .body-content {
                padding: 10px !important;

            }

            /* Increase the width of the body content */
            .body-content {
                max-width: 100% !important;
                text-align: justify;
            }
        }



    </style>
</head>
<body>
<div class="body-text">
    <div class="template-top">
{{--        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo">--}}
        <h1 style="text-align: center">{{config('app.name')}}</h1>
    </div>
    <div class="body-content">
        <p>Hello {{$name}},</p>

        <div style="margin-top:20px">
            @yield('content')
        </div>
        <div class="signature">
            <p>Best regards</p>
            <p style="margin-top: 8px">The {{ config('app.name') }} Team.</p>
        </div>

    </div>
    <div class="template-bottom">
        <p style="text-align: center">If you need to reach us, please reply to this email.</p>
    </div>
</div>
<footer style="padding: 2rem;">
    <div>
        <p style="font-size: 14px; margin-bottom: 1rem;text-align: center">
            {{config('app.name')}} | 33 Jhalandar P1,  India.
        </p>
        <p style="font-size: 12px;text-align: center">
            © {{date('Y')}} {{config('app.name')}} Inc. All rights reserved.
        </p>
    </div>
</footer>

</body>
</html>
