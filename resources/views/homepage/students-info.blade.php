@extends('layouts.index')
@section('content')
{{-- Body Contents --}}
<div style="background-image: url({{ asset('assets/img/for_students/two-students.jpeg') }}); background-size: cover;" class="max-w-full bg-no-repeat phone:bg-right-min-28 hd:bg-top-min-20 laptop:bg-top-min-20 fhd:bg-top-min-32 py-24">
    <div class="max-w-screen-xl mx-auto px-6 hd:py-24 ">
        <div class="grid md:grid-cols-2 gap-4 items-center ">
            <div class="my-auto bg-darker-blue/[0.9] rounded-2xl px-8 py-4 mt-48 hd:mt-0 hd:px-16 hd:py-8">
                <h2 class="intelOne text-white font-bold text-xl hd:text-3xl leading-11">
                    <span>Information for</span> <span class="text-light-brown"> Students</span>
                </h2>
                <span class="intelOne text-white font-light text-sm hd:text-lg leading-6">Join today to work on real-world
                    projects and kick start your career!</span>
                <div class="flex py-4">
                    <a href="{{ route('multiLogIn') }}"
                       class="intelOne text-dark-blue text-sm font-normal bg-white hover:bg-neutral-300 px-8 py-1.5 hd:px-16 hd:py-3.5 rounded-full">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Body Content 2 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="my-auto">
                <h2 class="intelOne text-dark-blue font-bold text-4xl">Information<br><span class="text-light-brown"> For Students</span></h2>
            </div>
            <div class="relative my-auto">
                <p class="mb-4 text-black text-justify">On this platform students are going  to have the opportunity to work on AI projects in an online work like manner. Most projects or tutorials found online walk students through projects step by step given them a clear pathway from an idea to a solution. On this platform, the projects student will be working on have been designed to walk students through a project as it manifests itself in a work like setting. The goal is for students to develop their independence by finding solutions to problems, time management and responsibility by meeting deadlines, and accountability for their work as the owners of their tasks. Once the students have completed their simulated internship, not only will they have grown as developers, but they will have grown their project portfolio.
                </p>
                <p class="m-0 text-black text-justify">
                    The projects our students will be working on have been designed to give students practical skills that will be beneficial in industry. From this program students will work on the following skills:
                </p>
            </div>
        </div>
    </div>

    {{-- Body Content 2.1 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="my-auto">
                {{-- <h2 class="intelOne text-dark-blue font-bold text-4xl">Information<br><span class="text-light-brown"> For Students</span></h2> --}}
            </div>
            <div class="relative my-auto bg-[#F3F3F3] rounded-xl px-8 py-4">
                <p class="mb-4 text-black text-justify">
                    <table class="table-fixed text-darker-blue font-medium">
                        <tr>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Collection</td>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 ml-16 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Wrangling</td>
                        </tr>
                        <tr>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Pipelining</td>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 ml-16 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Model Building</td>
                        </tr>
                        <tr>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">AI Model Evaluation</td>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 ml-16 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">AI Solution Proof of Concept (POC) deployment <span class="text-light-brown">(Coming Soon)</span></td>
                        </tr>
                    </table>
                </p>
            </div>
        </div>
    </div>

    {{-- Body Content 3 --}}
    <div class="max-w-screen-xl mx-auto px-6 pt-20 mb-0 flex flex-col md:flex-row md:space-x-4 relative">
        <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots" class="absolute z-10 -top-32 right-0"
            aria-hidden="true">
        <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots" class="absolute z-10 top-10 left-0 "
            aria-hidden="true">
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_students.png') }}" loading="lazy" class="relative z-20" alt="for students">
                <h1 class="text-dark-blue text-2xl font-bold py-3">For Students</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Acquire Employability Skills, Gain Industry
                    Experience, Strengthen Project Portfolio</p>
            </div>
        </div>
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_institution.png') }}" loading="lazy" class="relative z-20" alt="for students">
                <h1 class="text-dark-blue text-2xl font-bold py-3">For Institutes</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Enhanced Student Employability, Collaborate
                    with Industry leaders, Supervise Real-World AI Projects</p>
            </div>
        </div>
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_industries.png') }}" loading="lazy" class="relative z-20" alt="for students">
                <h1 class="text-dark-blue text-2xl font-bold py-3">For Industries</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Identify Top Future Talents, Collaborate
                    with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
            </div>
        </div>
    </div>

    {{-- Body Content 4 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="intelOne text-dark-blue font-bold text-3xl pb-8">Internship Projects</h2>
            <div class="flex space-x-4">
                <button class="bg-white border-2 border-dark-blue rounded-full p-2" id="swiper-button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-dark-blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="bg-white border-2 border-dark-blue rounded-full p-2" id="swiper-button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-dark-blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                {{-- @foreach ($projects as $project)
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div
                            class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-[#A4AADC] bg-white max-w-sm h-[250px] overflow-hidden">
                            <div class="flex space-x-2">
                                <div class=" my-auto border-2 border-[#A4AADC] rounded-xl py-1 px-1 mr-2">
                                    <img src="{{ asset('storage/' . $project->company->logo) }}"
                                        class="w-16 h-12 object-cover mx-auto rounded-xl" alt="Logo">
                                </div>
                                <div class="flex-col">
                                    <p
                                        class="intelOne text-dark-blue font-bold text-xl leading-7 m-0 overflow-ellipsis overflow-hidden">
                                        {{ substr($project->name, 0, 18) }}{{ strlen($project->name) > 18 ? '...' : '' }}
                                    </p>
                                    <p class="text-black font-normal text-sm m-0 overflow-ellipsis overflow-hidden">
                                        {{ $project->company->name }}</p>
                                    <div class="pt-2">
                                        <p
                                            class="text-dark-blue font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36 overflow-ellipsis overflow-hidden">
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
                                    class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full ">View
                                    Project</a>
                            </div>
                        </div>
                    </div>
                @endforeach --}}
            </div>
        </div>
        <div class="flex justify-end pt-6">
            <a href="{{ route('projects.index') }}" class="border-dark-blue text-dark-blue rounded-full border-[1px] border-solid px-4 py-2">View All Projects</a>
        </div>
    </div>


    <!-- Body Content 5 -->
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
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
                <h1 class="font-bold text-2xl mb-4 text-dark-blue text-justify">Learning Never Stops</h1>
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
    </div>
@endsection
