@php
    $skills = [
        'Having a competitive model',
        'Writing necessary business documentation',
        'Having a robust dataset',
        'Creating a basic website to display the product and company information',
        'Having a demonstrable product via a UI',
        'Pitching their product to potential investors and/or customers',
    ];
@endphp

@extends('layouts.index')

@section('content')
{{-- Hero Banner --}}
<div class="h-[556px] bg-black bg-cover bg-top bg-no-repeat" style="background-image: url({{ asset('/assets/img/home/entrepreneur-track-illustration.jpg') }})">
    <div class="max-w-screen-xl px-[6.5rem] h-full mx-auto flex items-center">
        <div class="w-max px-10 py-8 bg-[#FF8F51] opacity-90 rounded-2xl text-white text-3xl font-bold">
            Entrepreneur Track Information
        </div>
    </div>
</div>

<div class="relative max-w-screen-xl mx-auto">
    {{-- Decorations --}}
    {{-- Dots - top-right step 1 --}}
    <div
        class="absolute top-[520px] right-0 w-[339px] h-[186px]"
        style="background: url({{ asset('/assets/img/icon/profile/dots.png') }}), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat"
    ></div>

    {{-- Dots & shadow - top-left step 3 --}}
    <div
        class="absolute top-[1390px] -left-28 w-[339px] h-[186px]"
        style="background: url({{ asset('/assets/img/icon/profile/dots.png') }}), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat"
    ></div>
    <div
        class="absolute top-[1280px] -left-[40%] translate-x-[40%] w-[621px] h-[621px] bg-[#E4E7FF] rounded-full opacity-60 blur-[100px]"
    ></div>

    {{-- Dots & shadow - top-right step 3c --}}
    <div
        class="absolute top-[2870px] -right-10 w-[339px] h-[186px]"
        style="background: url({{ asset('/assets/img/icon/profile/dots.png') }}), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat"
    ></div>
    <div
        class="absolute top-[2590px] -right-[50%] -translate-x-[50%] w-[813px] h-[813px] bg-[#E4E7FF] rounded-full opacity-60 blur-[100px]"
    ></div>

    {{-- Dots & shadow - bottom-left the page --}}
    <div
        class="absolute bottom-[230px] left-0 w-[339px] h-[186px]"
        style="background: url({{ asset('/assets/img/icon/profile/dots.png') }}), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat"
    ></div>
    <div
        class="absolute -bottom-[650px] -left-[16%] -translate-x-[16%] w-[1273px] h-[1273px] bg-[#E4E7FF] rounded-full opacity-60 blur-[100px]"
    ></div>

    {{-- Main Content --}}
    <div class="relative z-[2] max-w-screen-xl mx-auto px-20 pt-20 pb-44 flex flex-col items-center">
        <h1 class="text-center text-3xl text-darker-blue font-bold">
            Learn more about the Entrepreneur Track
        </h1>

        <div class="max-w-[994px] mt-7 flex flex-col gap-4 text-center text-lg">
            <p>
                This track offers participants the opportunity to continue their work on the project they submitted to the Intel Global AI Impact Festival in an online work-like environment. During this track, the participants’ projects will be supported in defining the next steps for their projects to prepare them to go to the next level as a new business venture.
            </p>

            <p>
                During this program, participants will work towards:
            </p>
        </div>

        <div class="w-[900px] mt-8 px-8 pt-8 pb-6 bg-[#F3F3F3] rounded-2xl grid grid-cols-2 gap-x-2 gap-y-4">
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
                src="{{ asset('/assets/img/entrepreneur-track-info/step-1.png') }}"
                alt="Step 1"
                class="w-[493.14px]"
            >
        </div>

        {{-- Step 2 --}}
        <div class="relative mt-20 flex gap-[5.3rem]">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down-right.png') }}""
                class="absolute -top-24 left-[22rem] scale-y-75 scale-x-125"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-2.png') }}"
                alt="Step 2"
                class="relative z-[3] w-[513px]"
            >

            <div class="flex flex-col">
                <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                    Step 2
                </div>

                <h2 class="mt-5 text-[#000864] text-2xl font-medium">
                    Create Project
                </h2>

                <p class="max-w-[383px] mt-4 text-sm text-justify">
                    For the entrepreneur track, you will be extending the work you’ve done for your project that was submitted to the Intel AI Global Impact Festival. Therefore, to support your team’s work, the communication between your team and your mentors, and documentation, you will use this platform as your task management system. To start, you will need to add your project to the platform. By doing the following:
                </p>
            </div>
        </div>

        {{-- Step 3 --}}
        <div class="relative mt-[4.25rem] flex gap-[7.5rem]">
            <div class="flex flex-col items-end">
                <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                    Step 3
                </div>

                <h2 class="mt-7 text-[#000864] text-2xl font-medium">
                    Project Planning
                </h2>

                <p class="max-w-[457px] mt-4 text-end text-sm">
                    For the project track, you will be extending the work you’ve done for your project that was submitted to the Intel AI Global Impact Festival. Therefore, to support your team’s work, the communication between your team and your mentors, and for documentation, you will use this platform as your task management system.
                </p>
            </div>

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-3.png') }}"
                alt="Step 3"
                class="relative z-[3] w-[500px]"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down-left.png') }}""
                class="absolute -top-24 right-[22rem] scale-y-75"
            >
        </div>

        {{-- Step 3a --}}
        <div class="relative mt-[7.75rem] flex flex-col items-center gap-12">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down.png') }}""
                class="absolute -top-28 left-36 scale-y-90"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-3a.png') }}"
                alt="Step 3a"
                class="w-[531px]"
            >

            <div class="flex items-center gap-4">
                <div class="w-[35px] h-[35px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">A</div>
                <p class="text-2xl text-[#000864] font-medium">
                    Fill in Your Project Information
                </p>
            </div>
        </div>

        {{-- Step 3b --}}
        <div class="relative mt-[10.5rem] flex flex-col items-center gap-12">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down.png') }}""
                class="absolute -top-40 left-72 scale-y-90"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-3b.png') }}"
                alt="Step 3b"
                class="w-[540px]"
            >

            <div class="flex items-center gap-4">
                <div class="w-[35px] h-[35px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">B</div>
                <p class="text-2xl text-[#000864] font-medium">
                    Add New Tasks to Your Project Planner
                </p>
            </div>
        </div>

        {{-- Step 3c --}}
        <div class="relative mt-[9.5rem] flex flex-col items-center gap-12">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down.png') }}""
                class="absolute -top-36 left-60 scale-y-90"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-3c.png') }}"
                alt="Step 3c"
                class="w-[495px]"
            >

            <div class="flex items-center gap-4">
                <div class="w-[35px] h-[35px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">C</div>
                <p class="text-2xl text-[#000864] font-medium">
                    You can Edit Your Project
                </p>
            </div>
        </div>

        {{-- Step 3d --}}
        <div class="relative mt-[9.75rem] flex flex-col items-center gap-12">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down.png') }}""
                class="absolute -top-40 left-60 scale-y-90"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-3d.png') }}"
                alt="Step 3d"
                class="w-[495px]"
            >

            <div class="flex items-center gap-4">
                <div class="w-[35px] h-[35px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">D</div>
                <p class="text-2xl text-[#000864] font-medium">
                    Return to The Page Like Adding a Project
                </p>
            </div>
        </div>

        {{-- Step 4 --}}
        <div class="relative mt-[10.4rem] flex gap-24">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down-left.png') }}""
                class="absolute -top-36 right-[18.5rem] scale-x-75"
            >

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-4.png') }}"
                alt="Step 4"
                class="w-[500px]"
            >

            <div class="relative z-[3] flex flex-col">
                <div class="w-[99px] h-[99px] bg-[#E96424] rounded-full flex justify-center items-center text-white text-2xl font-medium">
                    Step 4
                </div>

                <h2 class="mt-5 text-[#000864] text-2xl font-medium">
                    Begin & Work to The Task
                </h2>

                <p class="max-w-[395px] mt-4 text-sm text-justify">
                    Dive into your tasks and transform your project into a new venture with the support of your teammates and mentors.
                </p>
            </div>
        </div>

        {{-- Step 5 --}}
        <div class="relative mt-[10.65rem] flex gap-[7.7rem]">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down-right.png') }}""
                class="absolute -top-32 left-[21rem]"
            >

            <div class="relative z-[3] flex flex-col items-end">
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
                src="{{ asset('/assets/img/entrepreneur-track-info/step-5.png') }}"
                alt="Step 5"
                class="w-[500px]"
            >
        </div>

        {{-- Step 6 --}}
        <div class="relative mt-60 flex gap-20">
            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/step-6.png') }}"
                alt="Step 6"
                class="w-[516px]"
            >

            <div class="relative z-[3] flex flex-col">
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

            <img
                src="{{ asset('/assets/img/entrepreneur-track-info/arrow-down-left.png') }}""
                class="absolute -top-36 right-72 scale-x-75"
            >
        </div>

        {{-- Entrepreneur Track --}}
        <div class="mt-[11.65rem] flex gap-14">
            <a href="{{ route('track-info.skills-track') }}" class="relative">
                <img
                    src="{{ asset('/assets/img/home/skills-track-illustration.jpg') }}"
                    alt="Skills Track"
                    class="w-[361px] h-[195px] bg-gray-200 rounded-2xl"
                    style="box-shadow: 5px 4px 10px 5px rgba(0, 0, 0, 0.20);"
                >

                <div class="absolute -top-6 left-6 w-11 h-11 bg-[#FF8F51] rounded-xl"></div>
            </a>

            <div class="mt-12 flex flex-col gap-2">
                <a href="{{ route('track-info.skills-track') }}" class="text-2xl text-darker-blue font-bold hover:underline">
                    Skills Track Information
                </a>

                <p class="w-[359px] text-sm text-justify">
                    Students will take on real-world projects specifically developed for them to hone their technical Al skills.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
