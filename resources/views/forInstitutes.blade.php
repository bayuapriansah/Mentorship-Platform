@extends('layouts.index')
@section('content')
<section id="for-institutes" class="min-h-screen ">
  <div class="relative mx-auto">
    <img src="{{asset('assets/img/hero-institutes.png')}}" alt="" class="w-full h-[556px] object-cover">
    <div class="absolute bottom-[15%] left-[4%] text-white bg-darker-blue rounded-3xl opacity-90 p-9 max-w-xl">
      <div class="flex flex-col opacity-100 space-y-4">
        <h1 class="font-bold text-3xl leading-8"><span class="text-light-brown">Simulated Internship</span> Platform for <span class="text-light-brown">Institutes</span></h1>
        <p class="text-[23px] font-light">Enroll your institute today to provide a virtual environment for students to work on real-world projects that simulate the demands of the workforce.</p>
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 z-30 text-lg space-y-20 text-justify">
    <div id="main-text" class="flex justify-between">
      <div class="w-[40%] my-auto">
        <h1 class="font-bold text-3xl leading-8">
          <span class="text-dark-blue">Simulated Internships</span><br>
          <span class="text-light-brown">For Institutes</span>
        </h1>
      </div>
      <div class="w-full">
        <p>In today's competitive job market, academic credentials alone are no longer enough to secure employment. Practical experience and relevant skills are increasingly in demand by employers. The simulated internship platform offers students the opportunity to work on AI projects and gain practical experience to help them stand out in the job market.</p>
        <p>Joining our platform can benefit your institution and students in several ways. Firstly, students will have a practical learning experience that simulates the demands of the workforce. This enables them to apply the knowledge and skills they have acquired in the classroom to real-world scenarios, developing critical skills that employers look for in candidates.</p>
        <p>Secondly, the online format offers flexibility and convenience. Students can access the program at their own pace and from anywhere. This makes it possible for students who may be unable to participate in traditional internships to still benefit from the program. Additionally, students can manage their schedules and balance personal commitments with meeting project deadlines.</p>
        <p>Thirdly, our program provides exposure to different types of AI projects, allowing students to build a well-rounded portfolio and explore various career paths. Students can select projects based on their interests and gain a better understanding of which paths they wish to pursue and specialize in.</p>
        <p>Lastly, our online simulated internship programs offer a safe learning environment where students can learn and experiment without fear of consequences. This allows students to develop their skills and confidence without any pressure.</p>
        <p>As a supervisor, you will play a crucial role in supporting your students throughout the project. You will act as the project manager, while our industry partners or the platform team will act as customers. This means that students will turn to you for guidance and support as they work on the projects.</p>
        <p>By partnering with our platform, educational institutions can help their students bridge the gap between the classroom and the workforce, gain a competitive edge in the job market, and make informed career choices. Join us today and help your students achieve their career goals!</p>
      </div>
    </div>
    <div id="ascociated" class="px-28">
      <h1 class="font-bold text-3xl leading-8 text-center text-dark-blue">Associated Institutes</h1>
      <div class="flex space-x-10 pt-14">
        <img src="{{asset('assets/img/for-institutes/image 56.png')}}" class="object-scale-down" alt="">
        <img src="{{asset('assets/img/for-institutes/image 57.png')}}" class="object-scale-down" alt="">
        <img src="{{asset('assets/img/for-institutes/image 58.png')}}" class="object-scale-down" alt="">
        <img src="{{asset('assets/img/for-institutes/image 59.png')}}" class="object-scale-down" alt="">
        <img src="{{asset('assets/img/for-institutes/image 60.png')}}" class="object-scale-down" alt="">
      </div>

    </div>
    <div id="benefits" class="px-28">
      <h1 class="font-bold text-3xl leading-8 text-center text-dark-blue">Benefits of Joining Simulated Internships </h1>
      <div class="mt-36 flex-col">
        <div class="bg-dark-blue py-9 pl-14 pr-36 rounded-3xl w-7/12 relative">
          <img src="{{asset('assets/img/for-institutes/image1.png')}}" class="absolute -right-24 -top-20" alt="">
          <p class="text-white text-lg font-normal">students will have a practical learning experience that simulates the demands of the workforce. This enables them to apply the knowledge and skills they have acquired in the classroom to real-world scenarios, developing critical skills that employers look for in candidates.</p>
        </div>
        <div class="flex flex-row-reverse mt-20">
          <div class="bg-light-brown px-11 pt-7 pb-20 rounded-3xl  w-7/12 relative ">
            <img src="{{asset('assets/img/for-institutes/image 65.png')}}" class="absolute -right-24 -bottom-14" alt="">
            <p class="text-white text-lg font-normal">the online format offers flexibility and convenience. Students can access the program at their own pace and from anywhere. This makes it possible for students who may be unable to participate in traditional internships to still benefit from the program. Additionally, students can manage their schedules and balance personal commitments with meeting project deadlines.</p>
          </div>
        </div>
        <div class="bg-dark-blue py-9 pl-36 pr-14 rounded-3xl w-7/12 relative mt-20">
          <img src="{{asset('assets/img/for-institutes/image 66.png')}}" class="absolute -left-24 -top-20" alt="">
          <p class="text-white text-lg font-normal">our program provides exposure to different types of AI projects, allowing students to build a well-rounded portfolio and explore various career paths. Students can select projects based on their interests and gain a better understanding of which paths they wish to pursue and specialize in.</p>
        </div>
        <div class="flex flex-row-reverse mt-20">
          <div class="bg-light-brown pl-44 pr-11 py-11 rounded-3xl  w-7/12 relative ">
            <img src="{{asset('assets/img/for-institutes/image 67.png')}}" class="absolute -left-20 -bottom-14" alt="">
            <p class="text-white text-lg font-normal">our online simulated internship programs offer a safe learning environment where students can learn and experiment without fear of consequences. This allows students to develop their skills and confidence without any pressure.</p>
          </div>
        </div>
      </div>
    </div>
    <div id="supervisor-role" class="px-28 pt-48 ">
      <div class="flex space-x-12">
        <img src="{{asset('assets/img/for-institutes/image 68.png')}}" alt="">
        <div class="my-auto space-y-8">
          <h1 class="font-bold text-3xl leading-8 text-dark-blue">Role of a Supervisor</h1>
          <p class="text-lg">
            As a supervisor, you will play a crucial role in supporting your students throughout the project. You will act as the project manager, while our industry partners or the platform team will act as customers. This means that students will turn to you for guidance and support as they work on the projects.
          </p>
        </div>
      </div>
    </div>
    <div id="institutes-say" class="px-28">
      <h1 class="font-bold text-3xl leading-8 text-center text-dark-blue">Institutes Say</h1>
      <p class="text-lg py-5">By partnering with our platform, educational institutions can help their students bridge the gap between the classroom and the workforce, gain a competitive edge in the job market, and make informed career choices. Join us today and help your students achieve their career goals!</p>
      <div class="flex px-20 justify-between my-12">
        <div class="flex-col w-[30%]">
          <img src="{{asset('assets/img/for-institutes/image 69.png')}}" class="mx-auto" alt="">
          <div class="text-center">
            <p class="text-2xl font-bold">Dr. A Singh</p>
            <p class="text-xl font-medium text-dark-blue">Sr. Profesor</p>
            <p class="text-xl">ABC University</p>
          </div>
        </div>
        <div class="flex-col w-[70%] my-auto">
          <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </p>
        </div>
        <div></div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection