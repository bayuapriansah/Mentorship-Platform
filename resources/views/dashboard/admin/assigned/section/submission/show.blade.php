@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Student Submission</h1>
  </div>
  <div class="card p-4">
    @if ($submission)
        <a href="{{asset('storage/'.$submission->file)}}">Download Submission</a>
    @else
        Student dont submit yet
    @endif
  </div>

</div>
@endsection
