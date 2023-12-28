@extends('layouts.admin2')

@section('more-css')
    <style>
        [x-cloak] { display: none !important; }
    </style>
@endsection

@section('content')
{{-- Breadcrumb --}}
<div class="flex flex-wrap text-[1.375rem] text-dark-blue font-medium gap-3">
    <a href="{{ $backUrl }}" class="hover:underline">
        All Participants
    </a>

    <span>></span>

    <span>
        Edit Details Participant
    </span>

    <span>></span>

    <span>
        {{ $student->first_name }} {{ $student->last_name }}
    </span>
</div>
{{-- ./Breadcrumb --}}

<div class="mt-12 lg:mt-5 grid grid-cols-12 gap-x-4 gap-y-8">
    {{-- Forms --}}
    <div class="order-last lg:order-first col-span-12 lg:col-span-7">
        {{-- End Date --}}
        <form x-data="{ endDate: '{{ $student->end_date }}' }" id="end-date-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <input type="hidden" name="update_type" value="end_date">

            <h1 class="text-xl text-dark-blue font-medium">
                End Date
            </h1>

            <input
                x-model="endDate"
                type="date"
                name="end_date"
                class="w-full mt-3 pl-3 pr-4 py-3 border border-grey rounded-lg"
                required
            >

            <button
                type="button"
                x-bind:disabled="endDate === null || endDate === ''"
                x-bind:class="{'cursor-not-allowed': endDate === null || endDate === ''}"
                data-modal-target="confirm-end-date-modal"
                data-modal-toggle="confirm-end-date-modal"
                class="mt-6 px-8 py-2 border border-primary rounded-full text-sm text-center text-primary font-medium"
            >
                Change End Date
            </button>
        </form>
        {{-- ./End Date --}}

        {{-- Password --}}
        <form x-data="{ newPassword: '' }" id="password-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('patch')

            <input type="hidden" name="update_type" value="password">

            <h1 class="text-xl text-dark-blue font-medium">
                Change Password
            </h1>

            <div class="relative mt-6">
                <input
                    x-model="newPassword"
                    type="password"
                    id="input-password"
                    name="password"
                    placeholder="New Password"
                    class="w-full border border-grey rounded-lg h-11 py-3 pl-4 pr-12 text-lightest-grey::placeholder leading-tight focus:outline-none"
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

            <button
                type="button"
                x-bind:disabled="newPassword === null || newPassword === ''"
                x-bind:class="{'cursor-not-allowed': newPassword === null || newPassword === ''}"
                data-modal-target="confirm-password-modal"
                data-modal-toggle="confirm-password-modal"
                class="mt-6 px-8 py-2 border border-primary rounded-full text-sm text-center text-primary font-medium"
            >
                Change Password
            </button>
        </form>
        {{-- ./Password --}}

        {{-- Mentorship Type --}}
        <form x-data="{ track: '{{ $student->mentorship_type }}' }" id="track-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('patch')

            <input type="hidden" name="update_type" value="mentorship_type">

            <h1 class="text-xl text-dark-blue font-medium">
                Mentorship Type (Optional)
            </h1>

            <select x-model="track" name="mentorship_type" class="w-full mt-3 py-3 border border-grey rounded-lg" required>
                <option value="" hidden>
                    Select Mentorship Type
                </option>

                <option value="skills_track">
                    Skills Track
                </option>

                <option value="entrepreneur_track">
                    Entrepreneur Track
                </option>
            </select>

            <button
                type="button"
                x-bind:disabled="track === null || track === ''"
                x-bind:class="{'cursor-not-allowed': track === null || track === ''}"
                data-modal-target="confirm-track-modal"
                data-modal-toggle="confirm-track-modal"
                class="mt-6 px-8 py-2 border border-primary rounded-full text-sm text-center text-primary font-medium"
            >
                Change Mentorship Type
            </button>
        </form>
        {{-- ./Mentorship Type --}}

        {{-- General Info --}}
        <form id="general-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="mt-8">
            @csrf
            @method('patch')

            <h1 class="text-xl text-dark-blue font-medium">
                General Information
            </h1>

            {{-- Name --}}
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="col-span-1 flex flex-col gap-2">
                    <input
                        type="text"
                        name="first_name"
                        value="{{ $student->first_name }}"
                        placeholder="First Name *"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >

                    @error('first_name')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col gap-2">
                    <input
                        type="text"
                        name="last_name"
                        value="{{ $student->last_name }}"
                        placeholder="Last Name *"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >

                    @error('last_name')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- ./Name --}}

            {{-- DOB & Sex --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="col-span-1 flex flex-col gap-2">
                    <input
                        type="date"
                        name="date_of_birth"
                        value="{{ $student->date_of_birth }}"
                        placeholder="Date of Birth *"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >

                    @error('date_of_birth')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col gap-2">
                    <select
                        name="sex"
                        value="{{ $student->sex }}"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >
                        <option value="" hidden>
                            Select Sex
                        </option>

                        <option value="male" {{ $student->sex === 'male'? 'selected' : '' }}>
                            Male
                        </option>

                        <option value="female" {{ $student->sex === 'female' ? 'selected' : '' }}>
                            Female
                        </option>
                    </select>

                    @error('sex')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- ./DOB & Sex --}}

            {{-- Country --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="col-span-2 flex flex-col gap-2">
                    <select
                        name="country"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >
                        <option value="" hidden>
                            Select Country
                        </option>

                        @foreach ($countries as $country)
                            <option value="{{ $country->name }}" {{ $student->country === $country->name ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('country')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- ./Country --}}

            {{-- Institution --}}
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="col-span-2 flex flex-col gap-2">
                    @if(Route::is('dashboard.students.manage'))
                        <input
                            type="text"
                            value="{{ $institution->name }}"
                            class="py-3 bg-gray-200 border border-grey rounded-lg"
                            readonly
                        >
                    @else
                        <select
                            name="institution"
                            class="py-3 border border-grey rounded-lg"
                            required
                        >
                            <option value="" hidden>
                                Select Institution
                            </option>

                            @foreach ($institutions as $institution)
                                <option value="{{ $institution->id }}" {{ $student->institution !== null && $student->institution->id === $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    @error('institution')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- ./Institution --}}

            {{-- Email --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="col-span-2 flex flex-col gap-2">
                    <input
                        type="email"
                        name="email"
                        value="{{ $student->email }}"
                        placeholder="Email *"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >

                    @error('email')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- ./Email --}}

            {{-- Year of Study --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="col-span-2 flex flex-col gap-2">
                    <select
                        name="year_of_study"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >
                        <option value="" hidden>
                            Select Year of Study
                        </option>

                        @foreach ($year_of_studies as $year_of_study)
                            <option value="{{ $year_of_study }}" {{ $student->year_of_study === $year_of_study ? 'selected' : '' }}>
                                {{ $year_of_study }}
                            </option>
                        @endforeach
                    </select>

                    @error('year_of_study')
                        <p class="text-red-600 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- ./Year of Study --}}

            {{-- Study Program --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="col-span-2 flex flex-col gap-2">
                    <select
                        name="study_program"
                        class="py-3 border border-grey rounded-lg"
                        required
                    >
                        <option value="" hidden>
                            Select Study Program
                        </option>

                        @foreach ($study_programs as $study_program)
                            <option value="{{ $study_program }}" {{ $student->study_program === $study_program ? 'selected' : '' }}>
                                {{ $study_program }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- ./Study Program --}}

            {{-- Hidden - Profile Picture --}}
            <input
                hidden
                id="input-profile-picture"
                type="file"
                name="profile_picture"
                accept="image/*"
            >
            {{-- ./Hidden - Profile Picture --}}

            <button
                type="button"
                data-modal-target="confirm-general-modal"
                data-modal-toggle="confirm-general-modal"
                class="mt-9 px-20 py-2 bg-[#E96424] rounded-full text-lg text-white"
            >
                Save
            </button>
        </form>
        {{-- ./General Info --}}
    </div>
    {{-- ./Forms --}}

    {{-- Profile Picture --}}
    <div class="order-first lg:order-last col-span-12 lg:col-span-3 lg:col-start-10 lg:w-max flex flex-col items-center gap-4">
        <img
            id="profile-picture"
            src="{{ $student->profile_picture ? asset('storage/'.$student->profile_picture) : asset('/assets/img/profile-placeholder.png') }}"
            onerror="this.src = `{{ asset('/assets/img/profile-placeholder.png') }}`"
            alt="Avatar"
            class="w-[145px] h-[145px] rounded-full object-cover ring ring-[#C5CAF3]"
        >

        <button type="button" onclick="openInputProfilePicture()" class="px-10 py-2 bg-primary rounded-full text-center text-sm text-[#F3F3F3] font-medium">
            Change Photo
        </button>
    </div>
    {{-- ./Profile Picture --}}
</div>

{{-- Confirm Change End Date Modal --}}
<div id="confirm-end-date-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-[75vw] max-h-full">
        <!-- Modal content -->
        <div class="relative w-max max-w-full mx-auto px-40 pt-14 pb-12 bg-white border-2 border-grey rounded-xl">
            <div
                class="absolute top-0 right-0 w-[253px] h-[138px]"
                style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
            ></div>

            <!-- Modal body -->
            <div>
                <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                    Are you sure you want to change the end date for this participant?
                </p>

                <div class="mt-8 flex justify-center items-center gap-6">
                    <button type="button" onclick="submitEndDateForm()" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                        Yes
                    </button>

                    <button type="button" data-modal-hide="confirm-end-date-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ./Confirm Change End Date Modal --}}

{{-- Confirm Change Password Modal --}}
<div id="confirm-password-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-[75vw] max-h-full">
        <!-- Modal content -->
        <div class="relative w-max max-w-full mx-auto px-40 pt-14 pb-12 bg-white border-2 border-grey rounded-xl">
            <div
                class="absolute top-0 right-0 w-[253px] h-[138px]"
                style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
            ></div>

            <!-- Modal body -->
            <div>
                <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                    Are you sure you want to change the password this participant?
                </p>

                <div class="mt-8 flex justify-center items-center gap-6">
                    <button type="button" onclick="submitPasswordForm()" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                        Yes
                    </button>

                    <button type="button" data-modal-hide="confirm-password-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ./Confirm Change Password Modal --}}

{{-- Confirm Change Track Modal --}}
<div id="confirm-track-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-[75vw] max-h-full">
        <!-- Modal content -->
        <div class="relative w-max max-w-full mx-auto px-40 pt-14 pb-12 bg-white border-2 border-grey rounded-xl">
            <div
                class="absolute top-0 right-0 w-[253px] h-[138px]"
                style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
            ></div>

            <!-- Modal body -->
            <div>
                <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                    Are you sure you want to change mentorship type for this participant?
                </p>

                <div class="mt-8 flex justify-center items-center gap-6">
                    <button type="button" onclick="submitTrackForm()" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                        Yes
                    </button>

                    <button type="button" data-modal-hide="confirm-track-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ./Confirm Change Track Modal --}}

{{-- Confirm General Modal --}}
<div id="confirm-general-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-[75vw] max-h-full">
        <!-- Modal content -->
        <div class="relative w-max max-w-full mx-auto px-40 pt-14 pb-12 bg-white border-2 border-grey rounded-xl">
            <div
                class="absolute top-0 right-0 w-[253px] h-[138px]"
                style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
            ></div>

            <!-- Modal body -->
            <div>
                <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                    Are you sure you want to update this participant profile data?
                </p>

                <div class="mt-8 flex justify-center items-center gap-6">
                    <button type="button" onclick="submitGeneralForm()" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                        Yes
                    </button>

                    <button type="button" data-modal-hide="confirm-general-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ./Confirm General Modal --}}
@endsection

@section('more-js')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function submitEndDateForm() {
            document.getElementById('end-date-form').submit()
        }

        function submitPasswordForm() {
            document.getElementById('password-form').submit()
        }

        function submitTrackForm() {
            document.getElementById('track-form').submit()
        }

        function submitGeneralForm() {
            document.getElementById('general-form').submit()
        }

        function toggleShowPassword(trigger) {
            const passwordInput = $($(trigger).attr('toggle'))

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text')
                $(trigger).css('background-image', 'url("{{ asset('/assets/img/icon/eye-open.svg') }}")')
            } else {
                passwordInput.attr('type', 'password')
                $(trigger).css('background-image', 'url("{{ asset('/assets/img/icon/eye-close.svg') }}")')
            }
        }

        function openInputProfilePicture() {
            document.getElementById('input-profile-picture').click()
        }

        $("#input-profile-picture").change(function (e) {
            const file = $(this).get(0).files[0]

            if (file) {
                const reader = new FileReader();

                reader.onload = function(){
                    $("#profile-picture").attr("src", reader.result)
                }

                reader.readAsDataURL(file)
            }
        })
    </script>
@endsection
