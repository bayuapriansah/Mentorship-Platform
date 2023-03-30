@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/messages"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Reply Message</h3>
</div>

<form action="/dashboard/messages" method="post" id="form-chat" class="text-dark-blue text-lg font-normal" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label for="inputproject">Select Project <span class="text-red-600">*</span></label>
    <select id="inputproject" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="project" required>
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

  <div class="mb-3">
    <label for="inputprojectinjection">Select Task <span class="text-red-600">*</span></label>
    <select id="inputprojectinjection" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="injection" required>
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

  <div class="mb-3">
    <label for="inputstudent">Select Student <span class="text-red-600">*</span></label>
    <select id="inputstudent" class="text w-full border border-light-blue rounded-lg mt-4 h-11 py-2 px-4 leading-tight invalid:text-lightest-grey focus:outline-none " name="student" required>
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

  <div class="mb-3">
    <label for="inputproject">CC </label>
    {{-- <input type="text" class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none"> --}}
    {{-- <select class="border border-light-blue bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5  invalid:text-lightest-grey focus:outline-none " id="inputproject"  name="project" disabled>
      <option value="{{$participant->id}}">
        {{$participant->mentor->first_name}} {{$participant->mentor->last_name}},
        @foreach ($customer_participants as $customer)
          {{$customer->first_name}} {{$customer->last_name}},
        @endforeach
      </option>
    </select> --}}
  </div>

  <div class="mb-3">
    <label for="inputproject">Message <span class="text-red-600">*</span> </label>
    <div class="w-full mb-4 border border-light-blue rounded-lg  ">
      <div class=" bg-white  rounded-t-lg   ">
          <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:outline-none" name="message" placeholder="Type Here" required></textarea>
      </div>
      <div class="flex items-center justify-between px-3 py-2 bg-white rounded-b-lg">
          <div class="flex pl-0 space-x-1 sm:pl-2 items-center">
              <label for="file-chat-input" type="button" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 ">
                <img src="{{asset('assets/img/icon/clip.svg')}}" class="w-[10px]" alt="">
              </label>
              <div id="chatFileName"></div>
              <input id="file-chat-input" class="hidden" type="file" name="file" />
          </div>
          <div>
            <a href="/dashboard/messages" class="bg-[#B11313] hover:bg-red-800 px-4 py-1 rounded-full text-white text-sm">Cancel</a>
            <button type="submit">
              <span class="bg-dark-blue hover:bg-darker-blue px-4 py-1 rounded-full text-white text-sm">
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
          var userAuth = {!! json_encode((array)auth()->user()) !!};
          userAuth = JSON.parse(JSON.stringify(userAuth));
          var guardRoles = userAuth['\u0000*\u0000guard'];
          var guard = userAuth['\u0000*\u0000attributes'];
          // console.log(guard.institution_id);
          // console.log(userAuth['\u0000*\u0000attributes']);
          var base_url = window.location.origin;
          $("#inputstudent").html('');
          $.ajax({
              url: base_url+"/api/student/project/"+idproject+"/"+guard.id+"/"+guardRoles+"/"+guard.institution_id,
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
