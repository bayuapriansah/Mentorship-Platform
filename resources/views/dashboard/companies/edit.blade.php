@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Companies</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/companies/{{$company->id}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="mb-3">
            <label for="inputname" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputname" name="name" value="{{$company->name}}">
            @error('name')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <div class="mb-3">
            <label for="inputaddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputaddress" name="address" value="{{$company->address}}">
            @error('address')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputemail" class="form-label">Email</label>
            <input type="text" class="form-control" id="inputemail" name="email" value="{{$company->email}}">
            @error('email')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputlogo" class="form-label">Company logo</label><br>
            <img src="{{asset('storage/'.$company->logo)}}" alt="" style="width: 350px; height: 230px;">
            <input type="file" class="form-control-file" id="inputlogo" name="logo">
            <label for="inputlogo" class="form-label">*Max file size is 5MB</label><br>
            <label for="inputlogo" class="form-label">*Image Extension is png, jpg or jpeg</label>
            @error('logo')
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