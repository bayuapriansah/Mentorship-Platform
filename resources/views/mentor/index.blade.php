@extends('layouts.index')
@section('content')
<section id="register" class="w-full">
    <div class="bg-darker-blue">
      <div class="max-w-[1366px] mx-auto px-16 py-10 grid grid-cols-12 gap-11 grid-flow-col ">
        <div class="col-span-7 relative">
          <h1 class="font-bold text-white text-3xl leading-10 relative z-20 pb-7">Complete Registration</h1>
          <p class="m-0 text-light-blue">Fill out the form below to complete registration as supervisor.</p>
          <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 -top-2 ">
        </div>
        <div class="col-start-10 col-span-4 relative ">
        </div>
      </div>
    </div>
    <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col">
      <div class="col-span-6">
          {{-- reg state 1 if we access register from email completion register --}}
          <form action="{{ route('supervisor.registerAuth',[$email]) }}" method="post" id="register">
              @csrf

              <input type="email" class="text w-full border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('email') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{ $checkMentor->email }}" placeholder="Email *" id="email" name="email" readonly><br>
              @error('email')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror

              <div class="flex justify-between mt-4">
                <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="firstname" type="text" value="{{old('first_name')}}" placeholder="First Name *" name="first_name" required><br>
                @error('first_name')
                    <p class="text-red-600 text-sm mt-1">
                      {{$message}}
                    </p>
                @enderror

                <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="lastname" type="text" value="{{old('last_name')}}" placeholder="Last Name *" name="last_name" required><br>
                @error('last_name')
                    <p class="text-red-600 text-sm mt-1">
                      {{$message}}
                    </p>
                @enderror
              </div>

                <select id="sex" class="border border-light-blue w-full rounded-lg mt-4 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none" name="sex" required>
                  <option value="" class="" hidden>Sex *</option>
                  <option value="male" {{old('sex') == 'male' ? 'selected' : ''}}>Male</option>
                  <option value="female" {{old('sex') == 'female' ? 'selected' : ''}}>Female</option>
                </select><br>
                @error('sex')
                    <p class="text-red-600 text-sm mt-1">
                      {{$message}}
                    </p>
                @enderror

              <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="institution" required>
                <option value="{{ $checkMentor->institution_id }}" selected>{{ $checkMentor->institution->name }}</option>
              </select><br>
              @error('institution')
                  <p class="text-red-600 text-sm mt-1">
                    {{ $message}}
                  </p>
              @enderror

              <div class="flex justify-between mt-4">
                <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 bg-gray-300 cursor-not-allowed focus:outline-none" id="ForCountry" type="text" value="{{old('country')}}" placeholder="Country *" name="country" readonly required>
                <br>
                @error('country')
                    <p class="text-red-600 text-sm mt-1">
                      {{$message}}
                    </p>
                @enderror

                <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight bg-gray-300 cursor-not-allowed focus:outline-none" id="ForState" type="text" value="{{old('state')}}" placeholder="State *" name="state" readonly required>
                <br>
                @error('state')
                    <p class="text-red-600 text-sm mt-1">
                      {{$message}}
                    </p>
                @enderror
              </div>

              <input type="password" class="text w-full border border-light-blue rounded-lg h-11 py-2 mt-4 px-4 text-lightest-grey::placeholder leading-tight {{old('password') != null ? 'border-red-500' : ''}} focus:outline-none"" placeholder="Password" id="password" name="password"><br>
              @error('password')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror

              <input type="password" class="text w-full border border-light-blue rounded-lg h-11 py-2 mt-4 px-4 text-lightest-grey::placeholder leading-tight {{old('password_confirmation') != null ? 'border-red-500' : ''}} focus:outline-none"" placeholder="Retype Password" id="password_confirmation" name="password_confirmation"><br>
              <div id="pass_alert"></div>
              @error('password_confirmation')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror

              <div class="g-recaptcha mt-4" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                @if(Session::has('g-recaptcha-response'))
                  <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
                  {{Session::get('g-recaptcha-response')}}
                  </p>
                @endif
              <div class="flex items-center mt-4">
                <input type="checkbox" class="checked:bg-blue-500 mr-4" name="tnc" required>
                <p class="text-sm font-normal leading-4">I accept the <span class="text-dark-blue text-sm font-normal leading-4" >Terms & Conditions and Privacy Policies</span></p>
              </div>
              <div class="mt-4">
                @include('flash-message')
              </div>
              <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Sign Up</button>
            </form>
      </div>
      <div class="col-start-7 col-span-6 relative">
        <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
        <img src="{{asset('assets/img/home2.png')}}" class="relative z-20" alt="">

        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
        <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
        <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->

      </div>
    </div>
  </section>
@endsection
@section('more-js')
<script>
  $(document).ready(function () {
      $('#inputInstitution').on('change', function () {
          var institutionVal = this.value;
          var base_url = window.location.origin;
          $.ajax({
              url: base_url+"/api/institution/"+institutionVal,
              contentType: "application/json",
              dataType: 'json',
              success: function (result) {
                // console.log(institutionVal);
                $('#ForCountry').val(result.countries);
                $('#ForState').val(result.states);
              }
          });
        }).trigger('change'); // Trigger the change event to make the AJAX request on page load

        $('#password_confirmation').on('input', function() {
        var password = $('#password').val();
        var password_confirmation = $(this).val();
        var hasUpperCase = false;
        var hasSymbol = false;
        var errorMessage = '';

        if (password.length < 8) {
            errorMessage = 'Password must be at least 8 characters long';
        } else {
            for (var i = 0; i < password.length; i++) {
                if (!hasUpperCase && password[i].match(/[A-Z]/)) {
                    hasUpperCase = true;
                }
                if (!hasSymbol && password[i].match(/[!@#$%^&*]/)) {
                    hasSymbol = true;
                }
            }
            if (!hasUpperCase) {
                errorMessage = 'Password must contain at least one uppercase letter';
            } else if (!hasSymbol) {
                errorMessage = 'Password must contain at least one symbol (!@#$%^&*)';
            }
        }

        if (password != password_confirmation) {
            $('#password').removeClass('border-green-500').addClass('border-red-500');
            $('#password_confirmation').removeClass('border-green-500').addClass('border-red-500');
            $('#pass_alert').html('<p class="text-red-600 text-sm mt-1">Passwords do not match</p>');
        } else if (errorMessage == '') {
            $('#password').removeClass('border-red-500').addClass('border-green-500');
            $('#password_confirmation').removeClass('border-red-500').addClass('border-green-500');
            $('#pass_alert').html('<p class="text-green-600 text-sm mt-1">Passwords match</p>');
        } else {
            $('#password').removeClass('border-green-500').addClass('border-red-500');
            $('#password_confirmation').removeClass('border-green-500').addClass('border-red-500');
            $('#pass_alert').html('<p class="text-red-600 text-sm mt-1">' + errorMessage + '</p>');
        }

        if (password == '' || password_confirmation == '') {
            $('#password').removeClass('border-red-500 border-green-500').addClass('border-light-blue');
            $('#password_confirmation').removeClass('border-red-500 border-green-500').addClass('border-light-blue');
            $('#pass_alert').html('');
        }
    });


    });
</script>
@endsection
