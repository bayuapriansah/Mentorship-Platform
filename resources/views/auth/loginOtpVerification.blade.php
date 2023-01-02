@extends('layouts.index')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class=" card col-6 p-4 bg-light">
      @include('flash-message')
      <form method="post" action="{{ route('otp.getlogin') }}">
        @csrf
        
        <input type="hidden" name="user_id" value="{{$user_id}}">
        <input type="hidden" name="email" value="{{$email}}">
        <label for="otp" class="form-label">OTP Code</label>
        <input type="text" id="otp" name="otp" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">Login</button>
      </form>
    </div>
  </div>
</div>
@endsection