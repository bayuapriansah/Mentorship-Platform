@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/staffs"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Edit Staff Member</h3>
  <a href="/dashboard/staffs" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
<form action="/dashboard/staffs/{{$staff->id}}/update" method="post" class="w-3/4">
  @method('patch')
  @csrf
  <input type="email" class="text w-full border border-light-blue rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" value="{{ $staff->email }}" placeholder="Email *" id="email" name="email" ><br>
  @error('email')
      <p class="text-red-600 text-sm mt-1">
        {{$message}}
      </p>
  @enderror
  
  <div class="flex justify-between mt-4">
    <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="firstname" type="text" value="{{$staff->first_name}}" placeholder="First Name *" name="first_name" required><br>
    @error('first_name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror

    <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none" id="lastname" type="text" value="{{$staff->last_name}}" placeholder="Last Name *" name="last_name" required><br>
    @error('last_name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Update</button>
  <a href="/dashboard/staffs" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-dark-red border-solid border-dark-red text-center capitalize bg-orange text-white font-light text-sm intelOne">Cancel</a>

</form>
@endsection