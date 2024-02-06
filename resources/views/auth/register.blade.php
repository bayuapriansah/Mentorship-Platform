@php
    $study_programs = [
        'Artificial Intelligence and Machine Learning',
        'Computer Science',
        'Computing Systems',
        'Software Engineering',
        'Computer Science & Engineering'
    ];

    $team_name = [
        "Way Back Home",
        "AI-Powered Robotic Service Animal for People with Visual Disabilities",
        "BRINL: Braille Interactive Learning",
        "Melody of Fingers – Application based on PyTorch, CNN, and AIxBoard",
        "AI powered platform to empower women in STEM",
        "Eye tracking for communicating patients with Amyotrophic Lateral Sclerosis (ALS)",
        "StraightenUp – Posture Assistant",
        "Utilizing AI to help Native Bees",
        "RescueAI: Smart City Disaster Digital Twin with Robotic Autonomy",
        "ASRV (AI SYSTEM FOR ROAD VIOLATIONS)",
        "Aimers - summarizer",
        "Detect Driving Fatigue Levels Using Real-Time Deep Learning",
        "WasteWise",
        "ARSS(AI Recycling Seperation System)",
        "Smart Home A-Eye Bin",
        "Cell detection using AI – a new way of diagnosing patients.",
        "Cancel the cancer",
        "AI-cognito",
        "Smart Attendance System",
        "EIPCA - Electrocardiogram Interpretation patterns for cardiovascular abnormalities prediction",
        "Eco marine",
        "Cotton + quality + technology = competitive producers",
        "Wildlife Vehicle Collisions Modelling",
        "Courage2Correct",
        "AI-ENABLED COMPUTER VISION FOR TUBERCULOSIS DETECTION FROM MRI SCANS",
        "Safety Traffic through AI Analysis of Dash cam in Delivery Riders",
        "Beach Cleaning Robot",
        "Sign Language AI Detector for Online Conferences",
        "HIL Simulation of Auto-Driving Control System Based on Intel Platform",
        "Socio Economic Status Causing high-level distress amongst communities",
        "MedINtel: Automated Triage Machine (ATM)"
    ];
    sort($team_name);
@endphp

@extends('layouts.index')
@section('content')
{{-- Header --}}
<div class="bg-black bg-center bg-cover bg-no-repeat" style="background-image: url({{ asset('/assets/img/main/header-bg.png') }})">
    <div class="max-w-[1366px] mx-auto px-[4.5rem] py-6">
        <h1 class="font-bold text-[#FF8F51] text-3xl">
            {{ $regState == 0 ? "Register" : "Complete Registration" }}
        </h1>

        <p class="max-w-[557px] mt-4 text-white text-lg font-light">
            {{ $regState == 0 ? "Fill out the empty information add the registration from below to finish sign up for the mentorship platform." : "Fill out the form below to complete registration." }}
        </p>
    </div>
</div>

<div class="max-w-[1366px] mx-auto pl-[4.5rem] pr-[5.4rem] pt-12 pb-[4.7rem] flex">
    {{-- Form --}}
    <div class="w-[442px]">
        @if ($regState == 0)
            {{-- reg state 0 if we access register just from the page --}}
            <form action="{{ route('register') }}" method="post" onsubmit="return validateForm()">
                @csrf

                {{-- Name --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="col-span-1">
                        <input
                            id="firstname"
                            type="text"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            placeholder="Name *"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                            required
                        >

                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <input
                            id="lastname"
                            type="text"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            placeholder="Last Name *"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                            required
                        >

                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- DOB & Sex --}}
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <div class="col-span-1">
                        <input
                            id="dob"
                            type="text"
                            name="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                            placeholder="Date of Birth *"
                            onfocus="(this.type='date')"
                            onblur="(this.type='text')"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight mr-5 focus:outline-none"
                            required
                        >

                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <select id="sex" class="border border-grey rounded-lg w-full h-11 py-2 px-4 pr-28 leading-tight focus:outline-none" name="sex" required>
                            <option value="" class="" hidden>Sex *</option>
                            <option value="male" {{old('sex') == 'male' ? 'selected' : ''}}>Male</option>
                            <option value="female" {{old('sex') == 'female' ? 'selected' : ''}}>Female</option>
                        </select>

                        @error('sex')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Team Name --}}
                <div class="mt-4">
                    <input
                        type="text"
                        name="team_name"
                        value="{{ old('team_name') }}"
                        placeholder="Name of Team *"
                        class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                        required
                    >

                    @error('team_name')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Country --}}
                <div class="mt-4">
                    <select id="inputStudy" name="country" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Country *</option>

                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('country')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Institution --}}
                <div class="mt-4">
                    <input
                        type="text"
                        name="institution_name"
                        value="{{ old('institution_name') }}"
                        placeholder="Educational Institution *"
                        class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                        required
                    >

                    @error('institution_name')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Study Program --}}
                <div class="mt-4">
                    <select id="inputStudy" name="study_program" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Study Program</option>
                        @foreach($study_programs as $study_program)
                        <option value="{{$study_program}}">{{$study_program}}</option>
                        @endforeach
                        <option value="other">Other</option>
                    </select>

                    @error('study_program')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <input type="study_program_form" id="study_program_form" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('study_program_form') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{old('study_program_form')}}" placeholder="Study Program" id="study_program_form" name="study_program_form">
                </div>

                {{-- Year of study --}}
                <div class="mt-4">
                    <select id="year_of_study" name="year_of_study" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Year of study *</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5+">5+</option>
                    </select>

                    @error('year_of_study')
                        <p class="text-red-600 text-sm mt-1">
                            {{$message}}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email Address *"
                        class="w-full border border-grey rounded-lg h-11 py-2 px-4 leading-tight focus:outline-none"
                        required
                    >

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Mentorship Type --}}
                <div class="mt-4">
                    <select name="mentorship_type" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Mentorship Type *</option>
                        <option value="skills_track" {{ old('mentorship_type') == 'skills_track' ? 'selected' : '' }}>
                            Skills Track
                        </option>

                        <option value="entrepreneur_track" {{ old('mentorship_type') == 'entrepreneur_track' ? 'selected' : '' }}>
                            Entrepreneur Track
                        </option>
                    </select>

                    @error('mentorship_type')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <div class="relative">
                        <input
                            type="password"
                            id="input-password"
                            name="password"
                            placeholder="Password *"
                            onkeyup="validatePasswordConfirm()"
                            class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[35%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <div class="relative">
                        <input
                            type="password"
                            id="input-confirm-password"
                            placeholder="Confirm Password *"
                            onkeyup="validatePasswordConfirm()"
                            class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-confirm-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[35%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    <small id="input-confirm-password-warning" style="display: none;" class="text-red-600 text-sm mt-1">
                        Passwords do not match
                    </small>
                </div>

                {{-- Accept Terms & Conditions --}}
                <div class="mt-6 flex items-center gap-2">
                    <input
                        id="input-check-tnc"
                        type="checkbox"
                        name="tnc"
                        class="w-4 h-4 rounded"
                        required
                    >

                    <label for="input-check-tnc" class="text-sm">
                        I accept the
                        <span class="text-darker-blue font-medium">
                            <a href="{{ route('terms-of-use') }}" class="hover:underline">
                                Terms & Conditions
                            </a>

                            <span class="text-black">and</span>

                            <a href="{{ route('privacy-policy') }}" class="hover:underline">
                                Privacy Policies
                            </a>
                        </span>
                    </label>
                </div>

                {{-- Recaptcha --}}
                <div class="mt-4 flex flex-col gap-4">
                    <p>
                        Please check the box below to proceed.
                    </p>

                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>

                    @if(Session::has('g-recaptcha-response'))
                        <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
                            {{ Session::get('g-recaptcha-response') }}
                        </p>
                    @endif
                </div>

                <button type="submit" class="mt-6 w-[190px] h-[51px] bg-primary rounded-full text-white text-lg font-medium">
                    Sign Up
                </button>
            </form>
        @elseif ($regState == 1)
            {{-- reg state 1 if we access register from email completion register --}}
            <form action="{{ route('student.register.completed', [$checkStudent->email]) }}" method="post">
                @csrf

                {{-- Name --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="col-span-1">
                        <input
                            id="firstname"
                            type="text"
                            name="first_name"
                            value="{{ $checkStudent->first_name ?? old('first_name') }}"
                            placeholder="Name *"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                            required
                        >

                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <input
                            id="lastname"
                            type="text"
                            name="last_name"
                            value="{{ $checkStudent->last_name }}"
                            placeholder="Last Name *"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                            required
                        >

                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- DOB & Sex --}}
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <div class="col-span-1">
                        <input
                            id="dob"
                            type="text"
                            name="date_of_birth"
                            value="{{ $checkStudent->date_of_birth }}"
                            placeholder="Date of Birth *"
                            onfocus="(this.type='date')"
                            onblur="(this.type='text')"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight mr-5 focus:outline-none"
                            required
                        >

                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <select id="sex" class="border border-grey rounded-lg w-full h-11 py-2 px-4 pr-28 leading-tight focus:outline-none" name="sex" required>
                            <option value="" class="" hidden>Sex *</option>
                            <option value="male" {{ $checkStudent->sex == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $checkStudent->sex == 'female' ? 'selected' : '' }}>Female</option>
                        </select>

                        @error('sex')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Team Name --}}
                {{-- <div class="mt-4">
                    <input
                        type="text"
                        name="team_name"
                        value="{{ $checkStudent->team_name }}"
                        placeholder="Name of Team *"
                        class="border border-grey rounded-lg w-full h-11 py-2 px-4 leading-tight focus:outline-none"
                        required
                    >

                    @error('team_name')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div> --}}

                {{-- Team Name --}}
                <div class="mt-4">
                    <select id="team_name" name="team_name" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Select Team Name</option>
                        @foreach($team_name as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    @error('team_name')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Country --}}
                <div class="mt-4">
                    <select id="inputStudy" name="country" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Country *</option>

                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" {{ $checkStudent->country == $country->name ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('country')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Institution --}}
                <div class="mt-4">
                    <input
                        type="text"
                        name="institution_name"
                        value="{{ $checkStudent->institution->name }}"
                        placeholder="Educational Institution"
                        class="border border-grey rounded-lg w-full h-11 py-2 px-4 bg-[#EDEDED] leading-tight cursor-not-allowed focus:outline-none"
                        readonly
                        required
                    >

                    @error('institution')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Study Program --}}
                <div class="mt-4">
                    <select id="inputStudy" name="study_program" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Study Program</option>

                        @foreach($study_programs as $study_program)
                            <option value="{{ $study_program }}" {{ $checkStudent->study_program == $study_program ? 'selected' : '' }}>
                                {{ $study_program }}
                            </option>
                        @endforeach

                        <option value="other">Other</option>
                    </select>

                    @error('study_program')
                        <p class="text-red-600 text-sm mt-1">
                            {{$message}}
                        </p>
                    @enderror

                    <input type="study_program_form" id="study_program_form" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('study_program_form') != null ? 'border-red-500' : ''}} focus:outline-none" value="{{old('study_program_form')}}" placeholder="Study Program" id="study_program_form" name="study_program_form">
                </div>

                {{-- Year of study --}}
                <div class="mt-4">
                    <select id="year_of_study" name="year_of_study" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Year of study *</option>
                        <option value="1st" {{ $checkStudent->year_of_study == '1st' ? 'selected' : '' }}>1st</option>
                        <option value="2nd" {{ $checkStudent->year_of_study == '2nd' ? 'selected' : '' }}>2nd</option>
                        <option value="3rd" {{ $checkStudent->year_of_study == '3rd' ? 'selected' : '' }}>3rd</option>
                        <option value="4th" {{ $checkStudent->year_of_study == '4th' ? 'selected' : '' }}>4th</option>
                        <option value="5+" {{ $checkStudent->year_of_study == '5+' ? 'selected' : '' }}>5+</option>
                    </select>

                    @error('year_of_study')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ $checkStudent->email }}"
                        placeholder="email address *"
                        class="w-full border border-grey rounded-lg h-11 py-2 px-4 bg-[#EDEDED] leading-tight focus:outline-none cursor-not-allowed"
                        required
                        readonly
                    >

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Mentorship Type --}}
                <div class="mt-4">
                    <select name="mentorship_type" class="w-full h-11 py-2 px-4 border border-grey rounded-lg leading-tight focus:outline-none" required>
                        <option value="" hidden>Mentorship Type *</option>

                        <option value="skills_track" {{ $checkStudent->mentorship_type == 'skills_track' ? 'selected' : '' }}>
                            Skills Track
                        </option>

                        <option value="entrepreneur_track" {{ $checkStudent->mentorship_type == 'entrepreneur_track' ? 'selected' : '' }}>
                            Entrepreneur Track
                        </option>
                    </select>

                    @error('mentorship_type')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <div class="relative">
                        <input
                            type="password"
                            id="input-password"
                            name="password"
                            placeholder="Password *"
                            onkeyup="validatePasswordConfirm()"
                            class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[35%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <div class="relative">
                        <input
                            type="password"
                            id="input-confirm-password"
                            placeholder="Confirm Password *"
                            onkeyup="validatePasswordConfirm()"
                            class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                            required
                        >

                        <span
                            toggle="#input-confirm-password"
                            onclick="toggleShowPassword(this)"
                            class="absolute top-[35%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                            style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                        >
                        </span>
                    </div>

                    <small id="input-confirm-password-warning" style="display: none;" class="text-red-600 text-sm mt-1">
                        Passwords do not match
                    </small>
                </div>

                {{-- Accept Terms & Conditions --}}
                <div class="mt-6 flex items-center gap-2">
                    <input
                        id="input-check-tnc"
                        type="checkbox"
                        name="tnc"
                        class="w-4 h-4 rounded"
                        required
                    >

                    <label for="input-check-tnc" class="text-sm">
                        I accept the
                        <span class="text-darker-blue font-medium">
                            <a href="{{ route('terms-of-use') }}" class="hover:underline">
                                Terms & Conditions
                            </a>

                            <span class="text-black">and</span>

                            <a href="{{ route('privacy-policy') }}" class="hover:underline">
                                Privacy Policies
                            </a>
                        </span>
                    </label>
                </div>

                {{-- Recaptcha --}}
                <div class="mt-4 flex flex-col gap-4">
                    <p>
                        Please check the box below to proceed.
                    </p>

                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>

                    @if(Session::has('g-recaptcha-response'))
                        <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
                            {{ Session::get('g-recaptcha-response') }}
                        </p>
                    @endif
                </div>

                <button type="submit" class="mt-6 w-[190px] h-[51px] bg-primary rounded-full text-white text-lg font-medium">
                    Sign Up
                </button>
            </form>
        @endif
    </div>

    {{-- Image & Decorations --}}
    <div class="relative flex-[1]">
        <img src="{{asset('assets/img/main/DBanner.png')}}" alt="Illustration" class="relative z-[2] w-[523px] ml-40">
        <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute -top-8 -right-36 w-[402px] h-[220px]">
        <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute bottom-10 left-16 w-[185px] h-[350px]">
    </div>
</div>
@endsection

@section('more-js')
<script>
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

    function validatePasswordConfirm() {
        const password = document.getElementById('input-password').value;
        const confirmPassword = document.getElementById('input-confirm-password').value;

        if (password !== confirmPassword) {
            document.getElementById('input-confirm-password-warning').style.display = 'block';
        } else {
            document.getElementById('input-confirm-password-warning').style.display = 'none';
        }

        return password === confirmPassword;
    }

    function validateForm() {
        if (!validatePasswordConfirm()) {
            return false;
        }

        return true;
    }
</script>

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
