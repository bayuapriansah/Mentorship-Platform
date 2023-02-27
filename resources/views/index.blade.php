@extends('layouts.index')
@section('content')
<div class="w-full bg-darker-blue">
  <div class="max-w-[1366px] mx-auto px-16 pt-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col ">
    <div class="flex flex-col col-span-6 my-auto">
      <h2 class="intelOne text-white font-bold text-3xl leading-11">
        <span class="text-light-brown">Simulated Internship</span> Platform for <span class="text-light-brown">Industry Readiness</span>
      </h2>
      <span class="intelOne text-white py-6 font-light text-lg leading-6">Join today to work on real-world projects and kick start your career!</span>
      <div class="flex">
        <a href="/otp/login" class="intelOne text-dark-blue text-sm font-normal bg-white hover:bg-neutral-300 px-16 py-3.5 rounded-full">Get Started</a>
      </div>
    </div>
    <div class="col-start-7 col-span-6 relative">
      <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
      <img src="assets/img/home1.png" class="relative z-50" alt="">

      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
      <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
      <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->
      
    </div>
  </div>
</div>
<div class="w-full">
  <div class="max-w-[1366px] mx-auto px-16 pt-16 pb-7 mb-0 grid grid-cols-12 gap-11 grid-flow-col ">
    <div class="col-span-12 text-center">
      <p class="font-normal inteOne text-base text-black m-0">Our Esteemed Industry Partners</p>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-36 mb-0 flex justify-between items-center ">
    <img src="{{asset('assets/img/image 3.png')}}" alt="">
    <img src="{{asset('assets/img/image 4.png')}}" alt="">
    <img src="{{asset('assets/img/image 5.png')}}" alt="">
    <img src="{{asset('assets/img/image 6.png')}}" alt="">
    <img src="{{asset('assets/img/image 7.png')}}" alt="">
  </div>
  <div class="max-w-[1366px] mx-auto px-36 pt-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col" id="AiForFuture">
    <div class="col-span-6 flex my-auto">
      <h2 class="intelOne text-dark-blue font-bold text-4xl">AI for <br>Future Workforce</h2>
    </div>
    <div class="col-end-13 col-span-6">
      <p class="m-0 text-black text-justify">Intel® AI For Workforce is a global AI skilling program for vocational students for building an AI-ready workforce. The program aims to address the AI skill crisis to cater to growing job demands related to AI/ML by empowering the future workforce with the necessary skills for employability in the digital economy. The program offers comprehensive, modular, experiential, and flexible AI content delivered through engaging learning experiences.</p>
      <br>
      <iframe width="525" height="300" class="relative z-20 rounded-lg" src="https://www.youtube.com/embed/K9iflwQqVsA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-36 pt-20 mb-0 grid grid-cols-12 gap-11 grid-flow-col  relative">
    <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 -top-32 right-0" aria-hidden="true" >
    <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-10 left-0 " aria-hidden="true" >
    <div class="col-span-4">
      <div class="flex flex-col">
        <img src="{{asset('assets/img/for_students.png')}}" class="relative z-20" alt="for students">
        <h1 class="text-dark-blue text-2xl font-bold py-3">For Students</h1>
        <p class="text-black font-normal text-sm">Acquire Employability Skills, Gain Industry Experience, Strengthen Project Portfolio</p>
      </div>
    </div>
    <div class="col-span-4">
      <div class="flex flex-col">
        <img src="{{asset('assets/img/for_institution.png')}}" class="relative z-20 mt-5" alt="for students">
        <h1 class="text-dark-blue text-2xl font-bold py-3 -mt-4">For Institutes</h1>
        <p class="text-black font-normal text-sm">Enhanced Student Employability, Collaborate with Industry leaders, Supervise Real-World AI Projects</p>
      </div>
    </div>
    <div class="col-span-4">
      <div class="flex flex-col">
        <img src="{{asset('assets/img/for_industries.png')}}" class="relative z-20" alt="for students">
        <h1 class="text-dark-blue text-2xl font-bold py-3">For Industries</h1>
        <p class="text-black font-normal text-sm">Identify Top Future Talents, Collaborate with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
      </div>
    </div>
  </div>
  <div class="container mx-auto">
    <div class="max-w-[1366px] mx-auto px-36 pt-28 mb-0 flex ">
      <div class="">
        <h2 class="intelOne text-dark-blue font-bold text-3xl">Internship Projects</h2>
      </div>
      {{-- untuk arrow --}}
    </div>
    <div class="max-w-[1366px] mx-auto px-36 pt-8 mb-0 grid grid-cols-13 gap-8 grid-flow-col">
      @foreach($projects as $project)
      <div class="col-span-4">
        <div class="flex flex-grow">
          <div class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-[#A4AADC]  bg-white max-w-sm">
            <div class="flex space-x-2">
              <div class=" my-auto border-2 border-[#A4AADC] rounded-xl py-4 px-2 mr-2">
                <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
              </div>
              <div class="flex-col">
                <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0">{{substr($project->name,0,17)}}...</p>
                <p class="text-black font-normal text-sm m-0">{{$project->company->name}}</p>
                <p class="text-dark-blue font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36">{{$project->project_domain}}</p>
              </div>
            </div>
            <div class="text-grey font-normal text-base mb-2 pt-3">
              {{ substr($project->overview,0,62) }}...
            </div>
            <div class="flex justify-between">
            <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-medium">{{ $project->period }} Months</span></p>
            <a href="
            @if (Auth::guard('student')->check() || Auth::guard('web')->check())
                /projects/{{$project->id}}
            @else
              /otp/login
            @endif
            " class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">View Project</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="max-w-[1366px] mx-auto px-36 pt-12 mb-0 grid grid-cols-12 gap-3 grid-flow-col">
      <div class="col-end-13 col-span-2">
        <button  class="intelOnetext-sm font-normal border-2 border-solid border-dark-blue text-darker-blue hover:bg-dark-blue hover:text-white px-3 py-2 rounded-full">
          <a href="/projects">View All Projects</a>
        </button>
      </div>
    </div>
  </div>
  <div class="w-full bg-white relative z-20">
    <div class="max-w-[1366px] mx-auto px-16  pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container relative">
      <div class="absolute z-10 w-20 h-20 bg-light-brown top-72 left-10 rounded-[10px]"></div>
      <div class="col-span-5">
        <iframe width="428" height="236" class="relative z-30 rounded-lg" src="https://www.youtube.com/embed/cUq-sTaxXks" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        {{-- <img src="{{asset('assets/img/learningneverstops.png')}}" class=" relative z-30" alt="learning never stops"> --}}
      </div>
      <div class="col-span-7">
        <h1 class="font-bold text-2xl text-dark-blue">Learning Never Stops</h1>
        <p>When he was 16 years old, Feridoon Ghanbari and his family left Iran to live in the U.S. With time spent in the Army as a combat medic and the Air Force as a guidance and navigation engineer—the military has shaped his life. Afterward, he moved to New Mexico, where he's been living for over four decades. With degrees in Electrical Engineering, Industrial Engineering, and Business, he has a deep background in STEM. He's passionate about Artificial Intelligence and always wants to learn about where the future of tech is headed, in real time for the real world. That's why he's excited about expanding his knowledge in our AI for Workforce classes. The program teaches innovative tech while empowering students with the necessary AI skills for employability in the digital economy.</p>
      </div>
    </div>
  </div>
</div>
@endsection
@section('more-js')
<script>
  var currentCard = 1;
  var cardCount = {{count($projects)}};

  function slideLeft(){
    if(currentCard > 1){
      currentCard--;
      updateCards();
    }
  }

  function slideRight(){
    if(currentCard < cardCount){
      currentCard++;
      updateCards();
    }
  }

  function updateCards(){
    var cards = document.querySelectorAll(".relative.flex > div");
    for(var i=0; i < cards.length; i++){
      if(i === currentCard-1 || i === currentCard || i === currentCard+1){
        cards[i].classList.remove("hidden");
      }else{
        cards[i].classList.add("hidden");
      }
    }
  }
</script>
@endsection