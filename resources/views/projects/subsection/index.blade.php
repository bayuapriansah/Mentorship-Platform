@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    @include('flash-message')
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>  

  <div class="row">
    {{-- {{$section_subsection->projectSection->project->name}} --}}
    <div class="col-9">
      <div class="row">
        <div class="col">
          {!!$section_subsection->description!!}
        </div>
      </div>
      <div class="row">
        <div class="col">
          Resource
          <ul>
            <li>
              <a href="{{asset('storage/'.$section_subsection->file1)}}">file1</a>
            </li>
            @if($section_subsection->file2 != null)
            <li>
              <a href="{{asset('storage/'.$section_subsection->file2)}}">file2</a>
            </li>
            @endif
            @if($section_subsection->file3 != null)
            <li>
              <a href="{{asset('storage/'.$section_subsection->file3)}}">file3</a>
            </li>
            @endif
            @if($section_subsection->video_link != null)
            <iframe width="420" height="315" src="{{$section_subsection->video_link}}" class="mt-4"></iframe>
            @endif
          </ul>
          @if(Route::is('projects.appliedSubmission'))
            @if($section_subsection->submission == null)
            <div class="row">
              <div class="col">
                <form action="/projects/{{$student_id}}/applied/{{$project_id}}/detail/{{$section_subsection->id}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <input type="file" class="form-control-file" id="inputsubmission" name="submission">
                  </div>
                  @error('submission')
                    <p class="text-danger text-sm mt-1">
                      {{$message}}
                    </p>
                  @enderror
                  <button type="submit" class="btn btn-primary">Upload Submission</button>
                </form>
              </div>
            </div>
            @else
            <strong>[Submitted]</strong>
            @endif
          @endif
        </div>
      </div>
    </div>
    <div class="col">
      @include('projects.sidebar')
    </div>
  </div>
</div>
@endsection