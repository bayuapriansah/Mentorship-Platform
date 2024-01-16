@extends('layouts.admin2')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        {{ $project->company->name }}
        <span class="mx-3">></span>
        Project
        <span class="mx-3">></span>
        Add Task
    </h1>

    <a href="{{ $backUrl }}" class="flex items-center gap-3 text-xl">
        <i class="fas fa-times-circle mt-1 text-primary"></i>
        Cancel
    </a>
</div>

<form action="{{ $formAction }}" method="post" enctype="multipart/form-data" class="mt-10">
    @csrf

    <div>
        <input
            type="text"
            id="inputtitle"
            name="title"
            value="{{ old('title') }}"
            placeholder="Task Name *"
            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none"
        >

        @error('title')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5 grid grid-cols-12 gap-4">
        <div class="col-span-6">
            <select disabled class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 invalid:text-lightest-grey focus:outline-none">
                <option>{{ $project->getProjectDomainText() }}</option>
            </select>
        </div>

        <div class="col-span-6">
            <select id="inputcardduration" name="duration" class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                <option value="" hidden>Task Duration *</option>

                @foreach (range(1,10) as $duration)
                    <option value="{{ $duration }}">
                        {{ $duration }} {{ $duration == 1 ? 'day' : 'days' }}
                    </option>
                @endforeach
            </select>

            @error('duration')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="mt-5">
        <select disabled id="inputproject" name="project" class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 invalid:text-lightest-grey focus:outline-none">
            <option value="{{ $project->id }}" hidden>{{ $project->name }}</option>
        </select>

        @error('project')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <textarea name="description" id="sectionDesc" placeholder="Task Details *">
            {{ old('description') }}
        </textarea>

        @error('description')
            <p class="text-danger text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <input
            type="text"
            id="inputtitle"
            name="dataset"
            value="{{ old('dataset') }}"
            placeholder="Dataset"
            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
        >

        @error('dataset')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- <div class="mt-10 flex justify-between">
        <h3 class="text-dark-blue font-medium text-xl">File Attachment</h3>
        <div class="text-xl text-dark-blue">
            <i class="fa-solid fa-circle-plus"></i>
            <input type="submit" class="cursor-pointer" name="addInjectionCardAttachment" value="Add Attachment">
        </div>
    </div> --}}

    <div class="mt-6">
        <div id="drop-area" class="relative cursor-pointer" style="background-color: white;">
            <label for="file-input">
                <div class="relative cursor-pointer" id="drop-area">
                    <input type="file" class="absolute opacity-0" id="file-input">
                    <div class="p-6 border-2 border-dashed hover:bg-white rounded-md border-light-blue">
                        <div class="text-center">
                            <i class="fas fa-file fa-3x text-lighter-blue"></i>
                            <p class="mt-4 text-sm text-gray-600">
                                Click to upload or drag and drop document
                            </p>
                            <p class="text-xs text-gray-500 "> (MAX. 5MB)</p>
                            <p class="mt-2 text-sm text-gray-600" id="file-name"></p>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <div id="files-container" class="mt-8 space-y-4"></div>

    <div class="mt-10">
        <input type="submit" class="py-2 cursor-pointer px-11 rounded-full border-2 bg-primary text-center text-white text-sm" name="addInjectionCard" value="Submit">
    </div>
</form>
@endsection

@section('more-js')
    <script>
        const dropArea = document.getElementById('drop-area')
        const fileInput = document.getElementById('file-input')
        let uploadedFiles = []

        function renderFiles() {
            $('#files-container').html('')

            uploadedFiles.forEach((file, index) => {
                $('#files-container').append(`
                    <div class="px-6 py-3 border border-light-blue rounded-lg flex items-center gap-7">
                        <input type="hidden" name="files[]" value="${file}">
                        <i class="fas fa-file text-darker-blue"></i>
                        <span class="text-sm">${file.name}</span>
                        <button class="ml-auto text-red-600" onclick="deleteFile(${index})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `)
            })
        }

        function addFile(file) {
            fileInput.value = ''

            if (uploadedFiles.length >= 3) {
                toastr.error('You can only upload up to 3 files')
                return
            }

            if (file) {
                if (file.size > 5500000) {
                    toastr.error('Maximum file size is 5 MB')
                } else {
                    uploadedFiles.push(file)
                    renderFiles()
                }
            }
        }

        function deleteFile(index) {
            uploadedFiles.splice(index, 1)
            renderFiles()
        }

        dropArea.addEventListener('dragover', e => {
            e.preventDefault()
            dropArea.style.backgroundColor = '#f2f2f2'
        })

        dropArea.addEventListener('dragleave', e => {
            e.preventDefault()
            dropArea.style.backgroundColor = 'white'
        })

        dropArea.addEventListener('drop', e => {
            e.preventDefault()
            dropArea.classList.remove('bg-gray-200')
            addFile(e.dataTransfer.files[0])
        })

        fileInput.addEventListener('change', e => {
            if (e.target.files.length > 0) {
                addFile(e.target.files[0])
            }
        })
    </script>
@endsection
