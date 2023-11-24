@extends('layouts.profile.index')
@section('content')
    <div class="mx-auto px-16 py-11 bg-white">
        <div class="px-[4.5rem] pt-6 pb-7 bg-[#fafafa] border border-grey rounded-xl">
            <div class="flex justify-between">
                <h1 class="text-2xl text-darker-blue font-medium">
                    Edit Profile
                </h1>

                @include('flash-message')
            </div>

            <div class="flex flex-col justify-center items-center">
                <form action="/profile/{{ Auth::guard('student')->user()->id }}" method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    {{-- Image --}}
                    <img
                        src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('assets/img/placeholder_pp.png') }}"
                        id="profile_img"
                        alt="message"
                        class="w-[145px] h-[145px] mt-8 mx-auto rounded-full object-cover"
                    >

                    <label for="file-upload" class="w-max mt-4 mx-auto py-2 px-6 bg-primary flex justify-center cursor-pointer rounded-full text-white font-medium">
                        Change Photo
                        <input id="file-upload" name="profile_picture" type="file" hidden />
                    </label>

                    <div class="mt-10 flex flex-col gap-4">
                        {{-- Name --}}
                        <div class="flex gap-3">
                            <input
                                type="text"
                                id="firstname"
                                name="first_name"
                                value="{{ $student->first_name }}"
                                placeholder="First Name *"
                                class="border border-light-blue rounded-lg w-64 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                                required
                            >
                            <br>
                            @error('first_name')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                            <input
                                type="text"
                                id="lastname"
                                name="last_name"
                                value="{{ $student->last_name }}"
                                placeholder="Last Name *"
                                class="border border-light-blue rounded-lg w-64 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                                required
                            >
                            <br>
                            @error('last_name')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- DOB & Gender --}}
                        <div class="flex gap-3">
                            <input
                                type="date"
                                id="dob"
                                name="date_of_birth"
                                value="{{ $student->date_of_birth }}"
                                placeholder="Date of birth"
                                class="border border-light-blue rounded-lg w-64 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none"
                                required
                            >
                            <br>
                            @error('date_of_birth')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                            <select
                                id="sex"
                                name="sex"
                                class="border border-light-blue rounded-lg w-64 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:outline-none"
                                required
                            >
                                <option value="" class="" id="emptySex" hidden>Sex *</option>
                                <option value="male" {{ $student->sex == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $student->sex == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <br>
                            @error('sex')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Country and State --}}
                        <div class="flex gap-3">
                            <select
                                id="country-dropdown"
                                name="country"
                                class="border border-light-blue rounded-lg w-64 h-11 py-2 px-4 leading-tight focus:outline-none"
                                required
                            >
                                <option value="" class="" id="emptyCountry" hidden>Country *</option>
                                <option>Australia</option>
                                <option>Andorra</option>
                                <option>Belgium</option>
                                <option>China</option>
                                <option selected>United States</option>
                            </select>
                            <br>
                            @error('country')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                            <select
                                id="state-dropdown"
                                name="state"
                                class="border border-light-blue rounded-lg w-64 h-11 py-2 px-4 leading-tight focus:outline-none"
                                required
                            >
                                <option value="" class="" id="emptyState" hidden>State *</option>
                                <option>California</option>
                                <option>Hawaii</option>
                                <option>Idaho</option>
                                <option>Tennessee</option>
                                <option selected>Texas</option>
                            </select>
                            <br>
                            @error('state')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Institution --}}
                        <div>
                            <select
                                id="institution-dropdown"
                                name="institution"
                                class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                                required
                            >
                                <option value="" class="" id="emptyInstitution" hidden>Institution *</option>
                                <option>Harvard University</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>Princeton University</option>
                                <option selected>Deakin University</option>
                                <option>UC Berkeley</option>
                            </select>
                            <br>
                            @error('institution')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <input
                                type="text"
                                value="{{ $student->email }}"
                                class="w-full border border-light-blue rounded-lg h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                                readonly
                            >
                            <br>
                            @error('first_name')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Year of Study --}}
                        <div>
                            <select
                                id="year_of_study"
                                name="year_of_study"
                                class="text w-full border border-light-blue rounded-lg h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none"
                                required
                            >
                                <option value="" hidden>Year of study *</option>
                                <option value="1st" {{ $student->year_of_study == '1st' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd" {{ $student->year_of_study == '2nd' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd" {{ $student->year_of_study == '3rd' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th" {{ $student->year_of_study == '4th' ? 'selected' : '' }}>4th Year</option>
                                <option value="5+" {{ $student->year_of_study == '5+' ? 'selected' : '' }}>5+ Year</option>
                            </select>
                            <br>
                            @error('year_of_study')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        @php
                            $study_programs = ['Artificial Intelligence and Machine Learning', 'Computer Science', 'Computing Systems', 'Software Engineering'];
                        @endphp

                        {{-- Degree --}}
                        <div>
                            <select
                                id="degree-dropdown"
                                name="degree"
                                class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                                required
                            >
                                <option value="" class="" id="emptyDegree" hidden>Degree *</option>
                                <option selected>Bachelor of Technology</option>
                                <option>Bachelor of Applied Science</option>
                                <option>Bachelor of Engineering</option>
                            </select>
                            <br>
                            @error('degree')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Study Program --}}
                        <div>
                            <select
                                id="study-dropdown"
                                name="study"
                                class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                                required
                            >
                                <option value="" class="" id="emptyStudy" hidden>Study Program *</option>
                                <option selected>Computer Science & Engineering</option>

                                @foreach ($study_programs as $study)
                                    <option>{{ $study }}</option>
                                @endforeach
                            </select>
                            <br>
                            @error('study')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Mentorship Type --}}
                        <div class="mt-2">
                            <h5 class="text-darker-blue text-xl font-medium">
                                Mentorship Type
                                <span class="text-red-600">*</span>
                            </h5>

                            <input
                                type="text"
                                value="Skill Track"
                                class="w-full mt-3 font-medium bg-light-grey border border-light-blue rounded-lg h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                                readonly
                            >
                        </div>

                        {{-- Change Track --}}
                        <div class="mt-3 flex items-center gap-8">
                            <a href="#" class="py-3 px-10 border-2 border-solid border-primary rounded-full text-center text-primary text-sm font-medium hover:bg-primary hover:text-white transition-colors duration-200">
                                Change Track
                            </a>

                            <p class="text-black text-xs text-justify font-light">
                                You can only change your track once and will not be able
                                to<br>return to your previous work once you change.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-[3.2rem] flex justify-center">
            <button type="button" class="py-3 px-10 rounded-full bg-primary border-2 border-solid border-primary text-center text-white text-lg font-medium">
                Update Profile
            </button>
        </div>
    </div>
@endsection
@section('more-js')
    {{-- <script>
        $(document).ready(function() {
            $('#inputInstitution').on('change', function() {
                var institutionVal = this.value;
                var base_url = window.location.origin;
                $.ajax({
                    url: base_url + "/api/institution/" + institutionVal,
                    contentType: "application/json",
                    dataType: 'json',
                    success: function(result) {
                        // console.log(institutionVal);
                        $('#ForCountry').val(result.countries);
                        $('#ForState').val(result.states);
                    }
                });
            });

            $('#study_program_form').hide();
            $("#inputStudy").change(function() {
                var values = $("#inputStudy option:selected").val();
                if (values == 'other') {
                    $('#study_program_form').show();
                } else {
                    $('#study_program_form').hide();
                }
            });
            $("#file-upload").change(function(e) {
                var file = $("input[type=file]").get(0).files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        $("#profile_img").attr("src", reader.result);
                    }
                    reader.readAsDataURL(file);
                }
                console.log(file)
                // $('#file-name').html($('#file-upload').files())
            });
        });
    </script> --}}
@endsection
