@extends('layouts.index')
@section('content')

<section id="project" class="w-full">
    {{-- Body Contents --}}
    <div class="max-w-full bg-darker-blue">
        <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20 bg-darker-blue">
            <div class="grid md:grid-cols-2 gap-4 items-center">
                <div class="my-auto">
                    <h2 class="intelOne text-white font-bold text-3xl leading-11 py-4">
                        <span>Internship <span class="text-light-brown">Projects</span>
                    </h2>
                    <span class="intelOne text-white py-6 font-light text-lg leading-6">Take a look at the active projects being offered by our industry partners</span>
                </div>
                <div class="relative my-auto">
                    <img src="{{asset('assets/img/internship-projects.png')}}" class="relative z-40" alt="">
                    <img src="{{ asset('assets/img/dots-1.png') }}" alt="dots"
                        class="absolute z-0 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true">
                    <img src="{{ asset('assets/img/dots-2.png') }}" alt="dots"
                        class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true">
                </div>
            </div>
        </div>
    </div>

    {{-- Body Content 2 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
      <div class="grid md:grid-cols-4 gap-4 items-start">
        <div class="relative col-span-3">
            <div class="flex justify-between items-center mb-4">
                <h2 class="m-0 text-2xl font-medium text-dark-blue font-semibold text-justify justify-start">Internship Projects</h2>
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
                    @foreach($projects as $project)
                        <!-- Slide -->
                        <div class="swiper-slide">
                            <div
                                class="block p-5 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-[#A4AADC] bg-white max-w-3xl h-[250px] overflow-hidden">
                                <div class="flex space-x-2">
                                    <div class=" my-auto border-2 border-[#A4AADC] rounded-xl py-1 px-1 mr-2">
                                        <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-12 object-cover mx-auto rounded-xl" alt="Logo">
                                    </div>
                                    <div class="flex-col">
                                        <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0 overflow-ellipsis overflow-hidden">{{$project->name}}</p>
                                        <p class="text-black font-normal text-sm m-0 overflow-ellipsis overflow-hidden">{{$project->company->name}}</p>
                                        <div class="pt-2">
                                            <p
                                            class="text-dark-blue font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36 overflow-ellipsis overflow-hidden">
                                            {{ $project->project_domain == 'statistical' ? 'Statistical Data' : ($project->project_domain == 'computer_vision' ? 'Computer Vision' : 'NLP') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-grey font-normal text-base mb-2 pt-3 overflow-ellipsis overflow-hidden">
                                    {{ $project->overview }}</div>
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
          </div>
          <div class="relative">
            <div class="relative z-30 rounded-lg overflow-hidden" style="padding-bottom: 56.25%">
              <iframe class="absolute inset-0 w-full h-full py-4" src="https://www.youtube.com/embed/aZLE-c7I7uk"
              title="YouTube video player" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
            </div>
            <h1 class="m-0 font-bold text-xl text-justify justify-start">Quick start video to get you going</h1>
            <p class="text-grey font-normal text-sm text-justify py-4">Facilitate your internship experience with this quick-start video - a step-by-step guide to give you a jumpstart! The video includes essential information about what to expect during the internship, how to navigate the platform, and success tips to make the most of the opportunity.</p>
            <div class="relative z-30 rounded-lg overflow-hidden py-6">
              <img src="{{asset('assets/img/image19.png')}}" class="w-full h-full" alt="">
            </div>
            <h1 class="m-0 font-bold text-xl text-justify justify-start">About intel digital readliness</h1>
            <p class="text-grey font-normal text-sm text-justify py-4">Intel® Digital Readiness Programs empower the non-technical audiences with the appropriate skill sets, mind-sets, toolsets, and opportunities to use technology impactfully and responsibly in the AI-fuelled world.</p>
          </div>    
      </div>
    </div>
</section>

@endsection
@section('more-js')
<script>
  var swiper = new Swiper('.swiper-container', {
      direction: 'vertical',
      slidesPerView: 'auto',
      spaceBetween: 10,
      navigation: {
      nextEl: '#swiper-button-next',
      prevEl: '#swiper-button-prev',
    },
  });
</script>
@endsection