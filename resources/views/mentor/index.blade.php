@extends('layouts.index')
@section('content')
<div class="container">

  <div class="text-center mb-5">
    <h1>Mentor Register</h1>
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
      <label for="state" class="form-label">Email</label>
      <input type="text" name="email" id="disabledTextInput" class="form-control" value="mentor@mail.com" disabled>
      @error('email')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="company" class="form-label">Company</label>
      <input type="text" name="company" id="disabledTextInput" class="form-control" value="Joseph n Co Ltd." disabled>
      @error('company')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="state" class="form-label">State</label>
      <input type="text" name="state" id="disabledTextInput" class="form-control">
      @error('state')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="country" class="form-label">Country</label>
      <input type="text" name="country" id="disabledTextInput" class="form-control">
      @error('country')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3" id="gender">
      <label for="gender" class="form-label">Gender</label>
      <select class="form-select" aria-label="Default select example" name="gender">
        <option value="">--Select Gender--</option>
        <option value="male" {{old('gender') == 'male' ? 'selected' : ''}}>Male</option>
        <option value="female" {{old('gender') == 'female' ? 'selected' : ''}}>Female</option>
      </select>
      @error('gender')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="position" class="form-label">Position</label>
      <input type="text" name="position" id="disabledTextInput" class="form-control">
      @error('position')
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