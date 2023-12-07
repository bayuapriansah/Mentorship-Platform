@extends('layouts.index')
@section('content')
@if (session()->has('reset-password-link-sent'))
    <div class="max-w-[1366px] min-h-[539px] mx-auto bg-white flex flex-col justify-center items-center">
        <img src="{{ asset('/assets/img/Mar-Business_18.png') }}" alt="Illustration" class="w-[289px]">

        <h1 class="text-darker-blue font-bold text-3xl text-center">
            Please check your email inbox
        </h1>

        <p class="mt-9 text-center text-xl">
            The link to reset your password has been sent, please check your email.
        </p>
    </div>
@else
    <div class="bg-black bg-cover bg-center" style="background-image: url({{ asset('/assets/img/main/background-1.svg') }})">
        <div class="max-w-screen-xl mx-auto px-6 tab:px-[4.5rem] py-11 flex">
            <form action="{{ url('/forgot-password') }}" method="POST">
                @csrf

                <a href="{{ route('multiLogIn') }}" class="text-white text-sm hover:underline">
                    < Go Back
                </a>

                <h1 class="mt-[4.75rem] text-3xl text-[#FF8F51] font-bold">
                    Reset Password
                </h1>

                <div class="mt-7">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email Address *"
                        class="w-[442px] border rounded-lg h-11 py-2 px-4 focus:outline-none leading-tight {{ old('email') != null ? 'border-red-500' : 'border-grey' }}"
                        required
                    >

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="w-[190px] h-[51px] mt-8 rounded-full bg-primary text-white font-medium text-lg">
                    Send Instructions
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
@endif
@endsection
