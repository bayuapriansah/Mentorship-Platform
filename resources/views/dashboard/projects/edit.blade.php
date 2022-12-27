@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Projects</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/projects/{{$project->id}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          <input type="hidden" value="{{$project->id}}" name="id">
          <div class="mb-3">
            <label for="inputname" class="form-label">Project Name</label>
            <input type="text" class="form-control" id="inputname" name="name" value="{{$project->name}}">
            @error('name')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputdomain" class="form-label">Project Domain</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="project_domain">
              <option value="">--Select Project Domain--</option>
              <option value="nlp" {{$project->project_domain == 'nlp'? 'selected':''}}>NLP</option>
              <option value="statistical" {{$project->project_domain == 'statistical'? 'selected':''}}>Statistical</option>
              <option value="computer_vision" {{$project->project_domain == 'computer_vision'? 'selected':''}}>Computer Vision</option>
            </select>
            @error('project_domain')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="inputproblem" class="form-label">Problem</label>
            <input type="text" class="form-control" id="inputproblem" name="problem" value="{{$project->problem}}">
            @error('problem')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputresources" class="form-label">Resources</label>
            <input type="file" class="form-control-file" id="inputresources" name="resources">
            {{explode('/',$project->resources)[2]}}
          </div>

          <div class="mb-3">
            <label for="inputvalid" class="form-label">Valid days</label>
            <input type="number" class="form-control" id="inputvalid" name="valid_time" value="{{$project->valid_time}}">
            @error('valid_time')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          @if(Auth::guard('web')->check())
          <div class="mb-3">
            <label for="inputvalid" class="form-label">Company</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="company_id">
              <option value="">--Select Project Domain--</option>
              @foreach($companies as $company)
              <option value="{{$company->id}}" {{$company->id == $project->company_id? 'selected':''}} >{{$company->name}}</option>
              @endforeach
            </select>
            @error('company_id')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          @endif
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection