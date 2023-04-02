@extends('layouts.index')
@section('content')
<section id="for-institutes" class="min-h-screen ">
  <div class="relative mx-auto">
    <img src="{{asset('assets/img/for-industry/hero1.png')}}" alt="" class="w-full h-[556px] object-cover">
    <div class="absolute bottom-[15%] left-[4%] text-white bg-darker-blue rounded-3xl opacity-90 p-9 max-w-xl">
      <div class="flex flex-col opacity-100 space-y-4">
        <h1 class="font-bold text-3xl leading-8">Information for <span class="text-light-brown">Partners</span></h1>
        <p class="text-[23px] font-light">Enroll your organisation today with us, partnering with the platform can help companies identify potential future talent.</p>
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-40 py-16 z-30 text-lg space-y-20 text-justify">
    <div id="main-text" class="flex flex-col space-y-20">
      <div class="flex justify-between">
        <div class="w-[40%] my-auto">
          <h1 class="font-bold text-3xl leading-8">
            <span class="text-dark-blue">Information</span><br>
            <span class="text-light-brown">For Partners</span>
          </h1>
        </div>
        <div class="w-full pl-20">
          <p class="text-lg">Collaborating with a platform that connects students with real-world problems presents an excellent opportunity for companies to receive innovative insights and potential solutions to their most pressing challenges. By sharing problem statements and anonymized data with the platform, partners can benefit from the diverse expertise and innovative thinking of a talented and motivated pool of students.</p>
        </div>
      </div>
      <div class="flex">
        <div class=" w-1/2 my-auto">
          <p class="text-lg">
            Students participating in the program come from various fields, such as engineering, computer science, business, and social sciences, providing partners with access to a broad range of perspectives and expertise. Additionally, students are often keen to work on real-world projects that can help them build their skills and gain practical experience, making it a mutually beneficial program for both partners and students.
          </p>
        </div>
        <div class="w-1/2 flex justify-end">
          <img src="{{asset('assets/img/for-industry/image 71.png')}}" alt="" class="rounded-2xl" style="width: 376px; height: 251px;">
        </div>
      </div>
      <div class="flex">
        <div class=" w-1/2 my-auto">
          <img src="{{asset('assets/img/for-industry/image 72.png')}}" alt="" class="rounded-2xl" style="width: 376px; height: 251px;">
        </div>
        <div class="w-1/2 my-auto">
          <p class="text-lg mb-3">
            Moreover, partnering with the platform can help companies identify potential future talent. The program provides a unique opportunity for partners to engage with students who have demonstrated an interest in their industry and challenges, enabling them to evaluate their skills, work ethic, and suitability for future employment opportunities.
          </p>
          <p class="text-lg">
            The platform takes privacy and data security seriously, and all data provided by partners is anonymized to protect confidentiality. Partners can be confident that their sensitive data will be safeguarded throughout the program, and they will have control over how and when their data is shared with students.
          </p>
        </div>
      </div>
      <div class="flex">
        <div class=" w-1/2 my-auto">
          <p class="text-lg">
            In designing a project, we are here to support you and ensure that both you and the students have a positive experience. Our AI educators will take your proposed project and transform it into the final project the students will see. Once the project is live, you will have the opportunity to interact with the students as if you are their customer contracting them to work on your project. However, this is optional as our team will also be there to help the students complete the project.
          </p>
        </div>
        <div class="w-1/2 flex justify-end">
          <img src="{{asset('assets/img/for-industry/partner3.png')}}" alt="" class="rounded-2xl" style="width: 376px; height: 251px;">
        </div>
      </div>
    </div>
    <div id="success-stories" class="space-y-8">
      <h1 class="font-bold text-3xl leading-8 text-center text-dark-blue">Collaborate With Us</h1>
      <p class="text-lg text-center">
        To get involved, please contact us to start discussing your problem statements, and we will begin transforming them into a project for our students. By collaborating with our platform, you can tap into the talent and creativity of motivated students from diverse backgrounds, gain fresh insights and potential solutions to your challenges, and help shape the minds and careers of future leaders. Contact us now to start the conversation and see how we can help turn your problem statement into a real-world project.
      </p>
      <div class="text-center">
        <a href="/contact" class="intelOne text-white text-sm font-normal bg-dark-blue hover:bg-darker-blue px-10 py-3 rounded-full">Contact Us</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection