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
{{-- Hero Banner --}}
<div class="min-h-[536px] bg-black bg-center bg-cover bg-no-repeat" style="background-image: url({{ asset('/assets/img/main/banner.png') }})">
    <div class="max-w-screen-xl mx-auto px-8 tab:px-[4.5rem] pt-48">
        <h1 class="text-white font-medium text-xl tab:text-3xl">
            <span>Intel® AI Global Impact Festival</span>
            <br>
            <span class="text-primary">
                Mentorship Platform
            </span>
        </h1>
        @if (isLoggedIn())
        @else
        <div class="mt-6 tab:mt-12">
            <a href="{{ route('multiLogIn') }}" class="text-white text-sm font-normal bg-primary px-8 py-1.5 hd:px-16 tab:py-3.5 rounded-full">
                Get Started
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Intro --}}
<div class="max-w-screen-xl mt-10 tab:mt-20 mx-auto px-6 flex flex-col items-center">
    <h2 class="font-bold text-2xl tab:text-3xl text-center text-darker-blue">
        Intel® AI Global Impact Festival<br>
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

{{-- Tracks --}}
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
                Take on real-world projects specifically developed for them to hone your technical AI skill.
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
                Extend your personal projects submitted to the Intel AI Impact Festival with a focus on polishing their projects and preparing to take the project to the next level as a new business venture.
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

{{-- Projects--}}
<div class="max-w-screen-xl mt-[8rem] mx-auto px-24 flex flex-col items-center">
    <h1 class="font-bold text-darker-blue text-2xl tab:text-3xl">
        Skills Track
    </h1>

    <div class="mt-12 flex flex-wrap justify-center gap-[3.25rem]">
        {{-- @dd($projects); --}}
        @foreach ($projects as $project)
            <div class="project-card w-[316px] min-h-[405px] pt-7 pb-10 px-6 flex flex-col items-center">
                <img
                    {{-- src="{{ 'storage/' . optional($project->company)->logo }}" --}}
                    src="{{ optional($project->company)->logo ? asset('storage/' . optional($project->company)->logo) : asset('/assets/img/project-logo-placeholder.png') }}"
                    onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
                    alt="Logo"
                    class="w-20 h-20 rounded-lg tab:rounded-xl bg-white border border-grey text-black text-center"
                >

                <h5 class="mt-4 font-bold text-lg text-darker-blue">
                    {{ optional($project)->name; }}
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

{{-- Project Planner --}}
<div class="relative max-w-screen-xl mt-[12.5rem] mb-[9.25rem] mx-auto px-6 flex flex-col tab:flex-row justify-center items-center gap-10 tab:gap-72">
    <div class="relative">
        <img src="{{ asset('/assets/img/home/planner-1.png') }}" alt="Image">
        <img src="{{ asset('/assets/img/home/planner-2.png') }}" alt="Image" class="absolute top-[3.5rem] -right-[12.5rem]">
    </div>

    <div class="relative z-[2] flex flex-col items-center gap-2">
        <h1 class="font-bold text-2xl text-darker-blue">
            Entrepreneur Track
        </h1>

        {{-- <a href="#" class="text-center text-white bg-primary px-8 py-2 text-xl rounded-full">
            View Project Planner
        </a> --}}
        <button data-modal-target="popup-enterpreneur-track-project-planner" data-modal-toggle="popup-enterpreneur-track-project-planner" type="button" class="text-center text-white bg-primary px-8 py-2 text-xl rounded-full" alt="View Project Planner">
            View Project Planner
        </button>
    </div>

    <div class="bubble-decoration-2 hidden tab:block absolute z-[2] -bottom-0 -right-8"></div>
    <div class="hidden tab:block absolute -bottom-60 -right-[10%] w-[621px] h-[621px] blue-shadow"></div>
</div>
<div id="popup-enterpreneur-track-project-planner" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-3/6 h-full max-w-4xl md:h-auto border-[3px] border-light-blue rounded-2xl">
        <div class="relative bg-white rounded-xl shadow-2xl">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center z-30" data-modal-hide="popup-enterpreneur-track-project-planner">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-left space-x-4">
                <img src="{{asset('assets/img/dots-1.png')}}" class="absolute top-0 right-0 w-[233px] h-[108px]" alt="">
                <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">This is only relevant for the entrepreneur track</h3>
                <div class="relative z-50 mt-8">
                  <button data-modal-hide="popup-enterpreneur-track-project-planner" type="submit" class="text-white text-sm font-normal bg-primary px-14 py-2 rounded-full">
                    Okay!
                  </button>
                  {{-- <button data-modal-hide="popup-enterpreneur-track-project-planner" type="button" class="ml-3 bg-white border border-primary text-primary text-sm font-normal px-12 py-2 rounded-full">Cancel</button> --}}
                </div>
            </div>
        </div>
    </div>
  </div>
{{-- Mentorship Timeline --}}
{{-- <div class="relative overflow-y-clip max-w-screen-xl mt-48 mx-auto px-6 pb-[11.25rem] flex flex-col items-center gap-[4.25rem]">
    <h1 class="relative z-[2] text-3xl text-center text-darker-blue font-bold">
        Mentorship Timeline
    </h1>

    <img
        src="{{ asset('/assets/img/home/mentorship-timeline.png') }}"
        alt="Mentorship Timeline"
        class="relative z-[2] w-[1066px]"
    >

    <div
        class="absolute -bottom-40 left-[30%] -translate-x-[30%] w-full h-[645.315px] bg-cover bg-no-repeat"
        style="background-image: url({{ asset('/assets/img/purple-wave.svg') }}); background-size: contain;"
    >
    </div>
</div> --}}


<section class="pt-16 pb-16 bg-white bg-no-repeat bg-center bg-cover bg-fixed overflow-hidden" style="background-image: url('{{ asset('/assets/img/purple-wave.svg') }}');">
    <div class="container px-4 mx-auto">
      <div class="py-16 px-20 bg-opacity-80 rounded-4xl">
      {{-- <div class="py-16 px-20 bg-opacity-80 rounded-4xl" style="backdrop-filter: blur(37px);"> --}}
        <div class="flex flex-wrap xl:items-center -m-8">
          <div class="w-full p-8">
              <h2 class="mb-14 text-3xl md:text-3xl text-center text-darker-blue font-bold tracking-px-n leading-tight">Mentorship Timeline</h2>
              <img src="{{ asset('/assets/img/home/mentorship-timeline.png') }}" alt="Mentorship Timeline" class="relative z-[2] w-[1066px] mx-auto block">
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
