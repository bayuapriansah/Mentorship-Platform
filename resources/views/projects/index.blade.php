@extends('layouts.index')
@section('content')
{{-- Hero Banner --}}
<div class="h-[539px] bg-black bg-cover bg-center" style="background-image: url({{ asset('/assets/img/main/background-1.svg') }})">
    <div class="max-w-screen-xl mx-auto pl-8 pr-28 py-12 flex justify-between">
        <div class="w-[442px] my-auto flex flex-col gap-4">
            <h1 class="text-[#FF8F51] text-3xl font-bold">
                View Projects
            </h1>

            <p class="text-white text-lg font-light">
                Take a look at the projects available for the skills track of the mentorship program.
            </p>
        </div>

        <img
            src="{{ asset('/assets/img/main/DBanner.png') }}"
            alt="Illustration"
            class="w-[453px]"
        >
    </div>
</div>

{{-- Project List --}}
<div class="relative overflow-y-clip">
    <div class="max-w-screen-xl mx-auto px-6 py-[4.4rem]">
        <h1 class="text-center text-3xl text-darker-blue font-bold">
            Skills Track
        </h1>

        <div class="mt-8 flex flex-col items-center gap-12">
            @foreach ($projects as $project)
                {{-- Project Card --}}
                <div class="relative z-[2] w-[730px] min-h-[251px] px-7 pt-9 pb-6 bg-white border border-grey rounded-xl">
                    {{-- Name and Logo --}}
                    <div class="flex items-center gap-3">
                        <img
                            src="{{ optional($project->company)->logo ? asset('storage/' . optional($project->company)->logo) : asset('/assets/img/project-logo-placeholder.png') }}"
                            onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
                            alt="Logo"
                            class="w-20 h-20 bg-white border border-grey rounded-xl object-scale-down"
                        >

                        <div class="flex flex-col gap-2">
                            <h6 class="text-lg text-darker-blue font-bold">
                                {{ $project->name }}
                            </h6>

                            <div class="min-w-[136px] py-1 px-2 bg-[#E4E7FF] rounded-full flex justify-center items-center text-xs text-[#010101]">
                                @if ($project->project_domain === 'statistical')
                                    Machine Learning
                                @elseif ($project->project_domain === 'computer_vision')
                                    Computer Vision
                                @else
                                    NLP
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Overview --}}
                    <p class="mt-3 text-sm text-justify">
                        {{ $project->overview }}
                    </p>

                    {{-- Duration and CTA --}}
                    <div class="mt-3 flex justify-between items-center">
                        <p class="text-sm">
                            Duration
                            <span class="font-medium">10 Weeks</span>
                        </p>

                        <a href="{{ route('projects.show', ['project' => $project->id]) }}" class="w-[140.63px] h-[38.03px] flex justify-center items-center bg-primary rounded-full text-sm text-white">
                            View Project
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Wave Effect --}}
    <div
        class="absolute -bottom-[15%] left-1/2 -translate-x-1/2 w-[1558px] h-[645.315px] bg-center bg-cover bg-no-repeat"
        style="background-image: url({{ asset('/assets/img/purple-wave.svg') }})"
    ></div>
</div>
@endsection
