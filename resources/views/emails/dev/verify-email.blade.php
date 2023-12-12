@extends('emails.dev.layout-1')

@section('css')
    <style type="text/css">
        .main-content {
            position: relative;
            overflow: hidden;
            width: 100%;
            background-color: white;
            padding: 35px 58px 100px 58px;
        }

        .main-content .top-right-dots {
            position: absolute;
            top: 0;
            right: 0;
            width: 339px;
            height: 186px;
            background-color: red;
            background-image: url("{{ public_path('assets/img/icon/profile/dots.png') }}");
        }

        .main-content .title {
            font-size: 35px;
            font-weight: bold;
            color: #000864;
        }

        .main-content .title span {
            color: #E96424;
        }

        .main-content .description {
            margin-top: 35px;
            font-size: 26px;
            text-align: justify;
            color: #000000;
        }

        .main-content .cta-text {
            margin-top: 70px;
            font-size: 26px;
            color: #000000;
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
            margin-top: 20px;
            padding: 18px 36px 18px 36px;
        }

        .main-content .closing {
            margin-top: 48px;
            font-size: 20px;
            text-align: justify;
            color: #000000;
        }

        .main-content .regards {
            margin-top: 56px;
            font-size: 22px;
            font-weight: bold;
            color: #000000;
        }

        .main-content .regards span {
            color: #E96424;
        }
    </style>
@endsection

@section('main-content')
<table>
    <tr>
        <td class="main-content">
            {{-- <div class="top-right-dots"></div> --}}

            <h1 class="title">
                Confirm your email address to get started with <span>Mentorship Platform</span>.
            </h1>

            <p class="description">
                Once you've confirmed that john.doe@sl2.org is your email address, we will help you find internship programs to join.
            </p>

            <p class="cta-text">
                Click on the button below to confirm,
            </p>

            <a href="{{ url('/') }}" class="cta-button">
                Confirm Email Address
            </a>

            <p class="closing">
                If you didn't request this email, there is nothing to worry about - you can safely ignore it
            </p>

            <p class="regards">
                Thank You,<br>
                <span>
                    SL2 Admin
                </span>
            </p>
        </td>
    </tr>
</table>
@endsection
