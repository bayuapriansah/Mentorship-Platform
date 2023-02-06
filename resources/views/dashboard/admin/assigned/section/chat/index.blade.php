@extends('layouts.admin2')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Student Comments</h1>
  </div>
  {{-- @foreach($enrolled_students as $enrolled_student)
    <a href="{{ route('dashboard.chat.singleStudentChat',[$project_id,$section_id,$enrolled_student->student->id]) }}">
      {{$enrolled_student->student->email}}
    </a><br>
  @endforeach --}}

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="dataTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th style="width: 1%">No</th>
            <th>Student Email</th>
            <th style="width: 190px">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($enrolled_students as $enrolled_student)
          <tr>
            <td>{{$no}}</td>
            <td>{{$enrolled_student->student->email}}</td>
            <td>
              <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ route('dashboard.chat.singleStudentChat',[$project_id,$section_id,$enrolled_student->student->id]) }}" >Start Reply Comment</a>
            </td>
          </tr>
          @php $no++ @endphp
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection