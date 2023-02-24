@extends('layouts.admin2')
@section('content')
@if (Route::is('dashboard.partner.partnerProjectsCreate'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/partners/{{$partner->id}}/projects"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif
@if (Route::is('dashboard.partner.partnerProjectsCreate'))
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Add Project</h3>
  <a href="/dashboard/partners/{{$partner->id}}/projects" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@else
<div class="flex justify-between mb-10">
  @if(Auth::guard('web')->check())
    <h3 class="text-dark-blue font-medium text-xl">Projects</h3>
  @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
    <h3 class="text-dark-blue font-medium text-xl">Submit Project Proposal</h3>
  @endif
  <a href="/dashboard/projects" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@endif
@include('flash-message')
@if (Route::is('dashboard.partner.partnerProjectsCreate'))
<form action="/dashboard/partners/{{$partner->id}}/projects" method="post" enctype="multipart/form-data" class="w-3/4">
@else
<form action="/dashboard/projects" method="post" enctype="multipart/form-data" class="w-3/4">
@endif
  @csrf
  <div class="mb-3">
    <input type="text" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" placeholder="Project Name *" id="inputname" name="name" value="{{old('name')}}">
    @error('name')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3 flex justify-between">
    <select class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none" id="inputdomain"  name="project_domain">
      <option value="" hidden>Select Project Domain *</option>
      <option value="nlp" {{old('domain') == 'nlp' ? 'selected': ''}}>NLP</option>
      <option value="statistical" {{old('domain') == 'statistical' ? 'selected': ''}}>Statistical Data</option>
      <option value="computer_vision" {{old('domain') == 'computer_vision' ? 'selected': ''}}>Computer Vision</option>
    </select>
    @error('domain')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror


    <select class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" id="inputperiod"  name="period">
      <option value="" hidden>Project Duration *</option>
      <option value="1" {{old('period') == '1' ? 'selected': ''}}>1 Month</option>
      <option value="2" {{old('period') == '2' ? 'selected': ''}}>2 Months</option>
      <option value="3" {{old('period') == '3' ? 'selected': ''}}>3 Months</option>
    </select>
    @error('period')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    @if (Route::is('dashboard.partner.partnerProjectsCreate'))
      <select class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none" id="inputpartner"  name="partner" disabled>
        <option value="{{$partner->id}}" hidden>{{$partner->name}}</option>
      </select>
    @else
      @if (Auth::guard('customer')->check())
        <select class="border bg-gray-300 border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none"id="inputpartner"  name="partner" disabled >
            <option value="{{Auth::guard('customer')->user()->company_id}}" >{{Auth::guard('customer')->user()->company->name}}</option>
        </select>
      @else
        <select class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none"id="inputpartner"  name="partner" >
          <option value="" hidden>Select Partner</option>
          @foreach ($partners as $partner)
            <option value="{{$partner->id}}" >{{$partner->name}}</option>
            @endforeach
        </select>
      @endif
    @endif
    @error('partner')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    {{-- <input type="text" class="form-control" id="inputproblem" name="problem" value="{{old('problem')}}"> --}}
    <textarea name="problem" id="problem" cols="30" rows="10">{{old('problem')}}</textarea>
    @error('problem')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <select class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" id="inputprojecttype"  name="projectType" >
        <option value="" hidden>Project type</option>
        <option value="public">Public to all institutions</option>
        @if(Auth::guard('web')->check() || Auth::guard('customer')->check())
          <option value="private">Private to one institution</option>
        @elseif(Auth::guard('mentor')->check())
          <option value="private">Private to your institution ({{Auth::guard('mentor')->user()->institution->name}})</option>
        @endif
    </select>
    @error('projectType')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <select class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" id="inputinstitution"  name="institution_id" >
        <option value="" hidden>Select Institution</option>
        @foreach ($institutions as $institution)
        <option value="{{$institution->id}}" >{{$institution->name}}</option>
        @endforeach
    </select>
  </div>

  <div class="mb-3">
    <input type="text" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" placeholder="Brief Project Overview (Optional)" id="inputoverview" name="overview" value="{{old('overview')}}">
    @error('overview')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  {{-- <div class="mb-3">
    <label for="inputperiod" class="form-label">Period *max 3</label>
    <div class="row">
      <div class="col">
        <input type="number" class="form-control" id="inputperiod" name="period" value="{{old('period')}}">
      </div>
      <div class="col my-auto">
        <label for="inputperiod" class="form-label" id="period_text_month">Month</label>
      </div>
    </div>

    @error('period')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div> --}}

  {{-- fix id name and option value to clear the confussion --}}
  {{-- @if(Auth::guard('web')->check())
  <div class="mb-3">
    <label for="inputvalid" class="form-label">Company</label>
    <select class="form-control form-select" id="inputCompany" aria-label="Default select example" name="company_id">
      <option value="">--Select Project Company--</option>
      @foreach($companies as $company)
      <option value="{{$company->id}}" {{old('company_id') == $company->id ? 'selected': ''}} >{{$company->name}}</option>
      @endforeach
    </select>
    @error('company_id')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  @endif --}}

  {{-- add institution dropdown --}}
  {{-- @if(Auth::guard('web')->check())
  <div class="mb-3">
    <label for="inputvalid" class="form-label">Institution</label>
    <select class="form-control form-select" id="inputInstitution" aria-label="Default select example" name="institution_id">
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
  </div>
  @endif --}}
  <div class="mb-3 mt-7">
    <h3 class="text-dark-blue font-medium text-xl">Add Dataset <span class="text-red-600">*</span></h3>
    <input type="text" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" placeholder="Add Data set URLs separated by semi-colon" id="inputdataset" name="dataset" value="{{old('dataset')}}">
    @error('dataset')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  @if (Auth::guard('web')->check())
  <div class="mb-3 mt-10 flex justify-between">
    <h3 class="text-dark-blue font-medium text-xl">Injection Cards</h3>
      <div class="text-xl text-dark-blue">
        <i class="fa-solid fa-circle-plus"></i>
        <input type="submit" class="cursor-pointer" name="addInjectionCard" value="Add Injection Card">
      </div>
  </div>
  @endif

  <div class="mb-3">
    @if (Auth::guard('web')->check())
      <input type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue hover:bg-dark-blue border-solid text-center capitalize bg-orange text-white font-light text-sm cursor-pointer" name="addProject" value="Add Project">
    @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
      <input type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue hover:bg-dark-blue border-solid text-center capitalize bg-orange text-white font-light text-sm cursor-pointer" name="addProject" value="Propose Project">
    @endif
  </div>
</form>
@endsection

@if(Auth::guard('web')->check() || Auth::guard('customer')->check())
  @section('more-js')
  <script>
    $(document).ready(function () {
        $('#institution').on('change', function () {
            var institutionVal = this.value;
            var base_url = window.location.origin;
            $("#ForState").html('');
            $.ajax({
                url: base_url+"/api/institution/"+institutionVal,
                contentType: "application/json",
                dataType: 'json',
                success: function (result) {
                  console.log(result);
                  $('#ForCountry').val(result.countries);
                  $('#ForState').val(result.states);
                }
            });
        });

        $('#inputinstitution').hide();
        $("#inputprojecttype").change(function(){
          var values = $("#inputprojecttype option:selected").val();
          if(values=='private'){
            $('#inputinstitution').show();
          }else{
            $('#inputinstitution').hide();
          }
        });
    });
  </script>
  @endsection
@elseif(Auth::guard('mentor')->check())
  @section('more-js')
  <script>
    $(document).ready(function () {
        $('#institution').on('change', function () {
            var institutionVal = this.value;
            var base_url = window.location.origin;
            $("#ForState").html('');
            $.ajax({
                url: base_url+"/api/institution/"+institutionVal,
                contentType: "application/json",
                dataType: 'json',
                success: function (result) {
                  console.log(result);
                  $('#ForCountry').val(result.countries);
                  $('#ForState').val(result.states);
                }
            });
        });

        $('#inputinstitution').hide();
    });
  </script>
  @endsection
@endif
