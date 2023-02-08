@extends('layouts.admin2')
@section('content')
@if(Route::is('dashboard.students.manage'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions/{{$institution->id}}/students"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif

<form action="/dashboard/institutions/{{$institution->id}}/students/{{$student->id}}/managepatch" method="post" enctype="multipart/form-data">
  @method('patch')
  @csrf
  <img src="{{$student->profile_picture ? asset('storage/'.$student->profile_picture) : asset('assets/img/placeholder_pp.png') }}" class="w-[145px] h-[145px] mx-auto mt-14 rounded-full object-cover" id="profile_img"  alt="message">
  <label for="file-upload" class="bg-dark-blue hover:bg-darker-blue flex mx-auto py-2 px-auto justify-center cursor-pointer mt-[18px] rounded-full text-white w-1/3">
    Change photo
    <input id="file-upload" name="profile_picture" type="file" hidden/>
  </label>
  <div class="mt-14">
    <div class="flex justify-between">
      <input class="border border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="firstname" type="text" value="{{$student->first_name}}" placeholder="First Name *" name="first_name" required><br>
      @error('first_name')
          <p class="text-red-600 text-sm mt-1">
            {{$message}}
          </p>
      @enderror
      <input class="border border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="lastname" type="text" value="{{$student->last_name}}" placeholder="Last Name *" name="last_name" required><br>
      @error('last_name')
          <p class="text-red-600 text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    </div>
    <div class="flex justify-between mt-4">
      <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5 focus:outline-none" id="dob" type="date" placeholder="Date of birth" value="{{$student->date_of_birth}}" name="date_of_birth" required><br>
      @error('date_of_birth')
          <p class="text-red-600 text-sm mt-1">
            {{$message}}
          </p>
      @enderror
      
      <select id="sex" class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none" name="sex" required>
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
    
    <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight bg-gray-300 invalid:text-black text-black cursor-not-allowed focus:outline-none" name="institution" disabled>
      <option value="" hidden class="text-black">{{$student->institution->name}}</option>
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

    <input type="study_program_form" id="study_program_form" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('study_program_form') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{old('study_program_form')}}" placeholder="Study Program" id="study_program_form" name="study_program_form">
    
    <select id="year_of_study" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="year_of_study" required>
      <option value="" hidden >Year of study *</option>
      <option value="1st" {{$student->year_of_study == '1st' ? 'selected' : ''}}>1st</option>
      <option value="2nd" {{$student->year_of_study == '2nd' ? 'selected' : ''}}>2nd</option>
      <option value="3rd" {{$student->year_of_study == '3rd' ? 'selected' : ''}}>3rd</option>
      <option value="4th" {{$student->year_of_study == '4th' ? 'selected' : ''}}>4th</option>
      <option value="5th+" {{$student->year_of_study == '5th+' ? 'selected' : ''}}>5th+</option>
    </select><br>
    @error('year_of_study')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror

    <select id="mentor_id" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="mentor_id" required>
      <option value="" hidden >Mentor</option>
      @foreach ($mentors as $mentor)
      <option value="{{$mentor->id}}" {{$mentor->id == $student->mentor_id ? 'selected':''}}>{{$mentor->first_name}} {{$mentor->last_name}}</option>
      @endforeach
    </select><br>
    @error('mentor_id')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror

  <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne flex mx-auto" type="submit">Update Student</button>

  </div>
</form>

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
      $("#file-upload").change(function(e){
        var file = $("input[type=file]").get(0).files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $("#profile_img").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
        console.log(file)
        // $('#file-name').html($('#file-upload').files())
      });
  });
</script>
@endsection