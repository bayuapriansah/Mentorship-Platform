@extends('layouts.index')
@section('content')
<div class="container">

  <div class="text-center mb-5">
    <h1>Student Profile</h1>
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
  </div>
  @include('flash-message')
  <form action="#" method="post" id="mentorregister">
    @csrf
    <div class="row">
      <div class="col">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" id="first_name" class="form-control" name="first_name" value="{{old('first_name')}}">
        @error('first_name')
            <p class="text-danger text-sm mt-1">
              {{$message}}
            </p>
        @enderror
      </div>
      <div class="col">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" id="last_name" class="form-control" name="last_name" value="{{old('last_name')}}">
        @error('last_name')
            <p class="text-danger text-sm mt-1">
              {{$message}}
            </p>
        @enderror
      </div>
    </div>

    <div class="mb-3">
      <label for="">Date of birth</label>
      <input type="date" class="form-control" name="date_of_birth" value="{{old('date_of_birth')}}">
      @error('date_of_birth')
            <p class="text-danger text-sm mt-1">
              {{$message}}
            </p>
        @enderror
    </div>


    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="text" name="email" id="disabledTextInput" class="form-control" value="[email]" disabled>
      @error('email')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Gender</label>
      <input type="text" name="gender" id="disabledTextInput" class="form-control" value="[gender]" disabled>
      @error('gender')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">State</label>
      <input type="text" name="state" id="disabledTextInput" class="form-control" value="[state]" disabled>
      @error('state')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Country</label>
      <input type="text" name="country" id="disabledTextInput" class="form-control" value="[country]" disabled>
      @error('country')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>
    
    <div class="mb-3">
      <!-- <label for="g-recaptcha-response" class="form-label">Captcha</label> -->
      <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}"></div>
      <!-- Here lies google recaptcha 😅 -->
      <div class="col md-3">
        @if(Session::has('g-recaptcha-response'))
        <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
        {{Session::get('g-recaptcha-response')}}
        </p>
        @endif
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
@endsection
@section('more-js')

@endsection