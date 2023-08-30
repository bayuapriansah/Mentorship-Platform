@extends('layouts.index')
@section('content')
    {{-- Body Contents --}}
    <div class="max-w-full bg-darker-blue">
        <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20 bg-darker-blue">
            <div class="grid md:grid-cols-2 gap-4 items-center">
                <div class="my-auto">
                    <h2 class="intelOne text-white font-bold text-3xl leading-11 py-4">
                        <span class="text-light-brown">Simulated Internship</span> Platform for <span
                            class="text-light-brown">Industry Readiness</span>
                    </h2>
                    <span class="intelOne text-white py-6 font-light text-lg leading-6">Join today to work on real-world
                        projects and kick start your career!</span>
                    <div class="flex py-4">
                        <a href="{{ route('multiLogIn') }}"
                            class="intelOne text-dark-blue text-sm font-normal bg-white hover:bg-neutral-300 px-16 py-3.5 rounded-full">GetStarted</a>
                    </div>
                </div>
                <div class="relative my-auto">
                    <img src="{{ asset('assets/img/home1.png') }}" loading="lazy" class="relative z-40" alt="">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots"
                        class="absolute z-0 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true">
                    <img src="{{ asset('assets/img/dots-2.png') }}" loading="lazy" alt="dots"
                        class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true">
                </div>
            </div>
        </div>
    </div>

    {{-- Body Content 2 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="my-auto">
                <h2 class="intelOne text-dark-blue font-bold text-4xl">AI for <br>Future Workforce</h2>
            </div>
            <div class="relative my-auto">
                <p class="m-0 text-black text-justify">Intel® AI For Workforce is a global AI skilling program for
                    vocational students for building an AI-ready workforce. The program aims to address the AI skill
                    crisis to cater to growing job demands related to AI/ML by empowering the future workforce with the
                    necessary skills for employability in the digital economy. The program offers comprehensive,
                    modular, experiential, and flexible AI content delivered through engaging learning experiences.</p>
                <div class="relative z-30 rounded-lg overflow-hidden" style="padding-bottom: 56.25%">
                    <iframe class="absolute inset-0 w-full h-full py-4" src="https://www.youtube.com/embed/K9iflwQqVsA"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                        allowfullscreen loading="lazy"></iframe>
                </div>
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
                @foreach ($projects as $project)
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
                @endforeach
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
@section('more-js')
<script>
  const swiper = new Swiper('.swiper-container', {
      slidesPerView: 3,
      spaceBetween: 30,
      navigation: {
          nextEl: '#swiper-button-next',
          prevEl: '#swiper-button-prev',
      },
      breakpoints: {
          320: {
              slidesPerView: 1,
              spaceBetween: 10
          },
          480: {
              slidesPerView: 1,
              spaceBetween: 10
          },
          640: {
              slidesPerView: 2,
              spaceBetween: 10
          },
          950: {
              slidesPerView: 3,
              spaceBetween: 30
          }
      }
  });
</script>
@endsection