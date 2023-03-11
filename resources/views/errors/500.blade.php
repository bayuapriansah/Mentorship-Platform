<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')

</head>
<body>
  <div class="w-full bg-profile-grey min-h-screen">
    <nav class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-14 grid-flow-col items-center">
      <a href="/" class="col-span-2">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" class="" alt="">
      </a>
    </nav>
    <div class="flex justify-center">
      <img src="{{url('/assets/img/error_page/404.png')}}" alt="Image"/>
    </div>
  </div>
</body>
</html>