@extends('layouts.index')
@section('content')
<section id="faq" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-7 relative">
        <h1 class="font-bold text-white text-3xl leading-10 relative z-20 ">Contact Us</h1>
        <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 -top-6 ">
        
      </div>
      <div class="col-start-10 col-span-4 relative ">
        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 -top-16 right-0 " aria-hidden="true" >

      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-7">
      <div class="mt-4">
        @include('flash-message')
      </div>
      <form action="/contact" method="post">
        @csrf
        <div class="mb-3 flex justify-between">
          <input type="text" name="first_name" placeholder="First Name*" class="border border-light-blue rounded-lg w-1/2 mr-5 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" 
          @if (Auth::guard('student')->check())
            value={{Auth::guard('student')->user()->first_name}}
            disabled
          @endif
          required>
          @error('first_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror

          <input type="text" name="last_name" placeholder="Last Name*" class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none"
          @if (Auth::guard('student')->check())
            value={{Auth::guard('student')->user()->last_name}}
            disabled
          @endif
          required>
          @error('last_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        <div class="mb-3">
          <input type="text" name="email" placeholder="Email Address*" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none"
          @if (Auth::guard('student')->check())
            value={{Auth::guard('student')->user()->email}}
            disabled
          @endif
          required>
          @error('email')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        <div class="mb-3">
          <textarea id="comment" name="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-light-blue focus:outline-none" placeholder="Your Message*" required></textarea>
          @error('message')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
          @enderror
        </div>
        <div class="mb-3">
          <p>Please check the box below to proceed.</p>
          <div class="g-recaptcha mt-4" data-sitekey="{{config('services.recaptcha.key')}}"></div>
          @if(Session::has('g-recaptcha-response'))
            <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
            {{Session::get('g-recaptcha-response')}}
            </p>
          @endif
        </div>
        <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Send</button>
      </form>
    </div>
    <div class="col-start-8 col-span-5">
      <img src="{{asset('assets/img/image19.png')}}" alt="">
      <h5 class="font-bold text-xl py-5">About intel digital readliness</h5>
      <p class="text-grey font-normal text-sm">Intel® Digital Readiness Programs empower the non-technical audiences with the appropriate skill sets, mind-sets, toolsets, and opportunities to use technology impactfully and responsibly in the AI-fuelled world.</p>
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection