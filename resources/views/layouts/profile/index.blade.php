
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulated Internship</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/icon/favicon.ico')}}">
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
        @if(Route::is('student.allProjects') || Route::is('student.ongoingProjects') || Route::is('student.completedProjects'))
          <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="hover:text-neutral-500">My Project</a></li>
        @else
          <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="hover:text-neutral-500">My Project</a></li>
        @endif

        @if(Route::is('student.allProjectsAvailable') || Route::is('student.availableProjectDetail'))
          <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable" class="hover:text-neutral-500">Internship Programs</a></li>
        @else
          <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable" class="hover:text-neutral-500">Internship Programs</a></li>
        @endif

        <li class="text-black intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Certificate</a></li>
        <li class="text-black intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Support</a></li>
      </ul>

      <div class="col-start-9 col-span-4 flex relative ">
        @if (!Route::is('student.edit'))
          @include('layouts.profile.sidebar')
          @else
          <div class="w-full bg-white absolute -top-5 rounded-xl border border-light-blue p-4">
            <div class="grid grid-cols-12 gap-2 grid-flow-col">
              <div class="col-span-2">
                <button type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="notification_bel">
                  <svg class="w-6 h-6"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <span class="sr-only">Notifications Bell</span>
                  {{-- <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $newMessage->count() }}</div> --}}
                  </button>
              </div>
              <div class="col-span-2">
                <button type="button" data-modal-target="message-modal" data-modal-toggle="message-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="message">
                  <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <span class="sr-only">Notifications Message</span>
                  <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $newMessage->count() }}</div>
                </button>
              </div>
              <div class="col-span-2">
                <a href="/profile/{{Auth::guard('student')->user()->id}}/edit" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                  </svg>
                  <span class="sr-only">Profile edit</span>
                </a>
              </div>
              <div class="col-end-13">
                <form class="inline" method="post" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="Logout">
                  <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endif
        
      </div>
    </nav>
  </div>

  <main class="bg-profile-grey ">
    @yield('content') 
  </main>

  <footer class="w-full bg-lightest-blue relative z-30">
    <div class="max-w-[1366px] mx-auto px-16 pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container">
      <div class="col-span-4">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" alt="">
        <p class="text-grey font-normal text-[10px] pt-2 ">Intel technologies may require enabled hardware, software or service activation. // No product or component can be absolutely secure. // Your costs and results may vary. // Performance varies by use, configuration and other factors. // See our complete legal <span class="text-black">Notices and Disclaimers</span>. // Intel is committed to respecting human rights and avoiding complicity in human rights abuses. See <span class="text-black">Intel's Global Human Rights Principles</span>. Intel's products and software are intended only to be used in applications that do not cause or contribute to a violation of an internationally recognised human right.</p>
      </div>
      <div class="col-start-6 col-span-2 flex flex-col">
        <ul class="text-dark-blue text-xs font-normal">
          <li class="pb-3"><a href="/#AiForFuture">For Industry Partners</a></li>
          <li class="pb-3"><a href="/#AiForFuture">For Institution</a></li>
          <li class="pb-3"><a href="/#AiForFuture">For Students</a></li>
        </ul>
      </div>
      <div class="col-start-8 col-span-2 flex flex-col">
        <ul class="text-dark-blue text-xs font-normal">
          <li class="pb-3"><a href="/faq">FAQs</a></li>
          <li class="pb-3"><a href="">Contact Us</a></li>
          <li class="pb-3"><a href="/#AiForFuture">About Us</a></li>
        </ul>
      </div>
      <div class="col-start-10 col-span-2 flex flex-col">
        <ul class="text-dark-blue intelOne text-xs font-normal">
          <li class="pb-3"><a href="/terms-of-use">Terms & Conditions</a></li>
          <li class="pb-3"><a href="/privacy-policy">Privacy Policies</a></li>
        </ul>
      </div>
    </div>
    <div class="w-full border-t border-grey">
      <div class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-11 grid-flow-col ">
        <div class="col-span-5 my-auto ">
          <p class="text-grey font-normal text-xs pt-2 intelOne">© 2023 Intel Simulated Internships. All rights reserved.</p>
        </div>
      </div>
    </div>
    
  </footer>

  @php
      $top = exec("top -bn1 | grep 'Cpu(s)'");
      preg_match_all("/\s+([0-9\.]+)%\s+id/", $top, $cores);
      $cores = $cores[1];
      foreach ($cores as $index => $usage) {
        echo "Core " . ($index + 1) . ": " . $usage . "%<br>";
      }
  @endphp
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.min.js"></script> --}}

    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('more-js')
  </body>
</html>
