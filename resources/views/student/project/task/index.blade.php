@extends('layouts.profile.index')
@section('content')
@include('flash-message')
  {{-- @dd($task->project->name); --}}
<div class="max-w-[1366px] mx-auto px-16 pt-16 grid grid-cols-12 gap-8 grid-flow-col items-center pb-36 min-h-[500px]">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-8 my-auto">
        {{-- @dd($task) --}}
        <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$task->project->id}}/detail" class="px-5 pb-2 py-2 rounded-lg text-white bg-darker-blue hover:bg-dark-blue"><i class="fa-solid fa-arrow-left pr-2"></i>back</a>

        <h2 class="text-dark-blue text-2xl font-medium mt-4 mb-3">{{$task->project->name}}</h2>
        <span class="intelOne text-dark-blue text-sm font-normal bg-lightest-blue capitalize px-10 py-2 rounded-full relative z-30 ">{{$task->project->project_domain}}</span>
      </div>
      <div class="col-span-4 relative">
        <img src="{{asset('assets/img/icon/profile/dots.png')}}" class="absolute z-10 right-0 -top-3 ">
        <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4 absolute z-30 right-10 top-10 ">
          <img src="{{asset('storage/'.$task->project->company->logo)}}" class="w-16 h-9 object-scale-down mx-auto " alt="">
        </div>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-14">
      <div class="col-span-7 relative my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">Task {{$task->section}} : {{$task->title}}</h1>
      </div>
      {{-- <div class="col-start-10 col-span-3">
          <span class="intelOne text-black text-sm font-normal">due date</span>
      </div> --}}
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
      <div class="col-span-9">
        @foreach($task->sectionSubsections as $subsection)
        <div class="border border-dark-blue px-7 py-4 rounded-xl mb-2 font-medium ">
          <a href="{{asset('storage/'.$subsection->file1)}}" class="flex justify-between items-center">
            <div class=" flex ">
              <img src="{{asset("assets/img/icon/Vector.png")}}" alt="" class="pr-8">
              {{$subsection->title}} {{substr($subsection->file1, strpos($subsection->file1, '.'))}}
            </div>
            <img src="{{asset('assets/img/icon/download.png')}}" alt="">
          </a>
        </div>
        @endforeach
      </div>
    </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-12">
      <div class="col-span-9  my-auto">
        <h1 class="text-dark-blue text-[22px] font-medium">Discussion</h1>
        <div class="border flex flex-col justify-end border-light-blue p-3 rounded-xl  ">
          <div class="chat pb-5 max-h-[500px] overflow-y-auto">
            @if ($comments->count() == 0)
                <p class="py-4 text-center">No Comments Yet</p>
            @endif
            @foreach($comments->where('project_id', $task->project->id)->where('project_section_id', $task->id)->where('student_id', Auth::guard('student')->user()->id) as $comment)
              <div class="mb-2">
                {{-- @dd($comment->mentor_id == null) --}}
                @if ($comment->mentor_id == null && $comment->user_id == null && $comment->companies_id == null)
                <div class="flex flex-row-reverse">
                  <div class="w-1/2 border border-light-blue  p-2 rounded-xl  bg-white ">
                    {{$comment->message}}
                    @if($comment->file)
                      <br>
                      <a download="image.jpg" href="{{asset('storage/'.$comment->file)}}" class="flex items-center">
                        <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
                        <span class="text-xs">click to download</span>
                      </a>
                    @endif
                  </div>
                </div>
                <p class="text-[14px] text-right text-[#585858]">
                  @php
                      $sent_date =   \Carbon\Carbon::parse($comment->created_at);
                      $sent_date = $sent_date->format('d-m-y, G:ia');
                  @endphp
                  {{$sent_date}}
                </p>
                @else
                <div class="flex ">
                  <div class="w-1/2 border border-light-blue  p-2 rounded-xl  bg-[#E2E3ED] ">
                    {{$comment->message}}
                    @if($comment->file)
                      <br>
                      <a href="{{asset('storage/'.$comment->file)}}" class="flex items-center">
                        <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
                        <span class="text-xs">click to download</span>
                      </a>
                    @endif
                  </div>
                </div>
                <p class="text-[14px] text-[#585858]">
                  @php
                      $sent_date =   \Carbon\Carbon::parse($comment->created_at);
                      $sent_date = $sent_date->format('d-m-y, G:ia');
                  @endphp
                  {{$sent_date}}
                </p>
                @endif

              </div>
              @endforeach
          </div>
          <div class="form ">
            <form action="/profile/{{$student->id}}/enrolled/{{$task->project->id}}/task/{{$task->id}}/chat" method="post" id="form-chat" enctype="multipart/form-data">
            @csrf
            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 ">
              <div class="px-4 py-2 bg-white rounded-t-lg ">
                  <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:outline-none" name="message" placeholder="Type Here" required></textarea>
              </div>
              <div class="flex items-center justify-between px-3 py-2 bg-white ">
                  <div class="flex pl-0 space-x-1 sm:pl-2 items-center">
                      <label for="file-chat-input" type="button" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 ">
                        <img src="{{asset('assets/img/icon/clip.svg')}}" class="w-[10px]" alt="">
                      </label>
                      <div id="chatFileName"></div>
                      <input id="file-chat-input" class="hidden" type="file" name="file" />
                  </div>
                  <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white focus:ring-4 focus:ring-blue-200">
                    <img src="{{asset('assets/img/icon/send.png')}}" class="w-[15px]" alt="">
                  </button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal toggle -->
    <!-- Main modal -->
    <div id="staticModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative border border-light-blue border-inherit shadow drop-shadow-2xl hover:drop-shadow-xl bg-white rounded-lg  ">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4  ">

                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="staticModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-6 py-2 ">
                    <p class="text-base leading-relaxed text-gray-500 ">
                      <div class="pb-20">
                        <h1 class="text-dark-blue font-medium text-[22px] mb-5">Upload Assignment</h1>
                        <form action="/profile/{{$student->id}}/enrolled/{{$task->project->id}}/task/{{$task->id}}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="relative cursor-pointer " id="drop-area">
                            <label for="file-input">
                              <div class="relative cursor-pointer" id="drop-area">
                                <input type="file" name="file" class="absolute opacity-0" id="file-input" required>
                                <div class="p-6 border-2 border-dashed hover:bg-gray-50 rounded-md border-light-blue">
                                    <div class="text-center">
                                      <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mt-1 text-sm text-gray-600">
                                          Click to upload or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 ">.{{$task->file_type}} (MAX. 5MB)</p>
                                        {{-- <p class="mt-2 text-sm text-gray-600" id="file-name"></p> --}}
                                    </div>
                                </div>
                              </div>
                            </label>
                            <div id="file-name" class="mt-5 mb-4 py-4 flex justify-between items-center">
                            </div>
                            <a class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 mt-5 items-end rounded-full float-right" type="button" style="display: block;" id="confirm">Confirm Submission</a>
                            <a class="intelOne text-dark-blue text-sm font-normal hover:bg-neutral-100 px-12 py-3 mt-5 items-end rounded-full shadow-xl float-right" type="button" style="display: none;" id="cancel">Cancel</a>
                            <button class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 mt-5 items-end rounded-full shadow-xl float-right" style="display: none;" id="submit"type="submit">Yes, Submit</button>
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
const fileChatInput = document.getElementById('file-chat-input')
const chatFileName = document.getElementById('chatFileName')

// Submission Button
document.querySelector('#confirm').addEventListener('click', function () {
  document.querySelector('#confirm').style.display = 'none';
  document.querySelector('#cancel').style.display = 'block';
  document.querySelector('#submit').style.display = 'block';
});

document.querySelector('#cancel').addEventListener('click', function () {
  document.querySelector('#confirm').style.display = 'block';
  document.querySelector('#cancel').style.display = 'none';
  document.querySelector('#submit').style.display = 'none';
});


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
    let classesToAdd = ["p-2","border","border", "hover:bg-gray-50", "rounded-md", "border-dark-blue", 'p']
    fileName.classList.add(...classesToAdd);
    fileName.innerHTML = `<img src="{{asset("assets/img/icon/Vector.png")}}" alt=""> ${e.dataTransfer.files[0].name} <i class="fas fa-times"></i>`
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

fileChatInput.addEventListener('change', e =>{
  // console.log('${e.target.files[0].name}');
  chatFileName.innerHTML = `${e.target.files[0].name} <i class="fas fa-times"></i> `
  console.log('tes')
  const fileClear = document.querySelector('.fa-times')
    fileClear.addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('form-chat').reset()
        chatFileName.textContent = '';
        chatFileName.value = '';
    });
})

// Listen for file input change events
fileInput.addEventListener('change', e => {
    fileName.innerHTML = `<img src="{{asset("assets/img/icon/Vector.png")}}" alt=""> ${e.target.files[0].name} <i class="fas fa-times"></i> `
    // You can handle the files here.
    handleUpload(e.target.files)
    let classesToAdd = ["p-2","border","border", "hover:bg-gray-50", "rounded-md", "border-dark-blue", 'p']
    fileName.classList.add(...classesToAdd);
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
