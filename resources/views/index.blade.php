@extends('layouts.index')
@section('content')
<div class="container">
  @include('flash-message')
  <div class="p-5 mb-4 text-center">
    <img src="{{asset('assets/img/heroBackground.jpg')}}" alt="" width="100%">
  </div>

  <div class="text-center mb-5">
    <h1>Welcome to the AI for Workforce Platform</h1>
    <h5 class="mt-5">Jump to the current AI project, sponsored by [Partner Name]</h5>
    <a href="{{route('projects.index')}}" class="btn btn-primary mb-2">Project Details</a>
    <img src="https://via.placeholder.com/150" class="text-center" width="100%" height="300px">

    <h5 class="mt-5">Info Page</h5>
    <p>Details on the AI for Workforce Program</p>
    <p>Details on the Simulated Internship</p>
    <img src="https://via.placeholder.com/150" class="text-center" width="100%" height="300px">

    {{-- register form --}}

  </div>

  <form action="/register" method="post">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" id="name" class="form-control" name="name">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="text" id="email" class="form-control" name="email">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" class="form-control" name="password">
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <select class="form-select" aria-label="Default select example" name="role">
        <option selected>--Select Role--</option>
        <option value="student">Student</option>
        <option value="partner">Partner</option>
      </select>
    </div>
    
    {{-- <div class="mb3">
      <label for="date" class="form-label">Date of Birth</label>
      <div class="col-5">
        <div class="input-group date" id="datepicker">
          <input type="text" class="form-control" id="date" name="date">
          <span class="input-group-append">
            <span class="input-group-text bg-light d-block">
              <i class="fa fa-calendar"></i>
            </span>
          </span>
        </div>
      </div>
    </div> --}}

    <div class="mb3">
      {{-- <label for="g-recaptcha-response" class="form-label">Captcha</label> --}}
      {{-- {{!! htmlFormSnippet() !!}} --}}
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
@endsection
