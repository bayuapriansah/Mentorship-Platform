@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Institutions</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/institutions" method="post">
          @csrf
          <div class="mb-3">
            <label for="inputname" class="form-label">Institution Name</label>
            <input type="text" class="form-control" id="inputname" name="name" value="{{old('name')}}">
            @error('name')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="inputCity" name="city" value="{{old('city')}}">
            @error('city')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputState" class="form-label">State</label>
            <input type="text" class="form-control" id="inputState" name="state" value="{{old('state')}}">
            @error('state')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection