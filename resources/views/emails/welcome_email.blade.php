<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Template</title>
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
        .header {
            background-color: #0000FF;
            text-align: center;
            padding: 20px;
        }
        .header img {
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



        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
            box-sizing: border-box;
            width: 100% !important;
        }

        .footer table {
            margin: 0 auto;
        }

        .footer td {
            padding: 5px 10px;
        }

        .footer a:hover {
            text-decoration: underline;
        }



        /* Add styles for screens with a max width of 600px */
        @media (max-width: 600px) {
            /* Reset the body padding to 0 */
            body {
                padding: 0 !important;
            }


            /* Add padding to the header to give it some breathing room */
            .header {
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
        <div class="header">
            <img src="https://laravel.com/img/notification-logoe.png" alt={{config('app.name')}}>
        </div>
        <div class="body-content">
            <p>Hello {{$name}},</p>

            <div style="margin-top:20px">
                <p style="margin-top: 15px"> Welcome to {{ config('app.name') }}! We're thrilled to have you onboard and can't wait to see what you create.<p>

                <p style="margin-top: 15px">As a registered user, you can now create, manage, and track your projects and tasks with ease. Whether you're working on a team or as an individual, {{ config('app.name') }} has everything you need to stay organized and productive.</p>

                <p style="margin-top: 15px"> If you have any questions or need help getting started, our support team is always here to assist you. Just reply to this email, and we'll be happy to help.</p>

                <p style="margin-top: 15px"> Thanks again for joining us, and we hope you enjoy using {{ config('app.name') }}!</p>

            </div>
            <div class="signature">
                <p>Best regards,</p>
                <p style="margin-top: 6px">The {{ config('app.name') }} Team.</p>
            </div>

        </div>
    </div>
    <div class="footer">
        <table cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td align="center">
                    <a href="#" style="color:#777777;text-decoration:none;">Home</a>
                </td>
                <td align="center">
                    <a href="#" style="color:#777777;text-decoration:none;">About Us</a>
                </td>
                <td align="center">
                    <a href="#" style="color:#777777;text-decoration:none;">Contact Us</a>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
