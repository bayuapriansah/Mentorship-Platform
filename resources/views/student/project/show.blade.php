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
          <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">Project Details</h1>
      </div>
      <div class="col-end-13 col-span-3">
          {{-- <button  class="intelOne text-white text-sm font-normal bg-darker-blue px-12 py-2 rounded-full absolute cursor-default ">Enrolled</button>  --}}
          @php
          $appliedDate = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
          $enrolledDate = $appliedDate->format('dS M,Y'); 
          $now = \Carbon\Carbon::now();
          @endphp
          <p class="font-normal text-sm text-right">Enrolled On <br> {{$enrolledDate}}</p>
          
      </div>
    </div>
    <div class="grid grid-cols-12 gap-8 grid-flow-col mt-14">
      <div class="col-span-10 problem text-justify">
        {!!$project->problem!!}
      </div>
      <div class="col-start-11 col-span-3">
        <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute mt-14  flex  float-right space-x-3 ">
          <i class="fa-regular fa-calendar"></i>
          <p class="font-normal text-sm text-light-blue">Duration: <span class="text-dark-blue">{{$project->period}} Month</span></p>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mb-3">
      <div class="col-span-12">
        @php
          $no = 1;
        @endphp
        @foreach($project_sections as $project_section)
          @if ($now >= $appliedDate || in_array($project_section->id, $submissions->where('section_id',$project_section->id)->where('student_id',$student->id)->pluck('section_id')->toArray()))
            <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium ">
              <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$project->id}}/task/{{$project_section->id}}" class="flex justify-between items-center">
                  Task {{$no}}: {{substr($project_section->title,0,60)}}...
                  <span class="text-sm font-normal">{{ $appliedDate->format('dS M,Y') }}</span>
              </a>
            </div>
          @endif
          @php
            $no++;
            $appliedDate = $appliedDate->addDays(10);
          @endphp
        @endforeach
        {{-- if(!) --}}
        {{-- @dd($projectsections->count() > 0) --}}
        @if($projectsections->count() > 0)
        @foreach($projectsections as $pro_section)
            <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium ">
                <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$project->id}}/task/{{$pro_section->id}}" class="flex justify-between items-center">
                    Task {{$no}}: {{substr($pro_section->title,0,60)}}...
                    <span class="text-sm font-normal">{{ $appliedDate->format('dS M,Y') }}</span>
                </a>
            </div>
        @endforeach
        @endif
      </div>
  </div>
    </div>
  </div>
</div>
@endsection