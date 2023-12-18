@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Edit Profile</h3>
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
  @if(!Auth::guard('web')->check())
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
  @else
  <div class="flex justify-between">
    <input class="border border-light-blue rounded-lg w-full h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="name" type="text" value="{{$user->name}}" placeholder="Name *" name="name" required><br>
    @error('name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="flex justify-between mt-4">
    <input class="border bg-gray-300 border-light-blue rounded-lg w-full h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="email" type="text" value="{{$user->email}}" placeholder="Email *" name="email" readonly required><br>
    @error('email')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  @endif

  <div class="flex justify-between mt-4">
    @if(Auth::guard('mentor')->check())
      @if (Auth::guard('mentor')->user()->institution_id != 0)
      <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none cursor-not-allowed" id="" type="text" value="{{$user->email}}" placeholder="Email *" name="email" readonly><br>
      @else
      <input class="border bg-gray-300 border-light-blue rounded-lg w-full h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none cursor-not-allowed" id="" type="text" value="{{$user->email}}" placeholder="Email *" name="email" readonly><br>
      @endif
    @endif
      {{-- <input class="border bg-gray-300 border-light-blue rounded-lg w-full h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="" type="text" value="{{$user->email}}" placeholder="Email *" name="email" readonly><br> --}}


    @if(Auth::guard('mentor')->check())
      @if (Auth::guard('mentor')->user()->institution_id != 0)
        <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="lastname" type="text" value="{{$user->institution->name}}" placeholder="Last Name *" name="institution" readonly><br>
      @endif
    @elseif(Auth::guard('customer')->check())
      <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="lastname" type="text" value="{{$user->company->name}}" placeholder="Last Name *" name="company" readonly><br>
    @endif
  </div>

  @if(Auth::guard('mentor')->check())
    @if (Auth::guard('mentor')->user()->institution_id != 0)
      <div class="flex justify-between mt-4">
        <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none cursor-not-allowed" id="firstname" type="text" value="{{$user->state}}" placeholder="State" name="state" readonly><br>

        <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="lastname" type="text" value="{{$user->country}}" placeholder="Country" name="country" readonly><br>
      </div>
    @endif
  @elseif(Auth::guard('customer')->check())
    <div class="flex justify-between mt-4">
      <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none cursor-not-allowed" id="firstname" type="text" value="{{$user->company->address}}" placeholder="First Name *" readonly><br>

      <input class="border bg-gray-300 border-light-blue rounded-lg w-1/2 h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none cursor-not-allowed" id="lastname" type="text" value="{{$user->company->email}}" placeholder="Last Name *" readonly><br>
    </div>
  @endif

  <div class="flex mt-4">
    @if(Auth::guard('mentor')->check())
      @if (Auth::guard('mentor')->user()->institution_id != 0)
        <input class="border border-light-blue rounded-lg w-full h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="" type="text" value="{{$user->position}}" placeholder="Position" name="position" required><br>
        @error('position')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
        @enderror
      @endif
    @elseif(Auth::guard('customer')->check())
      <input class="border border-light-blue rounded-lg w-full h-12 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="" type="text" value="{{$user->position}}" placeholder="Position" name="position" required><br>
      @error('position')
          <p class="text-red-600 text-sm mt-1">
            {{$message}}
          </p>
      @enderror
    @endif
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
