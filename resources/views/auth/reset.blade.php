@extends('layouts.index')
@section('content')
<section id="login" class="w-full">
  <div class="w-full bg-lightest-blue">
    <div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-6">
        <h1 class="intelOne text-dark-blue font-bold text-4xl leading-11">Reset password</h1>
        <p class="intelOne font-light text-black text-lg leading-6 py-6">Please enter your new password below to reset your account password</p>
        <form action="{{route('resetPassword')}}" method="post" id="register">
          @csrf
          <input type="hidden" name="token" value="{{$token}}">
          <input type="email" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" value="{{$email ?? old('email')}}" placeholder="Email" id="email" name="email" readonly>
          @error('email')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
          <input type="password" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Password" id="password" name="password" required>
          @error('password')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
          <input type="password" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"  placeholder="Confirm password" name="password_confirmation" required>
          @error('password_confirmation')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror

          <div class="mt-4">
            @include('flash-message')
          </div>

          <div class="flex">
            <button class="py-2.5 px-11 rounded-full border-2 bg-darker-blue border-solid hover:bg-dark-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Reset Password</button>
          </div>
        </form>
      </div>
      <div class="col-start-7 col-span-6 relative">
        <img src="{{asset('assets/img/home1.png')}}" class="relative z-20" alt="">

        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
        <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >

      </div>
    </div>
  </div>

  <div class="max-w-[1366px] mx-auto px-36 py-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-5 flex ">
      <iframe width="361" height="240" src="https://www.youtube.com/embed/aZLE-c7I7uk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
