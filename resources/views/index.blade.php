@extends('layouts.index')
@section('content')
    {{-- Body Contents --}}
    <div style="background-image: url({{ asset('assets/img/main/banner.png') }}); background-size: cover;" class="max-w-full bg-no-repeat phone:bg-right-min-28 hd:bg-top-min-20 laptop:bg-top-min-20 fhd:bg-top-min-32 py-24">
        <div class="max-w-screen-xl mx-auto px-6 hd:py-24 ">
            <div class="grid md:grid-cols-2 gap-4 items-center ">
                <div class="my-auto px-8 py-4 mt-48 hd:mt-0 hd:px-16 hd:py-8">
                    <h2 class="intelOne text-white font-bold text-xl hd:text-3xl leading-11">
                        <span>Intel AI Global Impact Festival</span> <span class="text-primary"> Mentorship Platform</span>
                    </h2>
                    <span class="intelOne text-white font-light text-sm hd:text-lg leading-6">Join today to work on real-world
                        projects and kick start your career!</span>
                    <div class="flex py-4">
                        <a href="{{ route('multiLogIn') }}"
                           class="intelOne text-white text-sm font-normal bg-primary hover:bg-primary-700 px-8 py-1.5 hd:px-16 hd:py-3.5 rounded-full">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Body Content 2 --}}
    <div class="max-w-screen-xl mx-auto px-6 flex flex-col items-center">
        <h2 class="font-bold text-4xl text-center text-darker-blue">
            Intel Impact Festival<br>
            <span class="text-primary">
                Mentorship Program
            </span>
        </h2>

        <p class="mt-[2.625rem] text-black text-center text-lg max-w-screen-tab">Intel® AI For Workforce is a global AI skilling program for
            vocational students for building an AI-ready workforce. The program aims to address the AI skill
            crisis to cater to growing job demands related to AI/ML by empowering the future workforce with the
            necessary skills for employability in the digital economy. The program offers comprehensive,
            modular, experiential, and flexible AI content delivered through engaging learning experiences.</p>
    </div>

    {{-- Body Content 3 --}}
    <div class="max-w-screen-tab mt-[5.75rem] mx-auto">
        <div class="relative w-full flex items-center gap-14">
            <div class="absolute -top-5 left-4 w-11 h-11 bg-secondary-cr2 rounded-lg"></div>

            <img src="{{ asset('/assets/img/home/skills-track.png') }}" alt="Skills Track">

            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-darker-blue">
                    Skills Track
                </h2>
                <p class="text-justify">Students will take on real-world projects specifically developed for them to hone their technical AI skills.</p>
            </div>
        </div>

        <div class="relative w-full mt-28 flex items-center gap-14">
            <div class="absolute -bottom-5 right-12 w-11 h-11 bg-secondary-cr2 rounded-lg"></div>

            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-right text-darker-blue">
                    Project Track
                </h2>
                <p class="text-justify">Students will extend their personal projects submitted to the Intel AI Impact Festival with the focus on polishing their project and preparing to take the project to the next level as a new business venture.</p>
            </div>

            <img src="{{ asset('/assets/img/home/project-track.png') }}" alt="Skills Track">
        </div>
    </div>

    {{-- Body Content 4 --}}
    <div class="max-w-screen-xl mt-[8rem] mx-auto px-24 flex flex-col items-center">
        <h1 class="font-bold text-darker-blue text-3xl">
            Skills Track
        </h1>

        <div class="mt-12 flex flex-wrap gap-[3.25rem]">
            @foreach ($projects as $project)
                <div class="w-[316px] min-h-[405px] rounded-lg shadow-xl"></div>
            @endforeach
        </div>
    </div>

    {{-- Body Content 5 --}}
    <div class="relative max-w-screen-xl mt-[12.5rem] mb-[9.25rem] mx-auto px-6 flex justify-center items-center gap-72">
        <div class="relative">
            <img src="{{ asset('/assets/img/home/pj1.png') }}" alt="Project Track">
            <img src="{{ asset('/assets/img/home/pj2.png') }}" alt="Project Track" class="absolute top-[3.5rem] -right-[12.5rem]">
        </div>

        <div class="flex flex-col items-center gap-2">
            <h1 class="font-bold text-2xl text-darker-blue">
                Project Track
            </h1>

            <a href="#" class="text-white bg-primary px-8 py-2 text-xl rounded-full">
                View Project Planner
            </a>
        </div>

        <img src="{{ asset('/assets/img/home/bubble-decoration.png') }}" alt="Decoration" class="absolute bottom-0 -right-8 w-[339px]">
    </div>

    {{-- Body Content 3 --}}
    {{-- <div class="max-w-screen-xl mx-auto px-6 pt-20 mb-0 flex flex-col md:flex-row md:space-x-4 relative">
        <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots" class="absolute z-10 -top-32 right-0"
            aria-hidden="true">
        <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots" class="absolute z-10 top-10 left-0 "
            aria-hidden="true">
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_students.png') }}" loading="lazy" class="relative shadow-lg rounded-2xl z-20" alt="for students">
                <h1 class="text-primary text-2xl font-bold py-3">For Students</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Acquire Employability Skills, Gain Industry
                    Experience, Strengthen Project Portfolio</p>
            </div>
        </div>
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_institution.png') }}" loading="lazy" class="relative shadow-lg rounded-2xl z-20" alt="for students">
                <h1 class="text-primary text-2xl font-bold py-3">For Institutes</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Enhanced Student Employability, Collaborate
                    with Industry leaders, Supervise Real-World AI Projects</p>
            </div>
        </div>
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_industries.png') }}" loading="lazy" class="relative shadow-lg rounded-2xl z-20" alt="for students">
                <h1 class="text-primary text-2xl font-bold py-3">For Industries</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Identify Top Future Talents, Collaborate
                    with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
            </div>
        </div>
    </div> --}}

    {{-- Body Content 4.1 --}}
    {{-- <div class="max-w-screen-xl mx-auto px-6 py-4 relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="intelOne text-primary font-bold text-3xl pb-8">Testimonial From Students</h2>
            <div class="flex space-x-4">
                <button class="bg-white border-2 border-primary rounded-full p-2" id="testimonial-swiper-button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="bg-white border-2 border-primary rounded-full p-2" id="testimonial-swiper-button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="swip-testimonial">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div
                            class="block p-3 rounded-lg shadow-lg hover:shadow-xl hover:border-2 border-2 hover:border-primary-darker border-[#A4AADC] bg-white max-w-sm h-auto overflow-hidden">
                            <div class="flex space-x-2">
                                <div class="flex-col">
                                    <p
                                        class="intelOne text-primary font-bold text-xl leading-7 m-0 overflow-ellipsis px-2 overflow-hidden">
                                        {{ $testimonial['name'] }}
                                    </p>
                                    <p class="text-black font-normal text-sm mt-2 overflow-ellipsis px-2 overflow-hidden">
                                        Student
                                    </p>
                                </div>
                            </div>
                            <div class="text-grey font-normal text-base text-justify mb-2 py-4 overflow-ellipsis px-2 overflow-hidden">
                                {{ $testimonial['feedback'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    {{-- Body Content 4 --}}
    {{-- <div class="max-w-screen-xl mx-auto px-6 py-4 relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="intelOne text-primary font-bold text-3xl pb-8">Skill Focus Track Projects</h2>
            <div class="flex space-x-4">
                <button class="bg-white border-2 border-primary rounded-full p-2" id="swiper-button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="bg-white border-2 border-primary rounded-full p-2" id="swiper-button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($projects as $project)
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div
                            class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-primary-darker border-[#A4AADC] bg-white max-w-sm h-[250px] overflow-hidden">
                            <div class="flex space-x-2">
                                <div class=" my-auto border-2 border-[#A4AADC] rounded-xl py-1 px-1 mr-2">
                                    <img src="{{ asset('storage/' . $project->company->logo) }}"
                                        class="w-16 h-12 object-cover mx-auto rounded-xl" alt="Logo">
                                </div>
                                <div class="flex-col">
                                    <p
                                        class="intelOne text-primary font-bold text-xl leading-7 m-0 overflow-ellipsis overflow-hidden">
                                        {{ substr($project->name, 0, 18) }}{{ strlen($project->name) > 18 ? '...' : '' }}
                                    </p>
                                    <p class="text-black font-normal text-sm m-0 overflow-ellipsis overflow-hidden">
                                        {{ $project->company->name }}</p>
                                    <div class="pt-2">
                                        <p
                                            class="text-primary font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36 overflow-ellipsis overflow-hidden">
                                            {{ $project->project_domain == 'statistical' ? 'Statistical Data' : ($project->project_domain == 'computer_vision' ? 'Computer Vision' : 'NLP') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-grey font-normal text-base mb-2 pt-3 overflow-ellipsis overflow-hidden">
                                {{ substr($project->overview, 0, 62) }}...</div>
                            <div class="flex justify-between">
                                <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span
                                        class="font-medium">{{ $project->period }} {{ strtolower($project->name) == "onboarding week" ? 'Week' : ($project->period > 1 ? 'Months' : 'Month') }}</span></p>
                                <a href="{{ isLoggedIn() ? route('projects.show', ['project' => $project->id]) : route('multiLogIn') }}"
                                    class="intelOne text-white text-sm font-normal bg-primary-darker hover:bg-primary px-3 py-2 rounded-full ">View
                                    Project</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <a href="{{ route('projects.index') }}" class="border-primary text-primary rounded-full border-[1px] border-solid px-4 py-2">View All Projects</a>
        </div>
    </div> --}}

    {{-- Body Content 4 --}}
    {{-- <div class="max-w-screen-xl mx-auto px-6 py-4 relative"> --}}
        {{-- <div class="flex justify-between items-center mb-4">
            <h2 class="intelOne text-primary font-bold text-3xl pb-8">Project Focus Track</h2>
            <div class="flex space-x-4">
                <button class="bg-white border-2 border-primary rounded-full p-2" id="swiper-button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="bg-white border-2 border-primary rounded-full p-2" id="swiper-button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div> --}}
        {{-- <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($projects as $project)
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div
                            class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-primary-darker border-[#A4AADC] bg-white max-w-sm h-[250px] overflow-hidden">
                            <div class="flex space-x-2">
                                <div class=" my-auto border-2 border-[#A4AADC] rounded-xl py-1 px-1 mr-2">
                                    <img src="{{ asset('storage/' . $project->company->logo) }}"
                                        class="w-16 h-12 object-cover mx-auto rounded-xl" alt="Logo">
                                </div>
                                <div class="flex-col">
                                    <p
                                        class="intelOne text-primary font-bold text-xl leading-7 m-0 overflow-ellipsis overflow-hidden">
                                        {{ substr($project->name, 0, 18) }}{{ strlen($project->name) > 18 ? '...' : '' }}
                                    </p>
                                    <p class="text-black font-normal text-sm m-0 overflow-ellipsis overflow-hidden">
                                        {{ $project->company->name }}</p>
                                    <div class="pt-2">
                                        <p
                                            class="text-primary font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36 overflow-ellipsis overflow-hidden">
                                            {{ $project->project_domain == 'statistical' ? 'Statistical Data' : ($project->project_domain == 'computer_vision' ? 'Computer Vision' : 'NLP') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-grey font-normal text-base mb-2 pt-3 overflow-ellipsis overflow-hidden">
                                {{ substr($project->overview, 0, 62) }}...</div>
                            <div class="flex justify-between">
                                <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span
                                        class="font-medium">{{ $project->period }} {{ strtolower($project->name) == "onboarding week" ? 'Week' : ($project->period > 1 ? 'Months' : 'Month') }}</span></p>
                                <a href="{{ isLoggedIn() ? route('projects.show', ['project' => $project->id]) : route('multiLogIn') }}"
                                    class="intelOne text-white text-sm font-normal bg-primary-darker hover:bg-primary px-3 py-2 rounded-full ">View
                                    Project</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}

        {{-- <div class="flex justify-end pt-6">
            <a href="{{ route('projects.index') }}" class="border-primary text-primary rounded-full border-[1px] border-solid px-4 py-2">View All Projects</a>
        </div> --}}
    {{-- </div> --}}


    <!-- Body Content 5 -->
    {{-- <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
        <div class="grid md:grid-cols-2 gap-4 items-start">
            <!-- Changed here -->
            <div class="relative">
                <div class="relative z-30 rounded-lg overflow-hidden" style="padding-bottom: 56.25%">
                    <iframe class="absolute inset-0 w-full h-full py-4" src="https://www.youtube.com/embed/cUq-sTaxXks"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                        allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
            <div class="relative">
                <h1 class="font-bold text-2xl mb-4 text-primary text-justify">Learning Never Stops</h1>
                <p class="m-0 text-black text-justify">When he was 16 years old, Feridoon Ghanbari and his family left
                    Iran to live in the U.S. With time spent in the Army as a combat medic and the Air Force as a
                    guidance and navigation engineer—the military has shaped his life. Afterward, he moved to New
                    Mexico, where he's been living for over four decades. With degrees in Electrical Engineering,
                    Industrial Engineering, and Business, he has a deep background in STEM. He's passionate about
                    Artificial Intelligence and always wants to learn about where the future of tech is headed, in real
                    time for the real world. That's why he's excited about expanding his knowledge in our AI for
                    Workforce classes. The program teaches innovative tech while empowering students with the necessary
                    AI skills for employability in the digital economy.</p>
            </div>
        </div>
    </div> --}}
@endsection
