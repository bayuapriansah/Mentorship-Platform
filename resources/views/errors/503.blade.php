<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>Under Maintenance</title>
</head>
<body class="bg-profile-grey min-h-screen ">
  <div class="flex justify-center">
    <div class="w-4/5 " style="padding: 120px 0;">
      <div class="flex justify-between">
        <div class="flex-col my-auto w-1/2 space-y-7">
          <img src="{{asset('assets/img/Intel-logo-2022.png')}}" class="mb-10" alt="">
          <h1 class="text-dark-blue my-8 text-3xl">Website is under maintenance</h1>
          <div class="text-justify text-2xl">
            Thank you for visiting our website. We're currently making some updates to provide you with an even better experience. We're sorry for any inconvenience this may cause and we appreciate your patience as we work to improve our site.
          </div>
          <div class="text-justify text-2xl">
            We're doing everything we can to minimize the downtime and ensure that our website is back up and running as soon as possible. Thank you for your understanding and support. We look forward to seeing you again soon.
          </div>
          <p>
          <div class="font-medium space-y-2 text-justify text-1xl">
            With best regards,
          </div>
          <div class="font-medium space-y-2 text-light-brown text-justify text-1xl">
            Simulated Internship Team
          </div>
          {{-- <h1 class="text-light-brown text-2xl font-medium space-y-2">
            Scheduled maintenance <br>
            <span class="text-black text-2xl">8th March 6:30am - 12:30pm IST.</span>
          </h1> --}}
        </div>
        <div class="w-1/2">
          <img src="{{url('/assets/img/error_page/under_construction.png')}}" class="!w-[513px] !h-[379px]" style="width: 513px; height: 379px;" alt="Image"/>
        </div>
      </div>
    </div>
  </div>
  <div class="relative">
    <div class="w-full bg-dark-blue text-white bottom-0">
      <div class="px-11 pt-12 pb-3">
        <p class="border-t text-xs">© 2023 Intel Simulated Internships. All rights reserved.</p>
      </div>
    </div>
  </div>
</body>
</html>