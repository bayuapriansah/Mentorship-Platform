@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <a href="/dashboard/projects/{{$project->id}}/section" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Back</a>
  </div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Attachment</h1>
      <a href="create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Add Attachment</a>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col card p-4">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>File type</th>
            <th>File 1</th>
            <th>File 2</th>
            <th>File 3</th>
            {{-- <th>Video link</th> --}}
            {{-- <th>Status</th> --}}
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($project_subsections as $project_subsection)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project_subsection->title}}</td>
            <td>{{$project_subsection->category}}</td>
            <td>{{$project_subsection->file_type}}</td>
            <td>
              @if($project_subsection->file1)
                <a href="{{asset('storage/'.$project_subsection->file1)}}">file1</a>
              @else
                [None]
              @endif
            </td>
            <td>
              @if($project_subsection->file2)
                <a href="{{asset('storage/'.$project_subsection->file2)}}">file2</a>
              @else
                [None]
              @endif
              </td>
            <td>
              @if($project_subsection->file3)
                <a href="{{asset('storage/'.$project_subsection->file3)}}">file3</a>
              @else
                [None]
              @endif
              </td>
            {{-- <td>{{$project_subsection->video_link ? $project_subsection->video_link : "None"}}</td> --}}
            {{-- <td>{{$project->is_submit}}</td> --}}
            <td>

              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection/{{$project_subsection->id}}/edit" >Edit</a>

              <form method="POST" action="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection/{{$project_subsection->id}}" >

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
