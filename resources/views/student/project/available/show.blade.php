@extends('layouts.profile.index')
@section('content')
<div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-6 my-auto">
        <h2 class="text-dark-blue text-2xl font-medium mb-3">{{$project->name}}</h2>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30 ">{{$project->project_domain}}</span>
      </div>
      <div class="col-span-6 relative">
        <img src="{{asset('assets/img/icon/profile/dots.png')}}" class="absolute z-10 right-0 -top-3 ">
        <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4 absolute z-30 right-10 top-10 ">
          <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9  mx-auto " alt="">
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px]">Project Details</h1>
      </div>
      <div class="col-start-10 col-span-2">
        @if(Auth::guard('student')->check())
          <form method="POST" action="/projects/{{ $project->id }}/apply" >
            @csrf
            <button type="submit" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full absolute " onClick="return confirm('Are you sure you want to enrol in the project - Automated Attendance System offered by Google?')">Enroll</button> 
            <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute mt-14  flex items-center space-x-3">
              <i class="fa-regular fa-calendar"></i>
              <p class="font-normal text-sm text-light-blue">Duration: <span class="text-dark-blue">{{$project->period}} Month</span></p>
            </div> 
          </form> 
        @endif 
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-9 problem text-justify">
        {!!$project->problem!!}
      </div>
    </div>
  </div>
</div>
@endsection