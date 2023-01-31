@extends('layouts.profile.index')
@section('content')
<div class="container py-6  mx-auto px-16">
  <div class="bg-white py-8 px-14 rounded-xl">
    <p class="text-2xl text-dark-blue font-medium">Edit Profile</p>
    <div class="flex flex-col justify-center items-center">
      <img src="{{asset('assets/img/icon/profile/pp.png')}}" class="w-[145px] h-[145px] mx-auto mt-14"  alt="message">
      <button class="bg-light-blue py-2 px-2 w-1/6 mt-[18px] rounded-full text-white">Change photo</button>
      <div class="mt-14">
        <div class="flex justify-between">
          <input class="border border-light-blue rounded-lg w-64 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="firstname" type="text" value="{{$student->first_name}}" placeholder="First Name *" name="first_name" required><br>
          @error('first_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
          <input class="border border-light-blue rounded-lg w-64 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="lastname" type="text" value="{{$student->last_name}}" placeholder="Last Name *" name="last_name" required><br>
          @error('last_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        <div class="flex justify-between mt-4">
          <input class="border border-light-blue rounded-lg w-64 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5 focus:outline-none" id="dob" type="date" placeholder="Date of birth" value="{{$student->date_of_birth}}" name="date_of_birth" required><br>
          @error('date_of_birth')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
          
          <select id="sex" class="border border-light-blue rounded-lg w-64 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none" name="sex" required>
            <option value="" class="" id="emptySex" hidden>Sex *</option>
            <option value="male" {{$student->sex == 'male' ? 'selected' : ''}}>Male</option>
            <option value="female" {{$student->sex == 'female' ? 'selected' : ''}}>Female</option>
          </select><br>
          @error('sex')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        
        <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight bg-gray-300 invalid:text-black cursor-not-allowed focus:outline-none" name="institution" disabled>
          <option value="" hidden>{{$student->institution->name}}</option>
        </select><br>
        @error('institution')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
        @enderror 

        <div class="flex justify-between mt-4">
          <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 bg-gray-300 cursor-not-allowed focus:outline-none" id="ForCountry" type="text" value="{{$student->country}}" placeholder="Country *" name="country" readonly required>
          <br>
          @error('country')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror

          <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight bg-gray-300 cursor-not-allowed focus:outline-none" id="ForState" type="text" value="{{$student->state}}" placeholder="State *" name="state" readonly required>
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
          <option value="" hidden>Study Name</option>
          @foreach($study_programs as $study_program)
          <option value="{{$study_program}}" {{$student->study_program == $study_program ? 'selected':''}}>{{$study_program}}</option>
          @endforeach
          <option value="other">Other</option>
        </select><br>
        @error('study_program')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
        @enderror 

      </div>
    </div>
  </div>
</div>
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
      });

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