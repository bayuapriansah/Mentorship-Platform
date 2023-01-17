@extends('layouts.profile.index')
@section('content')
  <div class="mt-5">
    @forelse($enrolled_projects as $enrolled_project)
    <div class="border mb-5 hover:border-darker-blue hover:border border-light-blue py-5 px-5 rounded-xl">
      <div class="flex space-x-2">
        <div class=" my-auto border border-light-blue rounded-xl py-4 px-2 mr-2 relative">
          @if($enrolled_project->is_submit == 0)
          <div class="intelOne text-white text-sm font-normal bg-light-brown px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span class="ml-2">Ongoing</span>
          </div>
          @elseif($enrolled_project->is_submit == 1)
          <div class="intelOne text-white text-sm font-normal bg-light-green px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
            <i class="fa-solid fa-check"></i>
            <span class="ml-2">Completed</span>
          </div>
          @endif
          <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9  mx-auto " alt="">
        </div>
        <div class="flex-col">
          <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0">{{$enrolled_project->project->name}}</p>
          <p class="text-black font-normal text-sm m-0">{{$enrolled_project->project->company->name}}</p>
          <p class="text-dark-blue font-normal text-sm bg-lightest-blue  rounded-full w-32 text-center m-0">{{$enrolled_project->project->project_domain}}</p>
        </div>
      </div>
      <div class="intelOne text-grey font-normal text-xs py-2 m-0">
        {!! substr($enrolled_project->project->problem,0,200) !!}...
      </div>
      <div class="flex justify-between mt-0">
        <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-bold">{{$enrolled_project->project->period}} Months</span></p>
        <a href="#" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-2 rounded-full">View Project</a>
      </div>
    </div>
    @empty
      @if(Route::is('student.allProjects'))
      <div class="mt-20 text-sm text-center space-y-4 mb-52">
        <p class="text-dark-blue">Get started with Intel Simulated Internship program. You need to enrol in 3 projects for your internship</p>
        <p class="text-black">Click on the link below to select projects</p>
        <p><a href="/projects" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-8 py-3 rounded-full">View All Available Projects</a></p>
      </div>
      @elseif(Route::is('student.ongoingProjects'))
      <div class="mt-20 text-sm text-center space-y-4 mb-52">
        <p class="text-dark-blue">You haven't ongoing projects yet</p>
      </div>
      @else
      <div class="mt-20 text-sm text-center space-y-4 mb-52">
        <p class="text-dark-blue">You haven't completed projects yet</p>
      </div>
      @endif
    @endforelse
  </div>
@endsection
  {{-- Jika tidak ada --}}
  