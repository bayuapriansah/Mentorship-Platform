@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="/dashboard/projects/" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>
  <div class="d-sm-flex-row align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage task for {{$project->name}}</h1>
      <h5>
        {{-- @dd($project->period) --}}

      </h5>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/projects/{{$project->id}}" method="post">
          @csrf

          <div class="mb-3">
            <label for="inputtitle" class="form-label">Title Section</label>
            <input type="text" class="form-control" id="inputtitle" name="title" value="{{old('title')}}">
            @error('title')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputsection" class="form-label">Description</label>
            <textarea name="description" id="sectionDesc" cols="30" rows="10">{{old('description')}}</textarea>
            @error('description')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3" id="filetype">
            <label for="inputfiletype" class="form-label">File type</label>
            <select class="form-control form-select" id="inputfiletype" aria-label="Default select example" name="inputfiletype">
              <option value="">--Select File type--</option>
              <option value="zip" {{old('inputfiletype') == 'zip' ? 'selected': ''}}>.zip</option>
              <option value="pdf" {{old('inputfiletype') == 'pdf' ? 'selected': ''}}>.pdf</option>
              <option value="docx" {{old('inputfiletype') == 'doc' ? 'selected': ''}}>.docx</option>
              <option value="pptx" {{old('inputfiletype') == 'ppt' ? 'selected': ''}}>.pptx</option>
            </select>
            @error('inputfiletype')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputsection" class="form-label">Task Duration</label>
            <input type="number" class="form-control" id="" name="duration" value="{{old('duration')}}">
            @error('duration')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary" >Submit</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Content Row -->
  <div class="row mt-4">
    <div class="col">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Task Lists</h1>
      </div>
      <div class="card p-4">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Task</th>
            <th>Title</th>
            <th>Description</th>
            <th>Submission type</th>
            <th>Duration</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($project_sections->sortBy('section') as $project_section)
          <tr>
            <td>
              {{$no}}
              <div class="btn-group" role="group" aria-label="Basic example">
                {{-- UP --}}
                {!! Form::open(['route' => ['dashboard.projects.SectionUp', [$project->id,$project_section->id]]]) !!}
                <button type="submit" class="btn btn-outline-primary mr-1">
                  <i class="fa-solid fa-arrow-up"></i>
                </button>
                {!! Form::close() !!}

                {{-- Down --}}
                {!! Form::open(['route' => ['dashboard.projects.SectionDown', [$project->id,$project_section->id]]]) !!}
                <button type="submit" class="btn btn-outline-primary">
                  <i class="fa-solid fa-arrow-down"></i>
                </button>
                {!! Form::close() !!}

              </div>
            </td>
            <td>{{$project_section->section}}</td>
            <td>{{substr($project_section->title,0,20)}}...</td>
            <td>
              {{substr($project_section->description,0,70)}}...

              <div class="collapse my-3" id="collapseExample{{$no}}">
                <div class="card card-body">
                 <ul class="m-0">
                  @foreach($project_section->sectionSubsections as $subsection)
                    <li>{{$subsection->title}}</li>
                  @endforeach
                 </ul>
                </div>
              </div>
            </td>
            <td>{{$project_section->file_type}}</td>
            <td>{{$project_section->duration}}</td>
            <td>

              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/edit" >Edit</a>
              <a class="btn btn-labele btn-primary " data-toggle="collapse" href="#collapseExample{{$no}}" role="button" aria-expanded="false" aria-controls="collapseExample">Show available attachment</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection" >Manage attachment</a>
              <form method="POST" action="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}" >
                @csrf
                @method('DELETE')
                <div class="control">
                <button type="submit" class="btn btn-danger ms-2" onClick="return confirm('Delete this project?')">Delete</button>
              </form>

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
