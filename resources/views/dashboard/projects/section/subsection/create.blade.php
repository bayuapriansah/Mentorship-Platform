@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Subtask </h1>
  </div>

  <div class="row">
    
    <div class="col">
      <div class="card p-4">
        {{-- @if($errors->any())
            {!! implode('', $errors->all('<div class="text-danger text-sm mt-1">:message</div>')) !!}
        @endif --}}
        
        <form action="/dashboard/projects/{{$project->id}}/section/{{$section->id}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="inputsection" class="form-label">Description</label>
            <textarea name="description" id="problem" cols="30" rows="10">{{old('description')}}</textarea>
            @error('description')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputfile1" class="form-label">File 1</label>
            <input type="file" class="form-control-file" id="inputfile1" name="file1">
            @error('file1')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputfile2" class="form-label">File 2</label>
            <input type="file" class="form-control-file" id="inputfile2" name="file2">
          </div>
          <div class="mb-3">
            <label for="inputfile3" class="form-label">File 3</label>
            <input type="file" class="form-control-file" id="inputfile3" name="file3">
          </div>
          <div class="mb-3">
            <label for="inputvideolink" class="form-label">Video</label>
            <input type="text" class="form-control" id="inputvideolink" name="video_link" value="{{old('video_link')}}">
            @error('video_link')
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