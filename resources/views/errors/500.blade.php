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
    <div class="flex flex-col">
      <div class="flex justify-center">
        <img src="{{url('/assets/img/error_page/500.png')}}" class="object-scale-down" alt="Image"/>
      </div>
      <div class="flex justify-center">
        <a href="{{ URL::previous() }}" class="px-5 pb-2 py-2 rounded-lg text-white bg-darker-blue hover:bg-dark-blue" >Go Back</a>
      </div>
    </div>
  </div>
</body>
</html>