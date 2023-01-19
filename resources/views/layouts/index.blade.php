
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
    {{-- <link href="https://fonts.cdnfonts.com/css/intelone-display" rel="stylesheet"> --}}
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
  <div class="w-full bg-white">
    <nav class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-14 grid-flow-col items-center">
      <a href="/" class="col-span-3">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" class="" alt="">
      </a>
      <ul class="col-start-5 col-span-4 flex justify-between text-black">
        <li class="text-dark-blue intelOne font-light text-sm"><a href="/" class="hover:text-neutral-500">Home</a></li>
        <li class="text-dark-blue intelOne font-light text-sm"><a href="{{route('projects.index')}}" class="hover:text-neutral-500">Internship Projects</a></li>
        <li class="text-dark-blue intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Industry Partners</a></li>
      </ul>
      <div class="col-start-9 col-span-4 flex relative {{Auth::guard('web')->check() || Auth::guard('student')->check() ? 'justify-end':'justify-between'}}">
        @if(Auth::guard('student')->check())
        <ul class="space-x-9 flex items-end text-black ">
          <li class="text-dark-blue intelOne font-light text-sm my-auto">
            <a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="py-2 px-12 rounded-full border-[1px] border-solid border-dark-blue text-center capitalize bg-orange text-dark-blue hover:bg-dark-blue hover:text-white font-light text-sm intelOne ml-10">
              Profile
            </a>
          </li>
          <form class="inline" method="post" action="{{ route('logout') }}">
            @csrf
            <li><button type="submit" class="py-2 px-11 rounded-full border-2 border-solid border-light-grey bg-light-grey text-center capitalize bg-orange text-darker-blue font-normal text-sm intelOne">Log Out</button></li>
          </form>
        </ul>
        @elseif(Auth::guard('web')->check())
        <ul class="text-left z-40">
          <li>
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="intelOne text-darker-blue bg-light-grey  hover:bg-neutral-200 focus:ring-4 focus:outline-none focus:ring-light-grey font-medium rounded-lg text-sm px-11 py-2 text-center inline-flex items-center " type="button">{{Auth::guard('web')->user()->email}} <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
      <!-- Dropdown menu -->
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44">
                <ul class="py-1 text-sm text-gray-700 " aria-labelledby="dropdownDefaultButton">
                  <li>
                    <a href="{{route('dashboard.admin')}}" class="block px-4 py-2 hover:text-dark-blue hover:font-semibold">Dashboard</a>
                  </li>
                  <form class="inline" method="post" action="{{ route('logout') }}" class="hover:bg-gray-100">
                    @csrf
                    <li><button type="submit" class="block px-4 py-2 hover:text-dark-blue hover:font-semibold intelOne">Log Out</button></li>
                  </form>
                </ul>
            </div>
          </li>
        </ul>      
        @else
        <a href="{{ route('otp.login') }}" class="py-2 px-14 rounded-full border-[1px] border-solid border-dark-blue text-center capitalize bg-orange text-dark-blue hover:bg-neutral-100 font-light text-sm intelOne ml-10">Login</a>
        <a href="{{route('registerPage')}}" class="py-2 px-11 rounded-full border-2 border-solid border-dark-blue bg-dark-blue text-center capitalize bg-orange text-white hover:bg-darker-blue font-normal text-sm intelOne">Register</a>
        @endif
        
      </div>
    </nav>
  </div>
  <main>
  @yield('content')
  </main>
  <footer class="w-full bg-lightest-blue relative z-30">
    <div class="max-w-[1366px] mx-auto px-16 pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container">
      <div class="col-span-4">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" alt="">
        <p class="text-grey font-normal text-[10px] pt-2 ">Intel technologies may require enabled hardware, software or service activation. // No product or component can be absolutely secure. // Your costs and results may vary. // Performance varies by use, configuration and other factors. // See our complete legal <span class="text-black">Notices and Disclaimers</span>. // Intel is committed to respecting human rights and avoiding complicity in human rights abuses. See Intel's Global Human Rights Principles. Intel's products and software are intended only to be used in applications that do not cause or contribute to a violation of an internationally recognised human right.</p>
      </div>
      <div class="col-start-6 col-span-2 flex flex-col">
        <ul class="text-dark-blue text-xs font-normal">
          <li class="pb-3"><a href="">About Us</a></li>
          <li class="pb-3"><a href="">For Industry Partners</a></li>
          <li class="pb-3"><a href="">For Institution</a></li>
          <li class="pb-3"><a href="">For Students</a></li>
        </ul>
      </div>
      <div class="col-start-8 col-span-2 flex flex-col">
        <ul class="text-dark-blue text-xs font-normal">
          <li class="pb-3"><a href="">FAQs</a></li>
          <li class="pb-3"><a href="">Contact Us</a></li>
          <li class="pb-3"><a href="">Help and Support</a></li>
        </ul>
      </div>
      <div class="col-start-10 col-span-2 flex flex-col">
        <ul class="text-dark-blue intelOne text-xs font-normal">
          <li class="pb-3"><a href="">Terms & Conditions</a></li>
          <li class="pb-3"><a href="">Privacy Policies</a></li>
          <li class="pb-3"><a href="">Site Map</a></li>
          <li class="pb-3"><a href="">Cookie Settings</a></li>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.min.js"></script>

    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('more-js')
  </body>
</html>
