@extends('layouts.index')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    @include('flash-message')
    <div class=" card col-6 p-4 bg-light">
      <form method="post" action="{{ route('otp.generate') }}">
        @csrf

        <h3>LOGIN</h3>
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control">
        <label for="otp" class="form-label">OTP Code</label>
        <input type="text" id="otp" name="otp" class="form-control">
        <button type="button" class="btn btn-primary mt-2">Log In</button>
        <button type="submit" class="btn btn-primary mt-2">Get OTP</button>
      </form>
    </div>
  </div>
</div>
@endsection