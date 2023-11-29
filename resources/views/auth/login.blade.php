@extends('layouts.index')
@section('content')
    <div class="bg-black bg-cover bg-center" style="background-image: url({{ asset('/assets/img/main/background-1.svg') }})">
        <div class="max-w-screen-xl mx-auto px-6 tab:px-[4.5rem] py-11 flex">
            <form action="{{ route('authenticate') }}" method="post" class="w-full tab:w-[442px]">
                @csrf

                <h1 class="text-[#FF8F51] font-bold text-3xl">
                    Login
                </h1>

                <p class="mt-4 font-light text-white text-lg">
                    Sign in to your account to continue.
                </p>

                <div class="mt-8">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        class="w-full border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                        required
                    >

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="relative">
                    <input
                        type="password"
                        id="input-password"
                        name="password"
                        placeholder="Password"
                        class="w-full mt-5 border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                        required
                    >

                    <span
                        id="toggle-password"
                        toggle="#input-password"
                        class="absolute top-[55%] right-3 h-4 w-4 bg-cover bg-center bg-no-repeat cursor-pointer"
                        style="background-image: url({{ asset('/assets/img/icon/eye-close.svg') }})"
                    >
                    </span>
                </div>

                @error('password')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

                <div class="mt-2 flex">
                    <a href="{{ route('forgotPassword') }}" class="ml-auto text-xs text-[#FF8F51]">
                        Forgot Password?
                    </a>
                </div>

                <p class="font-light text-white text-xs">
                    Please check the box below to proceed.
                </p>

                <div class="g-recaptcha mt-2" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                @if (Session::has('g-recaptcha-response'))
                    <p class="alert my-2 {{ Session::get('alert-class', 'alert-info') }}">
                        {{ Session::get('g-recaptcha-response') }}
                    </p>
                @endif

                <div class="mt-4">
                    @include('flash-message')
                </div>

                <button
                    type="submit"
                    class="mt-6 py-3 px-20 bg-primary rounded-full font-500 text-center text-white text-lg"
                >
                    Login
                </button>
            </form>

            <img
                src="{{ asset('/assets/img/main/DBanner.png') }}"
                alt="Illustration"
                class="hidden tab:block ml-[12.5rem]"
            >
        </div>
    </div>
@endsection

@section('more-js')
    <script>
        document.querySelector('#toggle-password').addEventListener('click', function() {
            const passwordInput = document.querySelector(this.getAttribute('toggle'));

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                this.style.backgroundImage ='url("{{ asset('/assets/img/icon/eye-open.svg') }}")'
            } else {
                passwordInput.type = 'password'
                this.style.backgroundImage = 'url("{{ asset('/assets/img/icon/eye-close.svg') }}")'
            }
        })
    </script>
@endsection
