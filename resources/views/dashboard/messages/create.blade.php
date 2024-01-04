@extends('layouts.admin2')
@section('content')
<a href="{{ route('dashboard.messages.index') }}" class="group block text-lg text-[#6973C6]">
    <
    <span class="ml-2 group-hover:underline">
        Back
    </span>
</a>

<h1 class="mt-2 text-dark-blue font-medium text-[1.375rem]">
    New Message
</h1>

<form action="/dashboard/messages" method="post" id="form-chat" class="mt-5 text-dark-blue text-lg" enctype="multipart/form-data">
  @csrf
  <div class="mb-4">
    <label for="inputproject">Select Project <span class="text-red-600">*</span></label>
    <select id="inputproject" class="text w-full border border-light-blue rounded-lg mt-2 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="project" required>
      <option hidden>Select Project</option>
      @foreach($projects as $project)
      <option value="{{$project->id}}">{{$project->name}}</option>
      @endforeach
      <option value="other">Other</option>
    </select><br>
    @error('project')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-4">
    <label for="inputprojectinjection">Select Task <span class="text-red-600">*</span></label>
    <select id="inputprojectinjection" class="text w-full border border-light-blue rounded-lg mt-2 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="injection" required>
      <option hidden>Select Task</option>
      {{-- @foreach($projectSections as $injection)
      <option value="{{$injection->id}}">{{$injection->title}}</option>
      @endforeach
      <option value="other">Other</option> --}}
    </select><br>
    @error('injection')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>

  <div class="mb-4">
    <label for="inputstudent">Select Student <span class="text-red-600">*</span></label>
    <select id="inputstudent" class="text w-full border border-light-blue rounded-lg mt-2 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="student" required>
      <option hidden>Select Student</option>
      {{-- @foreach($students as $students)
      <option value="{{$students->id}}">{{$students->first_name}} {{$students->last_name}}</option>
      @endforeach
      <option value="other">Other</option> --}}
    </select><br>
    @error('student')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
{{-- @dd($instituteId) --}}
  {{-- <div class="mb-3">
    <label for="inputproject">CC </label> --}}
    {{-- <input type="text" class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none"> --}}
    {{-- <select class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none " id="inputproject"  name="project" disabled>
      <option value="{{$participant->id}}">
        {{$participant->mentor->first_name}} {{$participant->mentor->last_name}},
        @foreach ($customer_participants as $customer)
          {{$customer->first_name}} {{$customer->last_name}},
        @endforeach
      </option>
    </select> --}}
  {{-- </div> --}}
  <div class="mb-4">
    <label for="inputproject">Message <span class="text-red-600">*</span> </label>
    <div class="w-full mt-2 mb-4 border border-light-blue rounded-lg  ">
      <div class=" bg-white  rounded-t-lg   ">
          <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:outline-none" name="message" placeholder="Type Here" required></textarea>
      </div>
      <div class="flex items-center justify-between px-3 py-2 bg-white rounded-b-lg">
          <div class="flex pl-0 space-x-1 sm:pl-2 items-center">
              <label for="file-chat-input" type="button" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 ">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_4187_8425)">
                        <path d="M13.0221 22.9167C9.85547 22.9167 7.29297 20.3542 7.29297 17.1876L7.29297 6.25008C7.29297 3.948 9.15755 2.08341 11.4596 2.08341C13.7617 2.08341 15.6263 3.948 15.6263 6.25008L15.6263 15.1042C15.6263 16.5417 14.4596 17.7084 13.0221 17.7084C11.5846 17.7084 10.418 16.5417 10.418 15.1042V7.29175H12.5013V15.198C12.5013 15.7709 13.543 15.7709 13.543 15.198V6.25008C13.543 5.10425 12.6055 4.16675 11.4596 4.16675C10.3138 4.16675 9.3763 5.10425 9.3763 6.25008V17.1876C9.3763 19.198 11.0117 20.8334 13.0221 20.8334C15.0326 20.8334 16.668 19.198 16.668 17.1876V7.29175H18.7513V17.1876C18.7513 20.3542 16.1888 22.9167 13.0221 22.9167Z" fill="#E96424"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_4187_8425">
                            <rect width="25" height="25" fill="white" transform="matrix(0 -1 1 0 0 25)"/>
                        </clipPath>
                    </defs>
                </svg>
              </label>
              <div id="chatFileName"></div>
              <input id="file-chat-input" class="hidden" type="file" name="file" />
          </div>
          <div>
            <a href="/dashboard/messages" class="bg-[#B11313] hover:bg-red-800 px-8 py-1 rounded-full text-white text-sm">Cancel</a>
            <button type="submit" class="ml-2">
              <span class="bg-primary px-8 py-1 rounded-full text-white text-sm">
                Send
              </span>
            </button>
          </div>
      </div>
    </div>
  </div>
</form>
@endsection
@section('more-js')
<script>
const fileChatInput = document.getElementById('file-chat-input')
const chatFileName = document.getElementById('chatFileName')

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
// fileInput.addEventListener('change', e => {
//     fileName.innerHTML = `<img src="{{asset("assets/img/icon/Vector.png")}}" alt=""> ${e.target.files[0].name} <i class="fas fa-times"></i> `
//     // You can handle the files here.
//     handleUpload(e.target.files)
//     let classesToAdd = ["p-2","border","border", "hover:bg-gray-50", "rounded-md", "border-dark-blue", 'p']
//     fileName.classList.add(...classesToAdd);
//     const fileClear = document.querySelector('.fa-times')
//     fileClear.addEventListener('click', e => {
//         e.preventDefault();
//         fileName.textContent = '';
//         fileInput.value = '';
//         resetUI();
//     });
// })

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

$(document).ready(function () {
      $('#inputproject').on('change', function () {
          var idproject = this.value;
          var base_url = window.location.origin;
          $("#inputprojectinjection").html('');
          $.ajax({
              url: base_url+"/api/comment/"+idproject,
              contentType: "application/json",
              dataType: 'json',
              success: function (result) {
                // console.log(result);
                  $('#inputprojectinjection').html('<option hidden>Select Task</option>');
                  $.each(result, function (key, value) {
                      $("#inputprojectinjection").append('<option value="' + value
                          .id + '">' + value.title + '</option>');
                  });
                //   $('#inputstudent').html('<option value="">Select Student</option>');
              }
          });
      });

      $('#inputproject').on('change', function () {
          var idproject = this.value;
          var userAuth = "{{ Auth::getDefaultDriver() }}";
          var guardId = "{{ Auth::user()->id }}";
          var instituteId = "{{ $instituteId }}";
          var guardIns = instituteId != 0 ? 1 : 0;
          var base_url = window.location.origin;
          $("#inputstudent").html('');
          $.ajax({
              url: base_url+"/api/student/project/"+idproject+"/"+guardId+"/"+userAuth+"/"+guardIns,
              contentType: "application/json",
              dataType: 'json',
              success: function (result) {
                  $('#inputstudent').html('<option hidden>Select Task</option>');
                  $.each(result, function (key, value) {
                      console.log(value);
                      $("#inputstudent").append('<option value="' + value
                          .id + '">' + value.first_name + ' ' + value.last_name +'</option>');
                  });
              }
          });
      });
  });

</script>
@endsection
