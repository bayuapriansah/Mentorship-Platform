@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Subtask</h1>
  </div>

  <div class="row">
    
    <div class="col">
      <div class="card p-4">
        @if($errors->any())
            {!! implode('', $errors->all('<div class="text-danger text-sm mt-1">:message</div>')) !!}
        @endif
        <form action="/dashboard/projects/{{$project_id}}/section/{{$section_id}}/subsection/{{$section_subsection->id}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="mb-3">
            <label for="inputcategory" class="form-label">Select Category</label>
            <select class="form-control form-select" id="inputcategory" aria-label="Default select example" name="category">
              <option value="">--Select Category--</option>
              <option value="video" {{$section_subsection->category == 'video' ? 'selected': ''}}>Video</option>
              <option value="reading" {{$section_subsection->category == 'reading' ? 'selected': ''}}>Reading</option>
              <option value="task" {{$section_subsection->category == 'task' ? 'selected': ''}}>Task</option>
            </select>
            @error('category')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3" id="filetype">
            <label for="inputfiletype" class="form-label">File type</label>
            <select class="form-control form-select" id="inputfiletype" aria-label="Default select example" name="inputfiletype">
              <option value="">--Select File type--</option>
              <option value="zip" {{$section_subsection->file_type  == 'zip' ? 'selected': ''}}>.zip</option>
              <option value="ipynb" {{$section_subsection->file_type == 'ipynb' ? 'selected': ''}}>.ipynb</option>
              <option value="pdf" {{$section_subsection->file_type == 'pdf' ? 'selected': ''}}>.pdf</option>
              <option value="doc" {{$section_subsection->file_type == 'doc' ? 'selected': ''}}>.doc or docx</option>
              <option value="ppt" {{$section_subsection->file_type == 'ppt' ? 'selected': ''}}>.ppt or pptx</option>
              <option value="none" {{$section_subsection->file_type == 'none' ? 'selected': ''}}>No need to upload file</option>
            </select>
            @error('inputfiletype')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>


          <div class="mb-3">
            <label for="" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="{{$section_subsection->title}}">
            @error('title')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputsection" class="form-label">Description</label>
            <textarea name="description" id="problem" cols="30" rows="10">{{$section_subsection->description}}</textarea>
            @error('description')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputfile1" class="form-label">File 1</label>
            <input type="file" class="form-control-file" id="inputfile1" name="file1">
           {{explode("/",$section_subsection->file1)[4]}}
          </div>
          <div class="mb-3">
            <label for="inputfile2" class="form-label">File 2</label>
            <input type="file" class="form-control-file" id="inputfile2" name="file2">
            @if($section_subsection->file2)
            {{explode("/",$section_subsection->file2)[4]}}
            @endif
          </div>
          <div class="mb-3">
            <label for="inputfile3" class="form-label">File 3</label>
            <input type="file" class="form-control-file" id="inputfile3" name="file3">
            @if($section_subsection->file3)
            {{explode("/",$section_subsection->file3)[4]}}
            @endif
          </div>
          <div class="mb-3">
            <label for="inputvideolink" class="form-label">Video</label>
            <input type="text" class="form-control" id="inputvideolink" name="video_link" value="{{$section_subsection->video_link}}">
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
   $(document).ready(function(){
    // $('#inviteMentors').hide();
    $('#filetype').hide();
    // console.log($('#inputcategory').val())
    var values = $("#inputcategory option:selected").val();

    if(values == "task"){
      $('#filetype').show();
    }else{
      $('#filetype').hide();
    }

    $("#inputcategory").change(function(){
      var values = $("#inputcategory option:selected").val();
      if(values == "task"){
        $('#filetype').show();
      }else{
        $('#filetype').hide();
      }
    });
    
  });
</script>
@endsection