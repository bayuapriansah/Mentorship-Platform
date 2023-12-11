@extends('layouts.index')
@section('content')
<div class="max-w-[1366px] min-h-[539px] mx-auto bg-white flex flex-col justify-center items-center">
    <img src="{{ asset('/assets/img/icons8-verified-account.gif') }}" alt="Illustration" class="w-[70px]">

    <h1 class="mt-2 text-darker-blue font-bold text-3xl text-center">
        Email address verified successfully!
    </h1>

    <p class="mt-2 text-center text-xl">
        Thanks for signing up for Simulated Mentorship Platform.<br>
        We're happy to have you.
    </p>

    <a href="{{ route('multiLogIn') }}" class="min-w-[190px] min-h-[51px] mt-10 flex justify-center items-center bg-primary rounded-full text-white text-sm">
        Proceed
    </a>
</div>
{{-- <section class="w-full">
  <div class="max-w-[1366px] mx-auto px-16 pt-28 pb-36 ">
    <div class="grid grid-cols-[repeat(auto-fit,_16.666666%)] m-auto justify-center">
      <div class="w-full p-8 col-span-4 text-center justify-center justify-self-center mx-auto space-y-3">
        <img src="{{asset('assets/img/icons8-verified-account.gif')}}" alt="" class="mx-auto">
        <h1 class="intelOne text-dark-blue font-bold text-3xl">Email address verified successfully!</h1>
        <p class="intelOne text-dark-blue text-xl">Thank you for signing up to Simulated Internship Platform for Industry Readiness. We are happy to have you. </p>
        <p></p>
        <a href="{{route('otp.login')}}" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-16 py-3.5 mt-20 rounded-full">Click here to login</a>
      </div>
    </div>
  </div>
</section> --}}
@endsection
