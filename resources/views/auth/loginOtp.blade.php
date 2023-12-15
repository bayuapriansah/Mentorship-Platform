@extends('layouts.index')
@section('content')
{{-- <div class="container">
  <div class="row justify-content-center">
    <div class=" card col-6 p-4 bg-light">
      <form method="post" action="{{ route('otp.generate') }}">
        @csrf

        <h3>LOGIN</h3>
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control">
        <label for="otp" class="form-label">OTP Code</label>
        <input type="text" id="otp" name="otp" class="form-control">
        {{-- <button type="button" class="btn btn-primary mt-2">Log In</button> --}}
        {{-- <button type="submit" class="btn btn-primary mt-2">Get OTP</button>
      </form>
    </div>
  </div>
</div>  --}}
<section id="login" class="w-full">
  {{-- <div class="w-full bg-lightest-blue"> --}}
  <div class="w-full bg-black">
    <div class="max-w-[1366px] mx-auto px-16 pb-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col ">
      <div class="col-span-5">
        <h1 class="intelOne text-primary font-bold text-4xl leading-11">Login</h1>
        <p class="intelOne font-light text-white text-lg leading-6 py-6">Sign in to your account to continue.</p>
        {{-- <form action="{{ route('otp.generate') }}" method="post" id="register"> --}}
        <form action="{{ route('multiLogInCheck') }}" method="post" id="register">
          @csrf
          <input type="email" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder focus:border focus:outline-none  focus:border-light-blue focus:ring-light-blue leading-tight {{old('email') != null ? 'border-red-500' : ''}}" value="{{old('email')}}" placeholder="Email *" id="email" name="email" required>
          @if (Session::has('email'))
              <p class="text-red-600 text-sm mt-1">
                {{ Session::get('email') }}
              </p>
          @endif

          <div class="g-recaptcha mt-4" data-sitekey="{{config('services.recaptcha.key')}}"></div>
            @if(Session::has('g-recaptcha-response'))
              <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
              {{Session::get('g-recaptcha-response')}}
              </p>
            @endif
          {{-- <div class="bg-red-alert intelOne text-sm p-4 w-2/3 rounded-lg mt-4 flex" role="alert">
            <img src="{{asset('assets/img/close.png')}}" class=" mr-4" alt="">
            This email address is already registered!
          </div> --}}
          <div class="flex">
            <button class="py-2.5 px-11 rounded-full border-2 bg-primary-darker border-solid hover:bg-primary text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Log In</button>
          </div>
        </form>
        {{-- <a href="#" class="text-primary text-xs">Login as an admin/supervisor/customer/staff member</a> --}}
      </div>
      <div class="col-start-7 col-span-6 relative">
        <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
        <img src="{{asset('assets/img/main/DBanner.png')}}" class="relative z-20" alt="">

        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
        <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
        <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->

      </div>
    </div>
  </div>

  <div class="max-w-[1366px] mx-auto px-36 py-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-5 flex ">
      <iframe width="361" height="240" src="https://www.youtube.com/embed/aZLE-c7I7uk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" allowfullscreen></iframe>
    </div>
    <div class="col-start-6 col-span-7 space-y-4 my-auto">
      <h3 class="intelOne text-black text-2xl font-semibold">Quick start video to get you going</h3>
      <p class="intelOne text-black text-base font-normal">
        Facilitate your internship experience with this quick-start video - a step-by-step guide to give you a jumpstart! The video includes essential information about what to expect during the internship, how to navigate the platform, and success tips to make the most of the opportunity.
      </p>
    </div>
  </div>
</section>
@endsection
