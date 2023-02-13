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
<form action="{{ route('dashboard.students.sendInviteFromInstitution', ['institution'=>$institution->id]) }}" id="submitForm" method="post" enctype="multipart/form-data">
@else
<form action="{{route('dashboard.students.sendInvite')}}" method="post" enctype="multipart/form-data">
@endif
  @csrf

  <div class="mb-3">
    <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="email" type="email" value="{{old('email')}}" placeholder="Student Email" name="email" required><br>
    <div class="w-3/4 mt-4">
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
                        <p class="text-xs text-gray-500 ">.{{'xlsx, xls or csv'}}</p>
                        {{-- <p class="mt-2 text-sm text-gray-600" id="file-name"></p> --}}
                    </div>
                </div>
                </div>
            </label>
            <div id="hideornot">
                <div id="file-name" class="mt-5 mb-4 py-4 flex justify-between items-center">
                </div>
            </div>
            </div>
    </div>
    @error('email')
        <p class="text-red-600 text-sm mt-1">
          {{$message}}
        </p>
    @enderror
  </div>
  <p></p>
  <div class="mb-3">
    <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Invite Student</button>
    <!-- Select all button -->
    <a id="selectAllBtn" class="cursor-pointer py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm" style="display: none;">Select All</a>
    <!-- Unselect all button -->
    <a id="unselectAllBtn" class="cursor-pointer py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm" style="display: none;">Unselect All</a>
  </div>
  <div class="w-3/4">
    <table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
        <thead class="text-dark-blue">
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>Select</th>
            </tr>
        </thead>
            <tbody id="tableBody">
        </tbody>
    </table>
  </div>
</form>

@endsection
@section('more-js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
<script>
const dropArea = document.getElementById('drop-area')
const fileInput = document.getElementById('file-input')
const fileName = document.getElementById('file-name')
const emailInput = document.getElementById('email')
const selectAllBtn = document.getElementById('selectAllBtn')
const unselectAllBtn = document.getElementById('unselectAllBtn')

$('#dataTable').DataTable({
        paging: false,
        ordering: false,
        info: false,
        searching:false,
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
    emailInput.setAttribute('readonly', true);
    emailInput.removeAttribute('required');
    selectAllBtn.removeAttribute("style");
    unselectAllBtn.removeAttribute("style");
    let file = e.dataTransfer.files[0];
    let reader = new FileReader();
    reader.readAsBinaryString(file);
    reader.onload = function(e) {
    let data = e.target.result;
    let workbook = XLSX.read(data, {type: 'binary'});
    let emailSheet = workbook.Sheets[workbook.SheetNames[0]];
    let emails = XLSX.utils.sheet_to_json(emailSheet);
    let tableBody = $('#tableBody');
    tableBody.empty();
        for (let i = 0; i < emails.length; i++)
        {
            let email = emails[i];
            let row = `<tr>
                <td>${i + 1}</td>
                <td>${email.email}</td>
                <td><input value="${email.email}" type="checkbox" class="checkbox" name="checkbox[]"></td>
            </tr>`;
            tableBody.append(row);
        }
    };

    e.preventDefault()
    dropArea.classList.remove('bg-gray-200')
    fileInput.files = e.dataTransfer.files
    let classesToAdd = ["p-2","border","border", "hover:bg-gray-50", "rounded-md", "border-dark-blue", 'p']
    fileName.classList.add(...classesToAdd);
    fileName.innerHTML = `<img src="{{asset("assets/img/icon/Vector.png")}}" alt=""> ${e.dataTransfer.files[0].name} <i class="fas fa-times"></i>`
    // You can handle the files here.
    handleUpload(e.dataTransfer.files)
    document.querySelector('#hideornot').style.display = 'block';
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
    emailInput.setAttribute('readonly', true);
    emailInput.removeAttribute('required');
    selectAllBtn.removeAttribute("style");
    unselectAllBtn.removeAttribute("style");
    let file = e.target.files[0];
    let reader = new FileReader();
    reader.readAsBinaryString(file);
    reader.onload = function(e) {
    let data = e.target.result;
    let workbook = XLSX.read(data, {type: 'binary'});
    let emailSheet = workbook.Sheets[workbook.SheetNames[0]];
    let emails = XLSX.utils.sheet_to_json(emailSheet);
    let tableBody = $('#tableBody');
    tableBody.empty();
        for (let i = 0; i < emails.length; i++)
        {
            let email = emails[i];
            let row = `<tr>
                <td>${i + 1}</td>
                <td>${email.email}</td>
                <td><input value="${email.email}" type="checkbox" class="checkbox" name="checkbox[]"></td>
            </tr>`;
            tableBody.append(row);
        }
    };

    fileName.innerHTML = `<img src="{{asset("assets/img/icon/Vector.png")}}" alt=""> ${e.target.files[0].name} <i class="fas fa-times"></i> `
    // You can handle the files here.
    handleUpload(e.target.files)
    let classesToAdd = ["p-2","border","border", "hover:bg-gray-50", "rounded-md", "border-dark-blue", 'p']
    fileName.classList.add(...classesToAdd);
    document.querySelector('#hideornot').style.display = 'block';
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
    // Do something to reset the UI
    console.log('Resetting UI');
    document.querySelector('#hideornot').style.display = 'none';
    emailInput.setAttribute('required',true);
    emailInput.removeAttribute('readonly');
    let tableBody = $('#tableBody');
    tableBody.empty();
    selectAllBtn.style.display = 'none';
    unselectAllBtn.style.display = 'none';
}

document.getElementById("selectAllBtn").addEventListener("click", function() {
    // Get all the checkboxes
    var checkboxes = document.querySelectorAll(".checkbox");
    // Loop through all the checkboxes and set the checked property to true
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = true;
    }
});

document.getElementById("unselectAllBtn").addEventListener("click", function() {
    // Get all the checkboxes
    var checkboxes = document.querySelectorAll(".checkbox");
    // Loop through all the checkboxes and set the checked property to false
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
});

</script>
@endsection
