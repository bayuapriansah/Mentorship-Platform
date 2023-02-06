@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Partners</h3>
</div>


<form action="/dashboard/partners/{{$company->id}}" method="post" enctype="multipart/form-data">
  @csrf
  @method('patch')
  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="name" type="text" placeholder="Partner Name" name="name" value="{{$company->name}}" required><br>
    @error('name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="address" type="text" placeholder="Partner Address" name="address" value="{{$company->address}}" required><br>
    @error('address')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="email" type="text" placeholder="Partner Email" name="email"  value="{{$company->email}}" required><br>
    @error('email')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <label for="inputlogo" class="form-label">Company logo</label><br>
    <img src="{{asset('storage/'.$company->logo)}}" alt="" style="width: 350px; height: 230px;">
    <input class="block w-1/2 text-sm text-gray-900 border border-light-blue rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 p-3 focus:outline-none " id="file_input" type="file" name="logo">
    @error('logo')
      <p class="text-danger text-sm mt-1">
        {{$message}}
      </p>
    @enderror
    <label for="inputlogo" class="form-label">*Max file size is 5MB</label><br>
    <label for="inputlogo" class="form-label">*Image Extension is png, jpg or jpeg</label>
    @error('logo')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Edit Partner</button>

  </div>
</form>
      
@endsection