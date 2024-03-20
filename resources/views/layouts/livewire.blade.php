<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="max-w-2xl mx-auto">

        {{ $slot }}
    </div>

    @livewireScripts
</body>
