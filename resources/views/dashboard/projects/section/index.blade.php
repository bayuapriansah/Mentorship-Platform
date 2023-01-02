@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Sections for {{$project->name}}</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/projects/{{$project->id}}" method="post">
          @csrf
          <div class="mb-3">
            <label for="inputsection" class="form-label">Section Number</label>
            <input type="number" class="form-control" id="inputsection" name="section" value="{{old('section')}}">
            @error('section')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputsection" class="form-label">Description</label>
            <textarea name="description" id="problem" cols="30" rows="10">{{old('description')}}</textarea>
            @error('description')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Content Row -->
  <div class="row mt-4">
    <div class="col">
      <div class="card p-4">
        @include('flash-message')
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Section number</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($project_sections as $project_section)
          <tr>
            <td>{{$no}}</td>
            <td>{{$project_section->section}}</td>
            <td>{{$project_section->description}}</td>
            <td>

              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/edit" >Edit</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section/{{$project_section->id}}/subsection" >Manage Subsection</a>
              
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