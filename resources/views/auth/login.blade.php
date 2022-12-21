@extends('layouts.index')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class=" card col-6 p-4 bg-light">
      <form method="post" action="/authenticate">
        @csrf
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control">

        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection