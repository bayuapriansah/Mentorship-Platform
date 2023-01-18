@extends('layouts.profile.index')
@section('content')
<div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-3">
        <h2 class="text-dark-blue text-2xl font-medium">My Projects</h2>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-8">
        <div class="text-sm font-medium text-center text-light-blue border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
          <ul class="flex flex-wrap -mb-px">
              <li class="mr-2">
                {{-- {{}} --}}
                @if(Route::is('student.allProjects'))
                  <a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="inline-block p-4  border-b-2 text-black border-dark-blue rounded-t-lg active font-semibold" id="all">All Enrolled Projects</a>
                @else
                  <a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="inline-block p-4 border-b-2 rounded-t-lg  hover:text-lighter-blue hover:border-gray-300" id="all">All Enrolled Projects</a>
                @endif
              </li>
              <li class="mr-2">
                @if(Route::is('student.ongoingProjects'))
                  <a href="/profile/{{Auth::guard('student')->user()->id}}/ongoingProjects" class="inline-block p-4  border-b-2 text-black border-dark-blue rounded-t-lg active font-semibold" aria-current="page">Ongoing Project</a>
                @else
                  <a href="/profile/{{Auth::guard('student')->user()->id}}/ongoingProjects" class="inline-block p-4 border-b-2 rounded-t-lg  hover:text-lighter-blue hover:border-gray-300" aria-current="page">Ongoing Project</a>
                @endif
              </li>
              <li class="mr-2">
                @if(Route::is('student.completedProjects'))
                  <a href="/profile/{{Auth::guard('student')->user()->id}}/completedProjects" class="inline-block p-4  border-b-2 text-black border-dark-blue rounded-t-lg active font-semibold">Completed Project</a>
                @else
                  <a href="/profile/{{Auth::guard('student')->user()->id}}/completedProjects" class="inline-block p-4 border-b-2 rounded-t-lg hover:text-lighter-blue hover:border-gray-300">Completed Project</a>
                @endif
              </li>
          </ul>
        </div>
        <div class="mt-5 mb-28">
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
              <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$enrolled_project->project->id}}/detail" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-2 rounded-full">View Project</a>
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
      </div>
      <div class="col-start-9 col-span-4 ">
        <div class="border p-4 rounded-l-lg rounded-t-lg bg-dark-blue flex flex-col items-center ">
          <div class="flex justify-between relative items-center">
            <p class="text-white text-xl z-20 ">Score In <span class="text-light-brown">Top 10 Students</span> To Get Rewards</p>
            <img class="absolute w-36 z-10 -right-4 -top-9 -translate-y-0.5"  src="{{asset('assets/img/icon/profile/trophy1.png')}}" alt="">
          </div>
          <a href="#" class="intelOne z-30 text-dark-blue text-sm font-normal bg-white hover:bg-neutral-200 px-16 py-2 rounded-full mt-1" >Leaderboard</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
  {{-- Jika tidak ada --}}
  