@extends('layouts.admin2')
@section('content')
@if (Route::is('dashboard.partner.partnerProjectsEdit'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/partners/{{$partner->id}}/projects"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif

@if (Route::is('dashboard.partner.partnerProjectsEdit'))
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Add Project</h3>
  <a href="/dashboard/partners/{{$partner->id}}/projects" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@else
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Projects</h3>
  <a href="#" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@endif

@if (Route::is('dashboard.partner.partnerProjectsEdit'))
<form action="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}" method="post" enctype="multipart/form-data" class="w-3/4">
@else
<form action="/dashboard/projects/{{$project->id}}" method="post" enctype="multipart/form-data" class="w-3/4">
@endif
  @csrf
  @method('PATCH')
  {{-- <input type="hidden" value="{{$project->id}}" name="id"> --}}
  <div class="mb-3">
    <input type="text" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="inputname" name="name" value="{{$project->name}}">
    @error('name')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3 flex justify-between">
    <select class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none" id="inputdomain" aria-label="Default select example" name="project_domain">
      <option value="" hidden>Select Project Domain *</option>
      <option value="nlp" {{$project->project_domain == 'nlp'? 'selected':''}}>NLP</option>
      <option value="statistical" {{$project->project_domain == 'statistical'? 'selected':''}}>Statistical</option>
      <option value="computer_vision" {{$project->project_domain == 'computer_vision'? 'selected':''}}>Computer Vision</option>
    </select>
    @error('project_domain')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror

    <select class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight  invalid:text-lightest-grey focus:outline-none" id="inputperiod"  name="period">
      <option value="" hidden>Project Duration *</option>
      <option value="1" {{$project->period == '1' ? 'selected': ''}}>1 Month</option>
      <option value="2" {{$project->period == '2' ? 'selected': ''}}>2 Months</option>
      <option value="3" {{$project->period == '3' ? 'selected': ''}}>3 Months</option>
    </select>
    @error('period')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <select class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none" id="inputpartner"  name="partner" disabled>
      <option value="{{$partner->id}}" hidden>{{$partner->name}}</option>
    </select>
    @error('partner')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    {{-- <input type="text" class="form-control" id="inputproblem" name="problem" value="{{$project->problem}}"> --}}
    <textarea name="problem" id="problem" cols="30" rows="10">{{$project->problem}}</textarea>
    @error('problem')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <input type="text" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" placeholder="Brief Project Overview (Optional)" id="inputoverview" name="overview" value="{{$project->overview}}">
    @error('overview')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  {{-- @if(Auth::guard('web')->check())
  <div class="mb-3">
    <label for="inputvalid" class="form-label">Company</label>
    <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="company_id">
      <option value="">--Select Project Domain--</option>
      @foreach($companies as $company)
      <option value="{{$company->id}}" {{$company->id == $project->company_id? 'selected':''}} >{{$company->name}}</option>
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
      <option value="{{$project->institution_id}}">{{ $GetInstituionData->where('id',$project->institution_id)->first()->institutions }}</option>
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
  <div class="mb-3 mt-10 flex justify-between">
    <h3 class="text-dark-blue font-medium text-xl">Injection Cards</h3>
    <div class="text-xl text-dark-blue">
      {{-- <input type="submit" class="cursor-pointer" name="addInjectionCard" value="Add Injection Card"> --}}
      <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection"><i class="fa-solid fa-circle-xmark"></i> Add Injection Card</a>
    </div>
  </div>
  <div class="mb-3 space-y-2">
    @php
        $no = 1
    @endphp
    @foreach ($cards as $card)
    <div class="py-4 px-6 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
      <div>Task {{$no}}: {{substr($card->title,0,38)}}...</div>
      <div class="flex flex-col">
        <span class="text-xs">Duration:</span>
        <span class="text-xs text-dark-blue">{{$card->duration}} {{$card->duration==1?'Day':'Days'}}</span>
      </div>
      <div class="flex flex-col">
        <span class="text-xs">Added On:</span>
        <span class="text-xs text-dark-blue">{{$card->created_at->format('d/m/Y')}}</span>
      </div>
      <div class="space-x-5">
        <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$card->id}}/edit"><i class="fa-solid fa-pencil fa-lg text-dark-blue my-auto"></i></a>
        <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$card->id}}/delete"><i class="fa-solid fa-trash-can text-red-600 fa-lg my-auto"></i></a>
      </div>
      {{-- <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-5 text-dark-blue">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
      </svg> --}}
    </div>
    @php
      $no++
    @endphp
    @endforeach
  </div>
  <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Edit Project</button>
</form>
@endsection
