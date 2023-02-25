@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">
    Project Details
    @if($project->status == 'proposed')
      <a href="/dashboard/projects/{{$project->id}}/edit"><i class="fa-solid fa-pencil"></i></a>
    @endif
  </h3>
  <a href="/dashboard/projects" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>

<div class="flex flex-col">
  <p class="text-light-blue">Project Name</p>
  <p>{{$project->name}}</p>
</div>

<div class="flex justify-between mt-5 w-3/4">
  <div>
    <p class="text-light-blue">Project Name</p>
    <p>{{$project->project_domain}}</p>
  </div>
  <div>
    <p class="text-light-blue">Project Duration</p>
    <p>{{$project->period}} Months</p>
  </div>
  <div>
    <p class="text-light-blue">Project By</p>
    <p>{{$project->company->name}}</p>
  </div>
</div>

<div class="flex flex-col mt-7">
  <p class="text-light-blue">Project Details</p>
  <p>{!!$project->problem!!}</p>
</div>

<div class="flex flex-col mt-5">
  <p class="text-light-blue">Brief Project Overview (Optional)</p>
  <p>
    @if ($project->overview)
      {{$project->overview}}
    @else
      This Project doesn't have overview
    @endif
  </p>
</div>

<div class="w-3/4">
  <h3 class="text-dark-blue font-medium text-xl mt-14">Injection Cards</h3>
  <div class="mb-3 space-y-2">
    @php
        $no = 1
    @endphp
    @foreach ($cards as $card)
    <a href="/dashboard/projects/{{$project->id}}/injection/{{$card->id}}/show" class="">
      <div class="py-4 px-6 mb-2 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
        <div>Task {{$no}}: {{substr($card->title,0,38)}}...</div>
        <div class="flex flex-col">
          <span class="text-xs">Duration:</span>
          <span class="text-xs text-dark-blue">{{$card->duration}} {{$card->duration==1?'Day':'Days'}}</span>
        </div>
        <div class="flex flex-col">
          <span class="text-xs">Added On:</span>
          <span class="text-xs text-dark-blue">{{$card->created_at->format('d/m/Y')}}</span>
        </div>
        <div class="space-x-5">
            <i class="fa-solid fa-eye text-dark-blue"></i>
          </div>
      </div>
    </a>
    @php
      $no++
    @endphp
    @endforeach
  </div>
</div>
@endsection