@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Task</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/projects/{{$project_id}}/section/{{$section_id}}" method="post">
          @csrf
          @method('patch')

          <div class="mb-3">
            <label for="inputtitle" class="form-label">Title Section</label>
            <input type="text" class="form-control" id="inputtitle" name="title" value="{{$project_section->title}}">
            @error('title')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputfile1" class="form-label">Description</label>
            <textarea name="desc" id="problem" cols="30" rows="10">{{$project_section->description}}</textarea>
            @error('desc')
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
</div>
@endsection

@section('more-js')
<script>
</script>
@endsection