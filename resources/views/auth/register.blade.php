@extends('layouts.index')
@section('content')
<section id="register" class="w-full">
  <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-6">
      <h1 class="intelOne text-dark-blue font-bold text-4xl leading-11">Register</h1>
      <p class="intelOne font-light text-black text-lg leading-6 py-6">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
      <form action="#" method="post">
        @csrf
        <div class="flex justify-between">
          <input class=" border rounded w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 " id="firstname" type="text" placeholder="First Name *" name="first_name" required>
          <input class=" border rounded w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight " id="lastname" type="text" placeholder="Last Name *" name="last_name" required>
        </div>
        <div class="flex justify-between mt-4">
          <input class=" border rounded w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5" id="dob" type="date" name="date_of_birth" required>
          <select id="sex" class="border rounded w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:ring-blue-500 focus:border-blue-500 " name="sex" required>
            <option value="">Sex *</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="flex justify-between mt-4">
          <select id="country" class="border rounded w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:ring-blue-500 focus:border-blue-500 mr-5" name="country" required>
            <option value="">Country *</option>
            <option value="sad">Male</option>
            <option value="sdw">Female</option>
          </select>
          <select id="" class="border rounded w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight focus:ring-blue-500 focus:border-blue-500" name="state" required>
            <option value="">State *</option>
            <option value="sd">Male</option>
            <option value="wdw">Female</option>
          </select>
        </div>
        <input type="text" class="text w-full border rounded mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight" placeholder="Institution Name *" name="institution_name" required>
        <input type="email" class="text w-full border rounded mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight" placeholder="Email *" name="email" required>
        <div class="flex items-center mt-4">
          <input type="checkbox" class="checked:bg-blue-500 mr-4" name="tnc" required>
          <p class="text-sm font-normal leading-4">I accept the <span class="text-dark-blue text-sm font-normal leading-4" >Terms & Conditions and Privacy Policies</span></p>
        </div>
        <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Sign Up</button>
      </form>
    </div>
    <div class="col-start-7 col-span-6 relative">
      <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
      <img src="assets/img/home1.png" class="relative z-20" alt="">

      <img src="./assets/img/dots-1.png" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
      <img src="./assets/img/dots-2.png" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
      <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->
      
    </div>
  </div>
</section>
@endsection