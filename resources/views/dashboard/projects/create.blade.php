@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Projects</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/projects" method="post" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="inputname" class="form-label">Project Name</label>
            <input type="text" class="form-control" id="inputname" name="name">
          </div>

          <div class="mb-3">
            <label for="inputdomain" class="form-label">Project Domain</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="domain">
              <option value="">--Select Project Domain--</option>
              <option value="nlp">NLP</option>
              <option value="statistical">Statistical</option>
              <option value="computer_vision">Computer Vision</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="inputproblem" class="form-label">Problem</label>
            <input type="text" class="form-control" id="inputproblem" name="problem">
          </div>

          <div class="mb-3">
            <label for="inputresources" class="form-label">Resources</label>
            <input type="file" class="form-control-file" id="inputresources" name="resources">
          </div>

          <div class="mb-3">
            <label for="inputvalid" class="form-label">Valid days</label>
            <input type="number" class="form-control" id="inputvalid" name="valid_time">
          </div>
          @if(Auth::guard('web')->check())
          <div class="mb-3">
            <label for="inputvalid" class="form-label">Company</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="company_id">
              <option value="">--Select Project Domain--</option>
              @foreach($companies as $company)
              <option value="{{$company->id}}">{{$company->name}}</option>
              @endforeach
            </select>
          </div>
          @endif

          <input type="submit" class="btn btn-primary" name="publish" value="Publish Project">
          <input type="submit" class="btn btn-success" name="draft" value="Save as Draft">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection