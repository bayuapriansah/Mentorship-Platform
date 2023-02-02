@extends('layouts.index')
@section('content')
<section id="faq" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col ">
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
          'answer'=>'AI projects ranging from Machine Learning (ML), Natural Language Processing (NLP), to Computer Vision (CV)'
        ),
        1 => array(
          'title'=>'How do I enroll in a project?',
          'answer'=>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus, sequi.'
        ),
        2 => array(
          'title'=>'What are the requirements for a project?',
          'answer'=>'If you are enrolled in an institute involved in this program you can start any project.'
        ),
        3 => array(
          'title'=>'How long is this program?',
          'answer'=>'The program is typically 4 months long and comprised of projects of various durations (generally 1 month).'
        ),
        4 => array(
          'title'=>'Are there any deadlines for applying for projects?',
          'answer'=>'The deadlines for each task/project are the soft deadlines. These deadlines are what your customer is expecting you to meet but, your educational institute will be responsible for fixing hard deadlines.'
        ),
        5 => array(
          'title'=>'Can I work on more than one project at a time?',
          'answer'=>'You can only be enrolled in one project at a time. However, if the deadline of a projet has passed, you can enroll in a second one while you finish the first project.'
        ),
        6 => array(
          'title'=>'Will I receive college credit for my internship?',
          'answer'=>'College credit specifics is dependent on your insitution. Please contact your institution for more information.'
        ),
        7 => array(
          'title'=>'Are there any opportunities for full-time employment after the program?',
          'answer'=>'We cannot guarantee employment after this program.'
        ),
        8 => array(
          'title'=>'How will I be matched with an internship opportunity?',
          'answer'=>'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consectetur.'
        ),
        9 => array(
          'title'=>'Will there be a supervisor or mentor assigned to me during the internship?',
          'answer'=>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Amet, ipsa!.'
        ),
        10 => array(
          'title'=>'What are the expectations from an intern during an internship project?',
          'answer'=>'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam, error!.'
        ),
        11 => array(
          'title'=>'I see an industry partner listed but there is not a project listed by them?',
          'answer'=>'We have various industry partners however, we can only run a limited number of projects at a time. Our list of industry partners represents those we have worked with, either currently or in the past.'
        ),
      ];
      
      // foreach ($faqs as $faq) {
      //   dd($faq[1]);
      // }

  @endphp
  <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-7">
      <div id="accordion-collapse" data-accordion="collapse" class="">
        @php
            $no = 1;
        @endphp
        @foreach ($faqs as $faq)
        {{-- @dd($faq) --}}
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

        {{-- <h2 id="accordion-collapse-heading-2">
          <button type="button" class="flex items-center mb-2 justify-between w-full p-5 font-normal text-left text-gray-500 border rounded-xl border-gray-200 focus:ring-4 focus:ring-gray-200 " data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
            <span>Is there a Figma file available?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden pb-2" aria-labelledby="accordion-collapse-heading-2">
          <div class="p-5 font-light border rounded-xl border-gray-200 ">
            <p class="mb-2 text-gray-500">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
            <p class="text-gray-500">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-3">
          <button type="button" class="flex items-center mb-2 justify-between w-full p-5 font-normal text-left text-gray-500 border rounded-xl border-gray-200 focus:ring-4 focus:ring-gray-200 " data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
            <span>What are the differences between Flowbite and Tailwind UI?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden pb-2" aria-labelledby="accordion-collapse-heading-3">
          <div class="p-5 font-light border rounded-xl border-gray-200">
            <p class="mb-2 text-gray-500">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
            <p class="mb-2 text-gray-500">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
            <p class="mb-2 text-gray-500">Learn more about these technologies:</p>
            <ul class="pl-5 text-gray-500 list-disc">
              <li><a href="https://flowbite.com/pro/" class="text-blue-600 hover:underline">Flowbite Pro</a></li>
              <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 hover:underline">Tailwind UI</a></li>
            </ul>
          </div>
        </div> --}}
      </div>
    </div>
    <div class="col-start-8 col-span-5">
      <h1 class="text-xl font-medium text-dark-blue pb-6">Quick Guides</h1>
      {{-- <img src="{{asset('assets/img/guides.png')}}" alt=""> --}}
      <iframe width="451" height="300" src="https://www.youtube.com/embed/aZLE-c7I7uk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      
    </div>
  </div>
</section>
@endsection

@section('more-js')

@endsection