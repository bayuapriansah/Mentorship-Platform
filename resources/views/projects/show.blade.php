@extends('layouts.index')
@section('content')
<div class="container">
  @include('flash-message')

  <div class="text-center mb-5">
    <h3>Detail Project</h3>
    <p></p>
    <ul class="nav nav-pills nav-fill">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Info</a>
        <p>{{$project->name}}</p>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Feed</a>
        <p>[Feed]</p>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Student's</a>
        <p>{{$project->student->name}}</p>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Library</a>
        <a href="/supportlib">Support Library</a>
      </li>
    </ul>
  </div>
</div>
@endsection