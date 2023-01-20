@extends('layouts.profile.index')
@section('content')
{{-- 
  
  PHP CODE HERE

  --}}
  @php
  $appliedDate = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', $student->id)->where('project_id', $project->id)->first()->created_at);
  $date = $appliedDate->format('Y-m-d');
  $now = \Carbon\Carbon::now();
  @endphp

{{-- 
  END OF PHP CODE HERE
  --}}
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
        <h1 class="text-dark-blue text-[22px]">Project Details</h1>
      </div>
      <div class="col-start-10 col-span-3">
          <button  class="intelOne text-white text-sm font-normal bg-darker-blue px-12 py-2 rounded-full absolute cursor-default ">Enrolled</button> 
          <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute mt-14  flex items-center space-x-3">
            <i class="fa-regular fa-calendar"></i>
            <p class="font-normal text-sm text-light-blue">Duration: <span class="text-dark-blue">{{$project->period}} Month</span></p>
          </div>  
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-9 problem text-justify">
        {!!$project->problem!!}
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mb-3">
        <div class="col-span-12">
          @php $no = 1 @endphp
          @foreach($project_sections as $project_section)
          @if($now > $date)
              <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium ">
                <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$project->id}}/task/{{$project_section->id}}" class="flex justify-between items-center">
                  Task {{$no}}: {{substr($project_section->title,0,60)}}...
                  <span class="text-sm font-normal">{{ $appliedDate }}</span>
                </a>
              </div>
          @php $no++ @endphp
          @php $date = $appliedDate->addDays(5)->toDateString() @endphp
          @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection