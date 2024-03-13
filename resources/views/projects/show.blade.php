@extends('layouts.index')

@section('content')
{{-- Header --}}
<div class="bg-black bg-center bg-cover bg-no-repeat" style="background-image: url({{ asset('/assets/img/main/header-bg.png') }})">
    <div class="relative max-w-[1366px] mx-auto px-[4.5rem] py-8">
        <h1 class="font-bold text-white text-3xl">
            {{ $project->name }}
        </h1>

        <div class="w-max mt-4 px-10 py-2 bg-primary rounded-full text-sm text-white">
            {{ $project->getProjectDomainText() }}
        </div>

        <img
            src="{{ optional($project->company)->logo ? asset('storage/'.optional($project->company)->logo) : asset('/assets/img/project-logo-placeholder.png') }}"
            onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
            alt="Logo"
            class="absolute -bottom-4 right-16 w-20 h-20 object-cover bg-white border border-grey rounded-xl text-black text-center"
        >
    </div>
</div>
{{-- ./Header --}}

{{-- Main Content --}}
<div class="max-w-[1366px] min-h-[50vh] mx-auto px-16 pt-5 pb-10">
    <h1 class="text-[1.375rem] text-dark-blue font-medium">
        Project Details
    </h1>

    <div class="mt-4 flex justify-between items-center gap-6">
        <div class="w-max border border-light-blue rounded-[10px] bg-white p-2 flex items-center space-x-2">
            <i class="far fa-calendar"></i>
            <p class="font-normal text-sm text-light-blue">
                Duration:
                <span class="text-darker-blue font-medium">10 Weeks</span>
            </p>
        </div>

        {{-- @if (Auth::guard('student')->check() && !$isEnrolled)
            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="w-[140px] intelOne text-white text-lg bg-primary px-2 py-1 rounded-full">
                Enroll
            </button>

            <div id="popup-modal" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                <div class="relative w-3/6 h-full max-w-4xl md:h-auto border border-grey rounded-2xl">
                    <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden">
                        <form method="POST" action="{{ $project->id }}/apply" class="px-10 pt-7 pb-11">
                            @csrf

                            <img src="{{ asset('/assets/img/dots-1.png') }}" class="absolute z-[1] -bottom-3 left-6 w-[233px] h-[108px]" alt="Decoration">

                            <p class="text-darker-blue text-[1.4rem] font-medium">
                                Are you sure you want to enroll in the project - {{ $project->name }} offered by {{ optional($project->company)->name; }}?
                            </p>

                            <div class="mt-5 relative z-[2] flex justify-center items-center gap-5">
                                <button data-modal-hide="popup-modal" type="submit" class="w-[179px] intelOne text-white text-xl bg-primary px-2 py-1 rounded-full">
                                    Yes, Enroll me
                                </button>
                                <button data-modal-hide="popup-modal" type="button" class="w-[179px] intelOne bg-white border border-primary text-primary text-xl px-2 py-1 rounded-full">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif --}}
    </div>


    <article class="problem w-full mt-8">
        {!! $project->problem !!}
    </article>
</div>
{{-- ./Main Content --}}
@endsection
