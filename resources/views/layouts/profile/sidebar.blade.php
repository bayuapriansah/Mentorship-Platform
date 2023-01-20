<div class=" bg-white fixed top-5 w-1/4 rounded-xl border border-light-blue p-5">
  <div class="grid grid-cols-12 gap-2 grid-flow-col">
    <div class="col-span-2">
      <img src="{{asset('assets/img/icon/profile/bel.png')}}" alt="notification_bel">
    </div>
    <div class="col-span-1">
      <img src="{{asset('assets/img/icon/profile/message.png')}}" alt="message">
    </div>
    <div class="col-end-13">
      <form class="inline" method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class=""><img src="{{asset('assets/img/icon/profile/logout.png')}}" alt="Logout"></button>
      </form>
      
    </div>
  </div>
  <div class="flex flex-col mt-8 ">
    <div class="mx-auto">
      <img src="{{asset('assets/img/icon/profile/pp.png')}}" class="w-[100px] h-[100px]  mx-auto"  alt="message">
      <p class="text-dark-blue font-normal text-xl text-center ">{{$student->first_name}} {{$student->last_name}}</p>
      <p class="text-black font-normal text-sm text-center">4th Year, B.Tech in Computer Science & Engineering </p>
      <p class="text-dark-blue font-bold text-sm text-center ">{{$student->institution}}</p>
      <p class="text-black font-normal text-sm text-center">Internship Status:
        @if($student->is_confirm == 0)
          <span class="text-light-blue">Not Started</span>
        @else
        <span class="text-[#F8AC2A]">Ongoing</span>
        @endif 
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
   $start_date =   \Carbon\Carbon::parse($student->created_at);
   $start_date = $start_date->format('d-m-Y');
  @endphp
      <p class="text-center text-dark-blue font-bold text-lg p-2 border-2 border-light-blue w-12 py-auto mx-auto object-fit rounded-full">{{$enrolled_projects->where('is_submited',1)->count()}}</p>
      <p class="text-light-black text-sm font-normal">Projects Completed</p>
    </div>
  </div>
  <div class="mx-auto border border-light-blue rounded-xl mt-7 text-center p-3">
    <p class="text-black text-xs font-normal">Internship Projects Timeline</p>
    <div class="flex justify-between">
      @if($student->is_confirm == 1)
      <p class="text-black text-xs">{{$start_date}}</p>
      @endif
      <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700 mt-2">
        {{-- $dataDate is a function to calculate --}}
        <div class="bg-[#11BF61] h-1.5 rounded-full" style="width: {{ $dataDate }}%"></div>
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
  </div>
  @if(Route::is('student.taskDetail'))
  <form action="" method="post">
    @csrf
    @method('PATCH')
    <div class="flex flex-col mt-8 ">
      <p class="text-sm font-medium text-dark-blue">Task Submission</p>
      <button class="text-sm font-normal text-white bg-darker-blue hover:bg-dark-blue rounded-full p-2">Make Final Submission</button>
    </div>
  </form>
  @endif
</div>