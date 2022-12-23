@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Projects</h1>
      <a href="{{route('dashboard.projects.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Add Projects</a>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Project name</th>
            <th>Project domain</th>
            <th>Problem</th>
            <th>Company</th>
            <th>Resources</th>
            <th>Valid Time</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($projects as $project)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project->name}}</td>
            <td>{{$project->project_domain}}</td>
            <td>{{$project->problem}}</td>
            <td>{{$project->company->name}}</td>
            <td>{{$project->resources}}</td>
            <td>{{$project->valid_time}}</td>
            <td>{{$project->status}}</td>
            <td>actions</td>
          </tr>
          @php $no++ @endphp
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
@section('more-js')

@endsection