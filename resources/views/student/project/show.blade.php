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
      <div class="col-span-9">
        <div id="accordion-collapse" data-accordion="collapse">
          @php $no = 1 @endphp
          @foreach($project_sections as $project_section)
          @if($now > $date)
          <h2 id="accordion-collapse-heading-{{$no}}">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border  border-dark-blue rounded-xl mt-5 mb-2 focus:ring-4 bg-white focus:bg-neutral-100  hover:bg-neutral-100 " data-accordion-target="#accordion-collapse-body-{{$no}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$no}}">
              <span class="text-darker-blue font-bold text-xl flex items-center space-x-3">
                <img src="{{asset('assets/img/icon/folder.png')}}" class="mr-2" alt="">
                {{$project->type == 'weekly' ? 'Task': 'Month'}} {{$no}} 
                <span class="text-grey text-base">{{$project_section->sectionSubsections->count()}} tasks</span>
              </span>
              {{ $date }}
              @php
              $date = $appliedDate->addDays(10)->toDateString();
              // @dd($appliedDate->toDateString());
              @endphp
              {{-- @dd($student->id) --}}
              <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-{{$no}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$no}}">
            <ul class="ml-4">
              @foreach($project_section->sectionSubsections as $subsection)
              {{-- @dd($date > $now) --}}
              <li class="py-4 px-5 rounded-xl mb-2 border border-xl border-gray-200 font-normal text-sm text-black bg-white">
                <div class="flex">
                  @if($subsection->category == 'video')
                    <img src="{{asset('assets/img/icon/video.png')}}" alt="">
                  @elseif($subsection->category == 'reading')
                    <img src="{{asset('assets/img/icon/pdf.png')}}" alt="">
                  @else
                    <i class="fa-regular fa-folder"></i>
                  @endif
                  <span class="font-normal text-sm ml-4">{{$subsection->category}}</span>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
          @php $no++ @endphp
          @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection