@extends('layouts.admin2')
@section('content')

@if (session('success'))
<div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 fixed top-5 left-5 m-6" role="alert">
  <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
      </svg>
      <span class="sr-only">Check icon</span>
  </div>
  <div class="ml-3 text-sm font-normal">Status Changed successfully.</div>
  <button id="toast-close-btn" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
      <!-- close icon -->
  </button>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // target element that will be dismissed
  const $targetEl = document.getElementById('toast-success');

  // optional trigger element
  const $triggerEl = document.getElementById('toast-close-btn');

  // options object
  const options = {
    transition: 'transition-opacity',
    duration: 1000,
    timing: 'ease-out',

    // callback functions
    onHide: (context, targetEl) => {
      console.log('element has been dismissed')
      console.log(targetEl)
    }
  };

  // Create Dismiss object
  const dismiss = new Dismiss($targetEl, $triggerEl, options);

  // Set a timeout to automatically dismiss the toast after 2 seconds
  setTimeout(() => {
    dismiss.hide();
  }, 2000);
});
</script>
@endif

<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/projects"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">
    {{$project->name}} <i class="fa-solid fa-chevron-right mr-2"></i> Enrollment
  </h3>
</div>

@if(Auth::guard('mentor')->check())
  @if (Auth::guard('mentor')->user()->institution_id != 0)
  <div class="flex items-center mb-2 space-x-2">
    <label for="filter" class="text-base font-normal text-black my-auto">Filter</label>
    <select id="filter" class="bg-gray-50 border border-[#aaa] text-gray-900 text-md p-1 focus:ring-blue-500 focus:border-blue-500 rounded-md">
      <option selected>All Students</option>
      <option value="supervised">My Students</option>
    </select>
  </div>
  @endif
@endif

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16 allStudent">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Student Name</th>
      <th>Supervisor Name</th>
      <th>College Name</th>
      <th>Status</th>
      @if(Auth::guard('mentor')->check() || Auth::guard('web')->check())
      @if (optional(Auth::guard('mentor')->user())->institution_id == 0 || optional(Auth::guard('web')->user())->id == 1)
      {{-- <th>Action</th>
      <th>Peek</th> --}}
        @endif
      @endif
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($enrolled_projects as $enrolled_project)
    <tr>
      <td>{{$no}}</td>
      <td>{{$enrolled_project->student?->first_name}} {{$enrolled_project->student?->last_name}}</td>
      <td>{{$enrolled_project->student?->mentor?->first_name}} {{$enrolled_project->student?->mentor?->last_name}}</td>
      <td>{{$enrolled_project->student?->institution?->name}}</td>
      <td>
        @if ($enrolled_project->is_submited == 1)
          <div class="text-green-600">Complete</div>
        @else
        <div class="text-[#D89B33]">Ongoing</div>
        @endif
      </td>
      {{-- @if(Auth::guard('mentor')->check() || Auth::guard('web')->check())
      @if (optional(Auth::guard('mentor')->user())->institution_id == 0 || optional(Auth::guard('web')->user())->id == 1)
      <td class="flex justify-center items-center">
        @if($enrolled_project->is_submited != 1)
          <button data-modal-target="popup-modal{{ $enrolled_project->id }}" data-modal-toggle="popup-modal{{ $enrolled_project->id }}" class="block py-1 px-3 bg-dark-blue hover:bg-darker-blue rounded-md text-white" type="button">
            Change Status
          </button>

          <div id="popup-modal{{ $enrolled_project->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal{{ $enrolled_project->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to change this student Project Status. Email : {{ $enrolled_project->student->email }} ?</h3>
                        <form action="{{ route('dashboard.enrollment.edit', [$enrolled_project->id,$enrolled_project->student_id,$enrolled_project->project_id]) }}" method="post">
                          @csrf
                          <button type="submit" data-modal-hide="popup-modal{{ $enrolled_project->id }}" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                              Yes, I'm sure
                          </button>
                          <button data-modal-hide="popup-modal{{ $enrolled_project->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        @else
            <button class="block py-1 px-3 bg-grey rounded-md text-white disable">Final Status</button>
        @endif
      </td>
      <td>

        <!-- Modal toggle -->
        <button data-modal-target="defaultModal-{{ $enrolled_project->student->id }}-{{ $enrolled_project->id }}" data-modal-toggle="defaultModal-{{ $enrolled_project->student->id }}-{{ $enrolled_project->id }}" class="block py-1 px-3 bg-dark-blue hover:bg-darker-blue rounded-md text-white" type="button">
          View detail
        </button>

        <!-- Main modal -->
        <div id="defaultModal-{{ $enrolled_project->student->id }}-{{ $enrolled_project->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Detail Project
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal-{{ $enrolled_project->student->id }}-{{ $enrolled_project->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                      @foreach ($project->submission($enrolled_project->student_id, $enrolled_project->project_id) as $submission)
                      <div class="p-1 mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                          <div class="grid grid-cols-1 md:grid-cols-2">
                              <div class="p-1">
                                  <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                      Task {{ $submission->taskNumber }}
                                  </p>
                              </div>
                              <div class="p-1 text-right">
                                  <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-{{ $submission->is_complete ? 'green-500' : 'red-100' }} bg-{{ $submission->is_complete ? 'green-600' : 'red-600' }} rounded-full">
                                      {{ $submission->is_complete ? 'Complete' : 'Incomplete' }}
                                  </span>
                                  <p class="text-sm text-gray-500 mt-2 dark:text-gray-400">
                                      at {{ $submission->created_at }}
                                  </p>
                              </div>
                          </div>
                      </div>
                  @endforeach

                  </div>
                </div>
            </div>
        </div>

      </td>
      @endif
      @endif --}}
    </tr>
    @php
      $no++;
    @endphp
    @endforeach
  </tbody>
</table>
{{-- @foreach($enrolled_projects as $enrolled_project)
<div id="popup-modal{{ $enrolled_project->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal{{ $enrolled_project->id }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close modal</span>
          </button>
          <div class="p-6 text-center">
              <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
              </svg>
              <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
              <form action="{{ route('dashboard.enrollment.edit', [$enrolled_project->id,$enrolled_project->student_id,$enrolled_project->project_id]) }}" method="post">
                @csrf
                <button type="submit" data-modal-hide="popup-modal{{ $enrolled_project->id }}" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes, I'm sure
                </button>
                <button data-modal-hide="popup-modal{{ $enrolled_project->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
              </form>
          </div>
      </div>
  </div>
</div>
@endforeach --}}
@if(Auth::guard('mentor')->check())
  @if (Auth::guard('mentor')->user()->institution_id != 0)
    <table id="dataTable2" class="bg-white rounded-xl border border-light-blue mt-16 allStudent">
      <thead class="text-dark-blue">
        <tr>
          <th>No</th>
          <th>Student Name</th>
          <th>Supervisor Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @php $no=1 @endphp
        @foreach($enrolled_projects_supervised as $enrolled_project)
        <tr>
          <td>{{$no}}</td>
          <td>{{$enrolled_project->student->first_name}} {{$enrolled_project->student->last_name}}</td>
          <td>{{$enrolled_project->student->mentor->first_name}} {{$enrolled_project->student->mentor->last_name}}</td>

          <td>
            @if ($enrolled_project->is_submited == 1)
              <div class="text-green-600">Complete</div>
            @else
            <div class="text-[#D89B33]">Ongoing</div>
            @endif
          </td>
        </tr>
        @php
            $no++;
        @endphp
        @endforeach
      </tbody>
    </table>
  @endif
@endif
@endsection
@section('more-js')
<script>
  $(document).ready(function () {
    let table2 = $('#dataTable2').DataTable();
    let table1 = $('#dataTable').DataTable();

    $('#dataTable2_wrapper').hide()
    $("#filter").change(function(){
      var values = $("#filter option:selected").val();
      console.log(values);
      if(values=='supervised'){
        $('#dataTable2_wrapper').show()
        $('#dataTable_wrapper').hide();
      }else{
        $('#dataTable_wrapper').show();
        $('#dataTable2_wrapper').hide();
      }
    })
  })
</script>
@endsection

