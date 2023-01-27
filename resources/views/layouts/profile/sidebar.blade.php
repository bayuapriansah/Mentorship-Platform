<aside class="w-full bg-white absolute -top-5 rounded-xl border border-light-blue p-5">
  {{-- @dd($enrolled_projects->where('is_submited',1)) --}}
  {{-- @foreach ($enrolled_projects as $enrolled_project)
      @if($enrolled_projects->where('is_submited',1))
      @dd('tes')

        <img src="{{asset('assets/img/icon/flag.png')}}"  alt="" class="ml-[{{$dataDate}}%]">
      @endif
  @endforeach --}}

  <div class="grid grid-cols-12 gap-2 grid-flow-col">
    <div class="col-span-2">
      <button type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" alt="notification_bel">
        <svg class="w-6 h-6"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <span class="sr-only">Notifications Bell</span>
        {{-- <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $newMessage->count() }}</div> --}}
        </button>
      {{-- <img src="{{asset('assets/img/icon/profile/bel.png')}}" alt="notification_bel"> --}}
    </div>
    <div class="col-span-1">
      <button type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" alt="message">
      <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
      <span class="sr-only">Notifications Message</span>
      <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $newMessage->count() }}</div>
      </button>
    </div>
    <div class="col-end-13">
      <form class="inline" method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" alt="Logout">
        <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        {{-- <img src="{{asset('assets/img/icon/profile/logout.png')}}" alt="Logout"> --}}
        </button>
      </form>
      
    </div>
  </div>
  <div class="flex flex-col mt-8 ">
    <div class="mx-auto">
      <img src="{{asset('assets/img/icon/profile/pp.png')}}" class="w-[100px] h-[100px]  mx-auto"  alt="message">
      <p class="text-dark-blue font-normal text-xl text-center ">{{$student->first_name}} {{$student->last_name}}</p>
      <p class="text-black font-normal text-sm text-center">{{$student->year_of_study}} Year, {{$student->study_program}} </p>
      <img src="{{asset('storage/'.$student->institution->logo)}}" class="h-[53px] w-[53px] mx-auto" alt="">
      <p class="text-dark-blue font-bold text-sm text-center ">{{$student->institution->name}}</p>
      <p class="text-black font-normal text-sm text-center">Internship Status:
        @if(\Carbon\Carbon::now()<=$student->end_date)
          <span class="text-[#F8AC2A] font-medium">Ongoing</span>
        @else
          <span class="text-light-green font-medium">Complete</span>
        @endif
        {{-- @if($student->is_confirm == 0)
          <span class="text-light-blue">Not Started</span>
        @elseif($student->is_confirm == 1)
        <span class="text-green">Complete</span>
        @else
        <span class="text-[#F8AC2A]">Ongoing</span>
        @endif  --}}
      </p>
    </div>
  </div>
  <div class="flex justify-between mt-8 ">
    <div>
      <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">{{$enrolled_projects->where('is_submited',0)->count()}}</p>
      <p class="text-light-black text-sm font-normal">Projects Enrolled</p>
    </div>
    <div>
  @php
   $start_date  = \Carbon\Carbon::parse($student->created_at)->format('dS M Y');
  @endphp
      <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">{{$enrolled_projects->where('is_submited',1)->count()}}</p>
      <p class="text-light-black text-sm font-normal">Projects Completed</p>
    </div>
  </div>
  <div class="mx-auto border border-light-blue rounded-xl mt-7 text-center p-3">
    {{-- SECTION TO SHOW TASK PROGRESS --}}
    @if(Route::is('student.enrolledDetail') || Route::is('student.taskDetail'))
    @php
         $dateApply   = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
    @endphp
    <p class="text-black text-xs font-normal">Internship Projects Timeline</p>
    <div class="flex justify-between">
      @if($student->is_confirm == 1)
      
      <p class="text-black text-xs">{{$dateApply->format('dS M Y')}}</p>
      @endif
      <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 mt-2">
        {{-- $dataDate is a function to calculate --}}
        <div class="bg-[#11BF61] h-1.5 rounded-full" style="width: {{ round($taskDate) }}%"></div>
        <div class="text-center">{{ round($taskDate) }}%</div>
      </div>
      {{-- <div class="flex-col ">
        <i class="fa-solid fa-calendar-days bg-[#11BF61] text-white p-2 rounded-full"></i>
        <p class="text-black text-[6px]">{{$student->end_date}}</p>
      </div> --}}
      @if($student->is_confirm == 1)
        <p class="text-black text-xs">{{$dateApply->addMonths($project->period)->format('dS M Y')}}</p>
      @endif
    </div>
    @if($student->is_confirm == 0)
      <p class="text-dark-blue text-[8px] font-normal">Internship Project has not yet started</p>
    @endif
    {{-- SECTION TO SHOW TASK PROGRESS --}}
    @else
    {{-- SECTION TO SHOW INTERNSHIP PROGRESS --}}
    <p class="text-black text-xs font-normal">Internship Projects Timeline</p>
    {{-- <span>s</span> --}}

    <div class="flex justify-between">
      @if($student->is_confirm == 1)
      <p class="text-black text-xs">{{$start_date}}</p>
      @endif
      <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 mt-2  ">
        {{-- $dataDate is a function to calculate --}}
        <div class="bg-[#11BF61] h-1.5 rounded-full " style="width: {{ $dataDate }}%">
        </div>
        @foreach ($enrolled_projects->where('is_submited',1) as $enrolled_project)
            <img src="{{asset('assets/img/icon/flag.png')}}"  alt="" class="ml-[{{$dataDate}}%]">
        @endforeach

      </div>
      {{-- <div class="flex-col ">
        <i class="fa-solid fa-calendar-days bg-[#11BF61] text-white p-2 rounded-full"></i>
        <p class="text-black text-[6px]">{{$student->end_date}}</p>
      </div> --}}
      @if($student->is_confirm == 1)
        <p class="text-black text-xs">{{$student->end_date}}</p>
      @endif
    </div>
    @if($student->is_confirm == 0)
      <p class="text-dark-blue text-[8px] font-normal">Internship Project has not yet started</p>
    @endif
    {{-- SECTION TO SHOW INTERNSHIP PROGRESS --}}
    @endif
  </div>
  
  @if(Route::is('student.taskDetail'))
    <div class="flex flex-col mt-8 ">
      @if($submission == null)
      <button data-modal-target="staticModal" data-modal-toggle="staticModal" class="text-sm font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2">Task Submission</button>
      @else
      <p class="text-xs mx-16 text-center py-2">You've successfully completed the task on {{$submission->created_at}}</p>
      <div class="mx-auto w-full border border-light-blue rounded-xl text-center p-3 flex justify-between items-center">
        <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
        <a href="{{asset('storage/'.$submission->file)}}">Your Submission file</a>
        <img src="{{asset('assets/img/icon/download.png')}}" alt="">
      </div>
      @endif
    </div>
  @else
  <div class="flex flex-col">
    <p class="text-dark-blue font-medium text-sm text-center my-3">Complete 3 Months project to unlock</p>
   
    <a href="#" class="text-sm text-center font-normal text-white bg-grey rounded-full p-2 cursor-default">Download Certificate</a>
    {{-- <a href="#" class="text-sm text-center font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2">Download Certificate</a> --}}

  </div>
  @endif
</aside>