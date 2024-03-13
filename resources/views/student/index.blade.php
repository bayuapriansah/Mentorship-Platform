@extends('layouts.profile.index')
@section('content')
    <div class="max-w-[1366px] mx-auto px-16 pt-16 bg-white grid grid-cols-12 gap-8 grid-flow-col items-center">
        <div class="col-span-8">
            <div class="grid grid-cols-12 gap-4 grid-flow-col">
                <div class="col-span-3">
                    <h2 class="text-dark-blue text-2xl font-medium"></h2>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4 grid-flow-col">
                <div class="col-span-12">
                    <div class="flex items-center gap-8 border-b border-gray-200">
                        <h1 class="w-max py-2 border-b-2 border-darker-blue text-darker-blue text-2xl font-medium">
                            <a href="{{ route('student.allProjects', ['student' => auth()->user()->id]) }}">
                                My Project
                            </a>
                        </h1>

                        @if (isSkillsTrack() && !DB::table('enrolled_projects')->where('student_id', auth()->user()->id)->where('mentorshipType', 'skill')->exists())
                            <h1 class="w-max py-2 text-grey text-xl">
                                <a href="{{ route('student.allProjectsAvailable', ['student' => auth()->user()->id]) }}?is_skills_track">
                                    Available Projects
                                </a>
                            </h1>
                        @endif
                    </div>

                    <div class="mt-12 min-h-[500px]">
                        @php
                            if(isSkillsTrack()){
                                $projectType = $enrolled_projects;
                            }else{
                                $projectType = $enrolled_projects_entrepreneur;
                            }
                        @endphp

                        @forelse($projectType as $enrolled_project)
                            @if ($enrolled_project->project)
                                <div class="border mb-5 hover:border-darker-blue hover:border border-light-blue py-5 px-5 rounded-xl bg-white">
                                    <div class="flex space-x-2">
                                        <div class=" my-auto border border-light-blue rounded-xl py-4 px-2 mr-2 relative">
                                            @if ($enrolled_project->is_submited == 0)
                                                <div
                                                    class="intelOne text-white text-sm font-normal bg-light-brown px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
                                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                                    <span class="ml-2">Ongoing</span>
                                                </div>
                                            @elseif($enrolled_project->is_submited == 1)
                                                <div
                                                    class="intelOne text-white text-sm font-normal bg-light-green px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span class="ml-2">Completed</span>
                                                </div>
                                            @endif
                                            <img
                                                src="{{ $enrolled_project->project->company->logo ? asset('storage/' . $enrolled_project->project->company->logo) : asset('/assets/img/project-logo-placeholder.png') }}"
                                                onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
                                                alt="Logo"
                                                class="w-16 h-9 object-scale-down mx-auto"
                                            >
                                        </div>
                                        <div class="flex-col">
                                            <p class="text-darker-blue font-bold text-sm">
                                                {{ $enrolled_project->project->name }}
                                            </p>

                                            <div class="min-w-[112px] mt-2 px-2 py-1 bg-lightest-blue rounded-full text-center text-xs font-medium">
                                                @switch($enrolled_project->project->project_domain)
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
                                        {{ substr($enrolled_project->project->overview, 0, 250) }}...
                                    </div>
                                    <div class="flex justify-between mt-0">
                                        <p class="intelOne text-black text-sm font-normal my-auto">
                                            Duration:
                                            <span class="font-bold">
                                                {{-- {{ $enrolled_project->project->period }} Month(s) --}}
                                                10 Weeks
                                            </span>
                                        </p>

                                        <div class="flex items-center gap-4">
                                            @if (!isSkillsTrack())
                                                <a
                                                    href="{{ route('participant.projects.create') }}"
                                                    class="text-primary text-sm font-normal bg-white border border-primary px-12 py-2 rounded-full"
                                                >
                                                    Edit Project
                                                </a>
                                            @endif

                                            <a
                                                href="/profile/{{ Auth::guard('student')->user()->id }}/enrolled/{{ $enrolled_project->project->id }}/detail"
                                                class="intelOne text-white text-sm font-normal bg-primary px-12 py-2 rounded-full"
                                            >
                                                View Project
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            @if (isSkillsTrack())
                                <p class="w-[548px] mx-auto text-center text-darker-blue text-2xl">
                                    Get started with Intel Mentorhip program.<br>
                                    You need to enroll in 1 <span class="font-medium">projects</span> for your internship.
                                </p>
                            @else
                                @if($existingProject)
                                    <div class="border mb-5 hover:border-darker-blue hover:border border-light-blue py-5 px-5 rounded-xl bg-white">
                                        <div class="flex space-x-2">
                                            <div class=" my-auto border border-light-blue rounded-xl py-4 px-2 mr-2 relative">
                                                    <div
                                                        class="intelOne text-white text-sm font-normal bg-light-brown px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
                                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                                        <span class="ml-2">Ongoing</span>
                                                    </div>
                                                    {{-- @if ($enrolled_project->is_submited == 0)
                                                        <div
                                                            class="intelOne text-white text-sm font-normal bg-light-brown px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
                                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                                            <span class="ml-2">Ongoing</span>
                                                        </div>
                                                    @elseif($enrolled_project->is_submited == 1)
                                                        <div
                                                            class="intelOne text-white text-sm font-normal bg-light-green px-6 rounded-full absolute -top-8 left-0 flex items-center justify-between">
                                                            <i class="fa-solid fa-check"></i>
                                                            <span class="ml-2">Completed</span>
                                                        </div>
                                                    @endif --}}
                                                <img
                                                    src="{{ asset('/assets/img/project-logo-placeholder.png') }}"
                                                    onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
                                                    alt="Logo"
                                                    class="w-16 h-9 object-scale-down mx-auto"
                                                >
                                            </div>
                                            <div class="flex-col">
                                                <p class="text-darker-blue font-bold text-sm">
                                                    {{ $existingProject->name }}
                                                </p>

                                                <div class="min-w-[112px] mt-2 px-2 py-1 bg-lightest-blue rounded-full text-center text-xs font-medium">
                                                    @switch($existingProject->project_domain)
                                                        @case('statistical')
                                                            Machine Learning (ML)
                                                            @break
                                                        @case('computer_vision')
                                                            Computer Vision (CV)
                                                            @break
                                                        @default
                                                            Natural Language Processing (NLP)
                                                    @endswitch
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-grey font-normal text-xs py-2 m-0">
                                            {{ substr($existingProject->overview, 0, 250) }}...
                                        </div>
                                        <div class="flex justify-between mt-0">
                                            <p class="intelOne text-black text-sm font-normal my-auto">
                                                Duration:
                                                <span class="font-bold">
                                                    {{-- {{ $enrolled_project->project->period }} Month(s) --}}
                                                    10 Weeks
                                                </span>
                                            </p>

                                            <div class="flex items-center gap-4">
                                                @if (!isSkillsTrack())
                                                    <a
                                                        href="{{ route('participant.projects.create') }}"
                                                        class="text-primary text-sm font-normal bg-white border border-primary px-12 py-2 rounded-full"
                                                    >
                                                        Edit Project
                                                    </a>
                                                @endif

@if(!DB::table('enrolled_projects')->where('team_name', auth('student')->user()->team_name)->where('mentorshipType', 'enterpreneurship')->exists());
                                                <a
                                                    href="{{ route('participant.projects.task.enroll', ['project' => $existingProject->id]) }}"
                                                    class="intelOne text-white text-sm font-normal bg-primary px-12 py-2 rounded-full"
                                                >
                                                    Enroll Project
                                                </a>
@else
                                                <a
                                                href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$existingProject->id}}/detail"
                                                class="intelOne text-white text-sm font-normal bg-primary px-12 py-2 rounded-full"
                                                >
                                                    View Project
                                                </a>
@endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="min-h-[154px] p-3 relative bg-white border border-grey rounded-xl">
                                        <div class="absolute inset-0 bg-white rounded-xl opacity-50"></div>

                                        <a href="{{ route('participant.projects.create') }}" class="absolute inset-0 flex justify-center items-center">
                                            <i class="fas fa-plus fa-10x text-primary"></i>
                                        </a>

                                        <div class="flex gap-2 items-end">
                                            <div class="h-16 w-16 border border-grey rounded-lg bg-gradient-to-r from-gray-400 to-gray-100"></div>

                                            <div class="flex flex-col gap-2 w-full">
                                                <div class="h-5 w-1/5 bg-gradient-to-r from-gray-400 to-white"></div>
                                                <div class="h-5 w-1/5 bg-gradient-to-r from-gray-400 to-white"></div>
                                            </div>
                                        </div>

                                        <div class="mt-2 h-6 w-1/2 bg-gradient-to-r from-gray-400 to-white"></div>
                                        <div class="mt-1 h-6 w-1/2 bg-gradient-to-r from-gray-400 to-white"></div>

                                        <div class="w-max ml-auto text-white text-sm font-normal bg-primary px-8 py-1 rounded-full">
                                            View Project
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
