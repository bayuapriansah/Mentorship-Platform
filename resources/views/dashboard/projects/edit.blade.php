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
            {{-- <input type="text" class="form-control" id="inputproblem" name="problem" value="{{$project->problem}}"> --}}
            <textarea name="problem" id="problem" cols="30" rows="10">{{$project->problem}}</textarea>

            @error('problem')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputtype" class="form-label">Task Progress</label>
            <select class="form-control form-select" id="inputtype" aria-label="Default select example" name="type">
              <option value="">--Select Task Progress--</option>
              <option value="weekly" {{$project->type == 'weekly' ? 'selected': ''}} >Weekly</option>
              <option value="monthly" {{$project->type == 'monthly' ? 'selected': ''}} >Monthly</option>
            </select>
            @error('type')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputperiod" class="form-label">Period</label>
            <div class="row">
              <div class="col">
                <input type="number" class="form-control" id="inputperiod" name="period" value="{{$project->period}}">
              </div>
              <div class="col">
                <label for="inputperiod" class="form-label" id="period_text_monthly">Month</label>
              </div>
            </div>

            @error('period')
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
          {{-- add institution dropdown --}}
          @if(Auth::guard('web')->check())
          <div class="mb-3">
            <label for="inputvalid" class="form-label">Institution</label>
            <select class="form-control form-select" id="inputInstitution" aria-label="Default select example" name="institution_id">
              <option value="{{$project->institution_id}}">{{ $GetInstituionData->where('id',$project->institution_id)->first()->institutions }}</option>
              @forelse($GetInstituionData as $ins)
              <option value="{{$ins->id}}">{{$ins->institutions}}</option>
              @empty
              <p>There is no Country Data</p>
              @endforelse
            </select><br>
            @error('institution')
                <p class="text-red-600 text-sm mt-1">
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