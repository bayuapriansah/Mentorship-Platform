@extends('layouts.index')
@section('content')
<div class="container">
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
  @include('flash-message')
  <form action="/register" method="post" id="register">
    @csrf

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" class="form-control" name="email" value="{{old('email')}}">
      @error('email')
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
      <label for="state" class="form-label">State</label>
      <input type="text" id="state" class="form-control" name="state" value="{{old('state')}}">
      @error('state')
          <p class="text-danger text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="country" class="form-label">Country</label>
      <input type="text" id="country" class="form-control" name="country" value="{{old('country')}}">
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