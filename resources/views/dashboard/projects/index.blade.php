@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Projects</h1>
      {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Students</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Project name</th>
            <th>Problem</th>
            <th>Image</th>
            <th>Batch</th>
            <th>Student</th>
            <th>Company</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($projects as $project)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project->name}}</td>
            <td>{{$project->problem}}</td>
            <td><img src="{{$project->image}}" alt="" width="150px"></td>
            <td>{{$project->batch_id}}</td>
            <td>{{$project->student->name}}</td>
            <td>{{$project->company->name}}</td>
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