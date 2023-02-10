@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Sections for {{$project->name}}</h1>
  </div>

  <!-- Content Row -->
  <div class="row mt-4">
    <div class="col">
      <div class="card p-4">
        @include('flash-message')
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Section number</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($project_sections as $project_section)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project_section->section}}</td>
            <td>{{$project_section->title}}</td>
            <td>
              <a class="btn btn-labeled bg-success editbtn text-white" href="{{ route('dashboard.chat.showAllStudentsChats',[$project->id,$project_section->id]) }}" >View Student chat</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="{{ route('dashboard.chat.projectSubsection',[$project->id,$project_section->id]) }}" >Manage Attachment</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="{{ route('dashboard.chat.showAllStudentsSubmission',[$project->id,$project_section->id]) }}" >Submission</a>
            </td>
          </tr>
          @php $no++ @endphp
          @endforeach
        </tbody>
      </table>
      </div>
    </div>
  </div>

</div>
@endsection
@section('more-js')

@endsection
