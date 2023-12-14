@extends('emails.layout-1')

@section('css')
    <style type="text/css">
        .main-content {
            position: relative;
            overflow: hidden;
            width: 100%;
            background-color: white;
            padding: 35px 58px 100px 58px;
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
            font-size: 20px;
            color: #000000;
        }

        .main-content .cta-button {
            display: inline-block;
            background-color: #E96424;
            border-radius: 60px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            color: #ffffff;
            margin-top: 32px;
            padding: 20px 50px 20px 50px;
        }

        .main-content .closing {
            margin-top: 36px;
            font-size: 20px;
            text-align: justify;
            color: #000000;
        }

        .main-content .regards {
            margin-top: 84px;
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
                You've been invited to join the Intel AI Global Impact Festival
                <span>
                    Mentorship Program.
                </span>
            </h1>

            <p class="description">
                Please click on the link below to accept the invitation and proceed to the registration page.
            </p>

            <a href="{{ $data['url'] }}" class="cta-button">
                Accept Invitation
            </a>

            <p class="closing">
                Please note that this invitation will expire in the next 10 days.
                Please accept the invitation before
                <strong>
                    {{ $data['expired_date'] }}
                </strong>
                For assistance, please contact our support team at help@simulatedinternship.com
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
@endsection
