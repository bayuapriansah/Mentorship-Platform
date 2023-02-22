@extends('layouts.index')
@section('content')
<section id="register" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 py-10 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-7 relative">
        <h1 class="font-bold text-white text-3xl leading-10 relative z-20 pb-7">{{ $regState == 0 ? "Register" : "Complete Registration" }}</h1>
        <p class="m-0 text-light-blue">{{ $regState == 0 ? "Fill out the registration form below to sign up for the platform." : "Fill out the form below to complete registration." }}</p>
        <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 -top-2 ">
      </div>
      <div class="col-start-10 col-span-4 relative ">
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-6">
        @if ($regState == 0)
        {{-- reg state 0 if we access register just from the page --}}
        <form action="{{route('register')}}" method="post" id="register">
            @csrf
            <div class="flex justify-between">
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
            <div class="flex justify-between mt-4">
              <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5 focus:outline-none" id="dob" type="text" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')" value="{{old('date_of_birth')}}" name="date_of_birth" required><br>
              @error('date_of_birth')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror

              <select id="sex" class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none" name="sex" required>
                <option value="" class="" hidden>Sex *</option>
                <option value="male" {{old('sex') == 'male' ? 'selected' : ''}}>Male</option>
                <option value="female" {{old('sex') == 'female' ? 'selected' : ''}}>Female</option>
              </select><br>
              @error('sex')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror
            </div>

            <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="institution" required>
              <option value="" hidden>Institution Name</option>
              @forelse($GetInstituionData as $ins)
              <option value="{{$ins->id}}">{{$ins->institutions}}</option>
              @empty
              <p>There is no Country Data</p>
              @endforelse
            </select><br>
            @error('institution')
                <p class="text-red-600 text-sm mt-1">
                  {{$message}}
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

            @php
              $study_programs = ['Artificial Intelligence and Machine Learning', 'Computer Science','Computing Systems', 'Software Engineering'];
            @endphp
            <select id="inputStudy" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="study_program" required>
              <option value="" hidden>Study Program</option>
              @foreach($study_programs as $study_program)
              <option value="{{$study_program}}">{{$study_program}}</option>
              @endforeach
              <option value="other">Other</option>
            </select><br>
            @error('study_program')
                <p class="text-red-600 text-sm mt-1">
                  {{$message}}
                </p>
            @enderror

            <input type="study_program_form" id="study_program_form" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('study_program_form') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{old('study_program_form')}}" placeholder="Study Program" id="study_program_form" name="study_program_form">

            <select id="year_of_study" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="year_of_study" required>
              <option value="" hidden>Year of study *</option>
              <option value="1st">1st</option>
              <option value="2nd">2nd</option>
              <option value="3rd">3rd</option>
              <option value="4th">4th</option>
              <option value="5th+">5th+</option>
            </select><br>
            @error('year_of_study')
                <p class="text-red-600 text-sm mt-1">
                  {{$message}}
                </p>
            @enderror


            <input type="email" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('email') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{old('email')}}" placeholder="Email *" id="email" name="email" required><br>
            @error('email')
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
            {{-- <div class="bg-red-alert intelOne text-sm p-4 w-2/3 rounded-lg mt-4 flex" role="alert">
              <img src="{{asset('assets/img/close.png')}}" class=" mr-4" alt="">
              This email address is already registered!
            </div> --}}
            <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Sign Up</button>
          </form>
        @elseif ($regState == 1)
        {{-- reg state 1 if we access register from email completion register --}}
        <form action="{{route('student.register.completed',[$checkStudent->email])}}" method="post" id="register">
            @csrf
            <div class="flex justify-between">
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
            <div class="flex justify-between mt-4">
              <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5 focus:outline-none" id="dob" type="text" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')" value="{{old('date_of_birth')}}" name="date_of_birth" required><br>
              @error('date_of_birth')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror

              <select id="sex" class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none" name="sex" required>
                <option value="" class="" hidden>Sex *</option>
                <option value="male" {{old('sex') == 'male' ? 'selected' : ''}}>Male</option>
                <option value="female" {{old('sex') == 'female' ? 'selected' : ''}}>Female</option>
              </select><br>
              @error('sex')
                  <p class="text-red-600 text-sm mt-1">
                    {{$message}}
                  </p>
              @enderror
            </div>

            <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="institution" required>
              <option value="" hidden>Institution Name</option>
              {{-- @forelse($GetInstituionData as $ins) --}}
              <option value="{{$checkStudent->institution_id}}" selected>{{$checkStudent->institution->name}}</option>
              {{-- @empty --}}
              {{-- <p>There is no Country Data</p> --}}
              {{-- @endforelse --}}
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

            @php
              $study_programs = ['Artificial Intelligence and Machine Learning', 'Computer Science','Computing Systems', 'Software Engineering'];
            @endphp
            <select id="inputStudy" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="study_program" required>
              <option value="" hidden>Study Program</option>
              @foreach($study_programs as $study_program)
              <option value="{{$study_program}}">{{$study_program}}</option>
              @endforeach
              <option value="other">Other</option>
            </select><br>
            @error('study_program')
                <p class="text-red-600 text-sm mt-1">
                  {{$message}}
                </p>
            @enderror

            <input type="study_program_form" id="study_program_form" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('study_program_form') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{old('study_program_form')}}" placeholder="Study Program" id="study_program_form" name="study_program_form">

            <select id="year_of_study" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="year_of_study" required>
              <option value="" hidden>Year of study *</option>
              <option value="1st">1st</option>
              <option value="2nd">2nd</option>
              <option value="3rd">3rd</option>
              <option value="4th">4th</option>
              <option value="5th+">5th+</option>
            </select><br>
            @error('year_of_study')
                <p class="text-red-600 text-sm mt-1">
                  {{$message}}
                </p>
            @enderror


            <input type="email" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('email') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{ $checkStudent->email }}" placeholder="Email *" id="email" name="email" readonly><br>
            @error('email')
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
          @endif
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
@if ($regState == 0)
      });
@elseif ($regState == 1)
      }).trigger('change'); // Trigger the change event to make the AJAX request on page load
@endif

      $('#study_program_form').hide();
      $("#inputStudy").change(function(){
        var values = $("#inputStudy option:selected").val();
        if(values=='other'){
          $('#study_program_form').show();
        }else{
          $('#study_program_form').hide();
        }
      });
  });
</script>
@endsection
