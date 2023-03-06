@extends('layouts.profile.index')
@section('content')
<div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center min-h-screen">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-6 my-auto">
        <a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="px-5 pb-2 py-2 rounded-lg text-white bg-darker-blue hover:bg-dark-blue"><i class="fa-solid fa-arrow-left pr-2"></i>back</a>
        <h2 class="text-dark-blue text-2xl font-medium mb-3">{{$project->name}}</h2>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30 ">
          @if ($project->project_domain == 'statistical')
            Statistical Data
          @elseif($project->project_domain == 'computer_vision')
            Computer Vision
          @else
            {{$project->project_domain}}
          @endif
        </span>
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
          $enrolledDate = $appliedDate->format('d M Y');

          $completedDate =  \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->updated_at)->startOfDay()->format('d M Y');
          // $co

          $now = \Carbon\Carbon::now()->startOfDay();
          @endphp
          {{-- @dd($completedDate) --}}
          <p class="font-normal text-sm text-right">
            @if ($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->where('is_submited', 1)->first())
              Completed On <br> {{$completedDate}}
            @else
              Enrolled On <br> {{$enrolledDate}}
            @endif
          
          </p>
          
      </div>
    </div>
    <div class="grid grid-cols-12 gap-8 grid-flow-col mt-14">
      <div class="col-span-10 text-justify">
        <div class="problem">
          {!!$project->problem!!}
        </div>
        @if ($project->overview)
        <div class="mb-6">
          <h1 class="text-dark-blue text-[22px] font-medium">Overview</h1>
          <p class="text-grey text-sm">
            {{$project->overview}}
          </p>
        </div>   
        @endif
        @if ($project->dataset)
          @php 
            $datasets_array = explode(';',$project->dataset);
            $no=1;
          @endphp
          <div class="mb-6">
          <h1 class="text-dark-blue text-[22px] font-medium mb-1">Dataset</h1>
            @foreach ($datasets_array as $dataset_array)
                <a href="{{$dataset_array}}" class="bg-light-brown hover:bg-dark-brown px-4 py-1 rounded-lg text-white mr-2" target="_blank">Dataset {{$no}} <i class="fa-solid fa-chevron-right"></i></a>
            @php $no++ @endphp
            @endforeach
          </div>

        @endif
      </div>
      <div class="col-start-11 col-span-3">
        <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute mt-14  flex  float-right space-x-3 ">
          <i class="fa-regular fa-calendar"></i>
          <p class="font-normal text-sm text-light-blue">Duration: <span class="text-dark-blue">{{$project->period}} Months</span></p>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mb-3">
      <div class="col-span-12">
        @php
          $no = 1;
          $nn = 1;
          $total_submission = $submissions->count();
          // dd($total_submission);
          if($total_submission == 0){
            $total_submission += 1;
            $project_sections = $project_sections->take($total_submission);
          }elseif($total_submission > 0) {
            $total_submission += 1;
            $project_sections = $project_sections->take($total_submission);
          }
          @endphp
          
          {{-- @dd($project_sections) --}}
          @foreach($project_sections as $project_section)
            {{-- @if ($now->gte($appliedDate)) --}}
              {{-- @if($projectsections->count() > 0 && $submissions->count() > 0) --}}
                  <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium re-ordering-position-{{ $nn }}">
                    <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$project->id}}/task/{{$project_section->id}}" class="grid grid-cols-12 gap-4 grid-flow-col">
                        <div class="col-span-5">Task {{$no++}}: {{substr($project_section->title,0,30)}}...</div>
                        <span class="col-start-6 col-span-3 text-sm font-normal text-right ">{{ $appliedDate->format('dS M,Y') }} {{ $appliedDate->format('g:ia') }}</span>
                        <div class="col-start-9 col-span-2 items-center">
                          @foreach ($project_section->submissions->where('student_id',Auth::guard('student')->user()->id)->where('is_complete', 1) as $submission)
                            @if($submission->grade)
                              @if ($submission->grade->status==1)
                                <span class="text-[#11BF61]"><i class="fa-solid fa-circle text-[#11BF61] fa-xs mr-2"></i> Complete</span>
                              @elseif($submission->grade->status==0)
                                <span class="text-[#EA0202]"><i class="fa-solid fa-circle text-[#EA0202] fa-xs mr-2"></i> Revise</span>
                              @endif
                            @else
                              <span class="text-light-brown"><i class="fa-solid fa-circle text-light-brown fa-xs mr-2"></i> In Review</span>
                            @endif

                            {{-- @if($submission)
                              @if($submission->grade)
                                @if ($submission->grade->status==1)
                                  <span class="text-[#11BF61]"><i class="fa-solid fa-circle text-[#11BF61] fa-xs mr-2"></i> Complete</span>
                                @elseif($submission->grade->status==0)
                                  <span class="text-[#EA0202]"><i class="fa-solid fa-circle text-[#EA0202] fa-xs mr-2"></i> Revise</span>
                                @endif
                              @else
                              <span class="text-light-brown"><i class="fa-solid fa-circle text-light-brown fa-xs mr-2"></i> In Review</span>
                              @endif
                            @else
                              <span class="text-light-brown"><i class="fa-solid fa-circle text-light-brown fa-xs mr-2"></i> In Review</span>
                            @endif --}}

                          @endforeach
                        </div>
                        <div class="col-start-12 col-span-2">
                          <i class="fa-solid fa-chevron-right text-dark-blue"></i>
                        </div>
                    </a>
                  </div>
                  @php
                    $appliedDate = $appliedDate->addDays(2);
                  @endphp
              {{-- @endif --}}
            {{-- @endif --}}
          @endforeach
          {{-- @foreach($projectsections as $proj) --}}
            {{-- @if ($now->gte($appliedDate)) --}}
            {{-- @dd($projectsections->count() - 1) --}}
              @if($projectsections->count() - 1 > 0 && $now->lt($appliedDate))
              {{ $projectsections->count() > 0 }}
              {{ 'Kondisi' }}
              {{ $now->lt($appliedDate) }}
                  <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium re-ordering-position-{{ $nn }}">
                    <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$project->id}}/task/{{$projectsections[0]->id}}" class="flex justify-between items-center">
                        Task {{$no++}}: {{substr($projectsections[0]->title,0,60)}}...
                        <span class="text-sm font-normal">{{ $appliedDate->format('dS M,Y') }}</span>
                        {{-- <i class="fa-solid fa-circle-check"></i> --}}
                    </a>
                  </div>
                  @php
                    $appliedDate = $appliedDate->addDays(2);
                  @endphp
              @endif
            {{-- @endif --}}
          {{-- @endforeach --}}
      </div>
  </div>
    </div>
  </div>
</div>
@endsection
@section('more-js')
<script>
var elements = $(".re-ordering-position-*");
elements.sort(function(a, b) {
    var aVal = parseInt(a.className.split("-")[2]);
    var bVal = parseInt(b.className.split("-")[2]);
    return bVal - aVal;
}).appendTo('.grid');
</script>
@endsection