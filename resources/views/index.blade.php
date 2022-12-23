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
      <label for="role" class="form-label">Role</label>
      <select class="form-select" aria-label="Default select example" name="role" id="role">
        <option>--Select Role--</option>
        <option value="student">Student</option>
        <option value="mentor">Mentor</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" class="form-control" name="email">
    </div>

    <div class="mb-3" id="name">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name">
    </div>

    <div class="mb-3" id="institution">
      <label for="institution" class="form-label">Institution Name</label>
      <input type="text" class="form-control" name="institution_name">
    </div>

    <div class="mb-3" id="position">
      <label for="position" class="form-label">Position</label>
      <select class="form-select" aria-label="Default select example" name="position">
        <option selected value="">--Select Position--</option>
        <option value="staff">Staff</option>
        <option value="supervisor">Supervisor</option>
        <option value="ceo">Ceo</option>
      </select>
    </div>

    <div class="mb-3" id="gender">
      <label for="gender" class="form-label">Gender</label>
      <select class="form-select" aria-label="Default select example" name="gender">
        <option selected value="">--Select Gender--</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="state" class="form-label">State</label>
      <input type="text" id="state" class="form-control" name="state">
    </div>

    <div class="mb-3">
      <label for="country" class="form-label">Country</label>
      <input type="text" id="country" class="form-control" name="country">
    </div>
    
    <div class="mb-3">
      <!-- <label for="g-recaptcha-response" class="form-label">Captcha</label> -->
      <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}"></div>
      <!-- Here lies google recaptcha 😅 -->
      <div class="col md-3">
        @if(Session::has('g-recaptcha-response'))
        <p class="alert {{Session::get('alert-class', 'alert-info')}}">
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
<script>
  $(document).ready(function(){
    $('#name').hide();
    $('#institution').hide();
    $('#position').hide();
    $('#role').on('click', function(){
      // console.log($('#role option:selected').val());
      if($('#role option:selected').val()=='student'){
        $('#name').hide();
        $('#gender').show();
        $('#institution').hide();
        $('#position').hide();
      }else if($('#role option:selected').val()=='mentor'){
        $('#name').show();
        $('#gender').hide();
        $('#institution').show();
        $('#position').show();
      }
    })
  });
</script>
@endsection