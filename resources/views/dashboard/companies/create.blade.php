@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Companies</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/companies" method="post">
          @csrf
          <div class="mb-3">
            <label for="inputname" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputname" name="name" value="{{old('name')}}">
            @error('name')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputaddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputaddress" name="address" value="{{old('address')}}">
            @error('address')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputemail" class="form-label">Email</label>
            <input type="text" class="form-control" id="inputemail" name="email" value="{{old('email')}}">
            @error('email')
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