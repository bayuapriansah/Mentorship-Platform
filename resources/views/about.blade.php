@extends('layouts.index')
@section('content')
<section id="about" class="w-full min-h-screen">
  <div class="relative">
    <img src="{{asset('assets/img/robot-hand-finger.jpeg')}}" alt="" class="w-full h-[316px] object-cover">
    <div class="absolute bottom-14 left-32 text-white">
      <h1 class="font-bold text-3xl">About</h1>
      <h1 class="font-bold text-3xl"><span class="text-light-brown">Simulated Internship</span> Platform</h1>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 z-30 text-lg space-y-5 text-justify">
    <section id="main-text">
      <p>
        Welcome to the Simulated Internship Platform, where we strive to provide students with an environment that mimics the real-world workplace experience. Our goal is to help students develop practical skills and gain hands-on experience in a professional setting, preparing them to become the workforce of the future.
      </p>
      <p class="mt-4">
        Our platform offers a range of AI projects that cover Machine Learning (ML), Natural Language Processing (NLP), and Computer Vision (CV), designed to challenge students and expand their knowledge. Each project has its own specific requirements, and students must complete all tasks to the satisfaction of our team or their institution's supervisor.
      </p>
      <p class="mt-4">
        We understand that real-world work experience can be difficult to come by, especially for students. That's why we created the Simulated Internship Program to provide an opportunity for students to gain valuable experience and enhance their skills. The program typically lasts four months and comprises projects of various durations, generally one month.
      </p>
      <p class="mt-4">
        Our platform not only offers students the opportunity to gain hands-on experience, but also provides a collaborative environment where they can work with industry professionals and communicate with supervisors and our team for any required support. Our industry partners provide us with various projects to work on, so students can be sure that they're gaining experience in relevant and current technologies. We believe that the skills and experience students gain will be valuable assets to them at the start of their careers. Join us on this journey to hone your skills, gain real-world experience, and become ready to be a part of the future workforce.
      </p>
    </section>

    <div class="grid grid-cols-12 gap-11 grid-flow-col relative">
      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 -top-10 -right-12" aria-hidden="true" >
      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-20 -left-12 " aria-hidden="true" >
      <div class="col-span-4">
        <div class="flex flex-col">
          <img src="{{asset('assets/img/for_students.png')}}" class="relative z-30" alt="for students">
          <h1 class="text-dark-blue text-2xl font-bold py-3 relative z-30 hover:text-darker-blue"><a href="for-students">For Students</a></h1>
          <p class="text-black font-normal text-sm">Acquire Employability Skills, Gain Industry Experience, Strengthen Project Portfolio</p>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex flex-col">
          <img src="{{asset('assets/img/for_institution.png')}}" class="relative z-20 mt-5" alt="for students">
          <h1 class="text-dark-blue text-2xl font-bold py-3 -mt-4 relative z-30 hover:text-darker-blue"><a href="for-institution">For Institutes</a></h1>
          <p class="text-black font-normal text-sm">Enhanced Student Employability, Collaborate with Industry leaders, Supervise Real-World AI Projects</p>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex flex-col">
          <img src="{{asset('assets/img/for_industries.png')}}" class="relative z-20" alt="for students">
          <h1 class="text-dark-blue text-2xl font-bold py-3 relative z-30 hover:text-darker-blue"><a href="for-industry">For Industries</a></h1>
          <p class="text-black font-normal text-sm">Identify Top Future Talents, Collaborate with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
        </div>
      </div>
    </div>
  </div>
  
</section>
@endsection