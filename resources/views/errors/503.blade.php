<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Under Maintenance</title>

    @vite('resources/css/app.css')
</head>
<body>
    <main class="max-w-[1366px] min-h-[690px] mx-auto p-[4.5rem] bg-white">
        <a href="{{ url('/') }}">
            <img
                src="{{ asset('/assets/img/logo/footer-logo.svg') }}"
                alt="Intel Digital Readiness Logo"
                class="w-[267.3px]"
            >
        </a>

        <div class="flex gap-[6.75rem]">
            <div class="mt-9">
                <h1 class="text-3xl text-darker-blue font-medium">
                    Website is Under Maintenance
                </h1>

                <p class="max-w-[471px] mt-5 text-[1.375rem] text-[#636262]">
                    Lorem ipsum dolor sit amet is a dummy text used as a placeholder.
                </p>

                @if (env('MAINTENANCE_SCHEDULE', '') !== '')
                    <p class="mt-6 text-2xl text-[#DEAA51] font-medium">
                        Scheduled Maintenance<br>
                        <span class="text-black">
                            8th March 6:30am - 12:30pm GMT.
                        </span>
                    </p>
                @endif
            </div>

            <img
                src="{{ asset('/assets/img/error_page/under_construction.png') }}"
                alt="Illustration"
                class="hidden tab:block relative -top-14 w-[513px] h-[379px]"
            >
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
