@extends('layouts.admin2')
@section('content')

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Edit Profile</h3>
  @include('flash-message')
</div>

@if (Auth::guard('web')->check()) 
<form action="/dashboard/profile/{{Auth::guard('web')->user()->id}}" method="post" enctype="multipart/form-data" class="w-3/4">

@elseif(Auth::guard('mentor')->check())
<form action="/dashboard/profile/{{Auth::guard('mentor')->user()->id}}" method="post" enctype="multipart/form-data" class="w-3/4">

@elseif(Auth::guard('customer')->check())
<form action="/dashboard/profile/{{Auth::guard('customer')->user()->id}}" method="post" enctype="multipart/form-data" class="w-3/4">

@endif
  @csrf
  @method('PATCH')
  <div class="flex justify-between">
    <input class="border border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="firstname" type="text" value="{{$user->first_name}}" placeholder="First Name *" name="first_name" required><br>
    @error('first_name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
    <input class="border border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="lastname" type="text" value="{{$user->last_name}}" placeholder="Last Name *" name="last_name" required><br>
    @error('last_name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="flex justify-between mt-4">
    <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none cursor-not-allowed" id="firstname" type="text" value="{{$user->email}}" placeholder="First Name *" name="email" readonly><br>
   
    <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="lastname" type="text" value="{{$user->institution->name}}" placeholder="Last Name *" name="institution" readonly><br>
  </div>

  <div class="flex justify-between mt-4">
    <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none cursor-not-allowed" id="firstname" type="text" value="{{$user->state}}" placeholder="First Name *" name="state" readonly><br>
   
    <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="lastname" type="text" value="{{$user->country}}" placeholder="Last Name *" name="country" readonly><br>
  </div>

  <div class="flex justify-between mt-4">
    <select id="sex" class="border border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5 focus:outline-none" name="sex" required>
      <option value="" class="" hidden>Sex *</option>
      <option value="male" {{$user->sex == 'male' ? 'selected' : ''}}>Male</option>
      <option value="female" {{$user->sex == 'female' ? 'selected' : ''}}>Female</option>
    </select><br>
    @error('sex')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
   
    <input class="border border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="" type="text" value="{{$user->position}}" placeholder="Position" name="position" required><br>
    @error('position')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="flex justify-between mt-4">
    <h3 class="text-dark-blue font-medium text-xl">Change Password</h3>
  </div>
  <div class="flex flex-col mt-4">
    <input type="password" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="New password" id="password" name="password" >
    @error('password')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
    <input type="password" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"  placeholder="Confirm new password" name="password_confirmation" >
    @error('password_confirmation')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Update Profile</button>

  <div class="flex justify-between mt-4">
  </div>
</form>
@endsection