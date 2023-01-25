@extends('layouts.index')
@section('content')
<div class="w-full bg-darker-blue">
  <div class="max-w-[1366px] mx-auto px-16 pt-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col ">
    <div class="flex flex-col col-span-6 my-auto">
      <h2 class="intelOne text-white font-bold text-4xl leading-11">Join <span class="text-light-brown">Simulated Internship</span> Program And Get Yourself <span class="text-light-brown">Industry Ready!</span></h2>
      <span class="intelOne text-white py-6 font-thin text-lg leading-6">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</span>
      <div class="flex">
        <button class="intelOne text-dark-blue text-sm font-normal bg-white hover:bg-neutral-300 px-16 py-3.5 rounded-full">Get Started</button>
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
      <p class="font-normal inteOne text-base text-black m-0">More than <span class="text-dark-blue">10,000+</span> Simulated Internships provided by our partners</p>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-36 mb-0 flex justify-between items-center ">
    <img src="{{asset('assets/img/imagesl.png')}}" alt="">
    <img src="{{asset('assets/img/image 4.png')}}" alt="">
    <img src="{{asset('assets/img/image 5.png')}}" alt="">
    <img src="{{asset('assets/img/image 6.png')}}" alt="">
    <img src="{{asset('assets/img/image 7.png')}}" alt="">
  </div>
  <div class="max-w-[1366px] mx-auto px-36 pt-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-6 flex my-auto">
      <h2 class="intelOne text-dark-blue font-bold text-4xl">AI for <br>Future Workforce</h2>
    </div>
    <div class="col-end-13 col-span-6">
      <p class="m-0 text-black">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
      <br>
      <p class="m-0 text-black">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus ea temporibus similique neque quam sapiente facilis molestiae nesciunt officia, alias inventore deleniti modi perspiciatis voluptatum repudiandae quibusdam illo dolore eligendi.</p>
      <br>
      <img src="{{asset('assets/img/intelss.png')}}" class="relative z-20" alt="">
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-36 pt-20 mb-0 grid grid-cols-12 gap-11 grid-flow-col  relative">
    <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 -top-32 right-0" aria-hidden="true" >
    <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-10 left-0 " aria-hidden="true" >
    <div class="col-span-4">
      <div class="flex flex-col">
        <img src="{{asset('assets/img/for_students.png')}}" class="relative z-20" alt="for students">
        <h1 class="text-dark-blue text-2xl font-bold py-3">For Students</h1>
        <p class="text-black font-normal text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laudantium, debitis fugit fuga harum commodi nihil ea veniam dolore ipsam ex?</p>
      </div>
    </div>
    <div class="col-span-4">
      <div class="flex flex-col">
        <img src="{{asset('assets/img/for_institution.png')}}" class="relative z-20 mt-5" alt="for students">
        <h1 class="text-dark-blue text-2xl font-bold py-3">For Institutes</h1>
        <p class="text-black font-normal text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laudantium, debitis fugit fuga harum commodi nihil ea veniam dolore ipsam ex?</p>
      </div>
    </div>
    <div class="col-span-4">
      <div class="flex flex-col">
        <img src="{{asset('assets/img/for_industries.png')}}" class="relative z-20" alt="for students">
        <h1 class="text-dark-blue text-2xl font-bold py-3">For Industries</h1>
        <p class="text-black font-normal text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laudantium, debitis fugit fuga harum commodi nihil ea veniam dolore ipsam ex?</p>
      </div>
    </div>
  </div>
  <div class="container mx-auto">
    <div class="max-w-[1366px] mx-auto px-36 pt-28 mb-0 flex ">
      <div class="">
        <h2 class="intelOne text-dark-blue font-bold text-3xl">Active Internships Program</h2>
      </div>
      {{-- untuk arrow --}}
    </div>
    {{-- CARD CAROUSEL --}}
    <div class="relative overflow-x-auto swipe-x">
      <div class="relative flex">
          @foreach ($projects as $project)
              <div class="max-w-sm rounded-lg m-4 transition">
                  <div
                      class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-[#A4AADC]  bg-white">
                      <div class="flex space-x-2">
                          <div class=" my-auto border-2 border-[#A4AADC] rounded-xl py-4 px-2 mr-2">
                              <img src="{{ asset('storage/' . $project->company->logo) }}"
                                  class="w-16 h-9 object-scale-down mx-auto " alt="">
                          </div>
                          <div class="flex-col">
                              <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0">
                                  {{ substr($project->name, 0, 17) }}...</p>
                              <p class="text-black font-normal text-sm m-0">{{ $project->company->name }}</p>
                              <p
                                  class="text-dark-blue font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36">
                                  {{ $project->project_domain }}</p>
                          </div>
                      </div>
                      <div class="text-grey font-normal text-base mb-2 pt-3">
                          {!! substr($project->problem, 0, 62) !!}...
                      </div>
                      <div class="flex justify-between">
                          <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-medium">2
                                  Months</span></p>
                          <a href="/projects/{{ $project->id }}"
                              class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full">View
                              Internship</a>
                      </div>
                  </div>
              </div>
          @endforeach
  
      </div>
      <div class="absolute top-0 right-0">
          <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-l"
              onclick="slideLeft()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                  <path class="heroicon-ui"
                      d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z" />
              </svg>
          </button>
          <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-r"
              onclick="slideRight()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                  <path class="heroicon-ui"
                      d="M18.59 13H3a1 1 0 0 1 0-2h15.59l-5.3-5.3a1 1 0 1 1 1.42-1.4l7 7a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.42-1.4l5.3-5.3z" />
              </svg>
          </button>
      </div>
  </div>  
    {{-- END CARD CAROUSEL --}}
    <div class="max-w-[1366px] mx-auto px-36 pt-12 mb-0 grid grid-cols-12 gap-3 grid-flow-col">
      <div class="col-end-13 col-span-2">
        <button class="intelOnetext-sm font-normal border-2 border-solid border-dark-blue text-darker-blue hover:bg-dark-blue hover:text-white px-3 py-2 rounded-full">View Internship</button>
      </div>
    </div>
  </div>
  <div class="w-full bg-lightest-blue">
    <div class="max-w-[1366px] mx-auto px-16 mt-12 pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container">
      <div class="col-span-3 my-auto">
        <img src="{{asset('assets/img/Ellipse2.png')}}" class="absolute z-10 w-[482px] -translate-x-1/3 -translate-y-1/4 " alt="">
        <p class="intelOne text-3xl rounded-full font-bold text-white relative z-20 m-0">What <br> Students Love</p>
      </div>
      <div class="col-start-5 gap-7 col-span-8 flex">
        <div class="relative max-w-md mx-auto flex flex-col py-6 px-8 bg-white rounded-lg shadow-lg">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRreh9Fwfj6mP6s9CINDCpfUXmi6OrRXJoD8fFI7BV01mzbbC1FhW5MLGQZYgH9PJ8UhC0&usqp=CAU"
            alt=""
            class="absolute rounded-full w-[75px] h-[75px] right-8 -translate-x-1/4 -top-6"
            />
          <p class="text-grey font-normal text-sm pt-12 m-0">
            “On the Windows talking painted pasture yet its express parties
            use. Sure last upon he same as knew next. Of believed or
            diverted no.”
          </p>
          <p class="mt-6 mb-2 text-right text-dark-blue font-medium text-sm intelOne m-0" >Mike taylor</p>
        </div>
        <div class="relative max-w-md mx-auto flex flex-col py-6 px-8 bg-white rounded-lg shadow-lg">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRreh9Fwfj6mP6s9CINDCpfUXmi6OrRXJoD8fFI7BV01mzbbC1FhW5MLGQZYgH9PJ8UhC0&usqp=CAU"
            alt=""
            class="absolute rounded-full w-[75px] h-[75px] right-8 -translate-x-1/4 -top-6"
            />
          <p class="text-grey intelOne font-normal pt-12 m-0">
            “On the Windows talking painted pasture yet its express parties
            use. Sure last upon he same as knew next. Of believed or
            diverted no.”
          </p>
          <p class="mt-10 mb-2 text-right text-dark-blue font-medium text-sm intelOne m-0">Mike taylor</p>
        </div>
        
      </div>
    </div>
  </div>
  <div class="w-full bg-white relative z-20">
    <div class="max-w-[1366px] mx-auto px-16  pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container relative">
      <div class="absolute z-10 w-20 h-20 bg-light-brown top-72 left-10 rounded-[10px]"></div>
      <div class="col-span-5">
        <img src="{{asset('assets/img/learningneverstops.png')}}" class=" relative z-30" alt="learning never stops">
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