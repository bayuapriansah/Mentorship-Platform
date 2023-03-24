@extends('layouts.index')
@section('content')
<section id="show" class="w-full min-h-screen">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 py-10 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-9 relative my-auto">
        <h1 class="font-bold text-white text-3xl relative mb-4 z-20">{{$project->name}}</h1>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30">
          @if ($project->project_domain == 'statistical')
            Statistical Data
          @elseif($project->project_domain == 'computer_vision')
            Computer Vision
          @else
            {{$project->project_domain}}
          @endif   
        </span>
        <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 top-0 ">
      </div>
      <div class="col-start-10 col-span-4 relative ">
        <img src="{{asset('assets/img/dotsdetail_2.png')}}" class="absolute z-10 right-0 -top-3 ">
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 pt-5 grid grid-cols-12 gap-11 grid-flow-col bg-white">
    <div class="col-span-7 relative my-auto">
      <h1 class="text-dark-blue text-[22px] font-medium">Project Details</h1>
    </div>
    <div class="col-start-11 col-span-2 relative flex flex-col space-y-5">
      <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4 absolute z-30 right-0 -top-20 ">
        <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
      </div>
      @if (Auth::guard('student')->check())
      <form method="POST" action="{{ $project->id }}/apply" class="">
        @csrf
        @if($enrolled_projects->isEmpty())
        <button data-modal-target="popup-confirm" data-modal-toggle="popup-confirm" type="button" class="intelOne text-white w-full text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full absolute ">Enroll</button> 
        @endif

        <div id="popup-confirm" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-3/6 h-full max-w-4xl md:h-auto border-[3px] border-light-blue rounded-2xl">
                <div class="relative bg-white rounded-xl shadow-2xl">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center z-30" data-modal-hide="popup-confirm">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-left space-x-4">
                        <img src="{{asset('assets/img/dots-1.png')}}" class="absolute top-0 right-0 w-[233px] h-[108px]" alt="">
                        {{-- <img src="{{asset('assets/img/dots-1.png')}}" class="absolute bottom-0 left-0 w-[233px] h-[108px]" alt=""> --}}
                        <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">Are you sure you want to enroll in the {{$project->name}} project</h3>
                        <div class="relative z-30">
                          <button data-modal-hide="popup-confirm" type="submit" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full shadow-xl">
                            Yes
                        </button>
                        <button data-modal-hide="popup-modal" type="button" class="intelOne text-dark-blue text-sm font-normal hover:bg-neutral-100 px-12 py-3 rounded-full shadow-xl">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form> 
      @endif
      <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute right-0 top-16 flex items-center space-x-3">
        <i class="fa-regular fa-calendar"></i>
        <p class="font-normal text-sm text-light-blue">Duration: 
          <span class="text-dark-blue">
            @if ($project->period>1)
              {{$project->period}} Months
            @else
              {{$project->period}} Month
            @endif
          </span>
        </p>
      </div>
    </div>
  </div>

  <div class="max-w-[1366px] mx-auto px-16 py-5 grid grid-cols-12 gap-11 grid-flow-col bg-white problem">
    <div class="col-span-9 my-auto">
      {!!$project->problem!!}
    </div>
  </div>
</section>
@endsection
