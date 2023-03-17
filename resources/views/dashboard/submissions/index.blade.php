@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  @if(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
  <a href="/dashboard/projects"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
  @else
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
  @endif
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{substr($project->name,0,34)}}<i class="fa-solid fa-chevron-right"></i> Submission</h3>
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

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Student Name</th>
      <th>Task</th>
      <th>Submitted On</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    
    @foreach ($submissions->whereNotNull('file') as $submission)
    <tr>
      <td>{{$no}}</td>
      <td>{{$submission->student->first_name}} {{$submission->student->last_name}}</td>
      <td>Task {{$submission->projectSection->section}} :{{substr($submission->projectSection->title,0,34)}} {{strlen($submission->projectSection->title) > 34? '...':''}}</td>
      <td>{{$submission->updated_at->format('d/m/Y')}}</td>
      <td>
        @if ($submission->grade)
          @if ($submission->grade->status==1)
            <span class="text-[#11BF61]">PASS</span>
          @elseif($submission->grade->status==0)
            <span class="text-[#EA0202]">REVISE</span>
          @endif
        @else
          @if($submission->file)
            <span class="text-light-brown">IN REVIEW</span>
          @endif
        @endif
      </td>
      <td>
        <div class="dropdown inline-block relative">
          <button id="dropdownHoverButton" class="text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
          <!-- Dropdown menu -->
          <div class="z-10 dropdown-menu absolute hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
                <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                  {{-- @if ($submission->grade)
                    <a href="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}/grade/{{$submission->grade->id}}" >View Submission</a>
                  @else --}}
                    <a href="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}" >View Submission</a>
                  {{-- @endif --}}
                </li>
              </ul>
          </div>
        </div>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>

@if(Auth::guard('mentor')->check())
  @if (Auth::guard('mentor')->user()->institution_id != 0)
    <table id="dataTable2" class="bg-white rounded-xl border border-light-blue mt-16">
      <thead class="text-dark-blue">
        <tr>
          <th>No</th>
          <th>Student Name</th>
          <th>Task</th>
          <th>Submitted On</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $no=1 @endphp
        
        @foreach ($submissionsSupervised->whereNotNull('file') as $submission)
        <tr>
          <td>{{$no}}</td>
          <td>{{$submission->student->first_name}} {{$submission->student->last_name}}</td>
          <td>Task {{$submission->projectSection->section}} :{{substr($submission->projectSection->title,0,34)}} {{strlen($submission->projectSection->title) > 34? '...':''}}</td>
          <td>{{$submission->updated_at->format('d/m/Y')}}</td>
          <td>
            @if ($submission->grade)
              @if ($submission->grade->status==1)
                <span class="text-[#11BF61]">PASS</span>
              @elseif($submission->grade->status==0)
                <span class="text-[#EA0202]">REVISE</span>
              @endif
            @else
              @if($submission->file)
                <span class="text-light-brown">IN REVIEW</span>
              @endif
            @endif
          </td>
          <td>
            <div class="dropdown inline-block relative">
              <button id="dropdownHoverButton" class="text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
              <!-- Dropdown menu -->
              <div class="z-10 dropdown-menu absolute hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                  <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
                    <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                      {{-- @if ($submission->grade)
                        <a href="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}/grade/{{$submission->grade->id}}" >View Submission</a>
                      @else --}}
                        <a href="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}" >View Submission</a>
                      {{-- @endif --}}
                    </li>
                  </ul>
              </div>
            </div>
          </td>
        </tr>
        @php $no++ @endphp
        @endforeach
      </tbody>
    </table>
  @endif
@endif
@endsection
@section('more-js')
<script>
  $(document).ready(function () {
    // console.log('tes');
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
