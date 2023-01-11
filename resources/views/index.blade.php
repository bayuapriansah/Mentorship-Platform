@extends('layouts.index')
@section('content')
<div class="w-full bg-lightest-blue">
  <div class="max-w-[1366px] mx-auto px-16 pt-24 mb-0 grid grid-cols-12 gap-11 grid-flow-col ">
    <div class="flex flex-col col-span-6 my-auto">
      <h1 class="intelOne text-dark-blue font-bold text-4xl leading-11">Join Simulated Internship Program And Get Yourself Industry Ready!</h1>
      <p class="intelOne text-black py-6 font-thin text-lg leading-6">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
      <div class="flex">
        <button class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-16 py-3.5 rounded-full">Get Started</button>
      </div>
    </div>
    <div class="col-start-7 col-span-6 relative">
      <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
      <img src="assets/img/home1.png" class="relative z-20" alt="">

      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
      <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
      <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->
      
    </div>
  </div>
</div>
<div class="w-full">
  <div class="max-w-[1366px] mx-auto px-16 pt-24 pb-7 mb-0 grid grid-cols-12 gap-11 grid-flow-col ">
    <div class="col-span-12 text-center">
      <p class="font-normal inteOne text-base text-black">More than <span class="text-dark-blue">10,000+</span> Simulated Internships provided by our partners</p>
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
    <div class="col-span-5 flex my-auto">
      <h1 class="intelOne text-dark-blue font-bold text-4xl">AI for Youth</h1>
    </div>
    <div class="col-end-13 col-span-6">
      <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
      <br>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus ea temporibus similique neque quam sapiente facilis molestiae nesciunt officia, alias inventore deleniti modi perspiciatis voluptatum repudiandae quibusdam illo dolore eligendi.</p>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-36 pt-20 mb-0 flex justify-between items-center relative">
    <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/3 -translate-y-2/4 right-1/4 translate-x-3/4" aria-hidden="true" >
    <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-24 " aria-hidden="true" >
    <img src="{{asset('assets/img/image8.png')}}" class="relative z-20" alt="">
  </div>
  <div class="container mx-auto">
    <div class="max-w-[1366px] mx-auto px-36 pt-28 mb-0 flex justify-between items-center">
      <div class="col-span-4">
        <h1 class="intelOne text-dark-blue font-bold text-3xl">Active Internships Program</h1>
      </div>
      {{-- untuk arrow --}}
    </div>
    <div class="max-w-[1366px] mx-auto px-36 pt-28 mb-0 grid grid-cols-12 gap-3 grid-flow-col">
      <div class="col-span-4">
        <div class="flex flex-grow">
          <a href="#" class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-grey bg-white max-w-sm">
            <div class="flex">
              <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9 mr-5" alt="">
              <div class="flex-col">
                <p class="bg-lighter-blue text-dark-blue font-normal text-sm min-w-2 mx-w-2 rounded-full text-center">1 January 2023</p>
                  <p class="intelOne text-dark-blue font-bold text-xl">[Project name]</p>
              </div>
            </div>
            <p class="text-gray-700 text-base mb-2 pt-3">
              Some quick example text to build on the card title and make up the bulk of the card's
              content.
            </p>
            <div class="flex justify-between">
            <p class="intelOne text-dark-blue text-sm font-normal my-auto">232 student</p>
            <button class="intelOne text-white text-sm font-normal bg-darker-blue px-3 py-2 rounded-full">View Internship</button>
            </div>
          </a>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex flex-grow">
          <a href="#" class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-grey bg-white max-w-sm">
            <div class="flex">
              <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9 mr-5" alt="">
              <div class="flex-col">
                <p class="bg-lighter-blue text-dark-blue font-normal text-sm min-w-2 mx-w-2 rounded-full text-center">1 January 2023</p>
                  <p class="intelOne text-dark-blue font-bold text-xl">[Project name]</p>
              </div>
            </div>
            <p class="text-gray-700 text-base mb-2 pt-3">
              Some quick example text to build on the card title and make up the bulk of the card's
              content.
            </p>
            <div class="flex justify-between">
            <p class="intelOne text-dark-blue text-sm font-normal my-auto">232 student</p>
            <button class="intelOne text-white text-sm font-normal bg-darker-blue px-3 py-2 rounded-full">View Internship</button>
            </div>
          </a>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex flex-grow">
          <a href="#" class="block p-3 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-grey bg-white max-w-sm">
            <div class="flex">
              <img src="{{asset('assets/img/imagesl.png')}}" class="w-16 h-9 mr-5" alt="">
              <div class="flex-col">
                <p class="bg-lighter-blue text-dark-blue font-normal text-sm min-w-2 mx-w-2 rounded-full text-center">1 January 2023</p>
                  <p class="intelOne text-dark-blue font-bold text-xl">[Project name]</p>
              </div>
            </div>
            <p class="text-gray-700 text-base mb-2 pt-3">
              Some quick example text to build on the card title and make up the bulk of the card's
              content.
            </p>
            <div class="flex justify-between">
            <p class="intelOne text-dark-blue text-sm font-normal my-auto">232 student</p>
            <button class="intelOne text-white text-sm font-normal bg-darker-blue px-3 py-2 rounded-full">View Internship</button>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="max-w-[1366px] mx-auto px-36 pt-12 mb-0 grid grid-cols-12 gap-3 grid-flow-col">
      <div class="col-end-13 col-span-2">
        <button class="intelOnetext-sm font-normal border-2 border-solid border-dark-blue text-darker-blue px-3 py-2 rounded-full">View Internship</button>
      </div>
    </div>
  </div>
  <div class="w-full bg-lightest-blue">
    <div class="max-w-[1366px] mx-auto px-16 mt-12 pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container">
      <div class="col-span-3 my-auto">
        <img src="{{asset('assets/img/Ellipse2.png')}}" class="absolute z-10 w-[482px] -translate-x-1/3 -translate-y-1/4 " alt="">
        <p class="intelOne text-3xl rounded-full font-bold text-white relative z-20">What <br> Students Love</p>
      </div>
      <div class="col-start-5 gap-7 col-span-8 flex">
        <div class="relative max-w-md mx-auto flex flex-col py-6 px-8 bg-white rounded-lg shadow-lg">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRreh9Fwfj6mP6s9CINDCpfUXmi6OrRXJoD8fFI7BV01mzbbC1FhW5MLGQZYgH9PJ8UhC0&usqp=CAU"
            alt=""
            class="absolute rounded-full w-[75px] h-[75px] right-8 -translate-x-1/4 -top-6"
            />
          <p class="text-grey intelOne font-normal pt-12">
            “On the Windows talking painted pasture yet its express parties
            use. Sure last upon he same as knew next. Of believed or
            diverted no.”
          </p>
          <p class="mt-6 mb-2 text-right text-dark-blue font-medium text-sm intelOne">Mike taylor</p>
        </div>
        <div class="relative max-w-md mx-auto flex flex-col py-6 px-8 bg-white rounded-lg shadow-lg">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRreh9Fwfj6mP6s9CINDCpfUXmi6OrRXJoD8fFI7BV01mzbbC1FhW5MLGQZYgH9PJ8UhC0&usqp=CAU"
            alt=""
            class="absolute rounded-full w-[75px] h-[75px] right-8 -translate-x-1/4 -top-6"
            />
          <p class="text-grey intelOne font-normal pt-12">
            “On the Windows talking painted pasture yet its express parties
            use. Sure last upon he same as knew next. Of believed or
            diverted no.”
          </p>
          <p class="mt-6 mb-2 text-right text-dark-blue font-medium text-sm intelOne">Mike taylor</p>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection
@section('more-js')

@endsection