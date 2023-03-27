@extends('layouts.index')
@section('content')
<section id="for-students" class="min-h-screen ">
  <div class="relative mx-auto">
    <img src="{{asset('assets/img/two-happy.jpeg')}}" alt="" class="w-full h-[556px] object-cover">
    <div class="absolute bottom-1/4 left-[10%] text-white bg-darker-blue rounded-xl opacity-90 p-9 max-w-xl">
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
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est ratione veritatis cupiditate, accusantium molestias dolorem modi vero porro corporis quisquam. Necessitatibus cupiditate adipisci veritatis. Vitae ipsa modi dolore veniam illum.</p>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet esse tenetur nemo illum consequatur atque animi autem, dicta dolorem voluptatibus iusto adipisci assumenda corporis dolores vel error a, deleniti iure dolore excepturi fuga. Nisi fuga assumenda distinctio, repudiandae optio maxime, eos, iusto repellendus magni ipsam expedita similique incidunt neque corporis ullam unde et alias a perferendis perspiciatis? Voluptates totam sapiente, possimus vitae porro quos eum provident adipisci. Sint vero aspernatur recusandae commodi reiciendis harum minus blanditiis earum amet corporis temporibus voluptates aperiam, magni distinctio, ducimus fuga eius atque nostrum ipsa? Dolor qui accusantium itaque eaque facere nobis enim suscipit tempore at. Sit recusandae, quibusdam fugiat quis id veritatis, sunt odit mollitia asperiores impedit laudantium non maiores optio sed dolores magni soluta error iste fugit nesciunt debitis ipsum quia ipsa deserunt? Rerum iusto labore quam neque officia dicta repudiandae maxime ratione saepe, dolorum nihil dolores aperiam doloremque! Repellendus nihil magnam at ipsam, ex aut impedit iste aliquam similique et illum accusamus iure deserunt voluptatum nisi porro mollitia! Iure, unde exercitationem delectus dolorum ducimus molestiae corrupti, suscipit necessitatibus impedit quaerat, odio magni reiciendis incidunt. Iusto quasi, blanditiis minus accusantium enim odio a reprehenderit minima tempora expedita ipsa? Quasi, possimus reprehenderit? Voluptatibus, repellendus?</p>
      </div>
    </div>
    <div id="success-stories" class="px-28">
      <h1 class="font-bold text-3xl leading-8 text-center text-dark-blue">Success Stories</h1>
      <div class="flex mt-10">
        <div class="w-1/2 flex flex-col">
          <p class=" text-[28px]">
            <span class="font-medium text-3xl leading-8 text-center">Anne Marie</span>
            , 28yrs <br>
            Data Analyst at <span class="text-dark-blue">IBM</span>  
          </p>
        </div>
        <div class="w-1/2">
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe eligendi recusandae nobis aliquid nulla amet labore ea quo quasi. Consequuntur provident ex voluptatum sapiente neque facere deserunt voluptas quas eligendi.
          </p>
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
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection