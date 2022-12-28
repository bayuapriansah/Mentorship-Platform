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
    <div class="col card p-4">
      @include('flash-message')
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Project name</th>
            <th>Project domain</th>
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
            <td>{{$project->company->name}}</td>
            <td><a href="{{asset('storage/'. $project->resources)}}">[Resource file name]</a></td>
            <td>{{$project->valid_time}}</td>
            <td>{{$project->status}}</td>
            <td>

              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/edit" >Edit</a>

              <form method="POST" action="/dashboard/projects/{{ $project->id }}" >
                @csrf
                @method('DELETE')
                <div class="control">
                <button type="submit" class="btn btn-danger ms-2" onClick="return confirm('Delete this project?')">Delete</button>
              </form>

              @if($project->status == 'draft')
              <form method="POST" action="/dashboard/projects/{{ $project->id }}/publish" >
                @csrf
                @method('PATCH')
                <div class="control">
                <button type="submit" class="btn btn-success ms-2" onClick="return confirm('Publish this project??')">Publish</button>
              </form>
              @endif
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