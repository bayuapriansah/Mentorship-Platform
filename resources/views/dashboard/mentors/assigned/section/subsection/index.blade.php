@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Subsection</h1>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col card p-4">
      @include('flash-message')
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Description</th>
            <th>Student Submission</th>
            {{-- <th>Status</th> --}}
            <th>Grade</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($project_subsections as $project_subsection)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project_subsection->description}} {{$project->id}}</td>
            @if($project_subsection->submission === null)
            <td>Student has not submit yet</td>
            @else
            <td><a href="{{asset('storage/'.$project_subsection->submission->file)}}">submission {{$project_subsection->submission->id}}</a></td>
            @endif
            <td>

              {{-- <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection/{{$project_subsection->id}}/edit" >Edit</a>

              <form method="POST" action="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection/{{$project_subsection->id}}" >
                
                @csrf
                @method('DELETE')
                <div class="control">
                <button type="submit" class="btn btn-danger ms-2" onClick="return confirm('Delete this project?')">Delete</button>
              </form> --}}
              {{-- @dd($project_subsection->submission) --}}
              @if($project_subsection->submission == null)
                Student has not submit yet

              @elseif($project_subsection->submission->grade !=null)
                {{$project_subsection->submission->grade->score}}
              @elseif($project_subsection->submission != null )
              <form action="/dashboard/grade/{{$project_subsection->submission->id}}" method="post">
                @csrf
                <input type="number" class="form-control" name="grade">
                <button type="submit" class="btn btn-success mt-2 float-right" onClick="return confirm('Grade this submission?')">Submit</button>
              </form>
              @endif
              {{-- @if($project_subsection->submission !=null)
                {{$project_subsection->submission->grade->score}}
              @elseif($project_subsection->submission == null)
              <form action="/dashboard/grade/{{$project_subsection->submission->id}}" method="post">
                @csrf
                <input type="number" class="form-control" name="grade">
                <button type="submit" class="btn btn-success mt-2 float-right" onClick="return confirm('Grade this submission?')">Submit</button>
              </form>
              @endif --}}
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