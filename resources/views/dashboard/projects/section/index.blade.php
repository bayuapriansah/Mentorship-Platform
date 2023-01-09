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
        @if($project->type == 'weekly')
        @php $max_task = 4 * $project->period @endphp
        *Max Task is {{$max_task}}
        @elseif($project->type == 'monthly')
        @php $max_task = 1 * $project->period @endphp
        *Max Task is {{$max_task}}
        @endif
      </h5>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/projects/{{$project->id}}" method="post">
          @csrf
          <div class="mb-3">
            <label for="inputsection" class="form-label">Description</label>
            <textarea name="description" id="{{$project_sections->count() != $max_task ? 'sectionDesc' : 'sectionDescDisable'}}" cols="30" rows="10">{{old('description')}}</textarea>
            @error('description')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary" {{$project_sections->count() == $max_task ? 'disabled' : ''}}>Submit</button>
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
        @include('flash-message')
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Task</th>
            <th>Description</th>
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
            <td>
              {{$project_section->description}}
              
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
            <td>

              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/edit" >Edit</a>
              <a class="btn btn-labele btn-primary " data-toggle="collapse" href="#collapseExample{{$no}}" role="button" aria-expanded="false" aria-controls="collapseExample">Show available subtask</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection" >Manage Subtask</a>
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