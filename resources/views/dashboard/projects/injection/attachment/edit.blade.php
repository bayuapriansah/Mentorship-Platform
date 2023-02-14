@extends('layouts.admin2')
@section('content')
@if (Route::is('dashboard.partner.partnerProjectsInjectionAttachment'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/edit"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif

@if (Route::is('dashboard.partner.partnerProjectsInjectionAttachment'))
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Add Project <i class="fa-solid fa-chevron-right"></i> Injection Card <i class="fa-solid fa-chevron-right"></i> File Attachment</h3>
  <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/edit" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@else
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Projects</h3>
  <a href="#" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@endif
<form action="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment->id}}" class="w-3/4" enctype="multipart/form-data" method="post">
    @csrf
    @method('patch')
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-dark-blue" for="file_input">Upload Attachment 1<span class="text-red-600">*</span></label>
        <input class="block w-full text-sm text-dark-blue border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-4" id="file_input1" name="file_input1" type="file">
        @if ($attachment->file1)
            <a href="{{asset('storage/'.$attachment->file1)}}" target="_blank" class="text-lg text-dark-blue mt-2">*Attached File(Click to download)</a>
        @endif
        @error('file_input1')
            <p class="text-red-600 text-sm mt-1">
            {{$message}}
            </p>
        @enderror
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-dark-blue" for="file_input">Upload Attachment 2 (Optional)</label>
        <input class="block w-full text-sm text-dark-blue border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-4" id="file_input2" name="file_input2" type="file">
        @if ($attachment->file2)
            <a href="{{asset('storage/'.$attachment->file2)}}" target="_blank" class="text-lg text-dark-blue mt-2">*Attached File(Click to download)</a>
        @endif
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-dark-blue" for="file_input">Upload Attachment 3 (Optional)</label>
        <input class="block w-full text-sm text-dark-blue border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-4" id="file_input3" name="file_input3" type="file">
        @if ($attachment->file3)
            <a href="{{asset('storage/'.$attachment->file3)}}" target="_blank" class="text-lg text-dark-blue mt-2">*Attached File(Click to download)</a>
        @endif
    </div>
    <div class="mb-3">
        <input type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm cursor-pointer hover:bg-dark-blue" value="Add Attachment">
    </div>
</form>
@endsection
