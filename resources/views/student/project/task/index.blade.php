@extends('layouts.profile.index')
@section('content')
@include('flash-message')
  {{-- @dd($task->project->name); --}}
<div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center ">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-6 my-auto">
        <h2 class="text-dark-blue text-2xl font-medium mb-3">{{$task->project->name}}</h2>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30 ">{{$task->project->project_domain}}</span>
      </div>
      <div class="col-span-6 relative">
        <img src="{{asset('assets/img/icon/profile/dots.png')}}" class="absolute z-10 right-0 -top-3 ">
        <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4 absolute z-30 right-10 top-10 ">
          <img src="{{asset('storage/'.$task->project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">{{$task->title}}</h1>
      </div>
      <div class="col-start-10 col-span-3">
          <span class="intelOne text-black text-sm font-normal">due date</span> 
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-3">
      <div class="col-span-9 problem text-justify">
        {!!$task->description!!}
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-12">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">Attachment</h1>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mb-3">
      <div class="col-span-12">
        @foreach($task->sectionSubsections as $subsection)
        <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium ">
          <a href="{{asset('storage/'.$subsection->file1)}}" class="flex justify-between items-center">
            {{$subsection->title}} {{substr($subsection->file1, strpos($subsection->file1, '.'))}}
            <img src="{{asset('assets/img/icon/download.png')}}" alt="">
          </a>
        </div>
        @endforeach
      </div>
    </div>
    <!-- Modal toggle -->
    <!-- Main modal -->
    <div id="staticModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative border-4 border-dashed border-inherit drop-shadow-2xl hover:drop-shadow-xl bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Upload Submission
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="staticModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      <div class="pb-20">
                        <form action="/profile/{{$student->id}}/enrolled/{{$task->project->id}}/task/{{$task->id}}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="relative cursor-pointer " id="drop-area">
                            <label for="file-input">
                              <div class="relative cursor-pointer" id="drop-area">
                                <input type="file" name="file" class="absolute opacity-0" id="file-input">
                                <div class="p-6 border-2 border-dashed hover:bg-gray-50 rounded-md border-light-blue">
                                    <div class="text-center">
                                      <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mt-1 text-sm text-gray-600">
                                          Click to upload or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">.{{$task->file_type}} (MAX. 5MB)</p>
                                        <p class="mt-2 text-sm text-gray-600" id="file-name"></p>
                                    </div>
                                </div>
                              </div>
                            </label>
                            <button class="text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 mt-5 items-end rounded-full float-right" type="submit">Confirm Submission</button>
                          </div>
                        </form>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('more-js')
<script>
const dropArea = document.getElementById('drop-area')
const fileInput = document.getElementById('file-input')
const fileName = document.getElementById('file-name')

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
    fileName.innerHTML = `${e.dataTransfer.files[0].name} <i class="fas fa-times"></i>`
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
    fileName.innerHTML = `${e.target.files[0].name} <i class="fas fa-times"></i> `
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