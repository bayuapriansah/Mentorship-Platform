@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions/{{$institution->id}}/supervisors"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$institution->name}} <i class="fa-solid fa-chevron-right"></i> Edit Supervisor </h3>
  <a href="/dashboard/institutions/{{$institution->id}}/supervisors" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
<form action="/dashboard/institutions/{{$institution->id}}/supervisors/{{$supervisor->id}}" method="post" class="w-3/4">
  @method('patch')
  @csrf
  <input type="email" class="text w-full border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" value="{{ $supervisor->email }}" placeholder="Email *" id="email" name="email" ><br>
  @error('email')
      <p class="text-red-600 text-sm mt-1">
        {{$message}}
      </p>
  @enderror
  
  <div class="flex justify-between mt-4">
    <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="firstname" type="text" value="{{$supervisor->first_name}}" placeholder="First Name *" name="first_name" required><br>
    @error('first_name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror

    <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="lastname" type="text" value="{{$supervisor->last_name}}" placeholder="Last Name *" name="last_name" required><br>
    @error('last_name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>


  <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight bg-gray-300 invalid:text-black text-black cursor-not-allowed focus:outline-none" name="institution" disabled>
    <option value="{{ $supervisor->institution_id }}" selected>{{ $supervisor->institution->name }}</option>
  </select><br>
  @error('institution')
      <p class="text-red-600 text-sm mt-1">
        {{ $message}}
      </p>
  @enderror

  <div class="flex justify-between mt-4">
    <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 bg-gray-300 cursor-not-allowed focus:outline-none" id="ForCountry" type="text" value="{{$supervisor->country}}" placeholder="Country *" name="country" readonly required>
    <br>
    @error('country')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror

    <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight bg-gray-300 cursor-not-allowed focus:outline-none" id="ForState" type="text" value="{{$supervisor->state}}" placeholder="State *" name="state" readonly required>
    <br>
    @error('state')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Update</button>
  <a href="/dashboard/institutions/{{$institution->id}}/supervisors" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-dark-red border-solid border-dark-red text-center capitalize bg-orange text-white font-light text-sm intelOne">Cancel</a>

</form>
@endsection