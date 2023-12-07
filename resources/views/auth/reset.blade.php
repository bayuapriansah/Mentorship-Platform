@extends('layouts.index')
@section('content')
<div class="bg-black bg-cover bg-center" style="background-image: url({{ asset('/assets/img/main/background-1.svg') }})">
    <div class="max-w-screen-xl mx-auto px-6 tab:px-[4.5rem] py-11 flex">
        <form action="{{ route('resetPassword') }}" method="POST">
            @csrf

            <a href="{{ route('multiLogIn') }}" class="text-white text-sm hover:underline">
                < Go Back
            </a>

            <h1 class="mt-[4.75rem] text-3xl text-[#FF8F51] font-bold">
                Reset Password
            </h1>

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Password --}}
            <div class="mt-7">
                <div class="relative w-[442px]">
                    <input
                        type="password"
                        id="input-password"
                        name="password"
                        placeholder="New Password *"
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
            <div class="mt-5">
                <div class="relative w-[442px]">
                    <input
                        type="password"
                        id="input-confirm-password"
                        name="password_confirmation"
                        placeholder="Confirm New Password *"
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

                @error('password_confirmation')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" class="w-[190px] h-[51px] mt-12 rounded-full bg-primary text-white font-medium text-lg">
                Set Password
            </button>

            <div class="mt-4">
                @include('flash-message')
            </div>
        </form>

        <img
            src="{{ asset('/assets/img/main/DBanner.png') }}"
            alt="Illustration"
            class="ml-[197px]"
        >
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
    </script>
@endsection
