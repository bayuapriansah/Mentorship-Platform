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
      </div>
    </div>
  </div>
</div>
@endsection