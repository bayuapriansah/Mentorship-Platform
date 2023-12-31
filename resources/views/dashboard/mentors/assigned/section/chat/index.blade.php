@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Student Comments</h1>
  </div>
  @foreach($enrolled_students as $enrolled_student)
    <a href="/dashboard/assigned_projects/{{$project_id}}/section/{{$section_id}}/student/{{$enrolled_student->student->id}}">
      {{$enrolled_student->student->email}}
    </a><br>
  @endforeach

</div>
@endsection