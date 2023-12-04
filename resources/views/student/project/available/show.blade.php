@extends('layouts.profile.index')
@section('content')

{{-- @foreach($notifNewTasks as $notifNewTask)
    {{ $notifNewTask->read_notification }}
@endforeach --}}
<div class="max-w-[1366px] mx-auto pl-16 pt-4 pb-20 grid grid-cols-12 gap-8 grid-flow-col items-center bg-white">
  <div class="col-span-8 min-h-[600px]">
    <a href="{{ route('student.allProjectsAvailable', ['student' => auth()->user()->id]) }}?is_skills_track" class="text-darker-blue text-sm hover:underline">
        < Go Back
    </a>

    @if ($message = Session::get('error'))
      <div id="toast-danger" class="flex flex-grow items-center w-full p-4 mb-4 text-white rounded-lg bg-[#CE2E2E]" role="alert">
        <div class="ml-3 text-sm font-normal">{{$message}}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-white hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 " data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </div>
      @endif
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-6">
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
      </div>
      <div class="col-span-6 relative">
        <img src="{{ asset('/assets/img/icon/profile/dots.png') }}" class="absolute -top-8 right-0">
        <div class="relative top-[20%] -right-[80%]">
            <div class="w-[30px] h-[30px] absolute z-[3] -top-3 -left-3 bg-[#FF8F51] rounded-lg"></div>

            <img
                src="{{ $project->company->logo ? asset('storage/'.$project->company->logo) : asset('/assets/img/project-logo-placeholder.png') }}"
                onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
                alt="Logo"
                class="w-16 h-16 relative z-[4] object-cover bg-white border border-grey rounded-xl text-black text-center"
            >
        </div>
      </div>
    </div>
    <div class="mt-6 grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-9 relative">
        <h1 class="w-[545px] font-medium text-darker-blue text-[1.4rem]">
            Project Details
        </h1>
      </div>
      <div class="col-span-3 relative">
        @if(Auth::guard('student')->check())
          <form method="POST" action="/projects/{{ $project->id }}/apply" >
            @csrf
            {{-- <button type="submit" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full absolute " onClick="return confirm('Are you sure you want to enrol in the project - Automated Attendance System offered by Google?')">Enroll</button>  --}}
            <br>
            @if($enrolled_projects->isEmpty())
              <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="w-[140px] absolute left-10 intelOne text-white text-lg bg-primary px-2 py-1 rounded-full" type="button">
                Enroll
              </button>
            @endif

            {{-- Popup --}}
            <div id="popup-modal" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                <div class="relative w-3/6 h-full max-w-4xl md:h-auto border border-grey rounded-2xl">
                    <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden">
                        <div class="px-10 pt-7 pb-11">
                            <img src="{{asset('/assets/img/dots-1.png')}}" class="absolute z-[1] -bottom-3 left-6 w-[233px] h-[108px]" alt="Decoration">
                            <p class="text-darker-blue text-[1.4rem] font-medium">
                                Are you sure you want to enroll in the project - {{ $project->name }} offered by {{ $project->company->name }}?
                            </p>

                            <div class="mt-5 relative z-[2] flex justify-center items-center gap-5">
                                <button data-modal-hide="popup-modal" type="submit" class="w-[179px] intelOne text-white text-xl bg-primary px-2 py-1 rounded-full">
                                    Yes, Enroll me
                                </button>
                                <button data-modal-hide="popup-modal" type="button" class="w-[179px] intelOne bg-white border border-primary text-primary text-xl px-2 py-1 rounded-full">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute top-20 left-2 border border-light-blue rounded-[10px] bg-white p-2 flex items-center space-x-2">
              <i class="far fa-calendar"></i>
              <p class="font-normal text-sm text-light-blue">
                Duration:
                <span class="text-darker-blue font-medium">10 Weeks</span>
              </p>
            </div>
          </form>
        @endif
      </div>
    </div>

    {{-- Project Details --}}
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-8 problem text-black text-justify font-normal">
        {!!$project->problem!!}
      </div>
    </div>

    {{-- Project Overview --}}
    @if ($project->overview)
        <div class="mt-4 grid grid-cols-12 gap-4 grid-flow-col">
            <div class="col-span-8">
                <h1 class="font-medium text-darker-blue text-[1.4rem]">
                    Overview
                </h1>
                <div class="problem mt-2 text-black text-justify font-normal">
                    {{ $project->overview }}
                </div>
            </div>
        </div>
    @endif
  </div>
</div>
@endsection
