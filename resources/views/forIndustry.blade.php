@extends('layouts.index')
@section('content')
<section id="for-institutes" class="min-h-screen ">
  <div class="relative mx-auto">
    <img src="{{asset('assets/img/for-industry/hero1.png')}}" alt="" class="w-full h-[556px] object-cover">
    <div class="absolute bottom-[15%] left-[4%] text-white bg-darker-blue rounded-3xl opacity-90 p-9 max-w-xl">
      <div class="flex flex-col opacity-100 space-y-4">
        <h1 class="font-bold text-3xl leading-8"><span class="text-light-brown">Simulated Internship</span> Platform for <span class="text-light-brown">Partners</span></h1>
        <p class="text-[23px] font-light">Enroll your institute today to provide a virtual environment for students to work on real-world projects that simulate the demands of the workforce.</p>
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-40 py-16 z-30 text-lg space-y-20 text-justify">
    <div id="main-text" class="flex flex-col">
      <div class="flex justify-between">
        <div class="w-[60%] my-auto">
          <h1 class="font-bold text-3xl leading-8">
            <span class="text-dark-blue">Simulated <br>Internships</span><br>
            <span class="text-light-brown">For Partners</span>
          </h1>
        </div>
        <div class="w-full pl-20">
          <p>Collaborating with a platform that connects students with real-world problems presents an excellent opportunity for companies to receive innovative insights and potential solutions to their most pressing challenges. By sharing problem statements and anonymized data with the platform, partners can benefit from the diverse expertise and innovative thinking of a talented and motivated pool of students.</p>
        </div>
      </div>
      <div class="flex">
        <div class=" w-1/2 my-auto">
          <p>
            Students participating in the program come from various fields, such as engineering, computer science, business, and social sciences, providing partners with access to a broad range of perspectives and expertise. Additionally, students are often keen to work on real-world projects that can help them build their skills and gain practical experience, making it a mutually beneficial program for both partners and students.
          </p>
        </div>
        <div class="w-1/2">
          <img src="{{asset('assets/img/for-industry/image 71.png')}}" alt="" style="width: 376px; height: 251px;">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection