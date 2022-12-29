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
            <input type="text" class="form-control" id="inputname" name="name" value="{{old('name')}}">
            @error('name')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputdomain" class="form-label">Project Domain</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="domain">
              <option value="">--Select Project Domain--</option>
              <option value="nlp" {{old('domain') == 'nlp' ? 'selected': ''}}>NLP</option>
              <option value="statistical" {{old('domain') == 'statistical' ? 'selected': ''}}>Statistical</option>
              <option value="computer_vision" {{old('domain') == 'computer_vision' ? 'selected': ''}}>Computer Vision</option>
            </select>
            @error('domain')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="inputproblem" class="form-label">Problem</label>
            {{-- <input type="text" class="form-control" id="inputproblem" name="problem" value="{{old('problem')}}"> --}}
            <textarea name="problem" id="problem" cols="30" rows="10">{{old('problem')}}</textarea>
            @error('problem')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputresources" class="form-label">Resources</label>
            <input type="file" class="form-control-file" id="inputresources" name="resources">
            @error('resources')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputvalid" class="form-label">Valid days</label>
            <input type="number" class="form-control" id="inputvalid" name="valid_time" value="{{old('valid_time')}}">
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
              <option value="{{$company->id}}" {{old('company_id') == $company->id ? 'selected': ''}} >{{$company->name}}</option>
              @endforeach
            </select>
            @error('company_id')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          @endif
          
          <div class="mb-3">
            <input type="submit" class="btn btn-primary" name="publish" value="Publish Project">
            <input type="submit" class="btn btn-success" name="draft" value="Save as Draft">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection