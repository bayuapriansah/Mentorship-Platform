@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{substr($project->name,0,34)}}<i class="fa-solid fa-chevron-right"></i> Submission</h3>
</div>

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
    @foreach ($submissions as $submission)
    <tr>
      <td>{{$no}}</td>
      <td>{{$submission->student->first_name}} {{$submission->student->last_name}}</td>
      <td>{{substr($submission->projectSection->title,0,34)}} {{strlen($submission->projectSection->title) > 34? '...':''}}</td>
      <td>{{$submission->updated_at->format('d/m/Y')}}</td>
      <td>
        @if ($submission->grade)
          @if ($submission->grade->status==1)
            <span class="text-[#11BF61]">PASS</span>
          @elseif($submission->grade->status==0)
            <span class="text-[#EA0202]">REVISE</span>
          @endif
        @else
          <span class="text-light-brown">IN REVIEW</span>
        @endif
      </td>
      <td>
        <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover{{$no}}" data-dropdown-trigger="hover" class="text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
        <!-- Dropdown menu -->
        <div id="dropdownHover{{$no}}" class="z-10 hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                @if ($submission->grade)
                  <a href="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}/grade/{{$submission->grade->id}}" >View Submission</a>
                @else
                  <a href="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}" >View Submission</a>
                @endif
              </li>
            </ul>
        </div>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@endsection