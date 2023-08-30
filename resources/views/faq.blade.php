@extends('layouts.index')
@section('content')
<section id="faq" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-screen-xl mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-7 relative">
        <h1 class="font-bold text-white text-3xl leading-10 relative z-20 ">Frequently Asked Questions</h1>
        <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 -top-6 ">
        
      </div>
      <div class="col-start-10 col-span-4 relative ">
        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 -top-16 right-0 " aria-hidden="true" >

      </div>
    </div>
  </div>
  @php
      $faqs = [
        0 => array(
          'title'=>'What types of projects are available on the website?',
          'answer'=>'We have various AI projects ranging from Machine Learning (ML), Natural Language Processing (NLP), to Computer Vision (CV).'
        ),
        1 => array(
          'title'=>'How do I enroll in a project?',
          'answer'=>'When you go to the Internship Projects page you will see the list of all available projects. To enroll simply click on the enroll button. Note that you can only be enrolled in one project at a time therefore, you will be able to enroll in another project after you have completed the project you are currently enrolled in.'
        ),
        2 => array(
          'title'=>'What are the requirements to enroll in a project?',
          'answer'=>'To enroll in a project you must be currently attending an institute which is involved in the Simulated Internship Program.'
        ),
        3 => array(
          'title'=>'What are the requirements to complete a project?',
          'answer'=>'Each project has it’s own specific requirements. After you enroll in a project you will receive a variety of tasks which you will need to complete. Once you submit a task, your institutions supervisor mark your task as pass or return it to you for revisions. You must pass all the tasks to complete a project. 
'
        ),
        4 => array(
          'title'=>'How long is this program?',
          'answer'=>'The program is typically 4 months long and comprised of projects of various durations (generally 1 month).'
        ),
        5 => array(
          'title'=>'Are there any deadlines for applying for projects?',
          'answer'=>'The deadlines for each task/project are the soft deadlines. These deadlines are what your customer is expecting you to meet but, your educational institute will be responsible for fixing hard deadlines.'
        ),
        6 => array(
          'title'=>'Can I work on more than one project at a time?',
          'answer'=>'You can only be enrolled in one project at a time. However, if the deadline of a project has passed, you can enroll in a second one while you finish the first project.'
        ),
        7 => array(
          'title'=>'Will I receive college credit for my internship?',
          'answer'=>'College credit specifics is dependent on your insitution. Please contact your institution for more information.'
        ),
        8 => array(
          'title'=>'Are there any opportunities for full-time employment after the program?',
          'answer'=>'We cannot guarantee employment after this program.'
        ),
        9 => array(
          'title'=>'Will there be a supervisor or mentor assigned to me during the internship?',
          'answer'=>'There will be one supervisor assigned to you from your own institute, and one staff member assigned to you from the Simulated Internship Platform team. You can chat with the supervisor and the staff member for any required support using the messaging feature present under each task of a project.'
        ),
        10 => array(
          'title'=>'What are the expectations from an intern during an internship project?',
          'answer'=>'An intern is expected to enroll in and complete multiple projects on the platform based on the duration of their internship. For each project, they must pass all the tasks inside the recommended project duration where each tasks should be completed inside the recommended task duration.'
        ),
        11 => array(
          'title'=>'I see an industry partner listed but there is not a project listed by them?',
          'answer'=>'We have various industry partners however, we can only run a limited number of projects at a time. Our list of industry partners represents those we have worked with, either currently or in the past.'
        ),
      ];

  @endphp
{{-- Body Content 2 --}}
<div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
  <div class="grid md:grid-cols-2 gap-4 items-start">
      <div class="my-auto">
        <div id="accordion-collapse" data-accordion="collapse" class="">
          @php
              $no = 1;
          @endphp
          @foreach ($faqs as $faq)
          <h2 id="accordion-collapse-heading-1 ">
            <button type="button" class="flex items-center mb-2 justify-between w-full p-5 font-normal text-left text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 " data-accordion-target="#accordion-collapse-body-{{$no}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$no}}">
              <span class="font-medium">{{$faq['title']}}</span>
              <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-{{$no}}" class="hidden pb-2" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 font-light border rounded-xl border-gray-200 ">
              <p class="mb-2 text-gray-500 ">{{$faq['answer']}}</p>
            </div>
          </div>
          @php
              $no++
          @endphp
          @endforeach
        </div>
      </div>
        <div class="relative">
          <h1 class="m-0 text-2xl font-medium text-dark-blue text-justify justify-start">Quick Guides</h1>
          <div class="relative z-30 rounded-lg overflow-hidden" style="padding-bottom: 56.25%">
            <iframe class="absolute inset-0 w-full h-full py-4" src="https://www.youtube.com/embed/aZLE-c7I7uk"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                allowfullscreen></iframe>
        </div>
        </div>    
  </div>
</div>

</section>
@endsection

@section('more-js')

@endsection