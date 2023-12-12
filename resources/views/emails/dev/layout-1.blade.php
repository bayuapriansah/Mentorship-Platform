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
            width: 95% !important;
        }

        .banner {
            width: 100%;
            height: auto;
        }

        .footer {
            background-color: #E9E9E9;
            padding: 58px 58px 25px 64px;
        }

        .footer-logo {
            width: 141.46px;
            height: auto;
        }

        .footer-links-container {
            text-align: end;
            padding-top: 18px;
        }

        .footer-links-container a {
            color: #000000;
            font-size: 12px;
            margin-left: 24px;
            text-decoration: none;
        }

        .footer-links-container a:hover {
            text-decoration: underline !important;
        }

        .footer-divider {
            width: 100%;
            height: 1px;
            background-color: #838383;
            margin-top: 44px;
            margin-bottom: 20px;
        }

        .copyright {
            margin-left: 12px;
            font-size: 12;
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
                                    <!-- Banner -->
                                    <img src="{{ $message->embed(public_path('assets/img/email/banner.png')) }}" alt="Banner" class="banner">

                                    <!-- Main Content -->
                                    @yield('main-content')
                                    <!-- ./Main Content -->

                                    <!-- Footer -->
                                    <div class="footer">
                                        <table class="row">
                                            <tr>
                                                <th class="small-6 large-6 first columns">
                                                    <!-- Logo -->
                                                    <img src="{{ $message->embed(public_path('assets/img/email/footer-logo.png')) }}" alt="Logo" class="footer-logo">
                                                </th>

                                                <th class="small-6 large-6 last columns footer-links-container">
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

                                        <hr class="footer-divider">

                                        <p class="copyright">
                                            © {{ date('Y') }} Intel Mentorship Platform. All rights reserved.
                                        </p>
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
