@extends('layouts.admin2')
@section('content')
    <a href="{{ route('dashboard.staffs.index') }}" class="group block text-lg text-[#6973C6]">
        <
        <span class="ml-2 group-hover:underline">
            Back
        </span>
    </a>
    <div class="mt-2 flex justify-between">
        <h3 class="text-dark-blue font-medium text-[1.375rem]">
            Edit {{ $staff->institution_id == 0 ? 'Staff' : 'Mentor' }}
        </h3>

        <a href="{{ route('dashboard.staffs.index') }}" class="flex items-center gap-3 text-xl">
            <i class="fas fa-times-circle mt-1 text-primary"></i>
            Cancel
        </a>
    </div>
    <form action="/dashboard/staffs/{{ $staff->id }}/update" method="post" class="w-full lg:w-3/4 mt-10">
        @method('patch')
        @csrf
        <input type="email"
            class="text w-full border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
            value="{{ $staff->email }}" placeholder="Email *" id="email" name="email"><br>
        @error('email')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

        <div class="flex justify-between mt-4">
            <input
                class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none"
                id="firstname" type="text" value="{{ $staff->first_name }}" placeholder="First Name *" name="first_name"
                required><br>
            @error('first_name')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            <input
                class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                id="lastname" type="text" value="{{ $staff->last_name }}" placeholder="Last Name *" name="last_name"
                required><br>
            @error('last_name')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button class="py-2 px-11 bg-primary rounded-full text-center capitalize bg-orange text-white text-sm"
                type="submit">
                Update
            </button>

            <a href="{{ route('dashboard.staffs.index') }}"
                class="py-2 px-11 rounded-full border bg-white border-primary text-center capitalize text-primary text-sm">
                Cancel
            </a>
        </div>
    </form>
@endsection
