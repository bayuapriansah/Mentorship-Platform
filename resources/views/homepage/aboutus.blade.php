@extends('layouts.index')
@section('content')
{{-- Body Contents --}}
<div style="background-image: url({{ asset('assets/img/aboutus.jpeg') }}); background-size: cover;" class="max-w-full bg-no-repeat bg-center">
    <div class="max-w-screen-xl mx-auto px-6 py-28 ">
        <div class="grid md:grid-cols-2 gap-4 items-center ">
            <div class="my-auto">
                <h2 class="intelOne text-white font-bold text-xl hd:text-3xl leading-11">
                    <p>About</p>
                    <p class="text-light-brown">Simulated Internship<span class="text-white"> Platform</span></p>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-16 py-16 grid grid-cols-12 grid-flow-col text-justify">
    <div class="col-span-12 text-sm font-normal">
      <div class="space-y-3">
        <p>
            Welcome to the Simulated Internship Platform, where we strive to provide students with an environment that mimics the real-world workplace experience. Our goal is to help students develop practical skills and gain hands-on experience in a professional setting, preparing them to become the workforce of the future.
        </p>
      <div class="space-y-3">
        <p>
            Our platform offers a range of AI projects that cover Machine Learning (ML), Natural Language Processing (NLP), and Computer Vision (CV), designed to challenge students and expand their knowledge. Each project has its own specific requirements, and students must complete all tasks to the satisfaction of our team or their institution's supervisor.
        </p>
      <div class="space-y-3">
        <p>
            We understand that real-world work experience can be difficult to come by, especially for students. That's why we created the Simulated Internship Program to provide an opportunity for students to gain valuable experience and enhance their skills. The program typically lasts four months and comprises projects of various durations, generally one month.
        </p>
      <div class="space-y-3">
        <p>
            Our platform not only offers students the opportunity to gain hands-on experience, but also provides a collaborative environment where they can work with industry professionals and communicate with supervisors and our team for any required support. Our industry partners provide us with various projects to work on, so students can be sure that they're gaining experience in relevant and current technologies. We believe that the skills and experience students gain will be valuable assets to them at the start of their careers. Join us on this journey to hone your skills, gain real-world experience, and become ready to be a part of the future workforce.
        </p>
      </div>

    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-6 pt-20 mb-0 flex flex-col md:flex-row md:space-x-4 relative">
    <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots" class="absolute z-10 -top-32 right-0"
        aria-hidden="true">
    <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots" class="absolute z-10 top-10 left-0 "
        aria-hidden="true">
    <div class="md:flex-1">
        <div class="flex flex-col px-4">
            <img src="{{ asset('assets/img/for_students.png') }}" loading="lazy" class="relative shadow-lg rounded-2xl z-20" alt="for students">
            <h1 class="text-dark-blue text-2xl font-bold py-3"><a href="{{ route('students.info') }}">For Students</a></h1>
            <p class="text-black font-normal text-sm text-justify py-3">Acquire Employability Skills, Gain Industry
                Experience, Strengthen Project Portfolio</p>
        </div>
    </div>
    <div class="md:flex-1">
        <div class="flex flex-col px-4">
            <img src="{{ asset('assets/img/for_institution.png') }}" loading="lazy" class="relative shadow-lg rounded-2xl z-20" alt="for students">
            <h1 class="text-dark-blue text-2xl font-bold py-3">For Institutes</h1>
            <p class="text-black font-normal text-sm text-justify py-3">Enhanced Student Employability, Collaborate
                with Industry leaders, Supervise Real-World AI Projects</p>
        </div>
    </div>
    <div class="md:flex-1">
        <div class="flex flex-col px-4">
            <img src="{{ asset('assets/img/for_industries.png') }}" loading="lazy" class="relative shadow-lg rounded-2xl z-20" alt="for students">
            <h1 class="text-dark-blue text-2xl font-bold py-3">For Industries</h1>
            <p class="text-black font-normal text-sm text-justify py-3">Identify Top Future Talents, Collaborate
                with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
        </div>
    </div>
</div>
@endsection
