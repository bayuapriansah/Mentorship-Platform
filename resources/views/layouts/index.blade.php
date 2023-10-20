<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simulated Internship</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icon/favicon.ico') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://kit.fontawesome.com/682a164d7d.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta name="theme-color" content="#712cf9">
</head>

<body>
    {{-- NAVBAR --}}
    <x-navbar></x-navbar>

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
    <x-footer></x-footer>

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
