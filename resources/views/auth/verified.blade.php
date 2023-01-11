@extends('layouts.index')
@section('content')
<section class="w-full">
  <div class="max-w-[1366px] mx-auto px-16 pt-28 pb-36 ">
    <div class="grid grid-cols-[repeat(auto-fit,_16.666666%)] m-auto justify-center">
      <div class="w-full p-8 col-span-4 text-center justify-center justify-self-center mx-auto space-y-3">
        <img src="{{asset('assets/img/icons8-verified-account.gif')}}" alt="" class="mx-auto">
        <h1 class="intelOne text-dark-blue font-bold text-3xl">Email address verified successfully!</h1>
        <p class="intelOne text-dark-blue text-xl">Thanks for signing up for Intel Simulated Internship Programs. We're happy to have you.</p>
        <p class="intelOne text-ligt-black text-xl">Your mail has been verified successfully...</p>

      </div>
    </div>
  </div>

  {{-- <div class="max-w-[1366px] mx-auto px-16 pt-28 pb-36 col-auto">
    <div class="grid grid-cols-[repeat(auto-fit,_16.666666%)] m-auto p-24 justify-center bg-slate-500">
      <div class="w-full p-8 col-span-2 justify-center justify-self-center mx-auto bg-slate-900 text-white text-center text-lg">
        2 cols, should be centered
      </div>
    </div>
  </div> --}}

</section>
@endsection