@extends('layouts.index')
@section('content')
<section id="register" class="w-full">
  <div class="bg-darker-blue">
    <div class="max-w-[1366px] mx-auto px-16 py-10 grid grid-cols-12 gap-11 grid-flow-col ">
      <div class="col-span-7 relative">
        <h1 class="font-bold text-white text-3xl leading-10 relative z-20 pb-7">Register</h1>
        <p class="m-0 text-light-blue">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quae, eaque.</p>
        <img src="{{asset('assets/img/dotsdetail_1.png')}}" class="absolute z-10 w-[156px] h-[137px] -left-10 -top-2 ">
      </div>
      <div class="col-start-10 col-span-4 relative ">
      </div>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 grid grid-cols-12 gap-11 grid-flow-col">
    <div class="col-span-6">
      <h1 class="intelOne text-dark-blue font-bold text-4xl leading-11">Register</h1>
      <p class="intelOne font-light text-black text-lg leading-6 py-6">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
      <form action="{{route('register')}}" method="post" id="register">
        @csrf
        <div class="flex justify-between">
          <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 " id="firstname" type="text" value="{{old('first_name')}}" placeholder="First Name *" name="first_name" required><br>
          @error('first_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror

          <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight " id="lastname" type="text" value="{{old('last_name')}}" placeholder="Last Name *" name="last_name" required><br>
          @error('last_name')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>
        <div class="flex justify-between mt-4">
          <input class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight mr-5" id="dob" type="text" placeholder="Date of birth" onfocus="(this.type='date')"  value="{{old('date_of_birth')}}" name="date_of_birth" required><br>
          @error('date_of_birth')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
          
          <select id="sex" class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 invalid:text-lightest-grey leading-tight " name="sex" required>
            <option value="">Sex *</option>
            <option value="male" {{old('sex') == 'male' ? 'selected' : ''}}>Male</option>
            <option value="female" {{old('sex') == 'female' ? 'selected' : ''}}>Female</option>
          </select><br>
          @error('sex')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>

        <select id="inputInstitution" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight" name="institution" required>
          <option>Institution Name *</option>
          @forelse($GetInstituionData as $ins)
          <option value="{{$ins->id}}">{{$ins->institutions}}</option>
          @empty
          <p>There is no Country Data</p>
          @endforelse
        </select><br>
        @error('institution')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
        @enderror        
        
        <div class="flex justify-between mt-4">
          <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 bg-gray-300 cursor-not-allowed" id="ForCountry" type="text" value="{{old('country')}}" placeholder="Country *" name="country" readonly required>
          <br>
          @error('country')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror

          <input class=" border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight bg-gray-300 cursor-not-allowed" id="ForState" type="text" value="{{old('state')}}" placeholder="State *" name="state" readonly required>
          <br>
          @error('state')
              <p class="text-red-600 text-sm mt-1">
                {{$message}}
              </p>
          @enderror
        </div>

        <input type="email" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight {{old('email') != null ? 'border-red-500' : ''}}" value="{{old('email')}}" placeholder="Email *" id="email" name="email" required><br>
        @error('email')
            <p class="text-red-600 text-sm mt-1">
              {{$message}}
            </p>
        @enderror

        <div class="g-recaptcha mt-4" data-sitekey="{{config('services.recaptcha.key')}}"></div>
          @if(Session::has('g-recaptcha-response'))
            <p class="alert my-2 {{Session::get('alert-class', 'alert-info')}}">
            {{Session::get('g-recaptcha-response')}}
            </p>
          @endif
        <div class="flex items-center mt-4">
          <input type="checkbox" class="checked:bg-blue-500 mr-4" name="tnc" required>
          <p class="text-sm font-normal leading-4">I accept the <span class="text-dark-blue text-sm font-normal leading-4" >Terms & Conditions and Privacy Policies</span></p>
        </div>
        <div class="mt-4">
          @include('flash-message')
        </div>
        {{-- <div class="bg-red-alert intelOne text-sm p-4 w-2/3 rounded-lg mt-4 flex" role="alert">
          <img src="{{asset('assets/img/close.png')}}" class=" mr-4" alt="">
          This email address is already registered!
        </div> --}}
        <button class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm intelOne" type="submit">Sign Up</button>
      </form>
    </div>
    <div class="col-start-7 col-span-6 relative">
      <!-- block absolute top-1/2 -translate-y-1/2 right-7 max-w-[1366px]  -->
      <img src="{{asset('assets/img/home2.png')}}" class="relative z-20" alt="">

      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-1/4 -translate-y-2/4 right-7 " aria-hidden="true" >
      <img src="{{asset('assets/img/dots-2.png')}}" alt="dots" class="absolute z-10 top-2/4 -translate-y-1/4 left-7 " aria-hidden="true" >
      <!-- <img src="./assets/img/dots-1.png" alt="dots" class="hidden lg:block absolute top-1/2 -translate-y-1/2 -left-24 xl:-left-7" aria-hidden="true" > -->
      
    </div>Project Domain
  </div>
</section>
@endsection

@section('more-js')
<script>
  $(document).ready(function () {
      $('#inputInstitution').on('change', function () {
          var institutionVal = this.value;
          var base_url = window.location.origin;
          // $("#ForState").html('');
          // console.log(institutionVal);
          $.ajax({

              url: base_url+"/api/institution/"+institutionVal,
              contentType: "application/json",
              dataType: 'json',
              success: function (result) {
                // console.log(result);
                $('#ForCountry').val(result.countries);
                $('#ForState').val(result.states);
              }
          });
      });
  });
</script>
@endsection