
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
  <div class="w-full bg-dark-blue">
    <nav class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-14 grid-flow-col items-center">
      <a href="/" class="col-span-3">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" class="" alt="">
      </a>
      <ul class="mx-1.5 col-start-5 col-span-4 flex justify-between text-black">
        <li class="text-white intelOne font-light text-sm"><a href="/">Home</a></li>
        <li class="text-white intelOne font-light text-sm"><a href="#">Internship Programs</a></li>
        <li class="text-white intelOne font-light text-sm"><a href="#">Industry Partners</a></li>
      </ul>
      <div class="col-start-9 col-span-4 flex justify-between">
        <button class="py-2 px-14 rounded-full border-2 border-solid border-light-grey text-center capitalize bg-orange text-white font-light text-sm intelOne ml-4">Login</button>
        <a href="{{route('registerPage')}}" class="py-2 px-11 rounded-full border-2 border-solid border-light-grey bg-light-grey text-center capitalize bg-orange text-darker-blue font-normal text-sm intelOne">Register</a>
      </div>
    </nav>
  </div>
  

  {{-- <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Intel</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link link-dark px-2" aria-current="page">Home</a></li>
        
        @if(Auth::guard('student')->check())
        <li class="nav-item"><a href="{{route('projects.index')}}" class="nav-link link-dark px-2">Project Page</a></li>
        <div class="btn-group">
          <button type="button" class="btn btn-danger">{{Auth::guard('student')->user()->email}}</button>
          <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('student.register', [Auth::guard('student')->user()->email]) }}">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <form class="inline" method="post" action="{{ route('logout') }}">
              @csrf
              <li><button type="submit" class="btn dropdown-item">Log Out</button></li>
            </form>
          </ul>
        </div>
        @elseif(Auth::guard('mentor')->check())
        //cek routenya han
        <li class="nav-item"><a href="{{route('dashboard.mentor')}}" class="nav-link link-dark px-2">Dashboard</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">{{Auth::guard('mentor')->user()->email}}</a></li>
        <form class="inline" method="post" action="/logout">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        @elseif(Auth::guard('company')->check())
        <li class="nav-item"><a href="{{route('dashboard.company')}}" class="nav-link link-dark px-2">Dashboard</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">{{Auth::guard('company')->user()->name}}</a></li>
        <form class="inline" method="post" action="/logout">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        @elseif(Auth::guard('web')->check())
        <li class="nav-item"><a href="{{route('dashboard.admin')}}" class="nav-link link-dark px-2">Dashboard</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">{{Auth::guard('web')->user()->name}}</a></li>
        <form class="inline" method="post" action="/logout">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        @else
        <li class="nav-item"><a href="{{ route('otp.login') }}" class="nav-link link-dark px-2">Sign In</a></li>
        <li class="nav-item"><a href="/#register" class="nav-link link-dark px-2">Register</a></li>
        @endif
      </ul>
    </header>
  </div>  --}}
  <main>
  @yield('content')
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
    <hr class="h-px bg-gray-200 border-1 dark:bg-gray-700">
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
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('more-js')
  </body>
</html>
