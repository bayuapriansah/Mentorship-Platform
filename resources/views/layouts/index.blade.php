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
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta name="theme-color" content="#712cf9">
</head>

<body>
    {{-- Navbar 2 --}}
    <nav class="bg-white border-gray-200 dark:bg-gray-900 px-12 phone:px-4">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('index') }}" class="text-dark-blue no-underline hover:text-lightest-blue">
                <img src="{{ asset('assets/img/logo/AIGlobalImpactFestival_Logo.svg') }}" class="" alt="Impact Festival Logo">
            </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @if (isLoggedIn())
                <button id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom" class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:mr-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                    type="button">
                    <span class="sr-only">Open user menu</span>
                    <i class="fa-solid fa-user fa-fade mr-2"></i>
                    {{ nameUserAuth() }}
                    <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ nameUserAuth() }}</span>
                    <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ emailUserAuth() }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        @if (Auth::guard('student')->check())
                            <a href="{{ route('student.allProjects', ['student' => Auth::guard('student')->user()->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        @elseif(Auth::guard('web')->check())
                            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        @elseif(Auth::guard('mentor')->check())
                            <a href="{{ route('dashboard.mentor') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        @elseif(Auth::guard('customer')->check())
                            <a href="{{ route('dashboard.customer') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                         @endif
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Log out</a>
                        <form id="logout-form" class="inline" method="post" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            @else
                <a href="{{ route('multiLogIn') }}"
                    class="border-primary hover:border-primary-500 hover:text-primary-800 text-primary rounded-full border-[1px] border-solid px-4 py-2">Login</a>
                <a href="{{ route('registerPage') }}"
                    class="border-primary bg-primary hover:border-primary-500 hover:bg-primary-800 text-white rounded-full border-[1px] border-solid px-4 py-2">Register</a>
            @endif
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
          <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
            <li>
              <a href="{{ route('index') }}" class="block py-2 px-3 rounded {{ Request::routeIs('index') ? 'text-primary-800 hover:text-black' : 'text-black hover:text-primary-800' }}" aria-current="page">Home</a>
            </li>
            <li>
              <a href="{{ route('projects.index') }}" class="block py-2 px-3 rounded {{ Request::routeIs('projects.index') ? 'text-primary-800 hover:text-black' : 'text-black hover:text-primary-800' }}">Skill Track</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-3 rounded {{ Request::routeIs('projects.index') ? 'text-primary-800 hover:text-black' : 'text-black hover:text-primary-800' }}">Project Track</a>
            </li>
          </ul>
        </div>
        </div>
      </nav>

    {{-- Navbar 2 End --}}

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#E9E9E9]">
        <div class="max-w-screen-xl mx-auto px-12 py-4" id="AiForFuture">
            <div class="p-4 py-6 lg:py-8">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/logo/AIGlobalImpactFestival_Logo.svg') }}"
                            class="object-scale-down h-15 w-auto py-4" alt="Intel Digital Readiness Logo" />
                    </a>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="relative">
                    <p class="text-justify text-black">Intel technologies may require enabled
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
                            <h2 class="mb-6 text-sm font-semibold text-black uppercase dark:text-black">Info</h2>
                            <ul class="text-black dark:text-gray-400 font-normal">
                                <li class="mb-4">
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">Project Track</a>
                                </li>
                                <li class="mb-4">
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">Skill Track</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('students.info') }}" class="hover:underline">For Students</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-black uppercase dark:text-black">Support</h2>
                            <ul class="text-black dark:text-gray-400 font-normal">
                                <li class="mb-4">
                                    <a href="{{ route('faq') }}" class="hover:underline">FAQs</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" class="hover:underline">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-black uppercase dark:text-black">Legal</h2>
                            <ul class="text-black dark:text-gray-400 font-normal">
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
                <span class="text-sm text-black sm:text-center dark:text-gray-400">© {{ date('Y') }} <a
                        href="/" class="hover:underline">Simulated Internship</a>. All Rights Reserved.
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
