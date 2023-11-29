@extends('layouts.profile.index')
@section('content')
    <div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center">
        <div class="col-span-8">
            <div class="grid grid-cols-12 gap-4 grid-flow-col">
                <div class="col-span-3">
                    <h2 class="text-dark-blue text-2xl font-medium"></h2>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4 grid-flow-col">
                <div class="col-span-12">
                    <div class="border-b border-gray-200">
                        <h1 class="w-max py-2 border-b-2 border-dark-blue text-darker-blue text-2xl font-medium">
                            My Project
                        </h1>
                    </div>

                    <div class="mt-12 min-h-[500px]">
                        @forelse($enrolled_projects as $enrolled_project)
                            @if ($enrolled_project->project)
                                <div
                                    class="border mb-5 hover:border-darker-blue hover:border border-light-blue py-5 px-5 rounded-xl bg-white">
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
                                            {{-- @dd($enrolled_project) --}}
                                            <img src="{{ asset('storage/' . $enrolled_project->project->company->logo) }}"
                                                class="w-16 h-9 object-scale-down  mx-auto " alt="">
                                        </div>
                                        <div class="flex-col">
                                            <p class="text-darker-blue font-bold text-sm">
                                                {{ $enrolled_project->project->name }}
                                            </p>

                                            <div class="min-w-[112px] mt-2 px-2 py-1 bg-lightest-blue rounded-full text-center text-xs font-medium">
                                                @switch($enrolled_project->project->project_domain)
                                                    @case('statistical')
                                                        Statistical Data
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
                                            <a
                                                href="#"
                                                class="intelOne text-white text-sm font-normal bg-primary px-12 py-2 rounded-full"
                                            >
                                                Edit
                                            </a>

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
                            <div class="min-h-[154px] p-3 relative bg-white border border-grey rounded-xl">
                                <div class="absolute inset-0 bg-white rounded-xl opacity-50"></div>

                                <a href="#" class="absolute inset-0 flex justify-center items-center">
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
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
