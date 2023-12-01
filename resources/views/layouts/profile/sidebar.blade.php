<aside class="w-full bg-[#FAFAFA] absolute z-[10] -top-5 rounded-xl border border-grey p-5">
  <div class="grid grid-cols-12 gap-2 grid-flow-col">
    <div class="col-span-2">
      <button type="button" data-modal-target="notification-modal" data-modal-toggle="notification-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="notification_bel">
        <svg class="w-6 h-6"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <span class="sr-only">Notifications Bell</span>
        @if($notifActivityCount > 0)
        <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $notifActivityCount }}</div>
        @endif
    </button>
    </div>
    <div class="col-span-2">
      <button type="button" data-modal-target="message-modal" data-modal-toggle="message-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="message">
      <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
      <span class="sr-only">Notifications Message</span>
      @if($newMessage > 0)
      <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $newMessage }}</div>
      @endif
      </button>
    </div>
    <div class="col-span-2">
      <a href="/profile/{{Auth::guard('student')->user()->id}}/edit" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
        </svg>
        <span class="sr-only">Profile edit</span>
      </a>
    </div>
    <div class="col-end-13">
      <form class="inline" method="post" action="{{ route('logout') }}">
        @csrf
          <button type="button" data-modal-target="popup-logout" data-modal-toggle="popup-logout" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="Logout">
            <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </button>

          <div id="popup-logout" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-3/6 h-full max-w-4xl md:h-auto border-[3px] border-light-blue rounded-2xl">
                <div class="relative bg-white rounded-xl shadow-2xl">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center z-30" data-modal-hide="popup-logout">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-left space-x-4">
                        <img src="{{asset('assets/img/dots-1.png')}}" class="absolute top-0 right-0 w-[233px] h-[108px]" alt="">
                        {{-- <img src="{{asset('assets/img/dots-1.png')}}" class="absolute bottom-0 z-10 left-0 w-[233px] h-[108px]" alt=""> --}}
                        <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">Are you sure you want to Logout?</h3>
                        <div class="relative z-30">
                          <button data-modal-hide="popup-logout" type="submit" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full shadow-xl">
                            Yes
                        </button>
                        <button data-modal-hide="popup-logout" type="button" class="intelOne text-dark-blue text-sm font-normal hover:bg-neutral-100 px-12 py-3 rounded-full shadow-xl">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </form>
    </div>
  </div>

  <div class="flex flex-col mt-8 ">
    <div class="mx-auto">
      <img src="{{$student->profile_picture ? asset('storage/'.$student->profile_picture) : asset('/assets/img/profile-placeholder.png') }}" class="w-[100px] h-[100px] rounded-full  mx-auto object-cover ring ring-[#C5CAF3]"  alt="Avatar">
      <p class="mt-4 text-dark-blue font-normal text-xl text-center capitalize">{{$student->first_name}} {{$student->last_name}}</p>
      <p class="text-black font-normal text-sm text-center">{{$student->year_of_study}} Year, {{$student->study_program}} </p>
      {{-- <img src="{{asset('storage/'.$student->institution->logo)}}" class="h-[53px] w-[53px] mt-2 mx-auto object-scale-down border rounded-full" alt="Logo"> --}}
      <img src="{{ asset('/assets/img/institution-placeholder.png') }}" class="h-[53px] w-[53px] mt-2 mx-auto object-scale-down border rounded-full" alt="Logo">
      <p class="mt-2 text-dark-blue font-bold text-sm text-center">{{$student->institution->name}}</p>
      <p class="mt-2 text-black font-normal text-sm text-center">Mentorship Status :

        @php
          $totalMonth = $completed_months->map(function ($item) {
            return $item['period'] ;
          });
        @endphp

        @if($total = $totalMonth->sum()==3 && \Carbon\Carbon::now() >= $student->end_date)
          <span class="text-light-green font-medium">Finished</span>
        @elseif($total = $totalMonth->sum()<3 && \Carbon\Carbon::now()->format('Y-m-d') > $student->end_date)
          <span class="text-red-600 font-medium">Incomplete</span>
        @else
          <span class="text-[#F8AC2A] font-medium">Ongoing</span>
        @endif
        {{-- @if($student->is_confirm == 0)
          <span class="text-light-blue">Not Started</span>
        @elseif($student->is_confirm == 1)
        <span class="text-green">Complete</span>
        @else
        <span class="text-[#F8AC2A]">Ongoing</span>
        @endif  --}}
      </p>

      <p class="mt-2 text-center text-sm text-[#2C2C2C]">
        Mentorship Type :
        <span class="font-medium text-darker-blue">
            Entrepreneur Track
        </span>
      </p>
    </div>
  </div>

  <div class="mt-4 flex flex-col justify-center text-center text-sm">
    <p class="text-[#2C2C2C]">
        Team Members:
    </p>

    <p class="font-medium text-darker-blue">Ady</p>
    <p class="font-medium text-darker-blue">Bayu</p>
    <p class="font-medium text-darker-blue">Kevin</p>
  </div>

  <div class="flex">
    {{-- <div>
      <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">{{$enrolled_projects->where('is_submited',0)->count()}}</p>
      <p class="text-light-black text-sm font-normal">Projects Enrolled</p>
    </div> --}}
    <div class="mx-auto">
  @php
   $start_date  = \Carbon\Carbon::parse($student->created_at)->format('d M Y');
  @endphp
      {{-- <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">{{$enrolled_projects->where('is_submited',1)->count()}}</p>
      <p class="text-light-black text-sm font-normal">Projects Completed</p> --}}
    </div>
  </div>
  <div class="mx-auto border border-light-blue rounded-xl mt-7 text-center p-3">
    {{-- SECTION TO SHOW TASK PROGRESS --}}
    @if(Route::is('student.enrolledDetail') || Route::is('student.taskDetail'))
    @php
         $dateApply   = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
    @endphp

    <p class="text-black text-xs font-normal">Projects Timeline</p>
    <div class="flex justify-between">
      @if($student->is_confirm == 1)
      <p class="text-black text-xs">{{$dateApply->format('d M Y')}}</p>
      @endif
      <div class="w-full  relative">
        @php $tipNumber = 1 @endphp
        @foreach ($submissions as $submission)
          {{-- @dd(array_search($submission, $submissions->toArray())) --}}
          @if ($loop->index %2 ==0)
            @if ($submission->grade == null)
              {{-- <img src="{{asset('assets/img/icon/flag.png')}}" class="absolute top-0" alt="" style="margin-left: {{$submission->flag_checkpoint}}%" data-toggle="flag" data-placement="top" title="Task {{$tipNumber}} &#013;{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}"> --}}
              <img src="{{asset('assets/img/icon/flag.png')}}" class="absolute top-0" alt="" style="margin-left: {{$submission->flag_checkpoint}}%" data-tooltip-target="tooltip-bottom{{$tipNumber}}" data-tooltip-placement="bottom" data-tooltip-trigger="hover">
              <div id="tooltip-bottom{{$tipNumber}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-black text-xs font-normal border border-light-blue bg-white rounded-lg shadow-sm opacity-0 tooltip">
                Task {{$tipNumber}} <br>
                {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}
                <div class="tooltip-arrow" data-popper-arrow></div>
              </div>
            @else
              @if($submission->grade->status == 1)
              <img src="{{asset('assets/img/icon/flag.png')}}" class="absolute top-0" alt="" style="margin-left: {{$submission->flag_checkpoint}}%" data-tooltip-target="tooltip-bottom{{$tipNumber}}" data-tooltip-placement="bottom" data-tooltip-trigger="hover">
              <div id="tooltip-bottom{{$tipNumber}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-black text-xs font-normal border border-light-blue bg-white rounded-lg shadow-sm opacity-0 tooltip">
                Task {{$tipNumber}} <br>
                {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}
                <div class="tooltip-arrow" data-popper-arrow></div>
              </div>
              @endif
            @endif
          @else
            @if ($submission->grade == null)
            <img src="{{asset('assets/img/icon/flag.png')}}" class="absolute bottom-0" alt="" style="margin-left: {{$submission->flag_checkpoint}}%" data-tooltip-target="tooltip-bottom{{$tipNumber}}" data-tooltip-placement="bottom" data-tooltip-trigger="hover">
              <div id="tooltip-bottom{{$tipNumber}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-black text-xs font-normal border border-light-blue bg-white rounded-lg shadow-sm opacity-0 tooltip">
                Task {{$tipNumber}} <br>
                {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}
                <div class="tooltip-arrow" data-popper-arrow></div>
              </div>
            {{-- {{$loop->index+1}} --}}
            @else
              @if($submission->grade->status == 1)
              <img src="{{asset('assets/img/icon/flag.png')}}" class="absolute bottom-0" alt="" style="margin-left: {{$submission->flag_checkpoint}}%" data-tooltip-target="tooltip-bottom{{$tipNumber}}" data-tooltip-placement="bottom" data-tooltip-trigger="hover">
              <div id="tooltip-bottom{{$tipNumber}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-black text-xs font-normal border border-light-blue bg-white rounded-lg shadow-sm opacity-0 tooltip">
                Task {{$tipNumber}} <br>
                {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}
                <div class="tooltip-arrow" data-popper-arrow></div>
              </div>
              @endif
            @endif
          @endif


            @php $tipNumber++ @endphp
        @endforeach

        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 mt-3">
          <div class="bg-[#11BF61] h-1.5 rounded-full" style="width: {{ (round($taskDate) >= 100) ? 100 : round($taskDate)}}%"></div>
        </div>

        @php $no=1 @endphp
        {{-- @foreach ($submissions as $submission)
          @if ($submission->grade == null)
            <p class="absolute bottom-0 font-medium text-center text-[10px]" style="left: {{$submission->flag_checkpoint-4}}%">Task {{$no}}</p>
            <p class="absolute font-normal text-[8px]" style="left: {{$submission->flag_checkpoint-6}}%">{{\Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}</p>
          @else
            @if($submission->grade->status == 1)
              <p class="absolute bottom-0 font-medium text-center text-[10px]" style="left: {{$submission->flag_checkpoint-4}}%">Task {{$no}}</p>
              <p class="absolute font-normal text-[8px]" style="left: {{$submission->flag_checkpoint-6}}%">{{\Carbon\Carbon::parse($submission->created_at)->format('d M Y')}}</p>
            @endif
          @endif
          @php $no++ @endphp
        @endforeach --}}
      </div>
      @if($student->is_confirm == 1)
        <p class="text-black text-xs">{{$dateApply->addMonths($project->period)->format('d M Y')}}</p>
      @endif
    </div>
    @if($student->is_confirm == 0)
      <p class="text-dark-blue text-[8px] font-normal">Internship Project has not yet started</p>
    @endif
    {{-- SECTION TO SHOW TASK PROGRESS --}}
    @else
    {{-- SECTION TO SHOW INTERNSHIP PROGRESS --}}
    <p class="text-black text-xs font-normal">Mentorship Timeline</p>
    {{-- <span>s</span> --}}

    <div class="flex justify-between">
      @if($student->is_confirm == 1)
      <p class="text-black text-xs">{{$start_date}}</p>
      @endif
      <div class="w-full relative">
        @php $tipNumber = 1 @endphp
        @foreach ($enrolled_projects->where('is_submited',1) as $enrolled_project)
          <img data-tooltip-target="tooltip-bottom{{$tipNumber}}" data-tooltip-placement="bottom" data-tooltip-trigger="hover" src="{{asset('assets/img/icon/flag.png')}}" class="absolute top-0"  alt="" style="margin-left: {{$enrolled_project->flag_checkpoint>=95?'95':$enrolled_project->flag_checkpoint}}%">
          {{-- <div class="bg-[#11BF61] h-1.5 rounded-full " style="width: {{ ($dataDate >= 100) ? 100 : $dataDate }}%"></div> --}}
          <div id="tooltip-bottom{{$tipNumber}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-black text-xs font-normal border border-light-blue bg-white rounded-lg shadow-sm opacity-0 tooltip">
            Project {{$tipNumber}} <br>
            {{$enrolled_project->project->name}} <br>
            {{\Carbon\Carbon::parse($enrolled_project->updated_at)->format('d M Y')}}
            <div class="tooltip-arrow" data-popper-arrow></div>
          </div>
          @php $tipNumber++ @endphp
        @endforeach

        <div class="bg-gray-200 rounded-full h-1.5 mb-4 mt-4 ">
          <div class="bg-[#11BF61] h-1.5 rounded-full " style="width: {{ ($dataDate >= 100) ? 100 : $dataDate }}%"></div>
        </div>
        <div class="text-center">
          @php $no=1 @endphp
          @foreach ($enrolled_projects->where('is_submited',1) as $enrolled_project)
            {{-- <p class="absolute bottom-0 mt-1 font-medium text-center text-[10px]" style="left: {{$enrolled_project->flag_checkpoint>=95?95-10:$enrolled_project->flag-10}}%">Project {{$no}}</p> --}}
            {{-- <p class="absolute -mt-3 font-normal text-[8px]" style="left: {{$enrolled_project->flag_checkpoint>=100?100-11:$enrolled_project->flag-11}}%">{{\Carbon\Carbon::parse($enrolled_project->updated_at)->format('d M Y')}}</p> --}}
            @php
              $no++
            @endphp
          @endforeach
        </div>

      </div>
      @if($student->is_confirm == 1)
        <p class="text-black text-xs">{{\Carbon\Carbon::parse($student->end_date)->format('d M Y')}}</p>
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
      @if($submissionData == null)
        @if (\Carbon\Carbon::now()->format('Y-m-d') <= $student->end_date)
          <button data-modal-target="staticModal" data-modal-toggle="staticModal" class="text-sm font-normal text-white bg-primary rounded-full p-2 mx-auto w-3/4">Submit Task</button>
        @endif
      @else
        <p class="text-xs mx-16 text-center py-2">You've successfully completed the task on {{$submissionData->created_at}}</p>
        <div class="mx-auto w-full border border-light-blue rounded-xl text-center p-3 flex justify-between items-center">
          @if (strpos($submissionData->file, 'https://') !== false)
            <i class="fa-solid fa-link"></i>
                Your Submission Link
            <a href="{{$submissionData->file}}">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
          @else
            <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
              Your Submission File
              @php
                $ekstension = substr($submissionData->file, strpos($submissionData->file, ".") + 1);
              @endphp
            <a download="submission.{{$ekstension}}" href="{{asset('storage/'.$submissionData->file)}}">
            <img  src="{{asset('assets/img/icon/download.png')}}" alt="">
          @endif
            {{-- <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
              Your Submission File
            @php
              $ekstension = substr($submissionData->file, strpos($submissionData->file, ".") + 1);
            @endphp
            <a download="submission.{{$ekstension}}" href="{{asset('storage/'.$submissionData->file)}}">
            <img  src="{{asset('assets/img/icon/download.png')}}" alt=""> --}}

          {{-- <i class="fa-solid fa-link"></i>
              Your Submission Link
          <a href="{{$submissionData->file}}">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
          </a> --}}
        </div>
        @if($submissionData->dataset)
          @php
            $datasets = explode(';',$submissionData->dataset);
            $no=1;
          @endphp
        <div class="flex flex-col text-center my-4">
          <h1 class="text-dark-blue font-medium text-sm text-center">Dataset</h1>
          <div class="flex flex-wrap justify-start pt-2">
            @foreach ($datasets as $dataset)
              <a href="{{$dataset}}" class="bg-light-brown hover:bg-dark-brown px-4 py-1 rounded-lg text-white mr-2 mb-2" target="_blank">Dataset {{$no}} <i class="fa-solid fa-chevron-right"></i></a>
              @php $no++ @endphp
            @endforeach
          </div>
        </div>
        @endif

        @if($submissionData->grade)
          @if ($submissionData->grade->status==1)
            <p class="text-dark-blue font-medium text-sm text-center">Status : <span class="text-[#11BF61]">Complete</span></p>
          @elseif($submissionData->grade->status==0)
            @if (\Carbon\Carbon::now()->format('Y-m-d') <= $student->end_date)
            <button data-modal-target="staticModal" data-modal-toggle="staticModal" class="text-sm font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2 mt-2">Resubmit Task </button>

            <p class="text-dark-blue font-medium text-sm text-center">Status : <span class="text-[#EA0202]">Revise</span></p>
            @endif
          @endif
        @else
          <p class="text-dark-blue font-medium text-sm text-center">Status : <span class="text-light-brown">In Review</span></p>
        @endif
      @endif

      {{-- grade status revise --}}
    </div>
  @else
  <div class="flex flex-col">
    @php
      $totalMonth = $completed_months->map(function ($item) {
        return $item['period'] ;
      });
    @endphp

    {{-- @if($total = $totalMonth->sum()==5 && \Carbon\Carbon::now() >= $student->end_date) --}}
    @if($enrolled_projects->where('is_submited',1)->count()==5)
      @if($student->feedback_done == null)
        <!-- Modal toggle -->
        <p class="text-dark-blue font-medium text-sm text-center my-3">One Last Step!</p>
        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="text-sm text-center font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2" type="button">
          Click Here!
        </button>

        <!-- Main modal -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                      <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Congratulations on Completing Your Internship!</h3>
                      <form class="space-y-6" action="{{ route('student.feedback', $student->id) }}" method="POST">
                        @csrf
                          <div>
                              <label for="feedback" class="block mb-2 text-sm text-gray-900 dark:text-white">We would be grateful if you could take a moment to share your feedback or a testimonial about your time with us.</label>
                              <textarea id="feedback" name="feedback" rows="4" maxlength="1000" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                              <span id="counter">0/1000</span>
                          </div>
                          <button type="submit" class="text-sm text-center font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2 px-6">Submit your feedback</button>
                      </form>
                  </div>
                </div>
            </div>
        </div>
      @elseif($student->feedback_done == 1)
        <p class="text-dark-blue font-medium text-sm text-center my-3">Congratulations!</p>
        <a href="/profile/{{Auth::guard('student')->user()->id}}/{{ $student->institution->id }}/certificate" class="text-sm text-center font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2">Download Certificate</a>
        {{-- <a href="/profile/{{Auth::guard('student')->user()->id}}/certificate" target="_blank" class="text-sm text-center font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2">Download Certificate</a> --}}
      @endif
    @elseif($total = $totalMonth->sum()<3 && \Carbon\Carbon::now()->format('Y-m-d') > $student->end_date)
      <p class="text-dark-blue font-medium text-sm text-center my-3">Sorry! You did not meet the requirements to complete the internship.</p>
      <button class="text-sm text-center font-normal text-white bg-grey rounded-full p-2 cursor-not-allowed">Download Certificate</button>
    @else
      <p class="text-dark-blue font-medium text-sm text-center my-3">Complete entire program to unlock</p>
      <button class="text-sm text-center font-normal text-white bg-grey rounded-full p-2 cursor-not-allowed">Download Certificate</button>
      {{-- <a href="/profile/{{Auth::guard('student')->user()->id}}/{{ $student->institution->id }}/certificate" target="_blank" class="text-sm text-center font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2">Download Certificate</a> --}}
    @endif


  </div>
  @endif
</aside>
<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
