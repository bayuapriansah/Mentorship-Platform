@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Institutions</h3>
</div>


<form action="{{ route('dashboard.institutions.update',[$id]) }}" method="post" enctype="multipart/form-data">
  @csrf
  @method('PATCH')
  <div class="mb-3">
    {{-- <input type="hidden" name="id" value="{{$id}}"> --}}
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="name" type="text" value="{{$institutions_view->institutions}}" placeholder="Institution Name" name="name" required>
    @error('name')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="name" type="text" value="{{$institutions_view->email}}" placeholder="Institution Email" name="email" required>
    @error('email')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  {{-- @dd($countries) --}}
  <div class="mb-3">
    <select class="text w-3/4 border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none" id="inputCountries" name="countries">
      <option>Select Country</option>
      <option value="{{$institutions->country}}" selected>{{$institutions_view->countries}}</option>
      @forelse($countries as $country)
      <option value="{{$country['id']}}">{{$country['name']}}</option>
      @empty
      <p>There is no Country Data</p>
      @endforelse
    </select>
    @error('countries')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <select class="text w-3/4 border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none" id="inputState" name="state">
      <option>Select State</option>
      <option value="{{$institutions->state}}" selected>{{$institutions_view->states}}</option>
    </select>
    @error('state')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <img src="{{asset('storage/'.$institutions->logo)}}" alt="" class="object-scale-down" style="width: 350px; height: 230px;">
    <input type="file" class="block w-1/2 text-sm text-gray-900 border border-light-blue rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 p-3 focus:outline-none " id="inputlogo" name="logo">
    <label for="inputlogo" class="form-label">*Max file size is 5MB</label><br>
    <label for="inputlogo" class="form-label">*Image Extension is png, jpg or jpeg</label>
    @error('logo')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Confirm</button>
    <a href="/dashboard/institutions_partners" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-dark-red border-solid border-dark-red text-center capitalize bg-orange text-white font-light text-sm">Cancel</a>
  </div>
</form>
<script>
  $(document).ready(function () {
      $('#inputCountries').on('change', function () {
          var iso2Country = this.value;
          var base_url = window.location.origin;
          $("#inputState").html('');
          $.ajax({
              url: base_url+"/api/countries?fields=iso2,states&filters[id]="+iso2Country,
              contentType: "application/json",
              dataType: 'json',
              success: function (result) {
                  if(result.data && result.data[0] && result.data[0].states){
                      $('#inputState').html('<option value="">Select State</option>');
                      $.each(result.data[0].states, function (key, value) {
                          $("#inputState").append('<option value="' + value.id + '">' + value.name + '</option>');
                      });
                  } else {
                      // console.log("Error: 'states' property is undefined");
                      $('#inputState').html('<option value="">Not Available</option>');
                  }
              }
          });
      });
  });
</script>
@endsection