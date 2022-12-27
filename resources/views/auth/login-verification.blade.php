@extends('layouts.index')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class=" card col-6 p-4 bg-light">
      @include('flash-message')
      <form method="post" action="">
        @csrf
        <label for="otp" class="form-label">otp</label>
        <input type="text" id="otp" name="otp" class="form-control">
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <button type="submit" class="btn btn-primary mt-2">{{__('LOGIN')}}</button>
      </form>
    </div>
  </div>
</div>
@endsection