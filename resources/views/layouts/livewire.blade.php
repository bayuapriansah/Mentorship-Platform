<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body>
    <div class="max-w-2xl mx-auto">

        {{ $slot }}
    </div>

    @livewireScripts
</body>
