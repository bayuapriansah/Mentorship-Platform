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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta name="theme-color" content="#712cf9">
</head>

<body>
    {{-- NAVBAR --}}
    <nav class="bg-white text-dark-blue px-6 py-4">
        <div class="max-w-screen-xl flex flex-col md:flex-row items-center justify-between mx-auto">
            <div class="text-lg font-semibold mb-4 md:mb-0">
                <a href="{{ route('index') }}" class="text-dark-blue no-underline hover:text-lightest-blue">
                    <img src="{{ asset('assets/img/Digitalreadiness-logo 1.svg') }}" class="" alt="">
                </a>
            </div>
            <div class="flex justify-center space-x-4 flex-grow mb-4 gap-5 tab:gap-5 md:mb-0">
                <a href="{{ route('index') }}"
                    class="text-dark-blue intelOne no-underline hover:text-lightest-blue">Home</a>
                <a href="{{ route('projects.index') }}"
                    class="text-dark-blue intelOne no-underline hover:text-lightest-blue">Internship
                    Projects</a>
                <a href="#" data-tooltip-target="Industry-Partners-hover" data-tooltip-trigger="hover"
                    class="text-dark-blue intelOne no-underline hover:text-lightest-blue">Industry Partners</a>
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
                        class="border-dark-blue text-dark-blue rounded-full border-[1px] border-solid px-4 py-2">Login</a>
                    <a href="{{ route('registerPage') }}"
                        class="bg-dark-blue text-white rounded-full border-[1px] border-solid border-dark-blue px-4 py-2">Register</a>
                        {{-- need to put it here as emergency button to logout --}}
                        {{-- <form class="inline" method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Log Out</button>
                        </form> --}}
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
                            <a href="{{ route('student.allProjects', ['student' => Auth::guard('student')->user()->id]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>

                            @elseif(Auth::guard('web')->check())
                            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>

                            @elseif(Auth::guard('mentor')->check())
                            <a href="{{ route('dashboard.mentor') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>

                            @elseif(Auth::guard('customer')->check())
                             <a href="{{ route('dashboard.customer') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>

                             @endif

                        </li>
                    </ul>
                    <div class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Log Out</a>

                        <form id="logout-form" class="inline" method="post" action="{{ route('logout') }}" style="display: none;">
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
    <footer class="bg-lightest-blue dark:bg-gray-900">
        <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
            <div class="p-4 py-6 lg:py-8">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/Digitalreadiness-logo 1.svg') }}"
                            class="object-scale-down h-15 w-auto py-4" alt="Intel Digital Readiness Logo" />
                    </a>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="relative">
                    <p class="text-justify drop-shadow-md shadow-blue-600/50">Intel technologies may require enabled
                        hardware, software, or service activation. No product or component can be absolutely secure.
                        Your costs and results may vary. Performance varies by use, configuration, and other factors.
                        See our complete legal <a
                            href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C"
                            class="text-black font-bold">Notices and Disclaimers</a>. Intel is committed to respecting
                        human rights and avoiding complicity in human rights abuses. See <a
                            href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html"
                            class="text-black font-bold">Intel’s Global Human Rights Principles</a>. Intel’s products
                        and software are intended only to be used in applications that do not cause or contribute to a
                        violation of an internationally recognized human right.</p>
                </div>
                <div class="relative">
                    <div class="md:flex col-start-8 col-span-4">
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Info</h2>
                            <ul class="text-gray-600 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">For Industry Partners</a>
                                </li>
                                <li class="mb-4">
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">For Institution</a>
                                </li>
                                <li>
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">For Students</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Support</h2>
                            <ul class="text-gray-600 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    {{-- <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline ">About Us</a> --}}
                                    <a href="/#AiForFuture" class="hover:underline ">About Us</a>
                                </li>
                                <li class="mb-4">
                                    <a href="{{ route('faq') }}" class="hover:underline">FAQs</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" class="hover:underline">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                            <ul class="text-gray-600 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="{{ route('privacy-policy') }}" class="hover:underline">Privacy
                                        Policy</a>
                                </li>
                                <li>
                                    <a href="{{ route('terms-of-use') }}" class="hover:underline">Terms &amp;
                                        Conditions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-black border-t-2 sm:mx-auto lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a
                        href="/" class="hover:underline">Simulated Internship</a>. All Rights Reserved.
                </span>
                {{-- <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
              <span class="sr-only">Facebook page</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
              <span class="sr-only">Instagram page</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
              <span class="sr-only">Twitter page</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
              <span class="sr-only">GitHub account</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd" /></svg>
              <span class="sr-only">Dribbble account</span>
          </a>
      </div> --}}
            </div>
        </div>
    </footer>

    {{-- @vite('resources/js/app.js') --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    @yield('more-js')

</body>

</html>
