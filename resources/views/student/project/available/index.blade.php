@extends('layouts.profile.index')
@section('content')
<div class="pb-[150px]">
  <div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
    <div class="col-span-8 flex justify-between">
      <h1 class="text-dark-blue text-2xl font-medium flex items-center">Internship Projects
        @if(!Auth::guard('student')->check())
        <img src="{{asset('assets/img/icon/magGlass.png')}}" class="pl-2 my-auto cursor-pointer" alt="Magnifying glass" id="search">
        @endif
      </h1>
      <p>Sort</p>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 grid grid-cols-12 gap-8 grid-flow-col items-center" id="searchBar">
    <div class="col-span-8 relative">
      <form action="/projects/search" method="get">
        @csrf
        <input type="text" class="w-1/2 px-2 border border-light-blue h-10 rounded-lg" placeholder="Search Projects" name="search">
        <div class="absolute inset-y-0 right-1/2 flex items-center pr-3 pointer-events-none">
          <img src="{{asset('assets/img/icon/magGlass.png')}}" class="pl-2 my-auto" alt="">
        </div>
      </form>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 pt-5 grid grid-cols-12 gap-8 grid-flow-col items-center">
    <div class="col-span-8 min-h-[500px]">
      @forelse($projects as $project)
        <div class="border-[1px] hover:border-darker-blue bg-white border-light-blue py-5 px-5 rounded-xl mb-3">
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
          <div class="intelOne text-grey font-normal text-sm py-2 m-0">{!! substr($project->problem,0,245) !!}...</div>
          <div class="flex justify-between mt-2">
            <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-bold">{{$project->period}} Months</span></p>
            <a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable/{{$project->id}}/detail"
               class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">View Internship</a>
          </div>
        </div>
        @empty
          <img src="{{asset('assets/img/4957155.png')}}" alt="" class="mx-auto">
          <p class="intelOne text-lg text-center">No Internship Found</p>
        @endforelse
    </div>
  </div>
</div>

@endsection
@section('more-js')
<script>
  $(document).ready(function(){
  // $('#inviteMentors').hide();
  $('#searchBar').hide();
  $("#search").click(function(){
    $('#searchBar').toggle();
  });
});
</script>

@endsection