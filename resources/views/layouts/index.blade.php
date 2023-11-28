<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simulated Internship</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icon/favicon.ico') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <script src="https://kit.fontawesome.com/682a164d7d.js" crossorigin="anonymous"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" /> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="theme-color" content="#712cf9">

    @yield('more-css')
</head>

<body>
    {{-- NAVBAR --}}
    <nav class="bg-white text-primary px-6 py-4">
        <div class="max-w-screen-xl flex flex-col md:flex-row items-center justify-between mx-auto">
            <div class="text-lg font-semibold mb-4 md:mb-0">
                <a href="{{ route('index') }}" class="text-dark-blue no-underline hover:text-lightest-blue">
                    <img src="{{ asset('assets/img/logo/AIGlobalImpactFestival_Logo.svg') }}"
                        alt="Impact Festival Logo">
                </a>
            </div>
            <div class="flex justify-center space-x-12 flex-grow mb-4 gap-5 tab:gap-5 md:mb-0">
                <a href="{{ route('index') }}" class="text-[#080808] text-sm hover:text-primary">
                    Home
                </a>

                <a href="#" class="text-[#080808] text-sm hover:text-primary">
                    Skills Track Info
                </a>

                <a href="#" class="text-[#080808] text-sm hover:text-primary">
                    Entrepreneur Track Info
                </a>
            </div>
            <div class="space-x-4 gap-12">
                @if (isLoggedIn())
                    <button id="dropdownRightEndButton" data-dropdown-toggle="dropdownRightEnd"
                        data-dropdown-placement="right-end"
                        class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:mr-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                        type="button">
                        <span class="sr-only">Open user menu</span>
                        <i class="fa-solid fa-user fa-fade mr-2"></i>
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" class="w-8 h-8 mr-2 rounded-full">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
                        </svg> --}}
                        {{ nameUserAuth() }}
                        <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @else
                    <a href="{{ route('multiLogIn') }}"
                        class="border-primary bg-primary hover:border-primary-500 hover:bg-primary-800 text-white text-sm rounded-full border-[1px] border-solid px-10 py-2">
                        Log in
                    </a>
                @endif
            </div>
            {{-- Navbar Componet --}}
            <div id="Industry-Partners-hover" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Coming Soon
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            @if (isLoggedIn())
                <!-- Dropdown menu -->
                <div id="dropdownRightEnd"
                    class="z-40 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div class="font-medium">{{ nameUserAuth() }}</div>
                        <div class="truncate">{{ emailUserAuth() }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRightEndButton">
                        <li>
                            @if (Auth::guard('student')->check())
                                <a href="{{ route('student.allProjects', ['student' => Auth::guard('student')->user()->id]) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            @elseif(Auth::guard('web')->check())
                                <a href="{{ route('dashboard.admin') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            @elseif(Auth::guard('mentor')->check())
                                <a href="{{ route('dashboard.mentor') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            @elseif(Auth::guard('customer')->check())
                                <a href="{{ route('dashboard.customer') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            @endif

                        </li>
                    </ul>
                    <div class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Log
                            Out</a>

                        <form id="logout-form" class="inline" method="post" action="{{ route('logout') }}"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endif
            {{-- End Navbar Component --}}
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
    {{-- <button id="chat-button" class="fixed bottom-0 right-0 m-6">
        <i class="fas fa-comment"></i> Chat
    </button>
    <div id="chat-container" class="hidden fixed bottom-0 right-0 m-6 chat-container">
        <div class="bg-white p-2 rounded-lg shadow-lg chat-box">
            <div class="chat-header flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fa-solid fa-robot bot-logo"></i>
                    <span class="bot-name ml-2">SimmyBot</span>
                    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                </div>
                <button id="close-chat" class="close-chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="chat-box" class="chat-messages">
                <!-- Chat messages will go here -->
            </div>
            <input id="user-input" class="mt-4 p-2 w-full rounded" placeholder="Type your message...">
        </div>
    </div> --}}
    <!-- Footer -->
    <footer class="bg-[#e9e9e9] border-[#838383] text-black">
        <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
            <div class="p-4 py-6 lg:py-8">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/logo/footer-logo.svg') }}" class="tab:scale-125"
                            alt="Intel Digital Readiness Logo" />
                    </a>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="relative">
                    <p class="text-justify">Intel technologies may require enabled
                        hardware, software, or service activation. // No product or component can be absolutely secure.
                        // Your costs and results may vary. // Performance varies by use, configuration, and other
                        factors.
                        // See our complete legal <a
                            href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C"
                            class="text-primary font-bold hover:underline">Notices and Disclaimers</a>. // Intel is
                        committed to respecting
                        human rights and avoiding complicity in human rights abuses. See <a
                            href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html"
                            class="text-primary font-bold hover:underline">Intel’s Global Human Rights Principles</a>.
                        Intel’s products
                        and software are intended only to be used in applications that do not cause or contribute to a
                        violation of an internationally recognized human right.</p>
                </div>
                <div class="relative tab:-top-10">
                    <div class="md:flex col-start-8 col-span-4">
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="text-sm font-semibold text-darker-blue">
                                INFO
                            </h2>

                            <ul class="mt-4 flex flex-col gap-2">
                                <li>
                                    <a href="#" class="text-sm font-normal hover:underline">
                                        Entrepreneur Track
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="text-sm font-normal hover:underline">
                                        Skill Track
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="text-sm font-semibold text-darker-blue">
                                SUPPORT
                            </h2>

                            <ul class="mt-4 flex flex-col gap-2">
                                <li>
                                    <a href="{{ route('faq') }}" class="text-sm font-normal hover:underline">
                                        FAQs
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('contact') }}" class="text-sm font-normal hover:underline">
                                        Contact Us
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="text-sm font-semibold text-darker-blue">
                                LEGAL
                            </h2>

                            <ul class="mt-4 flex flex-col gap-2">
                                <li>
                                    <a href="{{ route('privacy-policy') }}"
                                        class="text-sm font-normal hover:underline">
                                        Privacy Policies
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('terms-of-use') }}"
                                        class="text-sm font-normal hover:underline">
                                        Terms &amp; Conditions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-black sm:mx-auto lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-center tab:text-left">&copy; {{ date('Y') }} <a
                        href="{{ url('/') }}" class="hover:underline">Intel Simulated Internships</a>. All
                    Rights Reserved.
                </span>

            </div>
        </div>
    </footer>

    {{-- @vite('resources/js/app.js') --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script> --}}

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script> --}}

    @yield('more-js')

</body>

</html>
