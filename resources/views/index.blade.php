@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Custom jumbotron</h1>
      <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
      <button class="btn btn-primary btn-lg" type="button">Example button</button>
    </div>
  </div>

  <div class="text-center mb-5">
    <h1>Welcome to the AI for Workforce Platform</h1>
    <h5 class="mt-5">Jump to the current AI project, sponsored by [Partner Name]</h5>
    <button type="button" class="btn btn-primary mb-2">Project Details</button>
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
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
@endsection
