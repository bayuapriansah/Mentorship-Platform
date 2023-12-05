@extends('layouts.index')

@section('more-css')
<style>
    .blue-shadow {
        border-radius: 621px;
        opacity: 0.7;
        background: #E4E7FF;
        filter: blur(100px);
    }

    .bubble-decoration-1 {
        width: 339px;
        height: 186px;
        background: url('/assets/img/home/bubble-decoration.svg'), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat;
    }

    .bubble-decoration-2 {
        width: 339px;
        height: 186px;
        background: url('/assets/img/home/bubble-decoration.svg'), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat;
    }

    .project-card {
        border-radius: 15px;
        background: white;
        box-shadow: 0px 4px 25px 10px rgba(131, 131, 131, 0.20);
        cursor: pointer;
        transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
    }

    .project-card:hover {
        transform: scale(1.1);
        background: linear-gradient(180deg, rgba(233, 100, 36, 0.20) 5%, rgba(255, 255, 255, 0.00) 120.39%), #FFF;
        box-shadow: 0px 4px 20px 4px rgba(0, 0, 0, 0.20);
    }
</style>
@endsection

@section('content')
    {{-- Body Contents --}}
    <div style="background-image: url({{ asset('assets/img/main/banner.png') }}); background-size: cover;" class="max-w-full bg-no-repeat phone:bg-right-min-28 hd:bg-top-min-20 laptop:bg-top-min-20 fhd:bg-top-min-32 py-24">
        <div class="max-w-screen-xl mx-auto px-6 hd:py-24">
            <div class="relative -top-16 grid md:grid-cols-2 gap-4 items-center ">
                <div class="my-auto px-8 py-4 mt-48 hd:mt-0 hd:px-16 hd:py-8">
                    <h2 class="w-max text-white font-medium text-xl tab:text-3xl leading-11">
                        <span>Intel AI Global Impact Festival</span>
                        <br>
                        <span class="text-primary">
                            Mentorship Platform
                        </span>
                    </h2>

                    <div class="mt-12">
                        <a href="{{ route('multiLogIn') }}" class="text-white text-sm font-normal bg-primary hover:bg-primary-700 px-8 py-1.5 hd:px-16 tab:py-3.5 rounded-full">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Body Content 2 --}}
    <div class="max-w-screen-xl mt-10 hd:mt-0 mx-auto px-6 flex flex-col items-center">
        <h2 class="font-bold text-2xl tab:text-3xl text-center text-darker-blue">
            Intel AI Global Impact Festival<br>
            <span class="text-primary">
                Mentorship Program
            </span>
        </h2>

        <p class="max-w-screen-tab mt-6 tab:mt-[2.625rem] text-black text-center tab:text-lg">
            Intel® AI Global Impact Festival 2023 is a digital readiness celebration,
            inviting students, educators, academic leaders, governments, implementation partners,
            and all communities from across the world to enrich lives with AI innovation.
            This mentorship program aims to celebrate the student innovators and take their AI-enabled solutions
            to the next level and develop their AI skills.
        </p>
    </div>

    {{-- Body Content 3 --}}
    <div class="relative max-w-screen-tab mt-[5.75rem] mx-auto px-6">
        {{-- <img src="{{ asset('/assets/img/home/bubble-decoration.png') }}" alt="Decoration" class="hidden tab:block absolute top-1/4 -left-[33%]"> --}}
        <div class="bubble-decoration-1 hidden tab:block absolute top-1/4 -left-[33%]"></div>
        <div class="hidden tab:block absolute -top-24 -left-[60%] w-[621px] h-[621px] blue-shadow"></div>

        <div class="relative w-full grid grid-cols-4 tab:items-center">
            <div class="absolute -top-5 left-4 w-11 h-11 bg-secondary-cr2 rounded-lg"></div>

            <a href="{{ route('track-info.skills-track') }}" class="col-span-4 tab:col-span-2">
                <img
                    src="{{ asset('/assets/img/home/skills-track-illustration.jpg') }}"
                    alt="Skills Track"
                    class="w-[362px] h-[196px] rounded-2xl shadow-lg tab:shadow-2xl"
                >
            </a>

            <div class="col-span-4 tab:col-span-2 mt-8 tab:mt-0 tab:ml-8 flex flex-col gap-2">
                <a href="{{ route('track-info.skills-track') }}" class="font-bold text-darker-blue text-2xl hover:underline">
                    Skills Track Information
                </a>

                <p class="text-black text-justify text-sm">
                    Students will take on real-world projects specifically developed for them to hone their technical AI skills.
                </p>
            </div>
        </div>

        <div class="relative w-full mt-16 tab:mt-28 grid grid-cols-4 tab:items-center">
            <div class="absolute -top-5 tab:top-[initial] left-4 tab:left-[initial] tab:-bottom-5 tab:right-12 w-11 h-11 bg-secondary-cr2 rounded-lg"></div>

            <div class="hidden tab:flex col-span-4 tab:col-span-2 mt-8 tab:mt-0 tab:mr-10 flex-col gap-2">
                <a href="{{ route('track-info.entrepreneur-track') }}" class="font-bold text-2xl tab:text-[1.4rem] text-darker-blue hover:underline">
                    Entrepreneur Track Information
                </a>

                <p class="text-black text-sm text-justify">
                    Students will extend their personal projects submitted to the Intel AI Impact Festival with the focus on polishing their project and preparing to take the project to the next level as a new business venture.
                </p>
            </div>

            <a href="{{ route('track-info.entrepreneur-track') }}" class="col-span-4 tab:col-span-2">
                <img
                    src="{{ asset('/assets/img/home/entrepreneur-track-illustration.jpg') }}"
                    alt="Project Track"
                    class="w-[361px] h-[195px] rounded-2xl shadow-lg tab:shadow-2xl"
                >
            </a>


            <div class="flex tab:hidden col-span-4 tab:col-span-2 mt-8 tab:mt-0 tab:mr-10 flex-col gap-2">
                <a href="{{ route('track-info.entrepreneur-track') }}" class="font-bold text-2xl text-darker-blue hover:underline">
                    Entrepreneur Track Information
                </a>

                <p class="text-black text-sm text-justify">
                    Students will extend their personal projects submitted to the Intel AI Impact Festival with the focus on polishing their project and preparing to take the project to the next level as a new business venture.
                </p>
            </div>
        </div>
    </div>

    {{-- Body Content 4 --}}
    <div class="max-w-screen-xl mt-[8rem] mx-auto px-24 flex flex-col items-center">
        <h1 class="font-bold text-darker-blue text-3xl">
            Skills Track
        </h1>

        <div class="mt-12 flex flex-wrap justify-center gap-[3.25rem]">
            @foreach ($projects as $project)
                <div class="project-card w-[316px] min-h-[405px] pt-7 pb-10 px-6 flex flex-col items-center">
                    <img
                        src="{{ 'storage/' . $project->company->logo }}"
                        alt="Logo"
                        class="w-20 h-20 rounded-lg tab:rounded-xl bg-slate-200 text-black text-center"
                    >

                    <h5 class="mt-4 font-bold text-lg text-darker-blue">
                        {{ $project->company->name }}
                    </h5>

                    <div class="min-w-[124px] mt-4 px-4 py-1 bg-lightest-blue rounded-full text-black text-center text-xs">
                        {{ $project->project_domain == 'statistical' ? 'Machine Learning' : ($project->project_domain == 'computer_vision' ? 'Computer Vision' : 'NLP') }}
                    </div>

                    <p class="mt-4 text-sm text-justify">
                        {{ $project->overview }}
                    </p>

                    <p class="mt-2 mb-9 text-black self-start">
                        Duration:
                        <span class="font-[500]">
                            {{-- {{ $project->period }}
                            {{ $project->period > 1 ? 'Weeks' : 'Week' }} --}}
                            10 Weeks
                        </span>
                    </p>

                    <a
                        href="{{ route('projects.show', ['project' => $project->id]) }}"
                        class="px-4 py-2 mt-auto bg-primary rounded-full text-white text-center text-sm"
                    >
                        View Project
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Body Content 5 --}}
    <div class="relative max-w-screen-xl mt-[12.5rem] mb-[9.25rem] mx-auto px-6 flex flex-col tab:flex-row justify-center items-center gap-10 tab:gap-72">
        <div class="relative">
            <img src="{{ asset('/assets/img/home/planner-1.png') }}" alt="Image">
            <img src="{{ asset('/assets/img/home/planner-2.png') }}" alt="Image" class="absolute top-[3.5rem] -right-[12.5rem]">
        </div>

        <div class="flex flex-col items-center gap-2">
            <h1 class="font-bold text-2xl text-darker-blue">
                Entrepreneur Track
            </h1>

            <a href="#" class="text-center text-white bg-primary px-8 py-2 text-xl rounded-full">
                View Project Planner
            </a>
        </div>

        <div class="bubble-decoration-2 hidden tab:block absolute bottom-0 -right-8"></div>
    </div>
@endsection
