@extends('layouts.index')
@section('content')
{{-- <div class="container">
  @include('flash-message')
  <div class="row">
    <div class="col">
      <h1>{{$project->name}}</h1>
    </div>
  </div>
  

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Problem : </p>
      <p>{!! $project->problem !!}</p>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">type : </p>
      <p>{{$project->type}}</p>
    </div>
  </div> 
  
  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Period : </p>
      <p>{{$project->period}} Months</p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col">
      <p class="text-bold mb-0">Domain : </p>
      <p>{{$project->project_domain}}</p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col">
      <p class="text-bold mb-0">{{$project->company->name}}</p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col">
      <div class="accordion" id="accordionExample">
        @php $no = 1 @endphp
        @foreach($project_sections as $project_section)
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading{{$no}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$no}}" aria-expanded="true" aria-controls="collapse{{$no}}">
              Section {{$no}}
            </button>
          </h2>
          <div id="collapse{{$no}}" class="accordion-collapse collapse {{$no==1 ? 'show': ''}}" aria-labelledby="heading{{$no}}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              {!!$project_section->description!!}
              @foreach($project_section->sectionSubsections as $subsection)
              <a href="/projects/{{$project->id}}/detail/{{$subsection->id}}" class="text-decoration-none text-dark">
                <div class="card p-4 mb-2">
                  <div class="text-muted">{{$subsection->category}}</div>
                  {{$subsection->title}}
                </div>
              </a>
              @endforeach
            </div>
          </div>
        </div>
      @php $no++ @endphp
      @endforeach

      </div>
    </div>
  </div>
  @if(Auth::guard('student')->check())
  <div class="row mt-2">
    <div class="col">
      <form method="POST" action="{{ $project->id }}/apply" >
        @csrf
        <div class="control">
          <button type="submit" class="btn btn-success">Apply</button>
        </div>
      </form>
    </div>
  </div>
  @endif
</div> --}}
<section id="show" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 py-10 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-9 relative my-auto">
        <h1 class="font-bold text-white text-3xl relative mb-4 z-20">{{$project->name}}</h1>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30">{{$project->project_domain}}</span>
        <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 top-0 ">
      </div>
      <div class="col-start-10 col-span-4 relative ">
        <img src="{{asset('assets/img/dotsdetail_2.png')}}" class="absolute z-10 right-0 -top-3 ">
      </div>
      {{-- <div class="col-start-11 col-span-2 absolute">
        <div class=" my-auto border-[1px] border-light-blue rounded-xl w-30">
          <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9  mx-auto " alt="">
        </div>
      </div> --}}
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
      <form method="POST" action="{{ $project->id }}/apply" class="">
        @csrf
        <button data-modal-target="popup-confirm" data-modal-toggle="popup-confirm" type="button" class="intelOne text-white w-full text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full absolute ">Enroll</button> 
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
                        <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">Are you sure you want to enroll {{$project->name}} project</h3>
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
      <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute right-0 top-16 flex items-center space-x-3">
        <i class="fa-regular fa-calendar"></i>
        <p class="font-normal text-sm text-light-blue">Duration: <span class="text-dark-blue">{{$project->period}} Months</span></p>
      </div>
    </div>
  </div>

  <div class="max-w-[1366px] mx-auto px-16 py-5 grid grid-cols-12 gap-11 grid-flow-col bg-white problem">
    <div class="col-span-9 my-auto">
      {!!$project->problem!!}
    </div>
    <div class="col-end-13 col-span-3 text-right flex flex-col relative mt-5">
      <img src="{{asset('assets/img/certificate.png')}}" alt="" class="relative mt-20 w-[305] h-[236]">
    </div> 
  </div>
  {{--  --}}
  {{-- <div class="max-w-[1366px] mx-auto px-16 pb-16 grid grid-cols-12 gap-11 grid-flow-col bg-white">
    <div class="col-span-7">
      <h1 class="text-xl font-semibold text-dark-blue pb-6">FAQs</h1>
      <div id="accordion-collapse" data-accordion="collapse" class="">
        <h2 id="accordion-collapse-heading-1 ">
          <button type="button" class="flex items-center mb-2 justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200  hover:bg-gray-100 " data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span>What is Flowbite?</span>
            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden pb-2" aria-labelledby="accordion-collapse-heading-1">
          <div class="p-5 font-light border rounded-xl border-gray-200 ">
            <p class="mb-2 text-gray-500 ">Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
            <p class="text-gray-500 ">Check out this guide to learn how to <a href="/docs/getting-started/introduction/" class="text-blue-600 hover:underline">get started</a> and start developing websites even faster with components on top of Tailwind CSS.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-2">
          <button type="button" class="flex items-center mb-2 justify-between w-full p-5 font-medium text-left text-gray-500 border rounded-xl border-gray-200 focus:ring-4 focus:ring-gray-200   hover:bg-gray-100 " data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
            <span>Is there a Figma file available?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden pb-2" aria-labelledby="accordion-collapse-heading-2">
          <div class="p-5 font-light border rounded-xl border-gray-200 ">
            <p class="mb-2 text-gray-500 ">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
            <p class="text-gray-500 ">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600 hover:underline">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-3">
          <button type="button" class="flex items-center mb-2 justify-between w-full p-5 font-medium text-left text-gray-500 border rounded-xl border-gray-200 focus:ring-4 focus:ring-gray-200  hover:bg-gray-100 " data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
            <span>What are the differences between Flowbite and Tailwind UI?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden pb-2" aria-labelledby="accordion-collapse-heading-3">
          <div class="p-5 font-light border rounded-xl border-gray-200 ">
            <p class="mb-2 text-gray-500 ">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
            <p class="mb-2 text-gray-500 ">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
            <p class="mb-2 text-gray-500 ">Learn more about these technologies:</p>
            <ul class="pl-5 text-gray-500 list-disc ">
              <li><a href="https://flowbite.com/pro/" class="text-blue-600 hover:underline">Flowbite Pro</a></li>
              <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 hover:underline">Tailwind UI</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  {{-- @if(Auth::guard('student')->check())
  <div class="max-w-[1366px] mx-auto px-16 pb-16 grid grid-cols-12 gap-11 grid-flow-col bg-white">
    <div class="col-span-7">
      <div id="accordion-collapse" data-accordion="collapse">
        @php $no = 1 @endphp
        @foreach($project_sections as $project_section)
        <h2 id="accordion-collapse-heading-{{$no}}">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border  border-dark-blue rounded-xl mt-5 mb-2 focus:ring-4 bg-white focus:bg-neutral-100  hover:bg-neutral-100 " data-accordion-target="#accordion-collapse-body-{{$no}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$no}}">
            <span class="text-darker-blue font-bold text-xl flex items-center space-x-3">
              <img src="{{asset('assets/img/icon/folder.png')}}" class="mr-2" alt="">
              {{$project->type == 'weekly' ? 'Week': 'Month'}} {{$no}} 
              <span class="text-grey text-base">{{$project_section->sectionSubsections->count()}} tasks</span>
            </span>
            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-{{$no}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$no}}">
          <ul class="ml-4">
            @foreach($project_section->sectionSubsections as $subsection)
            <li class="py-4 px-5 rounded-xl mb-2 border border-xl border-gray-200 font-normal text-sm text-black">
              <div class="flex">
                @if($subsection->category == 'video')
                  <img src="{{asset('assets/img/icon/video.png')}}" alt="">
                @elseif($subsection->category == 'reading')
                  <img src="{{asset('assets/img/icon/pdf.png')}}" alt="">
                @else
                  <i class="fa-regular fa-folder"></i>
                @endif
                <span class="font-normal text-sm ml-4">{{$subsection->category}}</span>
              </div>
            </li>

            @endforeach
          </ul>
        </div>
        @php $no++ @endphp
        @endforeach
      </div>
    </div>
  </div>
  @endif --}}
</section>
@endsection
