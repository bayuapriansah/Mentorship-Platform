{{-- @dd($mentor->projects); --}}
@extends('layouts.admin2')
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
      <table id="dataTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Total Student</th>
            <th>Problem</th>
            <th>Project Domain</th>
            <th style="width:140px">Action</th>
          </tr>
        </thead>
        <tbody>
          {{-- @php $no=1 @endphp --}}
          {{-- @dd($projectAssigned->project) --}}
          @foreach($projects  as $index => $project)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $project->name }}</td>
            {{-- <td>{{ $totalStudents->where('project_id', $project->id)->first()->total ?? 0 }}</td> --}}
            <td class="text-center">{{ $enrolledProjects->where('project_id', $project->id)->unique('student_id')->count() }}</td>
            <td>{!! substr($project->problem,0,250) !!}</td>
            <td>{{ Str::upper($project->project_domain) }}</td>
            <td>
              {{-- <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/assigned_projects/{{$project->id}}/section" >Project Section</a> --}}
              <a class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2" href="{{ route('dashboard.chat.section',[$project->id]) }}" >Project Section</a>
              {{-- <a class="btn btn-labeled bg-primary editbtn text-white" href="" >Project Section</a> --}}
            </td>
          </tr>
          {{-- @php $no++ @endphp --}}
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
@section('more-js')

@endsection
