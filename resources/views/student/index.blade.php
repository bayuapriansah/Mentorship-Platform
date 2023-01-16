
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulated Internship</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    @vite('resources/css/app.css')
    {{-- font --}}
    <link href="https://fonts.cdnfonts.com/css/intelone-display" rel="stylesheet">
    <meta name="theme-color" content="#712cf9">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>
    <!-- Custom styles for this template -->
  </head>
<body>
  <div class="w-full bg-profile-grey">
    <nav class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-14 grid-flow-col items-center">
      <a href="/" class="col-span-2">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" class="" alt="">
      </a>
      <ul class="col-start-4 col-span-5 flex justify-between text-black">
        <li class="text-dark-blue intelOne font-light text-sm"><a href="/" class="hover:text-neutral-500">My Project</a></li>
        <li class="text-dark-blue intelOne font-light text-sm"><a href="{{route('projects.index')}}" class="hover:text-neutral-500">Internship Programs</a></li>
        <li class="text-dark-blue intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Certificate</a></li>
        <li class="text-dark-blue intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Support</a></li>
      </ul>
      <div class="col-start-9 col-span-4 flex relative">
        <div class="w-full bg-white absolute -top-5 rounded-xl border border-light-blue p-5">
          <div class="grid grid-cols-12 gap-2 grid-flow-col">
            <div class="col-span-2">
              <img src="{{asset('assets/img/icon/profile/bel.png')}}" alt="notification_bel">
            </div>
            <div class="col-span-1">
              <img src="{{asset('assets/img/icon/profile/message.png')}}" alt="message">
            </div>
            <div class="col-end-13">
              <img src="{{asset('assets/img/icon/profile/logout.png')}}" alt="message">
            </div>
          </div>
          <div class="flex flex-col mt-8 ">
            <div class="mx-auto">
              <img src="{{asset('assets/img/icon/profile/pp.png')}}" class="w-[100px] h-[100px]  mx-auto"  alt="message">
              <p class="text-dark-blue font-normal text-xl text-center ">Shweta Tripathi</p>
              <p class="text-black font-normal text-sm text-center">4th Year, B.Tech in Computer Science & Engineering </p>
              <p class="text-dark-blue font-bold text-sm text-center ">IIT BOMBAY</p>
              <p class="text-black font-normal text-sm text-center">Internship Status: <span class="text-light-blue">Not Started</span> </p>
            </div>
          </div>
          <div class="flex justify-between mt-8 ">
            <div>
              <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">0</p>
              <p class="text-light-black text-sm font-normal">Projects Enrolled</p>
            </div>
            <div>
              <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">0</p>
              <p class="text-light-black text-sm font-normal">Projects Completed</p>
            </div>
          </div>
          <div class="mx-auto border border-light-blue rounded-xl mt-7 text-center p-3">
            <p class="text-black text-sm font-normal">Total Enrolled Duration: </p>
            <p class="text-dark-blue text-sm font-bold">0 Months out of 3 Months</p>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <main class="mb-[500px] bg-profile-grey ">
    <div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
      <div class="col-span-8">
        <div class="grid grid-cols-12 gap-4 grid-flow-col">
          <div class="col-span-3">
            <h2 class="text-dark-blue text-2xl font-medium">My Projects</h2>
          </div>
        </div>
      </div>
    </div>
  {{-- @yield('content') content didalem main --}}
  </main>
  <footer class="w-full bg-lightest-blue relative z-30">
    <div class="max-w-[1366px] mx-auto px-16 pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container">
      <div class="col-span-3">
        <img src="{{asset('assets/img/Intelblue 1.png')}}" alt="">
        <p class="text-grey font-normal text-xs pt-2 intelOne">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
      </div>
      <div class="col-start-7 col-span-2 flex flex-col">
        <ul class="text-dark-blue intelOne text-xs font-normal">
          <li class="pb-3"><a href="">About Us</a></li>
          <li class="pb-3"><a href="">For Industry Partners</a></li>
          <li class="pb-3"><a href="">For Institution</a></li>
          <li class="pb-3"><a href="">For Students</a></li>
        </ul>
      </div>
      <div class="col-start-9 col-span-2 flex flex-col">
        <ul class="text-dark-blue intelOne text-xs font-normal">
          <li class="pb-3"><a href="">FAQs</a></li>
          <li class="pb-3"><a href="">Contact Us</a></li>
          <li class="pb-3"><a href="">Help and Support</a></li>
        </ul>
      </div>
      <div class="col-start-11 col-span-2 flex flex-col">
        <ul class="text-dark-blue intelOne text-xs font-normal">
          <li class="pb-3"><a href="">Terms & Conditions</a></li>
          <li class="pb-3"><a href="">Privacy Policies</a></li>
          <li class="pb-3"><a href="">Site Map</a></li>
          <li class="pb-3"><a href="">Cookie Settings</a></li>
        </ul>
      </div>
    </div>
    <hr class="h-px bg-gray-200 border-1">
    <div class="max-w-[1366px] mx-auto px-16 py-10 grid grid-cols-12 gap-11 grid-flow-col">
      <div class="col-span-5 my-auto">
        <p class="text-grey font-normal text-xs pt-2 intelOne">© 2023 Intel Simulated Internships. All rights reserved.</p>
      </div>
      <div class="col-end-13 col-span-2 flex flex-col">
        <p class="text-grey font-normal text-xs pt-2 intelOne">Powered by</p>
        <img class="h-9 w-[71px]" src="{{asset('assets/img/image_3.png')}}" alt="">
      </div>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.min.js"></script>

    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('more-js')
  </body>
</html>
