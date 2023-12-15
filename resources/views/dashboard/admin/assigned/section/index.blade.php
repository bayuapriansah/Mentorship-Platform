@extends('layouts.admin2')
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
      <table id="dataTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th style="width: 1%">No</th>
            <th style="width: 1%">Section number</th>
            <th>Description</th>
            <th style="width: 336px">Actions</th>
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
              <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"" href="{{ route('dashboard.chat.showAllStudentsChats',[$project->id,$project_section->id]) }}" >View Student chat</a>
              <a class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"" href="{{ route('dashboard.chat.projectSubsection',[$project->id,$project_section->id]) }}" >Manage Attachment</a>

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
