@extends('layouts.admin2')
@section('content')
{{-- <div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div> --}}

@if (Route::is('dashboard.students.institutionStudents'))
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Institutions <i class="fa-solid fa-chevron-right"></i> Students</h3>
  <a href="/dashboard/institutions/{{$institution->id}}/students/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Student</a>
</div>
@else
<div class="flex justify-between mb-10">
  @if (Auth::guard('mentor')->check())
    {{-- @if (Auth::guard('mentor')->user()->institution_id != 0) --}}
      <h3 class="text-dark-blue font-medium text-xl" id="BitTitle">Assign final project to student {{$student->first_name}} {{$student->last_name}}</h3>
    {{-- @else
      @if (Route::is('dashboard.student.completeAll'))
        <h3 class="text-dark-blue font-medium text-xl" id="BitTitle">Assign final project to student {{$student->first_name}} {{$student->last_name}}</h3>
      @elseif(Route::is('dashboard.student.complete3'))
        <h3 class="text-dark-blue font-medium text-xl" id="BitTitle">Assign final project to student {{$student->first_name}} {{$student->last_name}}</h3>
      @endif
    @endif --}}
  @elseif(Auth::guard('web')->check())
    <h3 class="text-dark-blue font-medium text-xl" id="BitTitle"> Assign final project to student {{$student->first_name}} {{$student->last_name}}</h3>
  @endif
</div>
@endif

<form action="/dashboard/completed_all/{{$student->id}}" method="post">
  @csrf
  <select id="project" class="border border-light-blue rounded-lg w-full  h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5 focus:outline-none" name="project" required>
    <option value="" class="" id="" hidden>Select final project</option>
    @foreach ($projects as $project)
      <option value="{{$project->id}}">{{$project->name}}</option>
    @endforeach
  </select>

  <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne flex" type="submit">Confirm</button>
</form>


@include('flash-message')


@endsection
