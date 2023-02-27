@extends('layouts.index')
@section('content')
{{-- <div class="container">
  <div class="p-5 mb-4 text-center">
    @include('flash-message')
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <h1 class="mb-4">Available Projects</h1>
  
  <div class="row">
    <div class="col-9">
      @foreach($projects as $project)
      <div class="row mb-4">
        <div class="col">
          <div class="card bg-light p-4 text-decoration-none text-dark border-left-primary">
            <div class="row">
              <div class="col-10">
                <h3>{{$project->name}}</h3>
              </div>
              <div class="col-2">
                <a class="btn btn-primary" href="/projects/{{$project->id}}" role="button">Details</a>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>{{$project->company->name}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>created at {{$project->created_at->toDateString()}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>{{$project->project_domain}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>
    <div class="col">
      @include('projects.sidebar')
    </div>
  </div> --}}
  
  {{-- <div class="card mt-5 text-center bg-light">
    
  </div> --}}

  {{-- <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Twitter-logo.svg" alt="" width="30px" height="30px">
    <p>Checkout Sponsoring Company</p>
  </div>
  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <p>Download the dataset here</p>
  </div>

  

  <h2 class="mt-5">Get help for your project</h2>
  <a href="#" class="link-primary">Link to discussion forum</a><br>
  <a href="#" class="link-primary">Link to support document library</a>
</div> --}}
<section id="login" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 pt-0 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-6 my-auto">
        <h2 class="intelOne text-white font-bold text-4xl leading-11">Internship <span class="text-light-brown">Projects</span></h2>
        <p class="intelOne font-light text-white text-lg leading-6 py-6 m-0">Take a look at the active projects being offered by our industry partners</p>
        {{-- @if(!Auth::guard('student')->check())
        
        <form action="/projects/search" method="get">
          @csrf
          <div class="flex justify-between">
          <div class="relative flex-grow">
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 focus:outline-none" placeholder="Search an internship program" name="search">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
          </div>
          </div>
          <div class="flex">
          </div>
        </form>
        @endif --}}
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