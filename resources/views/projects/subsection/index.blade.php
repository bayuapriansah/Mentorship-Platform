@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    @include('flash-message')
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <div class="row">
    {{$section_subsection->projectSection->project->name}}
  </div>
</div>
@endsection