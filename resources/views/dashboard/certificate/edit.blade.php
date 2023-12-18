@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Certificate </h3>
</div>
<form action="/dashboard/certificate/add/{{$student->id}}" method="post" enctype="multipart/form-data">
  @csrf
  @method('PATCH')
  <input class="block w-1/2 text-sm text-gray-900 border border-light-blue rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 p-3 focus:outline-none " id="file_input" type="file" name="certificate">
  <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Add Certificate</button>
</form>
@endsection
