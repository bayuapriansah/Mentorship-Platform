@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Institutions</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="{{ route('dashboard.institutions.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="inputname" class="form-label">Institution Name</label>
            <input type="text" class="form-control" id="inputname" name="name" value="{{old('name')}}">
            @error('name')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          {{-- @dd($countries) --}}
          <div class="mb-3">
            <label for="inputCountries" class="form-label">City</label>
            <select class="form-control form-select" id="inputCountries" name="countries">
              <option>Country</option>
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
            <label for="inputState" class="form-label">State</label>
            <select class="form-control form-select" id="inputState" name="state">
              <option>State</option>
            </select>
            @error('state')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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