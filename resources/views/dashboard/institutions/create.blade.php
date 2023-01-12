@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Institutions</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/institutions" method="post">
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
            <select class="form-control form-select" id="inputCountries" aria-label="Default select example" name="countries">
              <option>Country</option>
              @forelse($countries as $country)
              <option value="{{$country['iso2']}}">{{$country['name']}}</option>
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
            <input type="text" class="form-control" id="inputState" name="state" value="{{old('state')}}">
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
  // Fetch dari API
  $(document).ready(function() {
    $('#inputCountries').change(function(){
      // var iso2Data = $("#inputCountries option:selected").val();
      var e = document.getElementById("inputCountries");
      var iso2Datavalue = e.value;
      var text = e.options[e.selectedIndex].text;
      fetch("http://localhost:8000/api/countries?fields=iso2,states&filters[iso2]=" + iso2Datavalue)
        .then(response => response.json())
        .then(data => {
          console.log(data);
          //  $("#input").val(data);
        });     
    });
  });
</script>
@endsection