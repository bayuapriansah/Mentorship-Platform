@extends('layouts.admin2')
@section('content')
@if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/edit"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@else
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/projects/{{$project->id}}/edit"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif

@if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Add Project <i class="fa-solid fa-chevron-right"></i> Injection Card</h3>
  <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/edit" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@else
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Project <i class="fa-solid fa-chevron-right"></i> Add Project <i class="fa-solid fa-chevron-right"></i> Injection Card</h3>
  <a href="/dashboard/projects/{{$project->id}}/edit" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>
@endif
@include('flash-message')
@if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
<form action="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}" method="post" enctype="multipart/form-data" class="w-3/4">
@else
<form action="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}" method="post" enctype="multipart/form-data" class="w-3/4">
@endif
  @method('PATCH')
  @csrf
  <div class="mb-3">
    <input type="text" class="border border-light-blue rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" placeholder="Injection Card Title *" id="inputtitle" name="title" value="{{$injection->title}}">
    @error('title')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3 flex justify-between" >
    <select class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none" id="inputfiletype" aria-label="Default select example" name="inputfiletype">
      <option value="">Select file input type *</option>
      <option value="zip" {{$injection->file_type == 'zip' ? 'selected': ''}}>.zip</option>
      <option value="pdf" {{$injection->file_type == 'pdf' ? 'selected': ''}}>.pdf</option>
      <option value="docx" {{$injection->file_type == 'docx' ? 'selected': ''}}>.docx</option>
      <option value="pptx" {{$injection->file_type == 'ppt' ? 'selected': ''}}>.pptx</option>
    </select>
    @error('inputfiletype')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror

    @php
        $durations = range(1,10);
    @endphp
    <select class="border border-light-blue rounded-lg w-1/2 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none" id="inputcardduration" aria-label="Default select example" name="duration">
      <option value="" hidden>Task Duration *</option>
      @foreach ($durations as $duration)
      <option value="{{$duration}}"{{$duration == $injection->duration?'selected':''}}>{{$duration}} {{$duration==1?'day':'days'}}</option>
      @endforeach
    </select>
    @error('duration')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <div class="mb-3">
    <select class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none" id="inputproject"  name="project" disabled>
      <option value="{{$project->id}}" hidden>{{$project->name}}</option>
    </select>
    @error('project')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-3">
    <textarea name="description" id="sectionDesc" cols="30" rows="10" placeholder="Task Details*">{{$injection->description}}</textarea>
    @error('description')
        <p class="text-danger text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  {{-- <div class="mb-3">
    <div class="relative cursor-pointer bg-white " id="drop-area">
      <label for="file-input">
        <div class="relative cursor-pointer" id="drop-area">
          <input type="file" name="file" class="absolute opacity-0" id="file-input" >
          <div class="p-6 border-2 border-dashed hover:bg-white rounded-md border-light-blue">
              <div class="text-center">
                <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                  <p class="mt-1 text-sm text-gray-600">
                    Click to upload or drag and drop document
                  </p>
                  <p class="text-xs text-gray-500 "> (MAX. 5MB)</p>
                  <p class="mt-2 text-sm text-gray-600" id="file-name"></p>
              </div>
          </div>
        </div>
      </label>
    </div>
  </div> --}}

  {{-- <div class="mb-3">
    <div class="py-4 px-6 w-3/4 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
    <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
    <a href="{{asset('storage/'.$injection->file1)}}" target="_blank" class="text-base">Attachment File</a>
    <i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i>
    </div>
  </div> --}}
  <div class="mb-3 mt-10 flex justify-between">
    <h3 class="text-dark-blue font-medium text-xl">File Attachment</h3>
    {{-- @dd($attachment_id); --}}
    <div class="text-xl text-dark-blue">
      {{-- <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit"><i class="fa-solid fa-circle-xmark"></i> Add File Attachment</a> --}}
      @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
        @if ($attachment_id)
          <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
        @else
         <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
        @endif
      @else
        @if ($attachment_id)
          <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
        @else
          <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
        @endif
        
      @endif
    </div>
  </div>
  <div class="mb-3 space-y-2">
    @forelse ($attachments as $attachment)
    <div class="py-4 px-6 w-3/4 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
        <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
        <a href="{{asset('storage/'.$attachment->file1)}}" target="_blank" class="text-base">Attachment File 1</a>
        {{-- /dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit --}}
        @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
          <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{1}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a>
        @else
        <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{1}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a>
          
        @endif
    </div>

    @if ($attachment->file2)
        <div class="py-4 px-6 w-3/4 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
            <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
            <a href="{{asset('storage/'.$attachment->file2)}}" target="_blank" class="text-base">Attachment File 2</a>
            @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
              <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{2}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a>
            @else
            <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{2}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a>
            @endif
        </div>
    @endif

    @if ($attachment->file3)
        <div class="py-4 px-6 w-3/4 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
            <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
            <a href="{{asset('storage/'.$attachment->file3)}}" target="_blank" class="text-base">Attachment File 3</a>
            @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
              <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{3}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a>
            @else
              <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{3}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a>
            @endif
        </div>
    @endif
    @empty
    <p>No Attachments </p>
    @endforelse
  </div>
  <div class="mb-3">
    <input type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue hover:bg-dark-blue text-center capitalize bg-orange text-white font-light text-sm cursor-pointer" value="Submit">
  </div>
</form>
@endsection
@section('more-js')
<script>
const dropArea = document.getElementById('drop-area')
const fileInput = document.getElementById('file-input')
const fileName = document.getElementById('file-name')
// fileName.style.visibility = "hidden"
// Listen for file drag-and-drop events
dropArea.addEventListener('dragover', e => {
    e.preventDefault()
    dropArea.classList.add('bg-gray-200')
})
dropArea.addEventListener('dragleave', e => {
    e.preventDefault()
    dropArea.classList.remove('bg-gray-200')
})
dropArea.addEventListener('drop', e => {
    e.preventDefault()
    dropArea.classList.remove('bg-gray-200')
    fileInput.files = e.dataTransfer.files
    fileName.innerHTML = `<i class="fas fa-times"></i> ${e.dataTransfer.files[0].name}`
    // You can handle the files here.
    handleUpload(e.dataTransfer.files)
    const fileClear = document.querySelector('.fa-times')
    fileClear.addEventListener('click', e => {
        e.preventDefault();
        fileName.textContent = '';
        fileInput.value = '';
        resetUI();
    });
})

// Listen for file input change events
fileInput.addEventListener('change', e => {
    fileName.innerHTML = `<i class="fas fa-times"></i> ${e.target.files[0].name}`
    // You can handle the files here.
    handleUpload(e.target.files)
    const fileClear = document.querySelector('.fa-times')
    fileClear.addEventListener('click', e => {
        e.preventDefault();
        fileName.textContent = '';
        fileInput.value = '';
        resetUI();
    });
})

// Example function for handling file uploads
function handleUpload(files) {
    console.log('Uploading files:', files)
    // Do something with the files here
}

// Example function for resetting the UI
function resetUI() {
    console.log('Resetting UI');
    // Do something to reset the UI
}

</script>
@endsection
