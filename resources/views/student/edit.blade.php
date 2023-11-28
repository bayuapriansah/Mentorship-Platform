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

                    {{-- <label for="file-upload" class="w-max mt-4 mx-auto py-2 px-6 bg-primary flex justify-center cursor-pointer rounded-full text-white font-medium">
                        Change Photo
                        <input id="file-upload" name="profile_picture" type="file" hidden />
                    </label> --}}

                    {{-- Change Photo --}}
                    <button type="button" data-dropdown-toggle="change-photo-dropdown" class="w-max mt-4 mx-auto py-2 px-6 bg-primary flex justify-center cursor-pointer rounded-full text-white font-medium">
                        Change Photo
                    </button>

                    <input id="input-photo-file" name="profile_picture" type="file" hidden />

                    <div id="change-photo-dropdown" class="z-10 hidden min-w-[281px] bg-[#F4F4F5] border border-grey shadow-xl divide-y rounded-xl">
                        <ul class="py-2 text-sm font-medium" aria-labelledby="dropdownDefaultButton">
                          <li class="hover:bg-gray-300">
                            <button type="button" class="w-full px-4 py-2 flex justify-between items-center">
                                Photo Library

                                <div class="-scale-y-100">
                                    <i class="far fa-clone"></i>
                                </div>
                            </button>
                          </li>

                          <li class="border-y-2 hover:bg-gray-300">
                            <button type="button" class="w-full px-4 py-2 flex justify-between items-center">
                                Take Photo or Video

                                <i class="fas fa-camera"></i>
                            </button>
                          </li>

                          <li class="hover:bg-gray-300">
                            <button id="browse-photo-btn" type="button" class="w-full px-4 py-2 flex justify-between items-center">
                                Browse

                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                          </li>
                        </ul>
                    </div>

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
                        <div class="flex gap-3">
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
                        <div class="flex gap-3">
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
                        <div class="flex gap-3">
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
                        <div class="flex gap-3">
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
                        <div class="flex gap-3">
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

                        {{-- Change Password Button --}}
                        <button type="button" data-modal-target="change-password-modal" data-modal-toggle="change-password-modal" class="w-max mt-2 py-3 px-6 border-2 border-solid border-primary rounded-full text-center text-primary text-sm font-medium">
                            Change Password
                        </button>

                        {{-- Mentorship Type --}}
                        <div class="mt-2 pr-3">
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
                            <button type="button" data-modal-target="change-track-confirm-modal" data-modal-toggle="change-track-confirm-modal" class="py-3 px-10 border-2 border-solid border-primary rounded-full text-center text-primary text-sm font-medium">
                                Change Track
                            </button>

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

    {{-- Change Password --}}
    <div id="change-password-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div
                    class="w-[253px] h-[138px] absolute top-0 right-0"
                    style="background: url({{ asset('/assets/img/home/bubble-decoration.svg') }}), transparent -0.092px -9.628px / 100.073% 106.977% no-repeat;"
                ></div>
                <!-- Modal body -->
                <div class="px-12 py-11 flex flex-col items-center">
                    <p class="text-center text-[1.4rem] text-darker-blue font-medium">
                        Change Password
                    </p>

                    <div class="w-full relative">
                        <input
                            type="password"
                            id="input-current-password"
                            placeholder="Current Password"
                            class="w-full mt-5 border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-current-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[55%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    <div class="w-full relative">
                        <input
                            type="password"
                            id="input-new-password"
                            placeholder="New Password"
                            class="w-full mt-5 border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-new-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[55%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    <div class="w-full relative">
                        <input
                            type="password"
                            id="input-confirm-new-password"
                            placeholder="Confirm New Password"
                            class="w-full mt-5 border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-confirm-new-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[55%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    <div class="mt-6 flex justify-center items-center gap-4">
                        <button class="min-w-[145px] p-3 bg-primary border border-primary rounded-full text-sm text-white">
                            Save Password
                        </button>

                        <button data-modal-hide="change-password-modal" class="min-w-[145px] p-3 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Track Confirm --}}
    <div id="change-track-confirm-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div
                    class="w-[253px] h-[138px] absolute top-0 -right-1"
                    style="background: url({{ asset('/assets/img/home/bubble-decoration.svg') }}), transparent -0.092px -9.628px / 100.073% 106.977% no-repeat;"
                ></div>
                <!-- Modal body -->
                <div class="px-12 py-11 flex flex-col items-center">
                    <p class="text-center text-xl text-darker-blue font-medium">
                        Are you sure you want to change your mentorship track?
                    </p>
                    <p class="mt-4 text-center text-lg">
                        You can only change your track once and will not be able to return to your previous
                        work once you change.
                    </p>

                    <div class="mt-6 flex justify-center items-center gap-4">
                        <button
                            data-modal-hide="change-track-confirm-modal"
                            data-modal-target="change-track-modal"
                            data-modal-toggle="change-track-modal"
                            class="min-w-[101px] p-2 bg-primary border border-primary rounded-full text-sm text-white"
                        >
                            Yes
                        </button>

                        <button data-modal-hide="change-track-confirm-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Track --}}
    <div id="change-track-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div
                    class="w-[253px] h-[138px] absolute top-0 -right-1"
                    style="background: url({{ asset('/assets/img/home/bubble-decoration.svg') }}), transparent -0.092px -9.628px / 100.073% 106.977% no-repeat;"
                ></div>

                <!-- Modal body -->
                <div class="px-12 py-11 flex flex-col items-center">
                    <p class="text-center text-xl text-darker-blue font-medium">
                        Please Confirm!
                    </p>

                    <p class="mt-4 text-center text-lg">
                        Please confirm you wish to change your mentorship track.
                        To confirm, type "<span class="font-semibold">Change My Track</span>" in the box below.
                    </p>

                    <input
                        type="text"
                        placeholder='Please type "Change My Track" to confirm'
                        class="w-full mt-3 border border-light-blue rounded-lg h-12 py-2 px-4 text-lightest-grey::placeholder placeholder:font-thin leading-tight focus:outline-none"
                    >

                    <div class="mt-6 flex justify-center items-center gap-4">
                        <button class="min-w-[101px] py-2 px-3 bg-primary border border-primary rounded-full text-sm text-white"
                        >
                            Yes
                        </button>

                        <button data-modal-hide="change-track-modal" class="min-w-[101px] py-2 px-3 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('more-js')
    <script>
        $('#browse-photo-btn').on('click', function() {
            $('#input-photo-file').click()
        })

        function toggleShowPassword(trigger) {
            const passwordInput = $($(trigger).attr('toggle'))

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                $(trigger).css('background-image', 'url("{{ asset('/assets/img/icon/eye-open.svg') }}")');
            } else {
                passwordInput.attr('type', 'password');
                $(trigger).css('background-image', 'url("{{ asset('/assets/img/icon/eye-close.svg') }}")');
            }
        }
    </script>

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
