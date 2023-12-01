@php
    $appliedDate = \Carbon\Carbon::parse(
        $project->enrolled_project
            ->where('student_id', Auth::guard('student')->user()->id)
            ->where('project_id', $project->id)
            ->first()->created_at,
    )->startOfDay();

    $enrolledDate = $appliedDate->format('d M Y');

    $completedDate = \Carbon\Carbon::parse(
        $project->enrolled_project
                ->where('student_id', Auth::guard('student')->user()->id)
                ->where('project_id', $project->id)
                ->first()->updated_at,
    )->startOfDay()->format('d M Y');
    $now = \Carbon\Carbon::now()->startOfDay();

    // Datasets
    if ($project->dataset) {
        $datasets_array = explode(';', $project->dataset);
    }
@endphp

@extends('layouts.profile.index')
@section('content')

<div class="max-w-[1366px] mx-auto px-16 pt-4 pb-40 bg-white">
    <div class="w-[850px] relative">
        {{-- Top Right Content --}}
        <div
            class="w-[233px] h-[100px] absolute top-0 right-0"
            style="background: url({{ asset('/assets/img/home/bubble-decoration.svg') }}), transparent -0.084px -8.927px / 100.073% 126.737% no-repeat;"
        ></div>

        <div class="w-[30px] h-[30px] absolute top-[45px] right-[110px] bg-[#DEAA51] rounded-lg"></div>

        <div class="absolute top-14 right-16 flex flex-col items-end">
            <img src="{{ asset('storage/' . $project->company->logo) }}" alt="Logo" class="w-16 h-16 object-cover bg-slate-200 rounded-xl text-black text-center">

            @if ($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->where('is_submited', 1)->first())
                <p class="mt-[1.4rem] text-sm text-right">
                    Completed On <br> {{ $completedDate }}
                </p>
            @else
                <p class="mt-[1.4rem] text-sm text-right">
                    Enrolled On <br> {{ $enrolledDate }}
                </p>

                <p class="mt-2 flex gap-2 items-center font-medium text-[#6672D3] text-xs">
                    <span class="w-[10px] h-[10px] bg-[#6672D3] rounded-full"></span>
                    In Progress
                </p>
            @endif


            <div class="mt-4 p-3 flex items-center gap-2 border border-darker-blue rounded-lg text-darker-blue">
                <i class="far fa-calendar fa-lg"></i>

                <p class="text-sm">
                    Duration: 10 Weeks
                </p>
            </div>
        </div>

        {{-- Main Content --}}
        <a href="/profile/{{ Auth::guard('student')->user()->id }}/allProjects" class="text-darker-blue text-sm hover:underline">
            < Go Back
        </a>

        {{-- Project Name --}}
        <h1 class="mt-6 font-medium text-darker-blue text-2xl">
            {{ $project->name }}
        </h1>

        {{-- Domain --}}
        <div class="mt-2 min-w-[174px] w-max px-3 py-1 bg-[#E9E9E9] border border-grey rounded-full flex justify-center text-grey">
            @if ($project->project_domain == 'statistical')
                Machine Learning
            @elseif($project->project_domain == 'computer_vision')
                Computer Vision
            @else
                NLP
            @endif
        </div>

        {{-- Details --}}
        <h1 class="w-[545px] mt-10 font-medium text-darker-blue text-[1.4rem]">
            Project Details
        </h1>

        <div class="w-[545px] mt-4 text-sm text-justify problem">
            {!! $project->problem !!}
        </div>

        {{-- Overview --}}
        @if ($project->overview)
            <h1 class="mt-4 font-medium text-darker-blue text-[1.4rem]">
                Overview
            </h1>

            <div class="w-[545px] mt-4 flex flex-col gap-4 text-sm text-justify">
                <p>
                    {{ $project->overview }}
                </p>
            </div>
        @endif

        {{-- Datasets --}}
        @if ($project->dataset)
            <h1 class="mt-10 font-medium text-darker-blue text-[1.4rem]">
                Datasets
            </h1>

            <div class="mt-4 flex flex-wrap gap-5">
                @foreach ($datasets_array as $dataset)
                    <a href="{{ $dataset }}" class="w-[172px] h-[37px] px-3 py-1 bg-primary rounded-lg flex justify-between items-center font-medium text-white">
                        <span>URL {{ $loop->iteration }}</span>
                        <span>></span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Tasks --}}
        <h1 class="mt-16 font-medium text-darker-blue text-[1.4rem]">
            Tasks
        </h1>

        <div class="mt-4 flex flex-col gap-2">
            @foreach ($submission_data->sortByDesc('taskNumber') as $data)
            @if(\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($data->release_date)))
            <a href="{{ route('student.taskDetail', [Auth::guard('student')->user()->id,$project->id, $data->section_id]) }}" class="w-full py-4 pl-7 pr-[1.4rem] @if($data->is_complete == 1) bg-white @else bg-[#F8F8F8] @endif border border-darker-blue rounded-lg grid grid-cols-12 items-center gap-1 cursor-pointer re-ordering-position-{{ $data->taskNumber }}">
                <p class="col-span-6 font-medium text-darker-blue text-sm">
                    Task {{ $data->taskNumber }} :
                    {{ substr($data->projectSection->title, 0, 30) }}...
                </p>

                <p class="col-span-3 font-medium text-light-black text-xs">
                    {{ \Carbon\Carbon::parse($data->release_date)->format('dS') }} - {{ \Carbon\Carbon::parse($data->dueDate)->format('dS F Y') }}
                </p>

                @if ($data->is_complete == 1)
                    @if($submi_data->grade)
                        @if ($submi_data->grade->status == 1)
                            <p class="col-span-2 flex gap-2 items-center font-medium text-[#11BF61] text-xs">
                                <span class="w-[10px] h-[10px] bg-[#11BF61] rounded-full"></span>
                                Completed
                            </p>
                        @else
                            <p class="col-span-2 flex gap-2 items-center font-medium text-[#EA0202] text-xs">
                                <span class="w-[10px] h-[10px] bg-[#EA0202] rounded-full"></span>
                                Revise
                            </p>
                        @endif
                    @else
                        <p class="col-span-2 flex gap-2 items-center font-medium text-[#DEAA51] text-xs">
                            <span class="w-[10px] h-[10px] bg-[#DEAA51] rounded-full"></span>
                            In Review
                        </p>
                    @endif
                @else
                    <p class="col-span-2"></p>
                @endif

                <div class="col-span-1 text-[#000F8A] justify-self-end">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
            @endforeach
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
