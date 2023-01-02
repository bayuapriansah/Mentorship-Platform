
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulated Internship</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
  <main>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Intel</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link link-dark px-2" aria-current="page">Home</a></li>
        
        @if(Auth::guard('student')->check())
        <li class="nav-item"><a href="{{route('projects.index')}}" class="nav-link link-dark px-2">Project Page</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">{{Auth::guard('student')->user()->email}}</a></li>
        <form class="inline" method="post" action="/logout">
          @csrf
          <button type="submit" class="btn btn-primary">Logout</button>
        </form>
        @elseif(Auth::guard('mentor')->check())
        {{-- Cek Route nya han --}}
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
  </div>

    @yield('content')
    
    <div class="container">
      <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
        <div class="col mb-3">
          <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
          </a>
          <p class="text-muted">&copy; 2022</p>
        </div>
    
        <div class="col mb-3">
    
        </div>
    
        <div class="col mb-3">
          <h5>Section</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
          </ul>
        </div>
    
        <div class="col mb-3">
          <h5>Section</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
          </ul>
        </div>
    
        <div class="col mb-3">
          <h5>Section</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
          </ul>
        </div>
      </footer>
    </div>
  </div>
</main>
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('more-js')
  </body>
</html>
