@extends('layouts.index')
@section('content')
<section id="for-students" class="min-h-screen ">
  <div class="relative mx-auto">
    <img src="{{asset('assets/img/for-students-banner.png')}}" alt="" class="w-full">
    <div class="absolute bottom-1/4 left-[10%] text-white bg-darker-blue rounded-xl opacity-90 p-9 max-w-xl">
      <div class="flex flex-col opacity-100 space-y-4">
        <h1 class="font-bold text-3xl leading-8"><span class="text-light-brown">Simulated Internship</span> Platform for <span class="text-light-brown">Students</span></h1>
        <p class="text-[23px] font-light">Join today to work on real-world projects and kick-start your career!</p>
        <a href="#" class="py-2.5 px-11 rounded-full bg-white text-center capitalize bg-orange text-dark-blue font-light text-sm w-1/3">Get Started</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection