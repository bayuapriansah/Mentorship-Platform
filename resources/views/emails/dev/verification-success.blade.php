@extends('emails.dev.layout-1')

@section('css')
    <style type="text/css">
        .main-content {
            position: relative;
            overflow: hidden;
            width: 100%;
            background-color: white;
            padding: 64px 58px 100px 58px;
        }

        .main-content .title {
            font-size: 35px;
            font-weight: bold;
            color: #000864;
        }

        .main-content .description-1, .main-content .description-2 {
            font-size: 20px;
            text-align: justify;
            color: #000000;
        }

        .main-content .description-1 {
            margin-top: 40px;
        }

        .main-content .description-2 {
            margin-top: 18px;
        }

        .main-content .cta-button {
            display: inline-block;
            background-color: #E96424;
            border-radius: 60px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            font-size: 20;
            font-weight: 500;
            color: #ffffff;
            margin-top: 65px;
            padding: 16px 40px 16px 40px;
        }

        .main-content .regards {
            margin-top: 64px;
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
            <h1 class="title">
                Congratulations! You have been successfully onboarded into our platform.
            </h1>

            <p class="description-1">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <p class="description-2">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <a href="{{ url('/') }}" class="cta-button">
                Begin My Mentorship
            </a>

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
