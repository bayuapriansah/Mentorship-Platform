@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Institutions</h3>
</div>

<form action="{{ route('dashboard.institutions.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="name" type="text" value="{{old('name')}}" placeholder="Institution Name" name="name" required><br>
    @error('name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="email" type="email" value="{{old('email')}}" placeholder="Institution Email" name="email" required><br>
    @error('email')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <select class="text w-3/4 border border-light-blue rounded-lg h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none" id="inputCountries" name="countries" >
      <option hidden>Country<option>
      @forelse($countries as $country)
      <option value="{{$country['id']}}">{{$country['name']}}</option>
      @empty
      <p>There is no Country Data</p>
      @endforelse
    </select>
    @error('countries')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <select class="text w-3/4 border border-light-blue rounded-lg h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none" id="inputState" name="state">
    <option hidden>State</option>
    </select>
    @error('state')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <input class="block w-1/2 text-sm text-gray-900 border border-light-blue rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 p-3 focus:outline-none " id="file_input" type="file" name="logo">
    <label for="inputlogo" class="form-label">*Max file size is 5MB</label><br>
    <label for="inputlogo" class="form-label">*Image Extension is png, jpg or jpeg</label>

    @error('logo')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Add Institution</button>
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
                // console.log(result.data['0'].states);
                  $('#inputState').html('<option value="">Select State</option>');
                  $.each(result.data['0'].states, function (key, value) {
                      $("#inputState").append('<option value="' + value
                          .id + '">' + value.name + '</option>');
                  });
                  // $('#inputCity').html('<option value="">Select City</option>');
              }
          });
      });
  });
</script>
@endsection
