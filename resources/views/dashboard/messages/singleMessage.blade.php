@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/messages/{{$injection->id}}"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{substr($injection->title,0,35)}}{{strlen($injection->title) >=35?"...":''}} <i class="fa-solid fa-chevron-right"></i> Messages <i class="fa-solid fa-chevron-right"></i> {{$participant->first_name}} {{$participant->last_name}}</h3>
  <a href="/dashboard/messages/create" class="text-xl text-dark-blue"><i class="fa-solid fa-envelope"></i> New Message</a>
</div>


<div id="accordion-collapse" class="border border-light-blue rounded-lg p-4 bg-white" data-accordion="collapse">
  @php $no=1;  @endphp
  @foreach ($comments as $comment)
  <h2 id="accordion-collapse-heading-{{$no}}">
    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-black  border-b-2 border-gray-200" data-accordion-target="#accordion-collapse-body-{{$no}}" aria-expanded="false" aria-controls="accordion-collapse-body-{{$no}}">
      <div class="flex items-center space-x-4">
        <i class="text-dark-blue fa-solid fa-circle"></i>
        <div class="flex-col">
          <span class="font-medium">
            @if ($comment->mentor_id)
              {{$comment->mentor->first_name}} {{$comment->mentor->last_name}}
            @elseif ($comment->user_id)
              {{$comment->user->name}}
            @else
            {{$comment->student->first_name}} {{$comment->student->last_name}}
            @endif
          </span><br>
          <span class="font-light">{{substr($comment->message,0,99)}} {{strlen($comment->message)>=99?'...':''}}</span>
        </div>
      </div>

      <div class="text-xs text-light-blue font-light">
        {{$comment->created_at->format('d M Y')}}
        <i class="fa-sharp fa-solid fa-reply"></i>
      </div>
    </button>
  </h2>
  <div id="accordion-collapse-body-{{$no}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$no}}">
    <div class="p-5 font-light border border-b-0 border-gray-200">
      <p class="mb-2 text-gray-500 ">{{$comment->message}}</p>
      @if($comment->file)
        <br>
        <a download="image.jpg" href="{{asset('storage/'.$comment->file)}}" class="flex w-1/2 py-2 px-4 rounded-xl justify-between items-center border border-light-blue">
          <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
          <span class="text-xs  font-normal text-black">click to download (.{{substr($comment->file, strpos($comment->file, ".") + 1)}})</span>
          <img src="{{asset('assets/img/icon/download.png')}}" alt="">
        </a>
      @endif
    </div>
  </div>
  @php $no++ @endphp
  @endforeach

</div>
  {{-- <h2 id="accordion-collapse-heading-2">
    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
      <span>Is there a Figma file available?</span>
      <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </h2>
  <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
    <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">
      <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
      <p class="text-gray-500 dark:text-gray-400">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600 dark:text-blue-500 hover:underline">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
    </div>
  </div>
  <h2 id="accordion-collapse-heading-3">
    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-3" aria-expanded="true" aria-controls="accordion-collapse-body-3">
      <span>What are the differences between Flowbite and Tailwind UI?</span>
      <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </h2>
  <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
    <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
      <p class="mb-2 text-gray-500 dark:text-gray-400">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
      <p class="mb-2 text-gray-500 dark:text-gray-400">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
      <p class="mb-2 text-gray-500 dark:text-gray-400">Learn more about these technologies:</p>
      <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
        <li><a href="https://flowbite.com/pro/" class="text-blue-600 dark:text-blue-500 hover:underline">Flowbite Pro</a></li>
        <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
      </ul>
    </div>
  </div> --}}
@endsection