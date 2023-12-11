<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title', 'Mentorship Platform')
    </title>

    @vite('resources/css/app.css')
</head>
<body>
    <main class="max-w-[1366px] min-h-[690px] mx-auto py-5 px-20 bg-white">
        <a href="{{ url('/') }}">
            <img
                src="{{ asset('/assets/img/logo/footer-logo.svg') }}"
                alt="Intel Digital Readiness Logo"
                class="w-[144.08px]"
            >
        </a>

        <div class="relative w-[518px] min-h-[490px] mx-auto mt-5 flex justify-center bg-cover bg-no-repeat" style="background-image: url({{ asset('/assets/img/error_page/background.png') }})">
            <div class="absolute top-24 left-44 text-[#20205E] text-center">
                <p class="text-3xl leading-none">Oops!</p>

                <p class="text-[5.625rem] font-bold leading-none">
                    @yield('code', '500')
                </p>

                <p class="text-[1.375rem] leading-none">
                    @yield('message', 'Internal Server Error')
                </p>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
