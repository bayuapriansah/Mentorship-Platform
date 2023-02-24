@extends('layouts.admin2')
@section('content')
@if(Auth::guard('customer')->check())
    <div class="text-[#6973C6] hover:text-light-blue">
        <a href="/dashboard/customers"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
@else
    <div class="text-[#6973C6] hover:text-light-blue">
        {{-- @dd($partner) --}}
        <a href="/dashboard/partners/{{$partner->id}}/members"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
@endif

@if(Auth::guard('customer')->check())
    <div class="flex justify-between mb-10">
        <h3 class="text-dark-blue font-medium text-xl">{{Auth::guard('customer')->user()->company->name}} <i class="fa-solid fa-chevron-right"></i> Invite</h3>
    </div>
@else
    <div class="flex justify-between mb-10">
    <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Member <i class="fa-solid fa-chevron-right"></i> Invite</h3>
    </div>
@endif
@include('flash-message')
@if(Auth::guard('customer')->check())
    <form action="/dashboard/customer/sendInvitePartner/{{Auth::guard('customer')->user()->company_id}}" method="post" enctype="multipart/form-data">
@else
    <form action="{{ route('dashboard.partner.sendInvitePartner',[$partner->id]) }}" method="post" enctype="multipart/form-data">
@endif
    @csrf
  <div class="mb-3">
    @if(Auth::guard('customer')->check())
        <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="email" type="email" value="{{old('email')}}" placeholder="Customer Email" name="email[]" required><br>
    @else
        <input class="border border-light-blue rounded-lg w-3/4 h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none" id="email" type="email" value="{{old('email')}}" placeholder="Member Email" name="email[]" required><br>
    @endif
    <div class="mb-3">
        @if(Auth::guard('customer')->check())
            <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Invite Customer</button>
        @else
            <button type="submit" class="py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm">Invite Member</button>
        @endif
        </div>
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
    <a href="{{asset('assets/bulk_email.xlsx')}}" class="text-dark-blue hover:text-darker-blue">Click to download bulk email invitation format</a>

  </div>
  <p></p>
  <div class="mb-3">
    <!-- Select all button -->
    <a id="selectAllBtn" class="cursor-pointer py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm" style="display: none;">Select All</a>
    <!-- Unselect all button -->
    <a id="unselectAllBtn" class="cursor-pointer py-2.5 px-11 mt-4 rounded-full border-2 bg-darker-blue border-solid border-darker-blue text-center capitalize bg-orange text-white font-light text-sm" style="display: none;">Unselect All</a>
  </div>
  <div class="w-1/4">
    <table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16" style="display: none">
        <thead class="text-dark-blue">
            <tr>
                <th>No</th>
                <th>Select</th>
                <th>Email</th>
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
const dataTableVisibility = document.getElementById('dataTable')
const alertfileVisibility = document.getElementById('alert-file')

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
    let file = e.dataTransfer.files[0];
    let fileNames = file.name;
    let fileExtension = fileNames.substr((fileNames.lastIndexOf('.') + 1)).toLowerCase();
    if (fileExtension !== 'xlsx' && fileExtension !== 'xls' && fileExtension !== 'csv') {
        // alert('Only xlsx, xls, and csv file extensions are allowed.');
        alertfileVisibility.classList.remove('hidden');
        alertfileVisibility.classList.add('opacity-100');
        return;
    }else{
        emailInput.setAttribute('readonly', true);
        emailInput.removeAttribute('required');
        selectAllBtn.removeAttribute("style");
        unselectAllBtn.removeAttribute("style");
        dataTableVisibility.removeAttribute("style");

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
                    <td><input value="${email.email}" type="checkbox" class="checkbox" name="email[]"></td>
                    <td>${email.email}</td>
                </tr>`;
                tableBody.append(row);

                if (i === emails.length - 1) {
                    var checkboxes = document.querySelectorAll(".checkbox");
                    for (var j = 0; j < checkboxes.length; j++) {
                        checkboxes[j].checked = true;
                    }
                }
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
    }
})

// Listen for file input change events
fileInput.addEventListener('change', e => {
    let file = e.target.files[0];
    let fileNames = file.name;
    let fileExtension = fileNames.substr((fileNames.lastIndexOf('.') + 1)).toLowerCase();
    if (fileExtension !== 'xlsx' && fileExtension !== 'xls' && fileExtension !== 'csv') {
        // alert('Only xlsx, xls, and csv file extensions are allowed.');
        alertfileVisibility.classList.remove('hidden');
        alertfileVisibility.classList.add('opacity-100');
        return;
    }else{
        emailInput.setAttribute('readonly', true);
        emailInput.removeAttribute('required');
        selectAllBtn.removeAttribute("style");
        unselectAllBtn.removeAttribute("style");
        dataTableVisibility.removeAttribute("style");

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
                    <td><input value="${email.email}" type="checkbox" class="checkbox" name="email[]"></td>
                    <td>${email.email}</td>
                </tr>`;
                tableBody.append(row);

                if (i === emails.length - 1) {
                    var checkboxes = document.querySelectorAll(".checkbox");
                    for (var j = 0; j < checkboxes.length; j++) {
                        checkboxes[j].checked = true;
                    }
                }
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
    }
})

// Example function for handling file uploads
function handleUpload(files) {
    // console.log('Uploading files:', files)
    // Do something with the files here
}

// Example function for resetting the UI
function resetUI() {
    // Do something to reset the UI
    // console.log('Resetting UI');
    document.querySelector('#hideornot').style.display = 'none';
    emailInput.setAttribute('required',true);
    emailInput.removeAttribute('readonly');
    let tableBody = $('#tableBody');
    tableBody.empty();
    selectAllBtn.style.display = 'none';
    unselectAllBtn.style.display = 'none';
    dataTableVisibility.style.display = 'none';
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
