@extends('layouts.index')
@section('content')
<div class="container">
  @include('flash-message')
  <div class="row">
    <div class="col">
      <h1>{{$project->name}}</h1>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col">
      <p class="text-bold mb-0">Domain : </p>
      <p>{{$project->project_domain}}</p>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Problem : </p>
      <p>{!! $project->problem !!}</p>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Resource Document : </p>
      <p><a href="{{asset('storage/'. $project->resources)}}">Resource file</a></p>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Valid Time : </p>
      <p>{{$project->valid_time}} days</p>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col">
      <p class="text-bold mb-0">{{$project->company->name}}</p>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col">
      <form method="POST" action="{{ $project->id }}/apply" >
        @csrf
        <div class="control">
          <button type="submit" class="btn btn-success">Apply</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection