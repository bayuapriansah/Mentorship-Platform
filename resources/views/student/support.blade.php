@extends('layouts.profile.index')
@section('content')
<div class="min-h-screen">
  <div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col ">
    <div class="col-span-8">
      {{-- <div class="mt-4">
        @include('flash-message')
      </div> --}}
      <div class="flex justify-between">
        <h1 class="text-dark-blue text-2xl font-medium flex items-center">Contact Support</h1>
        @include('flash-message')
      </div>
      <p>Contact the Simulated Internship Platform team for any technical support that you require. 
        For project support, kindly use the chat feature available under each project task.</p>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 pt-5 grid grid-cols-12 gap-8 grid-flow-col ">
    <div class="col-span-6">
      <form action="/profile/{{Auth::guard('student')->user()->id}}/support" method="post">
        @csrf
        <div class="mb-3 flex justify-between">
          <input type="text" name="first_name" placeholder="First Name*" class="border bg-[#E8E8E8] border-light-blue rounded-lg w-1/2 mr-5 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" value={{Auth::guard('student')->user()->first_name}}
          required readonly>
          @error('first_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror

          <input type="text" name="last_name" placeholder="Last Name*" class="border bg-[#E8E8E8] border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" value={{Auth::guard('student')->user()->last_name}} required readonly>
          @error('last_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        <div class="mb-3">
          <input type="text" name="email" placeholder="Last Name*" class="border bg-[#E8E8E8] border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" value={{Auth::guard('student')->user()->email}} required readonly>
          @error('email')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        <div class="mb-3">
            <select id="query" class="text w-full border border-light-blue rounded-lg py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="query" required>
              <option value="" hidden>Type Of Query *</option>
              <option value="Bugs">Bugs</option>
              <option value="Functionality issues">Functionality issues</option>
              <option value="Performance problems">Performance problems</option>
              <option value="Compatibility errors">Compatibility errors</option>
              <option value="Security concerns">Security concerns</option>
              <option value="User interface glitches">User interface glitches</option>
              <option value="Other">Other</option>
            </select><br>
            @error('query')
                <p class="text-red-600 text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
        </div>
        <div class="mb-3">
          <textarea name="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-light-blue focus:outline-none" placeholder="Your Message*" required></textarea>
          @error('message')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
          @enderror
        </div>
        <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Send</button>
    </div>
  </div>
</div>
@endsection