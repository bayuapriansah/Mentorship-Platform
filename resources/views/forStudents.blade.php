@extends('layouts.index')
@section('content')
<section id="for-students" class="min-h-screen ">
  <div class="relative mx-auto">
    <img src="{{asset('assets/img/two-happy.jpeg')}}" alt="" class="w-full h-[556px] object-cover">
    <div class="absolute bottom-1/4 left-[10%] text-white bg-darker-blue rounded-3xl opacity-90 p-9 max-w-xl">
      <div class="flex flex-col opacity-100 space-y-4">
        <h1 class="font-bold text-3xl leading-8"><span class="text-light-brown">Simulated Internship</span> Platform for <span class="text-light-brown">Students</span></h1>
        <p class="text-[23px] font-light">Join today to work on real-world projects and kick-start your career!</p>
        <a href="#" class="py-2.5 px-11 rounded-full bg-white text-center capitalize bg-orange text-dark-blue font-light text-sm w-1/3">Get Started</a>
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 z-30 text-lg space-y-20 text-justify">
    <div id="main-text" class="flex justify-between">
      <div class="w-[40%] my-auto">
        <h1 class="font-bold text-3xl leading-8">
          <span class="text-dark-blue">Simulated Internships</span><br>
          <span class="text-light-brown">For Students</span>
        </h1>
      </div>
      <div class="w-full">
        <p>This platform offers students the opportunity to work on AI projects in an online work-like environment. Unlike typical projects or tutorials that provide a step-by-step guide, this platform is designed to replicate real-world work settings, allowing students to tackle projects with increasing independence. By completing the projects on this platform, students will develop valuable skills in problem-solving, time management, and accountability as they take ownership of their tasks and meet deadlines.</p>
        <p>The AI projects featured on this platform have been thoughtfully crafted to guide students through a work-like project experience, enhancing their independence and preparing them for industry settings. Students will gain experience in data collection, data wrangling, data pipelining, AI model building, AI model evaluation, and soon, AI solution proof of concept deployment.</p>
        <p>Throughout their time on the platform, students will enroll in projects, receive tasks, complete work, and submit it for review. Feedback will be provided, allowing students to revise and improve their work. Successful completion of the simulated internship program will result in a portfolio of projects that not only showcases a student's growth as a developer but also demonstrates their ability to work independently in a work-like setting.</p>
        <p>Overall, the platform provides students with a unique opportunity to develop practical skills, collaborate with industry professionals, and gain valuable experience that will benefit them in their future careers.</p>
        <div class="p-9 bg-[#F3F3F3] rounded-2xl mt-4">
          <div class="flex flex-col space-y-6">
            <div class="flex space-x-32">
              <div class="flex space-x-4">
                <img src="{{asset('assets/img/checkround.png')}}" class="object-scale-down" alt="">
                <p class="text-xl font-medium text-dark-blue">Data Collection</p>
              </div>
              <div class="flex space-x-4">
                <img src="{{asset('assets/img/checkround.png')}}" class="object-scale-down" alt="">
                <p class="text-xl font-medium text-dark-blue">Data Wrangling</p>
              </div>
            </div>
            <div class="flex space-x-32">
              <div class="flex space-x-4">
                <img src="{{asset('assets/img/checkround.png')}}" class="object-scale-down" alt="">
                <p class="text-xl font-medium text-dark-blue">Data Pipelining</p>
              </div>
              <div class="flex space-x-4">
                <img src="{{asset('assets/img/checkround.png')}}" class="object-scale-down" alt="">
                <p class="text-xl font-medium text-dark-blue">AI Model Building</p>
              </div>
            </div>
            <div class="flex space-x-32">
              <div class="flex space-x-4">
                <img src="{{asset('assets/img/checkround.png')}}" class="object-scale-down" alt="">
                <p class="text-xl font-medium text-dark-blue inline">AI Model Evaluation</p>
              </div>
              <div class="flex space-x-4">
                <img src="{{asset('assets/img/checkround.png')}}" class="object-scale-down" alt="">
                <p class="text-xl font-medium text-dark-blue inline">AI Solution Proof of Concept (POC) deployment <span class="text-light-brown">(Coming Soon)</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="success-stories" class="px-28">
      <h1 class="font-bold text-3xl leading-8 text-center text-dark-blue">How it Works?</h1>
      <div class="flex mt-[70px]">
        <div class="w-1/2 flex flex-col">
          <img src="{{asset('assets/img/1_how it work.png')}}" alt="">
        </div>
        <div class="w-1/2 ">
          <p class="bg-light-brown text-white p-2 rounded-full w-24 h-24 flex items-center justify-center text-2xl font-medium">Step 1</p>
          <h1 class="text-2xl font-medium py-5">Enroll in a project</h1>
          <p class="text-[#5A5A5A] ">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe eligendi recusandae nobis aliquid nulla amet labore ea quo quasi. Consequuntur provident ex voluptatum sapiente neque facere deserunt voluptas quas eligendi.
          </p>
        </div>
      </div>
      <div class="flex justify-end mt-[70px]">
        <div class="w-1/2 text-right">
          <p class="bg-light-brown ml-[80%] text-white text-justify p-2 rounded-full w-24 h-24 flex justify-center items-center text-2xl font-medium">Step 2</p>
          <h1 class="text-2xl font-medium py-5">Begin & Work on the Task</h1>
          <p class="text-[#5A5A5A] ">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe eligendi recusandae nobis aliquid nulla amet labore ea quo quasi. Consequuntur provident ex voluptatum sapiente neque facere deserunt voluptas quas eligendi.
          </p>
        </div>
        <div class="w-1/2 flex flex-col relative">
          <img src="{{asset('assets/img/line1.png')}}" class="absolute z-10 -top-32" alt="">
          <img src="{{asset('assets/img/2_how it work.png')}}" class="z-20 " style="width: 486px; height: 280px;" alt="">
        </div>
      </div>
      <div class="flex mt-[115px]">
        <div class="w-1/2 flex flex-col relative">
          <img src="{{asset('assets/img/line2.png')}}" class="absolute z-10 -top-36 -right-10" alt="">
          <img src="{{asset('assets/img/3.how it work.png')}}" class="z-20" alt="">
        </div>
        <div class="w-1/2 ml-12 mt-6">
          <p class="bg-light-brown text-white p-2 rounded-full w-24 h-24 flex items-center justify-center text-2xl font-medium">Step 3</p>
          <h1 class="text-2xl font-medium py-5">Submit the task</h1>
          <p class="text-[#5A5A5A] ">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe eligendi recusandae nobis aliquid nulla amet labore ea quo quasi. Consequuntur provident ex voluptatum sapiente neque facere deserunt voluptas quas eligendi.
          </p>
        </div>
      </div>
      <div class="flex justify-end mt-[158px]">
        <div class="w-1/2 text-right mt-10 mr-5">
          <p class="bg-light-brown ml-[80%] text-white text-justify p-2 rounded-full w-24 h-24 flex justify-center items-center text-2xl font-medium">Step 4</p>
          <h1 class="text-2xl font-medium py-5">Move onto the next task</h1>
          <p class="text-[#5A5A5A] ">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe eligendi recusandae nobis aliquid nulla amet labore ea quo quasi. Consequuntur provident ex voluptatum sapiente neque facere deserunt voluptas quas eligendi.
          </p>
        </div>
        <div class="w-1/2 flex flex-col relative">
          <img src="{{asset('assets/img/line3.png')}}" class="absolute z-10 -top-44 " alt="">
          <img src="{{asset('assets/img/4.how it work.png')}}" class="z-20" alt="">
        </div>
      </div>
    </div>
    <div id="internship-projects">
      <div class="container mx-auto">
        <div class="max-w-[1366px] mx-auto px-16 pt-10 mb-0 flex ">
          <div class="">
            <h2 class="intelOne text-dark-blue font-bold text-3xl">Internship Projects</h2>
          </div>
          {{-- untuk arrow --}}
        </div>
        <div class="max-w-[1366px] mx-auto px-16 pt-8 mb-0 grid grid-cols-13 gap-8 grid-flow-col">
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
                    <p class="text-dark-blue font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36">
                      @if ($project->project_domain == 'statistical')
                        Statistical Data
                      @elseif($project->project_domain == 'computer_vision')
                        Computer Vision
                      @else
                        NLP
                      @endif   
                    </p>
                  </div>
                </div>
                <div class="text-grey font-normal text-base mb-2 pt-3">
                  {{ substr($project->overview,0,62) }}...
                </div>
                <div class="flex justify-between">
                <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-medium">{{ $project->period }} Months</span></p>
                <a href="
                @if (Auth::guard('student')->check() || Auth::guard('web')->check() || Auth::guard('mentor')->check() || Auth::guard('customer')->check())
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
        <div class="max-w-[1366px] mx-auto px-16 pt-12 mb-0 grid grid-cols-12 grid-flow-col">
          <div class="col-end-13 col-span-2">
            <button  class="intelOnetext-sm font-normal border-2 border-solid border-dark-blue text-darker-blue hover:bg-dark-blue hover:text-white px-3 py-2 rounded-full">
              <a href="/projects">View All Projects</a>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="more">
      <div class="grid grid-cols-12 gap-11 grid-flow-col px-16 relative">
        <div class="col-span-4 my-auto">
          <div class="items-center">
            <h1 class="text-dark-blue text-3xl font-bold">Read More</h1>
          </div>
        </div>
        <div class="col-span-4">
          <div class="flex flex-col">
            <img src="{{asset('assets/img/for_institution.png')}}" class="relative z-20 mt-5" alt="for students">
            <h1 class="text-dark-blue text-2xl font-bold py-3 -mt-4 relative z-30 hover:text-darker-blue"><a href="for-institution">For Institutes</a></h1>
            <p class="text-black font-normal text-sm">Enhanced Student Employability, Collaborate with Industry leaders, Supervise Real-World AI Projects</p>
          </div>
        </div>
        <div class="col-span-4">
          <div class="flex flex-col">
            <img src="{{asset('assets/img/for_industries.png')}}" class="relative z-20" alt="for students">
            <h1 class="text-dark-blue text-2xl font-bold py-3 relative z-30 hover:text-darker-blue"><a href="for-industry">For Industries</a></h1>
            <p class="text-black font-normal text-sm">Identify Top Future Talents, Collaborate with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection