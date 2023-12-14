@extends('emails.layout-1')

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

        .main-content .description {
            font-size: 20px;
            color: #000000;
            margin-top: 40px;
        }

        .main-content .cta-button {
            display: inline-block;
            background-color: #E96424;
            border-radius: 60px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
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
                Congratulations! You have been successfully onboarded to the platform.
            </h1>

            <p class="description">
                Get started on your mentorship today!
            </p>

            <a href="{{ url('/') }}" class="cta-button">
                Begin My Mentorship
            </a>

            <p class="regards">
                Regards,<br>
                <span>
                    SL2 Admin
                </span>
            </p>
        </td>
    </tr>
</table>
@endsection
