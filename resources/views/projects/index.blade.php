@extends('layouts.index')
@section('content')
{{-- <div class="container">
  <div class="p-5 mb-4 text-center">
    @include('flash-message')
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <h1 class="mb-4">Available Projects</h1>
  
  <div class="row">
    <div class="col-9">
      @foreach($projects as $project)
      <div class="row mb-4">
        <div class="col">
          <div class="card bg-light p-4 text-decoration-none text-dark border-left-primary">
            <div class="row">
              <div class="col-10">
                <h3>{{$project->name}}</h3>
              </div>
              <div class="col-2">
                <a class="btn btn-primary" href="/projects/{{$project->id}}" role="button">Details</a>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>{{$project->company->name}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>created at {{$project->created_at->toDateString()}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>{{$project->project_domain}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>
    <div class="col">
      @include('projects.sidebar')
    </div>
  </div> --}}
  
  {{-- <div class="card mt-5 text-center bg-light">
    
  </div> --}}

  {{-- <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Twitter-logo.svg" alt="" width="30px" height="30px">
    <p>Checkout Sponsoring Company</p>
  </div>
  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <p>Download the dataset here</p>
  </div>

  

  <h2 class="mt-5">Get help for your project</h2>
  <a href="#" class="link-primary">Link to discussion forum</a><br>
  <a href="#" class="link-primary">Link to support document library</a>
</div> --}}
<section id="login" class="w-full">
  <div class="max-w-[1366px] mx-auto px-16 pt-0 grid grid-cols-12 gap-11 grid-flow-col bg-lightest-blue">
    <div class="col-span-6 my-auto">
      <h1 class="intelOne text-dark-blue font-bold text-4xl leading-11">Search Internships</h1>
      <p class="intelOne font-light text-black text-lg leading-6 py-6">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
      <form action="" method="post">
        @csrf
        <div class="flex justify-between">
        <div class="relative flex-grow">
          <input type="text" id="email-address-icon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search an internship program" name="search">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <button class="py-2.5 px-11 rounded-full border-2 bg-darker-blue border-solid hover:bg-dark-blue text-center capitalize bg-orange text-white font-light text-sm intelOne ml-5" type="submit">Search</button>

        </div>
        {{-- <div class="mt-4">
          @include('flash-message')
        </div> --}}
        <div class="flex">
        </div>
      </form>
    </div>
    <div class="col-start-7 col-span-6 relative">
      <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
      <img src="{{asset('assets/img/home1_test.png')}}" class="relative z-20" alt="">

      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
      <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
      <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->
      
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-36 pt-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-3">
      <h3 class="intelOne text-dark-blue text-2xl font-semibold">Program Filters</h3>
    </div>
    <div class="col-start-5 col-span-8 space-y-4">
      <h3 class="intelOne text-dark-blue text-2xl font-semibold">Internships Programs</h3>
    </div>
  </div>

  <div class="max-w-[1366px] mx-auto px-36 py-8 mb-0 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-3">
      <div class="border-2 border-blue-400 py-5 px-2">

      </div>
    </div>
    <div class="col-start-5 col-span-8 space-y-4 ">
      @forelse($projects as $project)

      <div class="border-[1px] hover:border-darker-blue hover:border-2 border-[#A4AADC] py-5 px-5 rounded-xl">
        <div class="flex space-x-2">
          <div class=" my-auto border-[1px] border-[#A4AADC] rounded-xl py-4 px-2 mr-2">
            <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9  mx-auto " alt="">
          </div>
          <div class="flex-col">
            <p class="intelOne text-dark-blue font-bold text-xl leading-7">{{$project->name}}</p>
            <p class="text-black font-normal text-sm">{{$project->company->name}}</p>
            <p class="text-black font-normal text-sm bg-lightest-blue text-center rounded-full px-8">{{$project->project_domain}}</p>
          </div>
        </div>
        <p class="intelOne text-grey font-normal text-sm py-2">{!! substr($project->problem,0,200) !!}...</p>
        <div class="flex justify-between mt-4">
          <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-bold">2 Months</span></p>
          <a href="/projects/{{$project->id}}" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">Internship Details</a>
          </div>
      </div>
          
      @empty
          
      @endforelse
    </div>
  </div>
</section>
@endsection