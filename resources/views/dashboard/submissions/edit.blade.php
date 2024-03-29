@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/submissions/project/{{$project->id}}"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Review Submission</h3>
</div>
<div class="w-3/5 space-y-10">
  <div class="space-y-6">
    <div class="flex justify-between">
      <div>
        <div class="text-dark-blue font-normal">Project Domain</div>
        <div class="font-normal">{{$project->name}}</div>
      </div>
      <div>
        <div class="text-dark-blue font-normal">Project By</div>
        <div class="font-normal">{{optional($project->company)->name;}}</div>
      </div>
    </div>
    <div>
      <div class="text-dark-blue font-normal">Task Name</div>
      <div class="font-normal">{{$submission->projectSection->title}}</div>
    </div>
  </div>

  <div class="space-y-6">
    <div class="flex justify-between">
      <div>
        <div class="text-dark-blue font-normal">Student Name</div>
        <div class="font-normal">{{$submission->student->first_name}} {{$submission->student->last_name}}</div>
      </div>
      <div>
        <div class="text-dark-blue font-normal">Institute</div>
        <div class="font-normal">{{$submission->student->institution->name}}</div>
      </div>
      <div>
        <div class="text-dark-blue font-normal">Mentor</div>
        <div class="font-normal">{{$submission->student->mentor->first_name}} {{$submission->student->mentor->last_name}}</div>
      </div>
    </div>
    <div>
      <div class="text-dark-blue font-normal">Submitted on</div>
      <div class="font-normal">{{$submission->updated_at->format('d/m/Y')}}</div>
    </div>
  </div>

  <div class="space-y-6">
    <div class="text-dark-blue font-normal">Task Submission</div>
      <div class="py-4 px-6 w-3/4 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">

        @if (strpos($submission->file, 'https://') !== false)
          <i class="fa-solid fa-link"></i>
            <a href="{{$submission->file}}" target="_blank" class="text-base">Submission Link</a>
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
        @else
          <img src="{{asset('assets/img/icon/Vector.png')}}" class="object-scale-down">
            <a href="{{asset('storage/'.$submission->file)}}" target="_blank" class="text-base">Submission file .{{ substr($submission->file, strpos($submission->file, '.')+1) }}</a>
            <img src="{{asset('assets/img/icon/download.png')}}" class="object-scale-down">
        @endif

        {{-- /dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit --}}
        {{-- <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{1}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a> --}}
      </div>
  </div>
  <form action="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}/adminGrade" method="post">
    @csrf
    <div class="flex space-x-6">
      {{-- data-modal-target="defaultModal" data-modal-toggle="defaultModal" --}}

      <input type="submit" class="text-white text-sm font-normal bg-[#11BF61] hover:bg-green-600 cursor-pointer px-12 py-3 mt-5  rounded-full" name="pass" value="PASS">

      <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="text-white text-sm font-normal bg-[#AB0606] hover:bg-red-800 cursor-pointer px-12 py-3 mt-5  rounded-full" type="button">
        NEED REVISION
      </button>
      <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto ">
          <div class="relative bg-white rounded-lg border border-light-blue shadow ">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="popup-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-left">
                <p class="text-dark-blue font-medium text-xl">Are you sure you want to mark this submission as revise submission?</p>
                <p class="text-base">Once submission is marked as revise, you can let the student re-submit the solution.</p>
                <br>
                <div class="flex space-x-4">
                  <button type="submit" name="revision" value="revision" class="bg-dark-blue w-1/2 rounded-lg text-white py-2">
                    Confirm
                  </button>
                  <button type="button" data-modal-hide="popup-modal" type="button" class="bg-[#B52809] w-1/2 rounded-lg text-white py-2">
                    Cancel
                  </button>
                </div>
                {{-- <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes, I'm sure
                </button>
                <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">No, cancel</button> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
