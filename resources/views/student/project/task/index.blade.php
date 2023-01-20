@extends('layouts.profile.index')
@section('content')
  {{-- @dd($task->project->name); --}}
<div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center ">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-6 my-auto">
        <h2 class="text-dark-blue text-2xl font-medium mb-3">{{$task->project->name}}</h2>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30 ">{{$task->project->project_domain}}</span>
      </div>
      <div class="col-span-6 relative">
        <img src="{{asset('assets/img/icon/profile/dots.png')}}" class="absolute z-10 right-0 -top-3 ">
        <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4 absolute z-30 right-10 top-10 ">
          <img src="{{asset('storage/'.$task->project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">Project Details</h1>
      </div>
      <div class="col-start-10 col-span-3">
          <span class="intelOne text-black text-sm font-normal">due date</span> 
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-3">
      <div class="col-span-9 problem text-justify">
        {!!$task->description!!}
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-12">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">Attachment</h1>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mb-3">
      <div class="col-span-12">
        @foreach($task->sectionSubsections as $subsection)
        <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium ">
          <a href="{{asset('storage/'.$subsection->file1)}}" class="flex justify-between items-center">
            {{$subsection->title}} {{substr($subsection->file1, strpos($subsection->file1, '.'))}}
            <img src="{{asset('assets/img/icon/download.png')}}" alt="">
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection