@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    <img src="{{asset('assets/img/heroBackground.jpg')}}" alt="" width="100%">
  </div>

  <h1>My Project</h1>
  
  @foreach($projects as $project)
  <a href="/projects/{{$project->id}}" class="text-decoration-none text-success">
    <div class="row mb-2">
      <div class="card col p-4 bg-light">
        <h2>{{$project->name}}</h2>
        <h4>Company name : {{$project->company->name}}</h4>
      </div>
    </div>
  </a>
  @endforeach
  
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

  <div class="mt-5">
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <h2 class="mt-5">Get help for your project</h2>
  <a href="#" class="link-primary">Link to discussion forum</a><br>
  <a href="#" class="link-primary">Link to support document library</a>
</div>
@endsection