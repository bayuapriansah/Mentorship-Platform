@extends('layouts.index')
@section('content')
<section id="login" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 pt-0 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-6 my-auto">
        <h2 class="intelOne text-white font-bold text-4xl leading-11">Internship <span class="text-light-brown">Projects</span></h2>
        <p class="intelOne font-light text-white text-lg leading-6 py-6 m-0">Take a look at the active projects being offered by our industry partners</p>
        
      </div>
      <div class="col-start-7 col-span-6 relative">
        <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
        <img src="{{asset('assets/img/internship-1.png')}}" class="relative z-20" alt="">

        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
        <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
        <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->
        
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 pt-24 mb-0 grid grid-cols-12 gap-8 grid-flow-col" id="#projectsSection">
    <div class="col-span-8 space-y-4">
      <h3 class="intelOne text-dark-blue text-2xl font-semibold">Internship Projects</h3>
    </div>
    
  </div>

  <div class="max-w-[1366px] mx-auto px-16 py-8 mb-0 grid grid-cols-12 gap-8 grid-flow-col">
    
    <div class="col-span-8 space-y-4 ">
      @if (Auth::guard('student')->check())
        @if (\Carbon\Carbon::now() > Auth::guard('student')->user()->end_date)
            <div class="text-center">Internship Ended</div>
        @else
          @forelse($projects as $project)
            <div class="border-[1px] hover:border-darker-blue border-light-blue py-5 px-5 rounded-xl">
              <div class="flex space-x-2">
                <div class=" my-auto border-[1px] border-light-blue rounded-xl py-4 px-2 mr-2">
                  <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
                </div>
                <div class="flex-col">
                  <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0">{{$project->name}}</p>
                  <p class="text-black font-normal text-sm m-0">{{$project->company->name}}</p>
                  <p class="text-dark-blue font-normal text-sm bg-lightest-blue  rounded-full w-32 text-center m-0">{{$project->project_domain}}</p>
                </div>
              </div>
              <p class="intelOne text-grey font-normal text-sm py-2 m-0 text-justify">{{ substr($project->overview,0,200) }}...</p>
              <div class="flex justify-between mt-4">
                <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-bold">
                  @if ($project->period>1)
                    {{$project->period}} Months
                  @else
                    {{$project->period}} Month
                  @endif  
                </span></p>
                <a href="/projects/{{$project->id}}" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">Project Details</a>
              </div>
            </div>
          @empty
            <img src="{{asset('assets/img/4957155.png')}}" alt="" class="mx-auto">
            <p class="intelOne text-lg text-center">No Project Found</p>
          @endforelse
        @endif
      @else
        @forelse($projects as $project)
          <div class="border-[1px] hover:border-darker-blue border-light-blue py-5 px-5 rounded-xl">
            <div class="flex space-x-2">
              <div class=" my-auto border-[1px] border-light-blue rounded-xl py-4 px-2 mr-2">
                <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
              </div>
              <div class="flex-col">
                <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0">{{$project->name}}</p>
                <p class="text-black font-normal text-sm m-0">{{$project->company->name}}</p>
                <p class="text-dark-blue font-normal text-sm bg-lightest-blue  rounded-full w-32 text-center m-0">{{$project->project_domain}}</p>
              </div>
            </div>
            <p class="intelOne text-grey font-normal text-sm py-2 m-0 text-justify">{{ substr($project->overview,0,200) }}...</p>
            <div class="flex justify-between mt-4">
              <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-bold">
                @if ($project->period>1)
                  {{$project->period}} Months
                @else
                  {{$project->period}} Month
                @endif  
              </span></p>
              <a href="/projects/{{$project->id}}" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">Project Details</a>
            </div>
          </div>
        @empty
          <img src="{{asset('assets/img/4957155.png')}}" alt="" class="mx-auto">
          <p class="intelOne text-lg text-center">No Project Found</p>
        @endforelse
      @endif
      {{-- @forelse($projects as $project)
      <div class="border-[1px] hover:border-darker-blue border-light-blue py-5 px-5 rounded-xl">
        <div class="flex space-x-2">
          <div class=" my-auto border-[1px] border-light-blue rounded-xl py-4 px-2 mr-2">
            <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
          </div>
          <div class="flex-col">
            <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0">{{$project->name}}</p>
            <p class="text-black font-normal text-sm m-0">{{$project->company->name}}</p>
            <p class="text-dark-blue font-normal text-sm bg-lightest-blue  rounded-full w-32 text-center m-0">{{$project->project_domain}}</p>
          </div>
        </div>
        <p class="intelOne text-grey font-normal text-sm py-2 m-0 text-justify">{{ substr($project->overview,0,200) }}...</p>
        <div class="flex justify-between mt-4">
          <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-bold">
            @if ($project->period>1)
              {{$project->period}} Months
            @else
              {{$project->period}} Month
            @endif  
          </span></p>
          <a href="/projects/{{$project->id}}" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">Project Details</a>
        </div>
      </div>
      @empty
        <img src="{{asset('assets/img/4957155.png')}}" alt="" class="mx-auto">
        <p class="intelOne text-lg text-center">No Project Found</p>
      @endforelse --}}
    </div>
    <div class="col-span-4">
      <div class="flex flex-col">
        <div class="space-y-5">
          <iframe width="361" height="240" src="https://www.youtube.com/embed/aZLE-c7I7uk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          <h5 class=" font-bold text-xl ">Quick start video to get you going</h5>
          <p class="text-grey font-normal text-sm">Facilitate your internship experience with this quick-start video - a step-by-step guide to give you a jumpstart! The video includes essential information about what to expect during the internship, how to navigate the platform, and success tips to make the most of the opportunity.</p>
        </div>
        <div class="space-y-5 mt-10">
          <img src="{{asset('assets/img/image19.png')}}" alt="">
          <h5 class=" font-bold text-xl ">About intel digital readliness</h5>
          <p class="text-grey font-normal text-sm">Intel® Digital Readiness Programs empower the non-technical audiences with the appropriate skill sets, mind-sets, toolsets, and opportunities to use technology impactfully and responsibly in the AI-fuelled world.</p>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection