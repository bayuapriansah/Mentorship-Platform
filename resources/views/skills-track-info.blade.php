@php
    $skills = [
        'Data Collection',
        'Data Wrangling',
        'Data Pipelining',
        'AI Model Building',
        'AI Model Evaluation',
        'AI Solution Proof of Concept (POC) deployment',
    ];
@endphp

@extends('layouts.index')

@section('content')
{{-- Hero Banner --}}
<div class="h-[556px] bg-black bg-cover bg-top bg-no-repeat" style="background-image: url({{ asset('/assets/img/home/skills-track-illustration.jpg') }})">
    <div class="max-w-screen-xl px-[6.5rem] h-full mx-auto flex items-center">
        <div class="w-max px-10 py-8 bg-[#FF8F51] opacity-90 rounded-2xl text-white text-3xl font-bold">
            Skills Track Information
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="max-w-screen-xl mx-auto px-20 pt-20 pb-44 flex flex-col items-center">
    <h1 class="text-center text-3xl text-darker-blue font-bold">
        Learn more about the Skills Track
    </h1>

    <div class="max-w-[994px] mt-7 flex flex-col gap-4 text-center text-lg">
        <p>
            This track offers students the opportunity to work on one of three AI projects in an online work-like environment. Unlike typical projects or tutorials that provide a step-by-step guide, this platform is designed to replicate a real-world work setting, allowing students to tackle projects with increasing independence. By completing a project on this platform, students will develop valuable skills in problem-solving, time management, and accountability as they take ownership of their tasks and meet deadlines.
        </p>

        <p>
            The projects our students will be choosing from working on have been designed to give students practical skills that will be beneficial in industry. From this program, students will work on the following skills:
        </p>
    </div>

    <div class="w-[745px] mt-8 px-8 pt-8 pb-6 bg-[#F3F3F3] rounded-2xl grid grid-cols-2 gap-x-2 gap-y-4">
        @foreach ($skills as $skill)
            <div class="flex gap-4 items-baseline">
                <i class="fas fa-circle-check fa-xl"></i>
                <span class="text-xl font-medium">
                    {{ $skill }}
                </span>
            </div>
        @endforeach
    </div>

    <h1 class="mt-32 text-center text-3xl text-darker-blue font-bold">
        How it Works ?
    </h1>

    {{-- Step 1 --}}
    <div class="mt-16 flex gap-32">
        <div class="flex flex-col items-end">
            <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                Step 1
            </div>

            <h2 class="mt-7 text-[#000864] text-2xl font-medium">
                Register & Login
            </h2>

            <p class="max-w-[370px] mt-4 text-end text-sm">
                Initiate your path to practical learning and industry experience by registering with the invitation link sent to your email.
            </p>
        </div>

        <img
            src="{{ asset('/assets/img/skills-track-info/step-1.png') }}"
            alt="Step 1"
            class="w-[493.14px]"
        >
    </div>

    {{-- Step 2 --}}
    <div class="mt-20 flex gap-[5.3rem]">
        <img
            src="{{ asset('/assets/img/skills-track-info/step-2.png') }}"
            alt="Step 2"
            class="w-[513px]"
        >

        <div class="flex flex-col">
            <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                Step 2
            </div>

            <h2 class="mt-5 text-[#000864] text-2xl font-medium">
                Enroll in a project
            </h2>

            <p class="max-w-[383px] mt-4 text-sm text-justify">
                Enroll in one of our various projects to begin your hands-on learning journey. Note, that you will only be able to enroll in one of our projects.
            </p>
        </div>
    </div>

    {{-- Step 3 --}}
    <div class="mt-[4.25rem] flex gap-[7.5rem]">
        <div class="flex flex-col items-end">
            <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                Step 3
            </div>

            <h2 class="mt-7 text-[#000864] text-2xl font-medium">
                Begin & Work on the Task
            </h2>

            <p class="max-w-[401px] mt-4 text-end text-sm">
                Dive into the given tasks and transform your knowledge into action. During these tasks, you will engage with real-world challenges, and work through them, to enrich your skill set.
            </p>
        </div>

        <img
            src="{{ asset('/assets/img/skills-track-info/step-3.png') }}"
            alt="Step 3"
            class="w-[500px]"
        >
    </div>

    {{-- Step 4 --}}
    <div class="mt-[10.5rem] flex gap-24">
        <img
            src="{{ asset('/assets/img/skills-track-info/step-4.png') }}"
            alt="Step 4"
            class="w-[500px]"
        >

        <div class="flex flex-col">
            <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                Step 4
            </div>

            <h2 class="mt-5 text-[#000864] text-2xl font-medium">
                Submit the task
            </h2>

            <p class="max-w-[395px] mt-4 text-sm text-justify">
                Once a task is completed, you will submit your work online so you can track and mark your progress throughout the project. Your task will then be evaluated by our mentor team who will be available for support throughout your mentorship.
            </p>
        </div>
    </div>

    {{-- Step 5 --}}
    <div class="mt-[10.65rem] flex gap-[7.7rem]">
        <div class="flex flex-col items-end">
            <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                Step 5
            </div>

            <h2 class="mt-7 text-[#000864] text-2xl font-medium">
                Move onto the next task
            </h2>

            <p class="max-w-[393px] mt-4 text-end text-sm">
                After submitting a task it will be marked in review. To stay on top of your deadlines, advance to the next task and monitor your past work as it gets reviewed and receives feedback.
            </p>
        </div>

        <img
            src="{{ asset('/assets/img/skills-track-info/step-5.png') }}"
            alt="Step 5"
            class="w-[500px]"
        >
    </div>

    {{-- Step 6 --}}
    <div class="mt-60 flex gap-20">
        <img
            src="{{ asset('/assets/img/skills-track-info/step-6.png') }}"
            alt="Step 6"
            class="w-[516px]"
        >

        <div class="flex flex-col">
            <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                Step 6
            </div>

            <h2 class="mt-5 text-[#000864] text-2xl font-medium">
                Certificate of Participation
            </h2>

            <p class="max-w-[370px] mt-4 text-sm text-justify">
                Once all tasks are completed, you will have completed the entire project! At this point, you will be eligible to download a certificate recognizing your work in the skills track of the mentorship program.
            </p>
        </div>
    </div>

    {{-- Entrepreneur Track --}}
    <div class="mt-[11.65rem] flex gap-14">
        <div class="mt-8 flex flex-col gap-2">
            <a href="{{ route('track-info.entrepreneur-track') }}" class="text-2xl text-end text-darker-blue font-bold hover:underline">
                Entrepreneur Track Information
            </a>

            <p class="w-[359px] text-sm text-justify">
                Students will extend their personal projects submitted to the Intel Al Impact Festival with the focus on polishing their project and preparing to take the project to the next level as a new business venture.
            </p>
        </div>

        <a href="{{ route('track-info.entrepreneur-track') }}" class="relative">
            <img
                src="{{ asset('/assets/img/home/entrepreneur-track-illustration.jpg') }}"
                alt="Entrepreneur Track"
                class="w-[361px] h-[195px] bg-gray-200 rounded-2xl"
                style="box-shadow: 5px 4px 10px 5px rgba(0, 0, 0, 0.10)"
            >

            <div class="absolute -bottom-4 right-10 w-11 h-11 bg-[#FF8F51] rounded-xl"></div>
        </a>
    </div>
</div>
@endsection
