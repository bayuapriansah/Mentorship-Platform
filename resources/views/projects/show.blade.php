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
      <p>{{$project->period}} Month</p>
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
      <h1 class="text-dark-blue text-[22px]">Project Details</h1>
    </div>
    <div class="col-start-11 col-span-2 relative flex flex-col space-y-5">
      <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4 absolute z-30 right-0 -top-20 ">
        <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9  mx-auto " alt="">
      </div>
      <form method="POST" action="{{ $project->id }}/apply" class="">
        @csrf
        <button type="submit" class="intelOne text-white w-full text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full absolute ">Enroll</button> 
      </form> 
      <div class="border border-light-blue rounded-[10px] bg-white p-2 absolute right-0 top-16 flex items-center space-x-3">
        <i class="fa-regular fa-calendar"></i>
        <p class="font-normal text-sm text-light-blue">Duration: <span class="text-dark-blue">{{$project->period}} Month</span></p>
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
  <div class="max-w-[1366px] mx-auto px-16 pb-16 grid grid-cols-12 gap-11 grid-flow-col bg-white">
    <div class="col-span-7">
      <h1 class="text-xl font-semibold text-dark-blue">FAQs</h1>
      <div id="accordion-collapse" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border  border-dark-blue rounded-xl mt-5 mb-2 focus:ring-4 bg-white focus:bg-neutral-100  hover:bg-neutral-100 " data-accordion-target="#accordion-collapse-body-1" aria-controls="accordion-collapse-body-1">
            <span class="text-darker-blue font-bold text-xl flex items-center space-x-3">
              <span class="text-grey text-base"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, nemo?</span>
            </span>
            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
          <ul class="">
            <li class="py-4 px-5 rounded-xl mb-2 border border-xl border-gray-200 font-normal text-sm text-black">
              <div class="flex">
                <span class="font-normal text-sm ml-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda aperiam dolores quis quibusdam laboriosam sint corrupti nemo et optio praesentium.</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div id="accordion-collapse" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-2">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border  border-dark-blue rounded-xl mt-5 mb-2 focus:ring-4 bg-white focus:bg-neutral-100  hover:bg-neutral-100 " data-accordion-target="#accordion-collapse-body-2" aria-controls="accordion-collapse-body-2">
            <span class="text-darker-blue font-bold text-xl flex items-center space-x-3">
              <span class="text-grey text-base"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, nemo?</span>
            </span>
            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
          <ul class="">
            <li class="py-4 px-5 rounded-xl mb-2 border border-xl border-gray-200 font-normal text-sm text-black">
              <div class="flex">
                <span class="font-normal text-sm ml-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi id, cum neque quis minus vero sunt fuga excepturi inventore sint!</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div id="accordion-collapse" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-3">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border  border-dark-blue rounded-xl mt-5 mb-2 focus:ring-4 bg-white focus:bg-neutral-100  hover:bg-neutral-100 " data-accordion-target="#accordion-collapse-body-3"  aria-controls="accordion-collapse-body-3">
            <span class="text-darker-blue font-bold text-xl flex items-center space-x-3">
              <span class="text-grey text-base"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, nemo?</span>
            </span>
            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
          <ul class="">
            <li class="py-4 px-5 rounded-xl mb-2 border border-xl border-gray-200 font-normal text-sm text-black">
              <div class="flex">
                <span class="font-normal text-sm ml-4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam, iste quos. Molestiae porro deserunt ea repudiandae corrupti atque iure? Ea.</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
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
