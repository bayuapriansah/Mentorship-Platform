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
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Feed</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Student's</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Libarary</a>
      </li>
    </ul>
  </div>
</div>
@endsection