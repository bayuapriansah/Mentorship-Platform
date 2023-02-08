@extends('layouts.admin2')
@section('content')
@if (Route::is('dashboard.students.inviteFromInstitution'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions/{{$institution->id}}/students"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@else
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/students/"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$institution->name}} <i class="fa-solid fa-chevron-right"></i> Students <i class="fa-solid fa-chevron-right"></i> Invite</h3>
</div>

@if (Route::is('dashboard.students.inviteFromInstitution'))
<form action="{{ route('dashboard.students.sendInviteFromInstitution', ['institution'=>$institution->id]) }}" method="post" enctype="multipart/form-data">
@else
<form action="{{route('dashboard.students.sendInvite')}}" method="post" enctype="multipart/form-data">
@endif  
  @csrf
  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="email" type="email" value="{{old('email')}}" placeholder="Student Email" name="email" required><br>
    @error('email')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Invite Student</button>
  </div>
</form>

@endsection