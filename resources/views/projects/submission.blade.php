@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <h1 class="mb-4">Submission</h1>
  @include('flash-message')
  <div class="row">
    <div class="col-9">
      <div class="row">
        <div class="col">
          <div class="card bg-light p-4 text-decoration-none text-dark">
            <div class="row">
              <div class="col-10">
                <h3>{{$enrolled_project->name}}</h3>
              </div>
              <div class="col-2">
                {{-- <a class="btn btn-primary" href="/projects/{{Auth::guard('student')->user()->id}}/applied/{{$project->id}}/submission" role="button">Submission</a> --}}
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>{{$enrolled_project->company->name}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>applied at {{$enrolled_project->created_at->toDateString()}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p> {!!$enrolled_project->problem!!}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Domain : {{$enrolled_project->project_domain}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <form action="/projects/{{Auth::guard('student')->user()->id}}/applied/{{$enrolled_project->id}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <input type="file" class="form-control-file" id="inputsubmission" name="submission">
                  </div>
                  <button type="submit" class="btn btn-primary">Upload Submission</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('projects.sidebar')
  </div>
  
  {{-- <div class="card mt-5 text-center bg-light">
    
  </div> --}}

  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Twitter-logo.svg" alt="" width="30px" height="30px">
    <p>Checkout Sponsoring Company</p>
  </div>
  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <p>Download the dataset here</p>
  </div>

  

  <h2 class="mt-5">Get help for your project</h2>
  <a href="#" class="link-primary">Link to discussion forum</a><br>
  <a href="#" class="link-primary">Link to support document library</a>
</div>
@endsection