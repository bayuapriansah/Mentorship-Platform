@extends('layouts.profile.index')
@section('content')
<div class="pb-[150px] bg-white">
  <div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
    <div class="col-span-12 flex items-center gap-8 border-b border-gray-200">
        <h1 class="w-max py-2 text-grey text-xl">
            <a href="{{ route('student.allProjects', ['student' => auth()->user()->id]) }}?is_skills_track">
                My Project
            </a>
        </h1>

        <h1 class="w-max py-2 border-b-2 border-darker-blue text-darker-blue text-2xl font-medium">
            <a href="{{ route('student.allProjectsAvailable', ['student' => auth()->user()->id]) }}?is_skills_track">
                Available Projects
            </a>
        </h1>
    </div>
  </div>
  {{-- <div class="max-w-[1366px] mx-auto px-16 grid grid-cols-12 gap-8 grid-flow-col items-center" id="searchBar">
    <div class="col-span-8 relative">
      <form action="/projects/search" method="get">
        @csrf
        <input type="text" class="w-1/2 px-2 border border-light-blue h-10 rounded-lg" placeholder="Search Projects" name="search">
        <div class="absolute inset-y-0 right-1/2 flex items-center pr-3 pointer-events-none">
          <img src="{{asset('assets/img/icon/magGlass.png')}}" class="pl-2 my-auto" alt="">
        </div>
      </form>
    </div>
  </div> --}}
  <div class="max-w-[1366px] mt-12 mx-auto px-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
    <div class="col-span-8 min-h-screen">
      @if (\Carbon\Carbon::now() > $student->end_date)
        <div id="toast-danger" class="flex flex-grow items-center w-full p-4 mb-4 text-white rounded-lg bg-[#CE2E2E]" role="alert">
          <div class="ml-3 text-sm font-normal">Internship Timeline is over. Please contact system admin.</div>
        </div>
      @else
        @forelse($projects as $project)
            <div class="border mb-8 hover:border-darker-blue hover:border border-light-blue py-5 px-5 rounded-xl bg-white">
                <div class="flex space-x-2">
                    <div class=" my-auto border border-light-blue rounded-xl py-4 px-2 mr-2 relative">
                        <img
                            src="{{ asset('storage/' . $project->company->logo) }}"
                            onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
                            alt="Logo"
                            class="w-16 h-9 object-scale-down mx-auto"
                        >
                    </div>
                    <div class="flex-col">
                        <p class="text-darker-blue font-bold text-sm">
                            {{ $project->name }}
                        </p>

                        <div class="min-w-[112px] mt-2 px-2 py-1 bg-lightest-blue rounded-full text-center text-xs font-medium">
                            @switch($project->project_domain)
                                @case('statistical')
                                    Machine Learning
                                    @break
                                @case('computer_vision')
                                    Computer Vision
                                    @break
                                @default
                                    NLP
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="text-grey font-normal text-xs py-2 m-0">
                    {{ substr($project->overview, 0, 250) }}...
                </div>
                <div class="flex justify-between mt-0">
                    <p class="intelOne text-black text-sm font-normal my-auto">
                        Duration:
                        <span class="font-bold">
                            {{-- {{ $project->period }} Month(s) --}}
                            10 Weeks
                        </span>
                    </p>

                    <div class="flex items-center gap-4">
                        <a
                            href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable/{{$project->id}}/detail"
                            class="intelOne text-white text-sm font-normal bg-primary px-12 py-2 rounded-full"
                        >
                            View Project
                        </a>
                    </div>
                </div>
            </div>
        @empty
          <img src="{{asset('assets/img/4957155.png')}}" alt="" class="mx-auto">
          <p class="intelOne text-lg text-center">No Project Found</p>
        @endforelse
      @endif
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
