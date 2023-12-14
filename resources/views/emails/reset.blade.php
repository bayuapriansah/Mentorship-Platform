<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Mentorship Platform</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/foundation-emails.css') }}">

    <style type="text/css">
        @import url('https://fonts.cdnfonts.com/css/intelone-display');

        table.body {
            font-family: 'IntelOne Display', arial, 'helvetica neue', helvetica, sans-serif;
        }

        table.container {
            width: 800px !important;
        }

        .main-content {
            width: 100%;
            background-color: white;
            padding: 70px 50px 100px 50px;
        }

        .main-content .logo {
            width: 158.44px;
            height: 84px;
        }

        .main-content .description {
            font-size: 20px;
            color: #000000;
            margin-top: 48px;
        }

        .main-content .cta-text {
            font-size: 26px;
            font-weight: 500;
            color: #000864;
            margin-top: 20px;
        }

        .main-content .cta-button {
            display: inline-block;
            background-color: #E96424;
            border-radius: 60px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            font-size: 20;
            color: #ffffff;
            margin-top: 32px;
            padding: 12px 44px 12px 44px;
        }

        .main-content .closing-1 {
            width: 586px;
            font-size: 16px;
            color: #000000;
            margin-top: 38px;
        }

        .main-content .cta-link {
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            color: #000864;
            margin-top: 18px;
        }

        .main-content .cta-link:hover {
            text-decoration: underline !important;
        }

        .main-content .closing-2 {
            font-size: 16px;
            color: #000000;
            margin-top: 24px;
        }

        .main-content .regards {
            margin-top: 68px;
            font-size: 22px;
            font-weight: bold;
            color: #000000;
        }

        .main-content .regards span {
            color: #E96424;
        }

        .footer {
            background-color: #E9E9E9;
            padding: 58px 58px 25px 64px;
        }

        .footer .logo {
            width: 141.46px;
            height: 75px;
        }

        .footer .links {
            text-align: end;
            padding-top: 18px;
        }

        .footer .links a {
            color: #000000;
            font-size: 12px;
            margin-left: 24px;
            text-decoration: none;
        }

        .footer .links a:hover {
            text-decoration: underline !important;
        }

        .footer .divider {
            width: 100%;
            height: 1px;
            background-color: #838383;
            margin-top: 44px;
            margin-bottom: 20px;
        }

        .footer .copyright {
            margin-left: 12px;
            font-size: 12px;
            color: #000000;
        }

        .footer .sl2-logo {
            width: 40px;
            height: auto;
        }
    </style>

    @yield('css')
</head>

<body>
    <table class="body" data-made-with-foundation>
        <tr>
            <td class="float-center" align="center" valign="top">
                <center>
                    <!-- Container -->
                    <table align="center" class="container">
                        <tbody>
                            <tr>
                                <td>
                                    <!-- Main Content -->
                                    <table>
                                        <tr>
                                            <td class="main-content">
                                                <!-- Logo -->
                                                <img src="{{ $message->embed(public_path('assets/img/logo/primary-logo.png')) }}" alt="Logo" class="logo">

                                                <p class="description">
                                                    You have made a request to reset your password.
                                                </p>

                                                <p class="cta-text">
                                                    Please click the button below to reset your password.
                                                </p>

                                                <a href="{{ $data['link'] }}" class="cta-button">
                                                    Click Here
                                                </a>

                                                <p class="closing-1">
                                                    If the button above does not work, please use the following link by
                                                    copying and pasting it into your browser
                                                </p>

                                                <a href="{{ $data['link'] }}" class="cta-link">
                                                    {{ $data['link'] }}
                                                </a>

                                                <p class="closing-2">
                                                    If you received this email but did not request to reset your password,
                                                    please change the password to your account immediately.
                                                </p>

                                                <p class="regards">
                                                    Regards,<br>
                                                    <span>
                                                        SL2 Admin
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- ./Main Content -->

                                    <!-- Footer -->
                                    <div class="footer">
                                        <table class="row">
                                            <tr>
                                                <th class="small-6 large-6 first columns">
                                                    <!-- Logo -->
                                                    <img src="{{ $message->embed(public_path('assets/img/logo/primary-logo.png')) }}" alt="Logo" class="logo">
                                                </th>

                                                <th class="small-6 large-6 last columns links">
                                                    <!-- Links -->
                                                    <a href="{{ route('privacy-policy') }}" target="_blank">
                                                        Policies
                                                    </a>

                                                    <a href="{{ route('privacy-policy') }}" target="_blank">
                                                        Help & Support
                                                    </a>
                                                </th>

                                                <th class="expander"></th>
                                            </tr>
                                        </table>

                                        <hr class="divider">

                                        <table class="row">
                                            <tr>
                                                <!-- Copyright  -->
                                                <th class="small-11 large-11 first columns">
                                                    <p class="copyright">
                                                        © {{ date('Y') }} Intel Mentorship Platform. All rights reserved.
                                                    </p>
                                                </th>

                                                <!-- SL2 Logo -->
                                                <th class="small-1 large-1 last columns">
                                                    <img src="{{ $message->embed(public_path('assets/img/logo/sl2-logo.png')) }}" alt="Logo" class="sl2-logo">
                                                </th>
                                            </tr>
                                        </table>

                                    </div>
                                    <!-- ./Footer -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- ./Container -->
                </center>
            </td>
        </tr>
    </table>
</body>

</html>
