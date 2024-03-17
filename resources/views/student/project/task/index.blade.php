@extends('layouts.profile.index')
@section('content')
<div class="max-w-[1366px] mx-auto px-16 pt-4 pb-40 grid grid-cols-12 gap-8 grid-flow-col items-center min-h-[500px] bg-white">
  <div class="col-span-8">
    <div class="grid grid-cols-12 gap-4 grid-flow-col">
      <div class="col-span-8 my-auto">
        <a href="/profile/{{Auth::guard('student')->user()->id}}/enrolled/{{$task->project->id}}/detail" class="text-darker-blue text-sm hover:underline">
            < Go Back
        </a>

        {{-- Project Name --}}
        <h1 class="mt-6 font-medium text-darker-blue text-2xl">
            {{ $task->project->name }}
        </h1>

        {{-- Domain --}}
        <div class="mt-2 min-w-[174px] w-max px-3 py-1 bg-primary border border-primary rounded-full flex justify-center text-white">
            {{ $task->project->getProjectDomainText() }}
        </div>
      </div>
      <div class="col-span-4 relative -right-12">
        <div
            class="w-[233px] h-[100px] absolute top-0 right-2"
            style="background: url({{ asset('/assets/img/home/bubble-decoration.svg') }}), transparent -0.084px -8.927px / 100.073% 126.737% no-repeat;"
        ></div>

        <div class="w-[30px] h-[30px] absolute top-[43px] right-[5.25rem] bg-[#FF8F51] rounded-lg"></div>

        <img
            src="{{ $task->project->company->logo ? asset('storage/'.$task->project->company->logo) : asset('/assets/img/project-logo-placeholder.png') }}"
            onerror="this.src = `{{ asset('/assets/img/project-logo-placeholder.png') }}`"
            alt="Logo"
            class="absolute top-[55px] right-10 w-16 h-16 object-cover bg-white border border-grey rounded-xl text-black text-center"
        >

        {{-- <p class="absolute -bottom-12 right-[75px] mt-2 flex gap-2 items-center font-medium text-[#6672D3] text-xs">
            <span class="w-[10px] h-[10px] bg-[#6672D3] rounded-full"></span>
            In Progress
        </p> --}}
      </div>
    </div>

    {{-- Task Title --}}
    <h2 class="w-[545px] mt-6 font-medium text-[1.4rem]">
        Task {{$task->section}} : {{$task->title}}
    </h2>

    {{-- Task Description --}}
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-3">
        <div class="problem col-span-12 text-justify text-black font-normal">
            {!!$task->description!!}
        </div>
    </div>

    {{-- Attachments --}}
    <h1 class="mt-10 font-medium text-darker-blue text-[1.4rem]">
        Attachments
    </h1>

    <div class="mt-4 flex flex-col gap-3">
        @forelse($task->sectionSubsections as $subsection)
            <a href="{{ asset('storage/'.$subsection->file1) }}" class="w-[545px] py-5 pl-6 pr-7 border border-grey rounded-xl flex items-center">
                <i class="fas fa-file-alt fa-lg"></i>
                <p class="pl-7 text-sm">
                    {{$subsection->title}} {{substr($subsection->file1, strpos($subsection->file1, '.'))}}
                </p>
                <i class="fas fa-download fa-lg ml-auto"></i>
            </a>
        @empty
          No Attachment
        @endforelse
    </div>

    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-2">
      <div class="col-span-10 text-justify">
        {{-- @dd($project->dataset); --}}
          @if ($project->dataset)
              @php
                  $datasets_array = $project->dataset;
                //   $datasets_array = explode(';', $project->dataset);
              @endphp
              <div class="mb-6">
                    <h1 class="mt-8 font-medium text-darker-blue text-[1.4rem]">Dataset</h1>
                    <div class="mt-4 flex flex-wrap gap-5">
                        @foreach ($datasets_array as $dataset_array)
                            <a href="{{ $dataset_array }}" class="w-[172px] h-[37px] px-3 py-1 bg-primary rounded-lg flex justify-between items-center font-medium text-white">
                                <span>URL {{ $loop->iteration }}</span>
                                <span>></span>
                            </a>
                        @endforeach
                    </div>
              </div>
          @endif
      </div>
      </div>
    <div class="grid grid-cols-12 gap-4 grid-flow-col mt-12">
      <div class="col-span-12  my-auto">
        <h1 class="font-medium text-darker-blue text-[1.4rem] mb-2">Messages</h1>
        @if ($comments->count())
        <div id="accordion-collapse" class="border border-light-blue rounded-lg p-4 bg-white" data-accordion="collapse">
          @php $no=1;  @endphp
          @foreach($comments->where('project_id', $task->project->id)->where('project_section_id', $task->id)->where('student_id', Auth::guard('student')->user()->id) as $comment)
            <h2 id="accordion-collapse-heading-{{$no}}" class="">
              <button type="button" id="accordion-{{$no}}" class="flex items-center justify-between w-full p-5 mb-2 font-medium text-left text-black  border-b-2 border-gray-200" data-accordion-target="#accordion-collapse-body-{{$no}}" aria-expanded="false" aria-controls="accordion-collapse-body-{{$no}}">
                <div class="flex items-center space-x-4">
                  <i class="text-dark-blue fa-solid fa-circle"></i>
                  <div class="flex-col capitalize">
                    <span class="font-medium">
                      @if ($comment->mentor_id)
                        {{$comment->mentor->first_name}} {{$comment->mentor->last_name}} (Supervisor)
                      @elseif($comment->staff_id)
                        {{optional($comment->staff)->first_name}} {{optional($comment->staff)->last_name}} (Customer)
                      @elseif ($comment->user_id)
                        {{$comment->user->name}} (Platform Admin)
                      @else
                        {{$comment->student->first_name}} {{$comment->student->last_name}} ({{$comment->student_id == Auth::guard('student')->user()->id?'You':''}})
                      @endif
                    </span><br>
                    <span class="font-light receiver text-xs">
                      @if($comment->mentor_id == null && $comment->user_id == null && $comment->companies_id == null)
                        to: {{$comment->student->mentor->first_name}} {{$comment->student->mentor->last_name}}(Supervisor), {{$comment->student->staff->first_name}}  {{$comment->student->staff->first_name}}(Customer),
                        @foreach ($admins as $admin)
                          <span class="font-light text-black">{{$admin->name}}(Admin); </span>
                        @endforeach
                        @foreach ($task->project->company->customers as $customer)
                          <span class="font-light text-black">{{$customer->first_name}} {{$customer->last_name}}({{$task->project->company->name}}); </span>
                        @endforeach
                      @endif
                    </span>
                    <span class="font-light message-top">{!!$mess = substr($comment->message,0,39)!!} {{strlen($mess)>38?'...':''}}</span>
                  </div>
                </div>

                <div class="text-xs text-light-blue font-light">
                  {{$comment->created_at->format('d M Y')}}
                  <i class="fa-sharp fa-solid fa-reply"></i>
                </div>
              </button>
            </h2>
            <div id="accordion-collapse-body-{{$no}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$no}}">
              <div class="p-5 font-light ">
                <p class="mb-2 text-base text-black ">{!!$comment->message!!}</p>
                @if($comment->file)
                  <br>
                  <a target="_blank" href="{{asset('storage/'.$comment->file)}}" class="flex w-1/2 py-2 px-4 rounded-xl justify-between items-center border border-light-blue">
                    <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
                    <span class="text-xs  font-normal text-black">Click to download (.{{substr($comment->file, strpos($comment->file, ".") + 1)}})</span>
                    <img src="{{asset('assets/img/icon/download.png')}}" alt="">
                  </a>
                @endif
              </div>
            </div>
            @php $no++ @endphp
          @endforeach
          <button type="button" id="reply-existing-message" class="text-white bg-dark-blue hover:bg-darker-blue px-8 py-1 rounded-full">Reply</button>
        </div>
        @endif
        <div class="border border-light-blue p-6 rounded-xl bg-white space-y-2" id="message-form">
          <p class="border-b-2 text-dark-blue font-medium">
            To:
            <span class="font-light text-black pl-4 capitalize">
              {{$student->mentor->first_name}} {{$student->mentor->last_name}} (Supervisor);
              @if ($student->staff_id)
                {{$student->staff->first_name}} {{$student->staff->last_name}} (Customer)
              @endif
            </span>
          </p>
          <p class="border-b-2 text-dark-blue font-medium capitalize">CC:
            <span class="pl-3">
              @foreach ($admins as $admin)
                <span class="font-light text-black">{{$admin->name}}(Admin); </span>
              @endforeach
              @foreach ($task->project->company->customers as $customer)
                <span class="font-light text-black">{{$customer->first_name}} {{$customer->last_name}}({{$task->project->company->name}}); </span>
              @endforeach
            </span>
          </p>
          <form action="/profile/{{$student->id}}/enrolled/{{$task->project->id}}/task/{{$task->id}}/chat" method="post" id="form-chat" enctype="multipart/form-data">
            @csrf
            <div class="w-full mb-4 ">
              <div class="bg-white  rounded-t-lg   ">
                  <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:outline-none" name="message" placeholder="Type Here" required novalidate></textarea>
              </div>
              <div class="flex items-center justify-between bg-white rounded-b-lg">
                  <div class="flex pl-0 space-x-1 sm:pl-2 items-center">
                      <label for="file-chat-input" type="button" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 ">
                        <img src="{{asset('assets/img/icon/clip.svg')}}" class="w-[10px]" alt="">
                      </label>
                      <div id="chatFileName"></div>
                      <input id="file-chat-input" class="hidden" type="file" name="file" />
                  </div>
                  <div class="mt-2 space-x-3">
                    <button type="button" class="px-6 py-1 bg-white border border-primary rounded-full text-primary text-sm" id="btn-cancel">
                        Cancel
                    </button>

                    <button type="submit" class="px-8 py-1 bg-primary border border-primary rounded-full text-white text-sm" id="btn-cancel">
                      Send
                    </button>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal toggle -->
    <!-- Main modal -->
    <div id="staticModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">

        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative border border-light-blue border-inherit shadow drop-shadow-2xl hover:drop-shadow-xl bg-white rounded-lg  ">
                <!-- Modal body -->
                <div class="px-6 pt-6 pb-4">
                    <p class="text-base leading-relaxed text-gray-500 ">
                      <div class="pb-20">
                        <h1 class="text-darker-blue font-medium text-[22px] mb-5">Upload Assignment</h1>
                        @if(Auth::guard('student')->user()->mentorship_type == "skills_track")
                            @if($submissionData == null)
                                <form action="{{ $taskSubmitForm }}" method="POST" enctype="multipart/form-data">
                            @else
                                <form action="{{ $taskReSubmitForm }}" method="POST" enctype="multipart/form-data">
                                @method('patch')
                            @endif
                        @else
                            @if($submissionData == null)
                                <form action="{{ $taskSubmitFormProjectPlanner }}" method="POST" enctype="multipart/form-data">
                            @else
                                <form action="{{ $taskReSubmitFormProjectPlanner }}" method="POST" enctype="multipart/form-data">
                                @method('patch')
                            @endif
                        @endif
                            @csrf
                          <div class="relative cursor-pointer " id="drop-area">
                          {{-- <div class="relative cursor-pointer " id="drop-area"> --}}
                            <div>
                              <h1 class="text-darker-blue font-medium mb-2">File Link</h1>
                                <input class="border border-grey rounded-lg w-full py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" type="text" placeholder="File Link" name="glablink" required>
                                <p class="text-sm text-red-600" id="link_error" style="display: none;">*Please enter a link from Google Docs, Google Drive, or Google Colab</p>
                            </div>
                            <div class="mt-4">
                              <h1 class="text-darker-blue font-medium mb-2">Additional Resources (Datasets, Reports, etc.)</h1>
                              <input class="border border-grey rounded-lg w-full py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" type="text" placeholder="Optional" name="dataset">
                              <p class="mt-2 text-xs text-darker-blue">*You can add more than one dataset by separating them with commas (,) </p><br>
                              {{-- <input type="text" class="w-full px-4 py-6 text-sm border border-gray-300 rounded outline-none"  name="tags"  value="Alpine Js, Tailwind CSS, PHP8.0" autofocus/> --}}
                            </div>
                            <a class="intelOne text-white text-sm font-normal bg-primary px-12 py-3 mt-5 items-end rounded-full float-right" type="button" style="display: block;" id="confirm">Confirm Submission</a>
                            <a class="intelOne text-dark-blue text-sm font-normal hover:bg-neutral-100 px-6 py-2 mt-5 ml-1 items-end rounded-full float-right" type="button" style="display: none;" id="cancel">Cancel</a>
                            <button class="intelOne text-white text-sm font-normal bg-primary px-6 py-2 mt-5 items-end rounded-full float-right" style="display: none;" id="submit"type="submit">Yes, Submit</button>
                            <h1 id="text-confirm" class="intelOne text-darker-blue text-sm font-bold py-3 mt-5 items-end float-left cursor-text" style="display: none;">Are you sure you want to make the task submission?</h1>
                          </div>
                        </form>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Resubmit Modal --}}


</div>
@endsection
@section('more-js')
@if ($comments->count())
  <script>
    $(document).ready( function () {
      $('#message-form').hide()
      $('#reply-btn').on('click', function(){
        $('#message-form').show();
        $('#reply-btn').hide();
      });
      $('#btn-cancel').on('click', function(){
        $('#message-form').hide();
        $('#reply-btn').show();
        $('#reply-existing-message').show();
      });

      $('#reply-existing-message').on('click', function(){
        $('#reply-existing-message').hide();
        $('#message-form').show();
      });


      $('.receiver').hide();

      $('[id^=accordion-]').on('click', function() {
        var messageTop = $(this).closest('button').find('.message-top');
        var receiver = $(this).closest('button').find('.receiver');
        receiver.toggle();
        messageTop.toggle();
      });

    });
  </script>
@endif
<script>
const dropArea = document.getElementById('drop-area')
const fileName = document.getElementById('file-name')
const fileChatInput = document.getElementById('file-chat-input')
const chatFileName = document.getElementById('chatFileName')

// Submission Button
document.querySelector('#confirm').addEventListener('click', function () {
  document.querySelector('#confirm').style.display = 'none';
  document.querySelector('#cancel').style.display = 'block';
  document.querySelector('#submit').style.display = 'block';
  document.querySelector('#text-confirm').style.display = 'block';
});

document.querySelector('#cancel').addEventListener('click', function () {
  document.querySelector('#confirm').style.display = 'block';
  document.querySelector('#cancel').style.display = 'none';
  document.querySelector('#submit').style.display = 'none';
  document.querySelector('#text-confirm').style.display = 'none';
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


var input = document.querySelector('input[name=dataset]');
// initialize Tagify on the above input node reference
const tagify = new Tagify(input, {
  delimiter: ',',
});
</script>

<!-- Your script -->
{{-- Better Javascript Validation for link html --}}
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const confirmButton = document.getElementById('confirm');
    const submitButton = document.getElementById('submit');
    const linkInput = document.querySelector('input[name="glablink"]');
    const linkError = document.getElementById('link_error');

    // Initially disable both buttons
    confirmButton.setAttribute('disabled', 'disabled');
    submitButton.setAttribute('disabled', 'disabled');

    // Validate the link as the user types
    linkInput.addEventListener('input', validateLink);

    function validateLink() {
        let url = linkInput.value.trim();

        // Remove www. if present

        // Ensure the URL starts with either http:// or https://
        if (!url.match(/^https?:\/\//)) {
          url = 'https://' + url;
        }

        // Move the www removal after ensuring the URL starts with http:// or https://
        url = url.replace(/^https?:\/\/www\./, 'https://');

        let hostname;
        try {
            hostname = new URL(url).hostname;
        } catch (e) {
            linkError.style.display = 'block';
            confirmButton.setAttribute('disabled', 'disabled');
            submitButton.setAttribute('disabled', 'disabled');
            return false; // URL is invalid
        }

        // Validate domain
        const validDomains = ['docs.google.com', 'drive.google.com', 'colab.research.google.com'];
        if (validDomains.includes(hostname)) {
            linkError.style.display = 'none';
            confirmButton.removeAttribute('disabled'); // Enable the confirm button
            submitButton.removeAttribute('disabled'); // Enable the submit button
            linkInput.value = url;
            return true; // URL is valid
        } else {
            linkError.style.display = 'block';
            confirmButton.setAttribute('disabled', 'disabled'); // Disable the confirm button
            submitButton.setAttribute('disabled', 'disabled'); // Disable the submit button
            return false; // URL is invalid
        }
    }
});

  </script>

@endsection
