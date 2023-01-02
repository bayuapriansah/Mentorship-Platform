{{-- @dd($mentor->projects); --}}
@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Assigned Projects</h1>
      {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Students</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Problem</th>
            <th>Project Domain</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($mentor->projects as $project)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project->name}}</td>
            <td>{{$project->problem}}</td>
            <td>{{$project->project_domain}}</td>
            <td>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/assigned_projects/{{$project->id}}/section" >Project Section</a>
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
@section('more-js')

@endsection