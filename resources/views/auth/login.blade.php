@extends('layouts.index')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class=" card col-6 p-4 bg-light">
      @include('flash-message')
      <form method="post" action="{{ route('otp.generate') }}">
        @csrf
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">{{__('Generate OTP')}}</button>
      </form>
    </div>
  </div>
</div>
@endsection